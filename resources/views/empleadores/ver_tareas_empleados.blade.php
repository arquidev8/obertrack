

<x-app-layout>
 <div class="bg-white dark:bg-white min-h-screen p-12">
    <main class="max-w-7xl mx-auto">
        
        <div class="text-center mb-12">
            {{-- <h1 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-8 mt-20">Panel de Tareas</h1> --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['icon' => 'fa-tasks', 'color' => 'indigo', 'label' => 'Tareas Totales', 'value' => $tareas->count()],
                        ['icon' => 'fa-check-circle', 'color' => 'green', 'label' => 'Completadas', 'value' => $tareas->where('completed', 1)->count()],
                        ['icon' => 'fa-clock', 'color' => 'yellow', 'label' => 'Pendientes', 'value' => $tareas->where('completed', 0)->count()],
                        ['icon' => 'fa-hourglass-half', 'color' => 'purple', 'label' => 'Horas Totales', 'value' => $tareas->sum('duration')]
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg p-6 transform transition duration-500 hover:scale-105 hover:shadow-2xl">
                        <div class="text-{{ $stat['color'] }}-500 text-4xl mb-3">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ $stat['label'] }}</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        
        <div class="bg-white dark:bg-white rounded-3xl shadow-lg p-6 mb-12">
            <form method="GET" action="{{ route('empleadores.tareas-asignadas') }}" class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-full sm:w-1/3">
                    <select name="status" class="w-full px-4 py-2 rounded-full border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-300">
                        <option value="all">Todas las tareas</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completadas</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendientes</option>
                    </select>
                </div>
                <div class="w-full sm:w-1/2">
                    <input type="text" name="search" placeholder="Buscar tarea..." value="{{ request('search') }}" class="w-full px-4 py-2 rounded-full border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-300">
                </div>
                <div class="w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </form>
        </div>

        
      


        <div id="taskList" class="space-y-4">
            @foreach($tareas as $tarea)
                <div id="task-{{ $tarea->id }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden
                            @if($tarea->priority == 'urgent') border-l-4 border-red-500
                            @elseif($tarea->priority == 'high') border-l-4 border-orange-500
                            @elseif($tarea->priority == 'medium') border-l-4 border-yellow-500
                            @else border-l-4 border-blue-500
                            @endif">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $tarea->title }}</h3>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                             @if($tarea->priority == 'urgent') bg-red-100 text-red-800
                                             @elseif($tarea->priority == 'high') bg-orange-100 text-orange-800
                                             @elseif($tarea->priority == 'medium') bg-yellow-100 text-yellow-800
                                             @else bg-blue-100 text-blue-800
                                             @endif">
                                    {{ ucfirst($tarea->priority) }}
                                </span>
                                <button onclick="toggleCompletion({{ $tarea->id }})" class="text-gray-500 hover:text-green-500 focus:outline-none">
                                    <i id="complete-icon-{{ $tarea->id }}" class="fas fa-check-circle text-2xl {{ $tarea->completed ? 'text-green-500' : '' }}"></i>
                                </button>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $tarea->description }}</p>
                        <div class="mt-3 flex flex-wrap items-center text-xs text-gray-500 dark:text-gray-400 space-x-4">
                            <div class="flex items-center">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <span>{{ $tarea->start_date->format('d/m/Y') }} - {{ $tarea->end_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="far fa-user mr-1"></i>
                                <span>Creado por: {{ $tarea->createdBy->name ?? 'Usuario desconocido' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Estado:</span>
                            <span id="status-{{ $tarea->id }}" class="ml-1 {{ $tarea->completed ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $tarea->completed ? 'Completada' : 'En progreso' }}
                            </span>
                        </div>
                        <div>
                            <button onclick="toggleComments({{ $tarea->id }})" class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                                Ver comentarios
                            </button>
                        </div>
                    </div>
                    <div id="comments-{{ $tarea->id }}" class="hidden bg-gray-50 dark:bg-gray-700 p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Comentarios</h4>
                        <div id="commentsList-{{ $tarea->id }}" class="space-y-2 mb-4">
                            @foreach ($tarea->comments as $comment)
                                <div id="comment-{{ $comment->id }}" class="bg-white p-4 rounded-lg shadow-sm">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-grow">
                                            <p class="text-sm text-gray-800">
                                                <span class="font-medium text-indigo-600">{{ $comment->user->name }}:</span> 
                                                <span id="commentContent-{{ $comment->id }}">{{ $comment->content }}</span>
                                            </p>
                                            <small class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($comment->user_id == auth()->id())
                                            <div class="flex space-x-2">
                                                <button onclick="editComment({{ $comment->id }})" class="text-blue-500 hover:text-blue-700 text-xs transition duration-150 ease-in-out">
                                                    <i class="fas fa-edit"></i> Editar
                                                </button>
                                                <button onclick="deleteComment({{ $comment->id }}, {{ $tarea->id }})" class="text-red-500 hover:text-red-700 text-xs transition duration-150 ease-in-out">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form onsubmit="addComment(event, {{ $tarea->id }})" class="mt-2">
                            @csrf
                            <textarea id="newComment-{{ $tarea->id }}" rows="2" class="w-full p-2 border rounded dark:bg-gray-600 dark:text-white" placeholder="Añadir un comentario..."></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-150 ease-in-out">Comentar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <script>
        function toggleCompletion(taskId) {
            const icon = document.getElementById(`complete-icon-${taskId}`);
            const statusSpan = document.getElementById(`status-${taskId}`);
            const isCompleted = icon.classList.contains('text-green-500');
            
            fetch(`/tasks/${taskId}/toggle-completion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ completed: !isCompleted })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    icon.classList.toggle('text-green-500');
                    statusSpan.textContent = isCompleted ? 'En progreso' : 'Completada';
                    statusSpan.classList.toggle('text-green-600');
                    statusSpan.classList.toggle('text-yellow-600');
                } else {
                    showAlert('Error al actualizar el estado de la tarea', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al actualizar el estado de la tarea', 'error');
            });
        }
        
        function toggleComments(taskId) {
            const commentsSection = document.getElementById(`comments-${taskId}`);
            commentsSection.classList.toggle('hidden');
        }
        
        function addComment(event, taskId) {
            event.preventDefault();
            const content = document.getElementById(`newComment-${taskId}`).value;
            if (!content.trim()) return;
        
            fetch('{{ route('comments.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ task_id: taskId, content: content })
            })
            .then(response => response.json())
            .then(comment => {
                const commentsList = document.getElementById(`commentsList-${taskId}`);
                commentsList.insertAdjacentHTML('beforeend', createCommentHTML(comment));
                document.getElementById(`newComment-${taskId}`).value = '';
                showAlert('Comentario añadido con éxito', 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al añadir el comentario: ' + error.message, 'error');
            });
        }
        
        function createCommentHTML(comment) {
            return `
                <div id="comment-${comment.id}" class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex-grow">
                            <p class="text-sm text-gray-800">
                                <span class="font-medium text-indigo-600">${comment.user.name}:</span> 
                                <span id="commentContent-${comment.id}">${comment.content}</span>
                            </p>
                            <small class="text-xs text-gray-500">${new Date(comment.created_at).toLocaleString()}</small>
                        </div>
                        ${comment.user_id == {{ auth()->id() }} ? `
                            <div class="flex space-x-2">
                                <button onclick="editComment(${comment.id})" class="text-blue-500 hover:text-blue-700 text-xs transition duration-150 ease-in-out">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button onclick="deleteComment(${comment.id}, ${comment.task_id})" class="text-red-500 hover:text-red-700 text-xs transition duration-150 ease-in-out">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }
        
        function editComment(commentId) {
    const commentElement = document.getElementById(`comment-${commentId}`);
    const contentElement = commentElement.querySelector(`#commentContent-${commentId}`);
    const currentContent = contentElement.textContent.trim();
    
    const input = document.createElement('textarea');
    input.value = currentContent;
    input.className = 'w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none';
    input.rows = 3;
    
    contentElement.replaceWith(input);
    
    input.focus();

    const saveButton = document.createElement('button');
    saveButton.textContent = 'Guardar';
    saveButton.className = 'mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-150 ease-in-out';
    saveButton.onclick = () => updateComment(commentId, input.value);

    commentElement.appendChild(saveButton);
}

function updateComment(commentId, newContent) {
    fetch(`/comments/${commentId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ content: newContent })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            if (commentElement) {
                // Recrear el contenido del comentario
                const newCommentHTML = `
                    <div class="flex-grow">
                        <p class="text-sm text-gray-800">
                            <span class="font-medium text-indigo-600">${data.comment.user.name}:</span> 
                            <span id="commentContent-${commentId}">${data.comment.content}</span>
                        </p>
                        <small class="text-xs text-gray-500">${new Date(data.comment.updated_at).toLocaleString()}</small>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="editComment(${commentId})" class="text-blue-500 hover:text-blue-700 text-xs transition duration-150 ease-in-out">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button onclick="deleteComment(${commentId}, ${data.comment.task_id})" class="text-red-500 hover:text-red-700 text-xs transition duration-150 ease-in-out">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                `;
                
                commentElement.innerHTML = newCommentHTML;
                showAlert('Comentario actualizado con éxito', 'success');
            } else {
                console.error(`Elemento de comentario no encontrado para el ID ${commentId}`);
                showAlert('Error al actualizar el comentario: Elemento no encontrado', 'error');
            }
        } else {
            showAlert('Error al actualizar el comentario: ' + (data.message || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al actualizar el comentario: ' + error.message, 'error');
    });
}


        
        function deleteComment(commentId, taskId) {
            if (!confirm('¿Estás seguro de que quieres eliminar este comentario?')) return;
        
            fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    commentElement.remove();
                    showAlert('Comentario eliminado con éxito', 'success');
                } else {
                    showAlert('Error al eliminar el comentario: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al eliminar el comentario: ' + error.message, 'error');
            });
        }
        
        function showAlert(message, type) {
            const alertElement = document.createElement('div');
            alertElement.className = `fixed top-4 right-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
            alertElement.textContent = message;
            document.body.appendChild(alertElement);
        
            setTimeout(() => {
                alertElement.remove();
            }, 3000);
        }
        </script>


        
     
    </main>
</div>





<div class="py-12 bg-gray-100 dark:bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($pendingWeeks))
            <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100 text-center">Semanas Pendientes de Aprobación</h2>
            @foreach($pendingWeeks as $pendingWeek)
                <div class="mb-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-600 dark:bg-blue-800 p-4">
                        <h3 class="text-xl font-semibold text-white">Semana del {{ $pendingWeek['start']->format('d/m/Y') }} al {{ $pendingWeek['end']->format('d/m/Y') }}</h3>
                    </div>
                    <div class="p-6">
                        @foreach($pendingWeek['summary'] as $employeeId => $summary)
                            <div class="mb-8 last:mb-0 border-b border-gray-200 dark:border-gray-700 pb-8 last:border-0 last:pb-0">
                                <div class="flex flex-wrap items-center justify-between mb-4">
                                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $summary['name'] }}</h4>
                                    <div class="flex space-x-2 mt-2 sm:mt-0">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $summary['total_hours'] }}/40 horas</span>
                                        @if($summary['pending_hours'] > 0)
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">{{ $summary['pending_hours'] }} pendientes</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Aprobadas</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach($summary['days'] as $day)
                                            <div class="text-center">
                                                <div class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ Carbon\Carbon::parse($day['date'])->format('D') }}</div>
                                                <div class="text-lg font-semibold {{ $day['approved'] ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                                    {{ $day['hours'] }}
                                                </div>
                                                <div class="text-xs {{ $day['approved'] ? 'text-green-500' : 'text-yellow-500' }}">
                                                    {{ $day['approved'] ? 'Aprobado' : 'Pendiente' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if($summary['pending_hours'] > 0)
                                    <div class="flex justify-end space-x-2">
                                        <form action="{{ route('work-hours.approve-week') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="week_start" value="{{ $pendingWeek['start']->format('Y-m-d') }}">
                                            <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition duration-300">
                                                Aprobar
                                            </button>
                                        </form>
                                        <button onclick="showCommentModal({{ $employeeId }}, '{{ $pendingWeek['start']->format('Y-m-d') }}')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition duration-300">
                                            Aprobar con comentarios
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100 text-center">Semana Actual</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 dark:bg-green-800 p-4">
                <h3 class="text-xl font-semibold text-white">{{ $weekStart->format('d/m/Y') }} al {{ $weekStart->copy()->endOfWeek(Carbon\Carbon::FRIDAY)->format('d/m/Y') }}</h3>
            </div>
            <div class="p-6">
                @foreach ($workHoursSummary as $employeeId => $summary)
                    <div class="mb-8 last:mb-0 border-b border-gray-200 dark:border-gray-700 pb-8 last:border-0 last:pb-0">
                        <div class="flex flex-wrap items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $summary['name'] }}</h4>
                            <div class="flex space-x-2 mt-2 sm:mt-0">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $summary['total_hours'] }}/40 horas</span>
                                @if($summary['pending_hours'] > 0)
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">{{ $summary['pending_hours'] }} pendientes</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Aprobadas</span>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-5 gap-2">
                                @foreach ($summary['days'] as $day)
                                    <div class="text-center">
                                        <div class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ Carbon\Carbon::parse($day['date'])->format('D') }}</div>
                                        <div class="text-lg font-semibold {{ $day['approved'] ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                            {{ $day['hours'] }}
                                        </div>
                                        <div class="text-xs {{ $day['approved'] ? 'text-green-500' : 'text-yellow-500' }}">
                                            {{ $day['approved'] ? 'Aprobado' : 'Pendiente' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($summary['pending_hours'] > 0)
                            <div class="flex justify-end space-x-2">
                                <form action="{{ route('work-hours.approve-week') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="week_start" value="{{ $weekStart->format('Y-m-d') }}">
                                    <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition duration-300">
                                        Aprobar
                                    </button>
                                </form>
                                <button onclick="showCommentModal({{ $employeeId }}, '{{ $weekStart->format('Y-m-d') }}')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition duration-300">
                                    Aprobar con comentarios
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<div id="commentModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    Aprobar con comentarios
                </h3>
                <div class="mt-2">
                    <textarea id="approvalComment" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Ingrese sus comentarios aquí"></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="approveWithComment()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Aprobar
                </button>
                <button type="button" onclick="closeCommentModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
        let currentEmployeeId, currentWeekStart;

        function showCommentModal(employeeId, weekStart) {
            currentEmployeeId = employeeId;
            currentWeekStart = weekStart;
            document.getElementById('commentModal').classList.remove('hidden');
        }

        function closeCommentModal() {
            document.getElementById('commentModal').classList.add('hidden');
        }

        function approveWithComment() {
            const comment = document.getElementById('approvalComment').value;
            
            fetch('{{ route('work-hours.approve-week-with-comment') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    employee_id: currentEmployeeId,
                    week_start: currentWeekStart,
                    comment: comment
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Semana aprobada con comentarios');
                    location.reload();
                } else {
                    alert('Error al aprobar la semana');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al aprobar la semana');
            });

            closeCommentModal();
        }
        </script>
    </div>





<div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-xl overflow-hidden mb-8 p-12">
    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-2 text-center">
        Resumen de {{ $currentMonth->translatedFormat('F Y') }}
    </h2>

    @foreach($empleadosInfo as $empleado)

    
   
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800 p-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Detalles del Reporte
                </h3>
            </div>
            
            <div class="p-4">
                <div class="mb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Resumen de Semanas</h4>
                        <p class="text-xl text-gray-600 dark:text-gray-800  text-start mb-4">
        Profesional: {{ $empleado['name'] }}
    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach($empleado['approvedWeeks'] as $index => $week)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2 shadow-sm transition-all duration-300 hover:shadow-md hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Semana {{ $index + 1 }}</span>
                                    <p class="text-xs text-{{ $week['approved'] ? 'green' : 'yellow' }}-600 dark:text-{{ $week['approved'] ? 'green' : 'yellow' }}-400">
                                        {{ $week['approved'] ? 'Aprobada' : 'Pendiente' }}
                                    </p>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $week['start'] }} - {{ $week['end'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                @php
                    $allApproved = collect($empleado['approvedWeeks'])->every(fn($week) => $week['approved']);
                    $canDownload = $allApproved && $empleado['totalApprovedHours'] >= 160;
                @endphp
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-inner">
                    <div class="flex items-center mb-3">
                        <input type="checkbox" id="certifyHours_{{ $empleado['id'] }}" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                        <label for="certifyHours_{{ $empleado['id'] }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Certifico que las horas mostradas son correctas y autorizo el pago al Profesional
                        </label>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="mb-3 sm:mb-0">
                            <span class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ number_format($empleado['totalApprovedHours'], 2) }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">horas aprobadas</span>
                        </div>
                        <button
                            onclick="downloadReport({{ $empleado['id'] }}, '{{ $empleado['name'] }}')"
                            class="w-full sm:w-auto flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white {{ $canDownload ? 'bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }} transition ease-in-out duration-150"
                            {{ $canDownload ? '' : 'disabled' }}
                        >
                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Descargar Reporte Mensual
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function downloadReport(employeeId, employeeName) {
    const certifyCheckbox = document.getElementById(`certifyHours_${employeeId}`);
    if (!certifyCheckbox.checked) {
        Swal.fire({
            title: 'Certificación requerida',
            text: 'Por favor, certifique que las horas son correctas antes de descargar el reporte.',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    const totalApprovedHours = {{ $totalApprovedHours }};
    if (totalApprovedHours < 160) {
        Swal.fire({
            title: 'Horas insuficientes',
            text: 'No se pueden descargar reportes hasta que se hayan aprobado al menos 160 horas.',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    Swal.fire({
        title: `Descargando reporte de ${employeeName}`,
        text: 'Por favor, espere mientras se genera el reporte...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Simular la descarga (reemplazar con la lógica real de descarga)
    setTimeout(() => {
        Swal.fire({
            title: 'Descarga completada',
            text: `El reporte de ${employeeName} se ha descargado con éxito. Se enviará una copia por correo electrónico en breve.`,
            icon: 'success',
            confirmButtonText: 'Genial'
        });
    }, 2000);
    
    // Iniciar la descarga real
    window.location.href = `{{ route('work-hours.download-monthly-report', ['month' => $currentMonth->format('Y-m')]) }}?employee_id=${employeeId}`;
}
</script>


</x-app-layout>