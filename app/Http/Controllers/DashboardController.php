<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\WorkHours;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show($role)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->tipo_usuario == $role) {
                return view("dashboard.$role");
            } else {
                abort(403, 'No autorizado');
            }
        } else {
            abort(401, 'No autorizado');
        }
    }

   

//     public function verTareasEmpleados(Request $request)
// {
//     $user = auth()->user();

//     // Verificar si el usuario es un empleador
//     if ($user->tipo_usuario !== 'empleador') {
//         abort(403, 'No autorizado');
//     }

//     // Obtener los empleados asignados a este empleador
//     $empleados = User::where('empleador_id', $user->id)->get();

//     // Obtener las tareas de estos empleados
//     $tareas = Task::whereIn('created_by', $empleados->pluck('id'))->with('comments');

//     // Filtrado por estado
//     if ($request->has('status') && $request->status !== 'all') {
//         $tareas = $tareas->where('completed', $request->status === 'completed' ? 1 : 0);
//     }

//     // Búsqueda por título
//     if ($request->has('search') && $request->search) {
//         $tareas = $tareas->where('title', 'like', '%' . $request->search . '%');
//     }

//     $tareas = $tareas->get();

//     // Preparar datos para el gráfico
//     $chartData = $this->prepareChartData($tareas);

//     // Obtener las horas trabajadas de los empleados por semana
//     $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
//     $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
//     $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);


//     $currentMonth = Carbon::now()->startOfMonth();
//     $approvedWeeks = $this->getApprovedWeeks($empleados, $currentMonth);

//     return view('empleadores.ver_tareas_empleados', compact('tareas', 'chartData', 'workHoursSummary', 'weekStart', 'approvedWeeks',  'currentMonth'));
// }




// public function verTareasEmpleados(Request $request)
// {
//     $user = auth()->user();

//     // Verificar si el usuario es un empleador
//     if ($user->tipo_usuario !== 'empleador') {
//         abort(403, 'No autorizado');
//     }

//     // Obtener los empleados asignados a este empleador
//     $empleados = User::where('empleador_id', $user->id)->get();

//     // Obtener las tareas de estos empleados
//     $tareas = Task::whereIn('created_by', $empleados->pluck('id'))->with('comments');

//     // Filtrado por estado
//     if ($request->has('status') && $request->status !== 'all') {
//         $tareas = $tareas->where('completed', $request->status === 'completed' ? 1 : 0);
//     }

//     // Búsqueda por título
//     if ($request->has('search') && $request->search) {
//         $tareas = $tareas->where('title', 'like', '%' . $request->search . '%');
//     }

//     $tareas = $tareas->get();

//     // Preparar datos para el gráfico
//     $chartData = $this->prepareChartData($tareas);

//     // Obtener las horas trabajadas de los empleados por semana
//     $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
//     $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
//     $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);

//     $currentMonth = Carbon::now()->startOfMonth();
//     $approvedWeeks = $this->getApprovedWeeks($empleados, $currentMonth);

//     // Calcular el total de horas aprobadas para el mes actual
//     $totalApprovedHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
//         ->whereYear('work_date', $currentMonth->year)
//         ->whereMonth('work_date', $currentMonth->month)
//         ->where('approved', true)
//         ->sum('hours_worked');

//     return view('empleadores.ver_tareas_empleados', compact('tareas', 'chartData', 'workHoursSummary', 'weekStart', 'approvedWeeks', 'currentMonth', 'totalApprovedHours'));
// }




// public function verTareasEmpleados(Request $request)
// {
//     $user = auth()->user();

//     // Verificar si el usuario es un empleador
//     if ($user->tipo_usuario !== 'empleador') {
//         abort(403, 'No autorizado');
//     }

//     // Obtener los empleados asignados a este empleador
//     $empleados = User::where('empleador_id', $user->id)->get();

//     // Obtener las tareas de estos empleados
//     $tareas = Task::whereIn('created_by', $empleados->pluck('id'))->with('comments');

//     // Filtrado por estado
//     if ($request->has('status') && $request->status !== 'all') {
//         $tareas = $tareas->where('completed', $request->status === 'completed' ? 1 : 0);
//     }

//     // Búsqueda por título
//     if ($request->has('search') && $request->search) {
//         $tareas = $tareas->where('title', 'like', '%' . $request->search . '%');
//     }

//     $tareas = $tareas->get();

//     // Preparar datos para el gráfico
//     $chartData = $this->prepareChartData($tareas);

//     // Obtener las horas trabajadas de los empleados por semana
//     $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
//     $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
//     $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);

//     // Obtener las semanas pendientes
//     $pendingWeeks = $this->getPendingWeeks($empleados);

//     $currentMonth = Carbon::now()->startOfMonth();
//     $approvedWeeks = $this->getApprovedWeeks($empleados, $currentMonth);

//     // Calcular el total de horas aprobadas para el mes actual
//     $totalApprovedHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
//         ->whereYear('work_date', $currentMonth->year)
//         ->whereMonth('work_date', $currentMonth->month)
//         ->where('approved', true)
//         ->sum('hours_worked');

