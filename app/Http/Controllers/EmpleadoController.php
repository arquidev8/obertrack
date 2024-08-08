<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\WorkHours;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $tareas = Task::all(); // Asume que tienes un modelo Task y quieres obtener todas las tareas
    //     return view('empleados.crear_tarea', compact('tareas'));
    // }

    public function create()
{
    $tareas = Task::where('created_by', auth()->id())->get();
    return view('empleados.crear_tarea', compact('tareas'));
}


// public function registrarHoras(Request $request)
// {
//     $user = auth()->user();
//     $currentMonth = $request->month ? Carbon::parse($request->month) : Carbon::now();
//     $calendar = $this->generateCalendar($currentMonth, $user->id);

//     return view('empleados.registrar_horas', compact('calendar', 'currentMonth'));
// }


public function registrarHoras(Request $request)
{
    $user = auth()->user();
    $currentMonth = $request->month ? Carbon::parse($request->month) : Carbon::now();
    $calendar = $this->generateCalendar($currentMonth, $user->id);

    // Calcular el total de horas para el mes
    $totalHours = WorkHours::where('user_id', $user->id)
        ->whereYear('work_date', $currentMonth->year)
        ->whereMonth('work_date', $currentMonth->month)
        ->sum('hours_worked');

    return view('empleados.registrar_horas', compact('calendar', 'currentMonth', 'totalHours'));
}



private function generateCalendar($month, $userId)
{
    $calendar = [];
    $startOfMonth = $month->copy()->startOfMonth();
    $endOfMonth = $month->copy()->endOfMonth();

    $workHours = WorkHours::where('user_id', $userId)
        ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
        ->get()
        ->keyBy('work_date');

    $currentDate = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
    $endDate = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

    while ($currentDate <= $endDate) {
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $currentDate->copy();
            $week[] = [
                'date' => $date,
                'inMonth' => $date->month === $month->month,
                'workHours' => $workHours->get($date->format('Y-m-d')),
            ];
            $currentDate->addDay();
        }
        $calendar[] = $week;
    }

    return $calendar;
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
