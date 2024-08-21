<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // En el modelo User
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_usuario',
        'empleador_id',
        'is_manager',
        'signature',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_manager' => 'boolean',
        ];
    }

    //  // Un empleador puede tener muchos empleados
    //  public function empleados():?HasMany
    //  {
    //      if ($this->tipo_usuario!== 'empleado') {
    //          return null;
    //      }

    //      // Aquí asumimos que todos los usuarios pueden tener empleados, incluso si son empleados.
    //      // Deberías ajustar esta lógica según tus requisitos específicos.
    //      return $this->hasMany(User::class, 'empleado_id', 'id');
    //  }

    //  // Un empleado tiene un único empleador
    //  public function empleador():?BelongsTo
    //  {
    //      if ($this->tipo_usuario!== 'empleado') {
    //          return null;
    //      }

    //      // Aquí asumimos que todos los usuarios pueden tener un empleador, incluso si son empleadores.
    //      // Deberías ajustar esta lógica según tus requisitos específicos.
    //      return $this->belongsTo(User::class, 'empleador_id', 'id');
    //  }





    // Un empleador puede tener muchos empleados
    public function empleados()
    {
        return $this->hasMany(User::class, 'empleador_id');
    }

    // Un empleado tiene un único empleador
    public function empleador()
    {
        return $this->belongsTo(User::class, 'empleador_id');
    }

    public function workHours()
    {
        return $this->hasMany(WorkHours::class);
    }


    public function signature()
    {
        return $this->hasOne(UserSignature::class);
    }


    // En el modelo User

    // Tareas creadas por el usuario
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    // Tareas asignadas al usuario
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'visible_para', 'id');
    }




    //para managers
    // Método para verificar si el usuario puede asignar tareas
    public function puedeAsignarTareas()
    {
        return $this->tipo_usuario === 'empleador' || $this->is_manager;
    }

    // Método para promover a un empleado a manager
    public function promoverAManager()
    {
        if ($this->tipo_usuario === 'empleado') {
            $this->is_manager = true;
            $this->save();
        }
    }

    // Método para degradar a un manager a empleado regular
    public function degradarDeManager()
    {
        if ($this->tipo_usuario === 'empleado' && $this->is_manager) {
            $this->is_manager = false;
            $this->save();
        }
    }

    public function compañerosDeTrabajo()
    {
        if ($this->tipo_usuario === 'empleador') {
            return $this->empleados;
        } else {
            return User::where('empleador_id', $this->empleador_id)
                       ->where('id', '!=', $this->id)
                       ->get();
        }
    }
}