//     return view('empleadores.ver_tareas_empleados', compact(
//         'tareas',
//         'chartData',
//         'workHoursSummary',
//         'weekStart',
//         'approvedWeeks',
//         'currentMonth',
//         'totalApprovedHours',
//         'pendingWeeks'
//     ));
// }



//ULTIMO 07-08-2024
// public function verTareasEmpleados(Request $request)
// {
//     $user = auth()->user();

//     // Verificar si el usuario es un empleador
//     if ($user->tipo_usuario !== 'empleador') {
//         abort(403, 'No autorizado');
//     }

//     // Obtener los empleados asignados a este empleador
//     $empleados = User::where('empleador_id', $user->id)->get();

//     // Obtener las tareas de estos empleados
//     $tareas = Task::whereIn('created_by', $empleados->pluck('id'))->with('comments');

//     // Filtrado por estado
//     if ($request->has('status') && $request->status !== 'all') {
//         $tareas = $tareas->where('completed', $request->status === 'completed' ? 1 : 0);
//     }

//     // Búsqueda por título
//     if ($request->has('search') && $request->search) {
//         $tareas = $tareas->where('title', 'like', '%' . $request->search . '%');
//     }

//     $tareas = $tareas->get();

//     // Preparar datos para el gráfico
//     $chartData = $this->prepareChartData($tareas);

//     // Obtener las horas trabajadas de los empleados por semana
//     $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
//     $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
//     $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);

//     // Obtener las semanas pendientes
//     $pendingWeeks = $this->getPendingWeeks($empleados);

//     $currentMonth = Carbon::now()->startOfMonth();
//     $approvedWeeks = $this->getApprovedWeeks($empleados, $currentMonth);

//     // Calcular el total de horas aprobadas para el mes actual
//     $totalApprovedHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
//         ->whereYear('work_date', $currentMonth->year)
//         ->whereMonth('work_date', $currentMonth->month)
//         ->where('approved', true)
//         ->sum('hours_worked');

//     $empleadosInfo = $empleados->map(function ($empleado) use ($currentMonth) {
//         $startOfMonth = $currentMonth->copy()->startOfMonth();
//         $endOfMonth = $currentMonth->copy()->endOfMonth();

//         $totalApprovedHours = WorkHours::where('user_id', $empleado->id)
//             ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
//             ->where('approved', true)
//             ->sum('hours_worked');

//         return [
//             'id' => $empleado->id,
//             'name' => $empleado->name,
//             'totalApprovedHours' => $totalApprovedHours
//         ];
//     });


    

//     return view('empleadores.ver_tareas_empleados', compact(
//         'tareas',
//         'chartData',
//         'workHoursSummary',
//         'weekStart',
//         'approvedWeeks',
//         'currentMonth',
//         'totalApprovedHours',
//         'pendingWeeks',
//         'empleadosInfo'
//     ));
// }




public function verTareasEmpleados(Request $request)
{
    $user = auth()->user();

    // Verificar si el usuario es un empleador
    if ($user->tipo_usuario !== 'empleador') {
        abort(403, 'No autorizado');
    }

    // Obtener los empleados asignados a este empleador
    $empleados = User::where('empleador_id', $user->id)->get();

    // Obtener las tareas de estos empleados
    $tareas = Task::whereIn('created_by', $empleados->pluck('id'))->with('comments');

    // Filtrado por estado
    if ($request->has('status') && $request->status !== 'all') {
        $tareas = $tareas->where('completed', $request->status === 'completed' ? 1 : 0);
    }

    // Búsqueda por título
    if ($request->has('search') && $request->search) {
        $tareas = $tareas->where('title', 'like', '%' . $request->search . '%');
    }

    $tareas = $tareas->get();

    // Preparar datos para el gráfico
    $chartData = $this->prepareChartData($tareas);

    // Obtener las horas trabajadas de los empleados por semana
    $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
    $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
    $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);

    // Obtener las semanas pendientes
    $pendingWeeks = $this->getPendingWeeks($empleados);

    $currentMonth = Carbon::now()->startOfMonth();

    // Calcular el total de horas aprobadas para el mes actual
    $totalApprovedHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
        ->whereYear('work_date', $currentMonth->year)
        ->whereMonth('work_date', $currentMonth->month)
        ->where('approved', true)
        ->sum('hours_worked');

    $empleadosInfo = $empleados->map(function ($empleado) use ($currentMonth) {
        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth();

        $totalApprovedHours = WorkHours::where('user_id', $empleado->id)
            ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
            ->where('approved', true)
            ->sum('hours_worked');

        $approvedWeeks = $this->getApprovedWeeks(collect([$empleado]), $currentMonth);

        return [
            'id' => $empleado->id,
            'name' => $empleado->name,
            'totalApprovedHours' => $totalApprovedHours,
            'approvedWeeks' => $approvedWeeks
        ];
    });

    return view('empleadores.ver_tareas_empleados', compact(
        'tareas',
        'chartData',
        'workHoursSummary',
        'weekStart',
        'currentMonth',
        'totalApprovedHours',
        'pendingWeeks',
        'empleadosInfo'
    ));
}


