<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkHours;

class TaskController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();
    //     $empleadorId = $user->empleador_id;

    //     $tareas = Task::where(function($query) use ($user, $empleadorId) {
    //                 $query->where('created_by', $user->id)
    //                       ->orWhere('visible_para', $empleadorId);
    //             })
    //             ->with('comments')
    //             ->get();

    //     return view('empleados.edit_tarea', compact('tareas'));
    // }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->tipo_usuario === 'empleador') {
            // Obtener los IDs de los empleados asignados a este empleador
            $empleadosIds = User::where('empleador_id', $user->id)->pluck('id');
            
            // Obtener las tareas de estos empleados
            $tareas = Task::whereIn('created_by', $empleadosIds)->with('comments')->get();
        } else {
            // Si es un empleado, solo obtener sus propias tareas
            $tareas = Task::where('created_by', $user->id)->with('comments')->get();
        }
    
        // Preparar datos para el gráfico
        $taskData = $tareas->groupBy(function($tarea) {
            return $tarea->created_at->format('Y-m');
        })->map->count()->toArray();
    
        return view('empleados.edit_tarea', compact('tareas', 'taskData'));
    }

    
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'duration' => 'required|numeric|min:0',
    //         'completed' => 'nullable|boolean',
    //     ]);

    //     $task = new Task($validatedData);
    //     $task->created_by = auth()->id();
    //     $task->visible_para = auth()->user()->empleador_id;
    //     $task->save();

    //     return back()->with('success', 'Tarea creada exitosamente.');
    // }

    
// public function store(Request $request)
// {
//     $validatedData = $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'duration' => 'nullable|numeric|min:0',
//         'completed' => 'boolean',
//         // ... otras validaciones ...
//     ]);

//     $task = Task::create([
//         'created_by' => Auth::id(),
//         'title' => $validatedData['title'],
//         'description' => $validatedData['description'],
//         'duration' => $validatedData['duration'],
//         'completed' => $validatedData['completed'] ?? false,
//         // ... otros campos ...
//     ]);

//     if ($validatedData['duration']) {
//         WorkHours::create([
//             'user_id' => Auth::id(),
//             'work_date' => now()->toDateString(),
//             'hours_worked' => $validatedData['duration'],
//             'approved' => false,
//         ]);
//     }

//     return response()->json($task, 201);
// }


// public function store(Request $request)
// {
//     $validatedData = $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'duration' => 'nullable|numeric|min:0',
//         'completed' => 'boolean',
//         // ... otras validaciones ...
//     ]);

//     $task = Task::create([
//         'created_by' => Auth::id(),
//         'title' => $validatedData['title'],
//         'description' => $validatedData['description'],
//         'duration' => $validatedData['duration'],
//         'completed' => $validatedData['completed'] ?? false,
//         // ... otros campos ...
//     ]);

//     if ($validatedData['duration']) {
//         WorkHours::create([
//             'user_id' => Auth::id(),
//             'work_date' => now()->toDateString(),
//             'hours_worked' => $validatedData['duration'],
//             'approved' => false,
//         ]);
//     }

//     return back()->with('success', 'Tarea creada exitosamente.');
// }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            // 'duration' => 'nullable|numeric|min:0',
            'completed' => 'boolean',
        ]);

        $task = Task::create([
            'created_by' => Auth::id(),
            'visible_para' => Auth::user()->empleador_id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'priority' => $validatedData['priority'],
            // 'duration' => $validatedData['duration'],
            'completed' => $validatedData['completed'] ?? false,
        ]);

        // if ($validatedData['duration']) {
        //     WorkHours::create([
        //         'user_id' => Auth::id(),
        //         'work_date' => now()->toDateString(),
        //         'hours_worked' => $validatedData['duration'],
        //         'approved' => false,
        //     ]);
        // }

        return back()->with('success', 'Tarea creada exitosamente.');
    }


    // public function update(Request $request, $taskId)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string|max:65535',
    //         'completed' => 'nullable|boolean',
    //         'duration' => 'nullable|numeric|min:0',
    //     ]);

    //     $task = Task::findOrFail($taskId);
    //     $task->update($validatedData);

    //     return back()->with('success', 'Tarea actualizada exitosamente.');
    // }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'priority' => 'required|in:low,medium,high,urgent',
        // 'duration' => 'required|numeric|min:0',
    ]);

    $task = Task::findOrFail($id);
    $task->update($validatedData);

    return back()->with('success', 'Tarea actualizada exitosamente.');
}

    // public function destroy($id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->comments()->delete();
    //     $task->delete();
    //     return redirect()->back()->with('success', 'Tarea eliminada con éxito');
    // }

        public function destroy($taskId)
    {
        $task = Task::findOrFail($taskId);
        
        WorkHours::where([
            'user_id' => $task->created_by,
            'work_date' => $task->created_at->toDateString(),
        ])->delete();

        $task->delete();

        return redirect()->back()->with('success', 'Tarea eliminada con éxito');
    }


    public function toggleCompletion(Request $request, $taskId)
{
    \Log::info('Toggling completion for task ID: ' . $taskId);

    try {
        $task = Task::findOrFail($taskId);
        
        \Log::info('Current task data: ' . json_encode($task->toArray()));

        $task->completed = !$task->completed;
        $result = $task->save();

        \Log::info('Update result: ' . ($result ? 'true' : 'false'));
        \Log::info('New task data: ' . json_encode($task->fresh()->toArray()));

        if (!$result) {
            throw new \Exception('Failed to update task');
        }

        return response()->json([
            'success' => true,
            'completed' => $task->completed
        ]);
    } catch (\Exception $e) {
        \Log::error('Error toggling task completion: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el estado de la tarea: ' . $e->getMessage()
        ], 500);
    }
}


    public function addComment(Request $request, $taskId)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:65535',
        ]);

        $comment = new Comment([
            'content' => $validatedData['content'],
            'task_id' => $taskId,
            'user_id' => auth()->id(),
        ]);
        $comment->save();

        return back()->with('success', 'Comentario agregado exitosamente.');
    }




    public function updateComment(Request $request, $taskId, $commentId)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:65535',
        ]);

        $comment = Comment::findOrFail($commentId);
        $comment->update([
            'content' => $validatedData['content'],
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Comentario actualizado exitosamente.');
    }



    public function deleteComment($taskId, $commentId)
    {
        $comment = Comment::where('task_id', $taskId)->where('id', $commentId)->firstOrFail();
        $comment->delete();
        return back()->with('success', 'Comentario eliminado exitosamente.');
    }
}