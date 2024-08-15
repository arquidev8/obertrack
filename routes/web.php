<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkHoursController;
use App\Http\Controllers\WorkHourApprovalController;
use App\Http\Controllers\TaskController; // Asegúrate de importar TaskController
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empleadores', [ProfileController::class, 'obtenerEmpleadores']);


// Route::get('/tareas', [TaskController::class, 'index'])->name('tareas.index');
Route::get('/empleados/editar-tareas', [TaskController::class, 'index'])->name('tareas.edit');
Route::post('/tareas', [TaskController::class, 'store'])->name('tareas.store');
Route::post('/tasks/{taskId}/toggle-completion', [TaskController::class, 'toggleCompletion']);

Route::put('/tareas/{taskId}', [TaskController::class, 'update'])->name('tareas.update');
Route::delete('/tareas/{taskId}', [TaskController::class, 'destroy'])->name('tareas.destroy');


Route::get('/empleadores/tareas-asignadas', [DashboardController::class, 'verTareasEmpleados'])->middleware(['auth'])->name('empleadores.tareas-asignadas');
Route::get('/grafico-tareas', [DashboardController::class, 'verTareasEmpleados']);


// Route::middleware(['auth'])->group(function () {
//     Route::get('/empleado/registrar-horas', [EmpleadoController::class, 'registrarHoras'])->name('empleado.registrar-horas');
//     Route::post('/work-hours', [WorkHoursController::class, 'store'])->name('work-hours.store');
//     Route::post('/work-hours/approve-week', [WorkHoursController::class, 'approveWeek'])->name('work-hours.approve-week');
//     Route::get('/empleador/dashboard', [DashboardController::class, 'empleadorDashboard'])->name('empleador.dashboard');
//    Route::post('/work-hours/download-monthly-report', [WorkHoursController::class, 'downloadMonthlyReport'])->name('work-hours.download-monthly-report');
//     Route::post('/work-hours/approve-week-with-comment', [WorkHoursController::class, 'approveWeekWithComment'])->name('work-hours.approve-week-with-comment');


//     Route::get('/work-hours/download-monthly-report/{month}', [WorkHoursController::class, 'downloadMonthlyReport'])
//     ->name('work-hours.download-monthly-report');


//     Route::post('/work-hours/approve-month', [WorkHoursController::class, 'approveMonth'])->name('work-hours.approve-month');

//     Route::get('/work-hours/total', [WorkHoursController::class, 'getTotalHours'])->name('work-hours.total');
    

// });

Route::middleware(['auth'])->group(function () {
    Route::get('/empleado/registrar-horas', [EmpleadoController::class, 'registrarHoras'])->name('empleado.registrar-horas');
    Route::post('/work-hours', [WorkHoursController::class, 'store'])->name('work-hours.store');
    Route::post('/work-hours/approve-week', [WorkHoursController::class, 'approveWeek'])->name('work-hours.approve-week');
    Route::get('/empleador/dashboard', [DashboardController::class, 'empleadorDashboard'])->name('empleador.dashboard');
    Route::post('/work-hours/download-monthly-report', [WorkHoursController::class, 'downloadMonthlyReport'])->name('work-hours.download-monthly-report');
    Route::post('/work-hours/approve-week-with-comment', [WorkHoursController::class, 'approveWeekWithComment'])->name('work-hours.approve-week-with-comment');
    Route::get('/work-hours/download-monthly-report/{month}', [WorkHoursController::class, 'downloadMonthlyReport'])->name('work-hours.download-monthly-report');
    Route::post('/work-hours/approve-month', [WorkHoursController::class, 'approveMonth'])->name('work-hours.approve-month');


    Route::post('/work-hours/approve', [WorkHourApprovalController::class, 'approve'])->name('work-hours.approve');

    Route::get('/work-hours/download-monthly-report/{month}', [WorkHoursController::class, 'downloadMonthlyReport'])
    ->name('work-hours.download-monthly-report');
});





Route::middleware(['auth'])->group(function () {
    // ... otras rutas ...

    // Rutas para comentarios
    Route::get('/tasks/{taskId}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Ruta para toggle completion
    Route::post('/tasks/{task}/toggle-completion', [TaskController::class, 'toggleCompletion'])->name('tasks.toggle-completion');
});
    


// Route::get('/tareas/{taskId}', [TaskController::class, 'show'])->name('tareas.show'); // Ruta para mostrar detalles de una tarea
// Route::post('/tareas/{taskId}/comentar', [TaskController::class, 'addComment'])->name('tareas.addComment'); // Ruta para agregar un comentario a una tarea
// Route::get('/tareas/{taskId}/comentarios', [TaskController::class, 'showComments'])->name('tareas.showComments'); // Ruta para mostrar los comentarios de una tarea
// // Route::get('/tareas/{taskId}/comentarios/{commentId}/editar', [TaskController::class, 'updateComment'])->name('tareas.comment.edit');
// Route::put('/tareas/{taskId}/comentarios/{commentId}', [TaskController::class, 'updateComment'])->name('tareas.comment.update');
// Route::delete('/tareas/{taskId}/comentarios/{commentId}', [TaskController::class, 'deleteComment'])->name('tareas.comment.delete');


Route::get('/dashboard', function () {
    $user = Auth::user();
    $nombreUsuario = $user? $user->name : 'Invitado';
    return view('dashboard', ['nombreUsuario' => $nombreUsuario]);
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/empleados/crear-tarea', [EmpleadoController::class, 'create'])->name('empleados.crear-tarea');

});

require __DIR__.'/auth.php';