private function getPendingWeeks($empleados)
{
    $pendingWeeks = [];
    $currentWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
    
    // Buscar hasta 4 semanas atrás, excluyendo la semana actual
    for ($i = 1; $i <= 4; $i++) {
        $weekStart = $currentWeek->copy()->subWeeks($i);
        $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
        
        $pendingHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
            ->whereBetween('work_date', [$weekStart, $weekEnd])
            ->where('approved', false)
            ->exists();
        
        if ($pendingHours) {
            $pendingWeeks[] = [
                'start' => $weekStart,
                'end' => $weekEnd,
                'summary' => $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd)
            ];
        }
    }
    
    return $pendingWeeks;
}

// private function getPendingWeeks($empleados)
// {
//     $pendingWeeks = [];
//     $currentWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
    
//     // Buscar hasta 4 semanas atrás
//     for ($i = 0; $i < 4; $i++) {
//         $weekStart = $currentWeek->copy()->subWeeks($i);
//         $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
        
//         $pendingHours = WorkHours::whereIn('user_id', $empleados->pluck('id'))
//             ->whereBetween('work_date', [$weekStart, $weekEnd])
//             ->where('approved', false)
//             ->exists();
        
//         if ($pendingHours) {
//             $pendingWeeks[] = [
//                 'start' => $weekStart,
//                 'end' => $weekEnd,
//                 'summary' => $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd)
//             ];
//         }
//     }
    
//     return $pendingWeeks;
// }




private function getApprovedWeeks($empleados, $month)
{
    $approvedWeeks = [];
    $currentWeek = $month->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
    $endOfMonth = $month->copy()->endOfMonth();

    while ($currentWeek->lte($endOfMonth)) {
        $weekEnd = $currentWeek->copy()->endOfWeek(Carbon::FRIDAY);
        
        // Ajustar el inicio y fin de la semana si están fuera del mes actual
        $weekStart = max($currentWeek, $month->copy()->startOfMonth());
        $weekEnd = min($weekEnd, $endOfMonth);

        if ($weekStart->lte($endOfMonth)) {
            $isApproved = WorkHours::whereIn('user_id', $empleados->pluck('id'))
                ->whereBetween('work_date', [$weekStart, $weekEnd])
                ->where('approved', true)
                ->exists();

            $approvedWeeks[] = [
                'start' => $weekStart->format('d/m/Y'),
                'end' => $weekEnd->format('d/m/Y'),
                'approved' => $isApproved
            ];
        }

        $currentWeek->addWeek();
    }

    return $approvedWeeks;
}



    private function prepareChartData($tareas)
    {
        $taskData = $tareas->groupBy(function($tarea) {
            return $tarea->created_at->format('Y-m');
        });

        $chartData = [];
        foreach ($taskData as $mes => $tareasDelMes) {
            $chartData[$mes] = [
                'total' => $tareasDelMes->count(),
                'completed' => $tareasDelMes->where('completed', 1)->count(),
                'pending' => $tareasDelMes->where('completed', 0)->count(),
            ];
        }

        return $chartData;
    }

    public function empleadorDashboard(Request $request)
    {
        $user = auth()->user();
        $empleados = User::where('empleador_id', $user->id)->get();

        $weekStart = $request->week ? Carbon::parse($request->week) : Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);

        $workHoursSummary = $this->getWorkHoursSummary($empleados, $weekStart, $weekEnd);

        return view('empleadores.dashboard', compact('empleados', 'workHoursSummary', 'weekStart'));
    }

    private function getWorkHoursSummary($empleados, $weekStart, $weekEnd)
    {
        $summary = [];
        foreach ($empleados as $empleado) {
            $workHours = WorkHours::where('user_id', $empleado->id)
                ->whereBetween('work_date', [$weekStart, $weekEnd])
                ->get();
    
            $summary[$empleado->id] = [
                'name' => $empleado->name,
                'total_hours' => $workHours->sum('hours_worked'),
                'approved_hours' => $workHours->where('approved', true)->sum('hours_worked'),
                'pending_hours' => $workHours->where('approved', false)->sum('hours_worked'),
                'days' => $this->getDailyHours($workHours, $weekStart, $weekEnd),
            ];
        }
        return $summary;
    }
    
    private function getDailyHours($workHours, $weekStart, $weekEnd)
    {
        $days = [];
        $currentDay = $weekStart->copy();
        while ($currentDay <= $weekEnd) {
            $dayHours = $workHours->where('work_date', $currentDay->format('Y-m-d'))->first();
            $days[] = [
                'date' => $currentDay->format('Y-m-d'),
                'hours' => $dayHours ? $dayHours->hours_worked : 0,
                'approved' => $dayHours ? $dayHours->approved : false,
            ];
            $currentDay->addDay();
        }
        return $days;
    }
    


}
