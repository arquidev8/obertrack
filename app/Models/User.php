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
}
