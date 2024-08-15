

<style>
    .task-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .task-card:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .task-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .task-body {
        padding: 1rem;
    }

    .task-footer {
        padding: 1rem;
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .priority-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
    }

    .priority-urgent { background-color: #FEE2E2; color: #991B1B; }
    .priority-high { background-color: #FFEDD5; color: #9A3412; }
    .priority-medium { background-color: #FEF9C3; color: #854D0E; }
    .priority-low { background-color: #DBEAFE; color: #1E40AF; }

    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .status-badge::before {
        content: '';
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    .status-completed {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .status-completed::before {
        background-color: #10B981;
    }

    .status-in-progress {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .status-in-progress::before {
        background-color: #F59E0B;
    }

    .task-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .task-button:hover {
        transform: translateY(-1px);
    }

    .toggle-status-button-in-progress {
        background-color: #F59E0B;
        color: white;
    }

    .toggle-status-button-in-progress:hover {
        background-color: #D97706;
    }

    .toggle-status-button-completed {
        background-color: #10B981;
        color: white;
    }

    .toggle-status-button-completed:hover {
        background-color: #059669;
    }

    .edit-form {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
    }

    .comments-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
</style>

<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Mis Tareas</h1>
        
        <div class="space-y-6">
            @foreach($tareas as $tarea)
                @if($tarea->created_by == auth()->id())
                    <div class="task-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="task-header flex justify-between items-center p-4 bg-gray-50">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $tarea->title }}</h3>
                            <div class="flex space-x-2">
                                <span class="priority-badge priority-{{ $tarea->priority }} px-2 py-1 rounded-full text-xs font-medium">
                                    {{ ucfirst($tarea->priority) }}
                                </span>
                                <span id="status-badge-{{ $tarea->id }}" class="status-badge {{ $tarea->completed ? 'status-completed' : 'status-in-progress' }} px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $tarea->completed ? 'Completada' : 'En Progreso' }}
                                </span>
                            </div>
                        </div>
                        <div class="task-body p-4">
                            <p class="text-gray-600 mb-4">{{ $tarea->description }}</p>
                            <div class="flex flex-wrap gap-2 text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $tarea->start_date->format('d/m/Y') }} - {{ $tarea->end_date->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="task-footer flex flex-wrap gap-2 p-4 bg-gray-50">
                        <button onclick="toggleTaskCompletion({{ $tarea->id }})" 
        id="toggle-button-{{ $tarea->id }}" 
        class="task-button {{ $tarea->completed ? 'toggle-status-button-completed' : 'toggle-status-button-in-progress' }} px-4 py-2 rounded-md transition duration-300 ease-in-out">
    {{ $tarea->completed ? 'Marcar como En Progreso' : 'Marcar como Completada' }}
</button>
                            <button onclick="showEditFields({{ $tarea->id }})" class="task-button bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                                Editar
                            </button>
                            <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta tarea?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="task-button bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                                    Eliminar
                                </button>
                            </form>
                            <button onclick="toggleComments({{ $tarea->id }})" class="task-button bg-gray-300 hover:bg-indigo-600 text-black px-4 py-2 rounded-md transition duration-300 ease-in-out">
                                <span id="commentButtonText-{{ $tarea->id }}">Mostrar Comentarios</span>
                                <span id="commentCount-{{ $tarea->id }}" class="ml-2 bg-white text-indigo-500 px-2 py-1 rounded-full text-xs font-bold">{{ $tarea->comments->count() }}</span>
                            </button>
                        </div>
                        
                        <form id="editForm{{ $tarea->id }}" style="display:none;" action="{{ route('tareas.update', $tarea->id) }}" method="POST" class="edit-form p-4 bg-gray-100">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label for="title{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" id="title{{ $tarea->id }}" name="title" value="{{ $tarea->title }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="description{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="description{{ $tarea->id }}" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $tarea->description }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Fecha de inicio</label>
                                        <input type="date" id="start_date{{ $tarea->id }}" name="start_date" value="{{ $tarea->start_date->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="end_date{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Fecha de fin</label>
                                        <input type="date" id="end_date{{ $tarea->id }}" name="end_date" value="{{ $tarea->end_date->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div>
                                    <label for="priority{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Prioridad</label>
                                    <select id="priority{{ $tarea->id }}" name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="low" {{ $tarea->priority == 'low' ? 'selected' : '' }}>Baja</option>
                                        <option value="medium" {{ $tarea->priority == 'medium' ? 'selected' : '' }}>Media</option>
                                        <option value="high" {{ $tarea->priority == 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="urgent" {{ $tarea->priority == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                        
                        <div id="commentsSection-{{ $tarea->id }}" class="hidden bg-gray-50 p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Comentarios</h4>
                            <div id="commentsList-{{ $tarea->id }}" class="space-y-4 mb-6">
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
                            <form onsubmit="addComment(event, {{ $tarea->id }})" class="mt-4">
                                @csrf
                                <div class="flex items-start space-x-4">
                                    <textarea id="newComment-{{ $tarea->id }}" rows="3" class="flex-grow p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Añadir un comentario..."></textarea>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-150 ease-in-out">
                                        <i class="fas fa-paper-plane mr-2"></i>Comentar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
    function toggleComments(taskId) {
        const commentsSection = document.getElementById(`commentsSection-${taskId}`);
        const buttonText = document.getElementById(`commentButtonText-${taskId}`);
        
        if (commentsSection.classList.contains('hidden')) {
            commentsSection.classList.remove('hidden');
            buttonText.textContent = 'Ocultar Comentarios';
        } else {
            commentsSection.classList.add('hidden');
            buttonText.textContent = 'Mostrar Comentarios';
        }
    }

    function showEditFields(taskId) {
        const form = document.getElementById(`editForm${taskId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleComments(taskId) {
        const commentsSection = document.getElementById(`commentsSection-${taskId}`);
        const buttonText = document.getElementById(`commentButtonText-${taskId}`);
        
        if (commentsSection.classList.contains('hidden')) {
            commentsSection.classList.remove('hidden');
            buttonText.textContent = 'Ocultar Comentarios';
        } else {
            commentsSection.classList.add('hidden');
            buttonText.textContent = 'Mostrar Comentarios';
        }
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
            
            // Actualizar el contador de comentarios
            const commentCount = document.getElementById(`commentCount-${taskId}`);
            commentCount.textContent = parseInt(commentCount.textContent) + 1;
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
                
                // Actualizar el contador de comentarios
                const commentCount = document.getElementById(`commentCount-${taskId}`);
                commentCount.textContent = parseInt(commentCount.textContent) - 1;
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

    function toggleTaskCompletion(taskId) {
    const statusBadge = document.getElementById(`status-badge-${taskId}`);
    const toggleButton = document.getElementById(`toggle-button-${taskId}`);
    
    console.log('Toggling completion for task:', taskId);
    
    fetch(`/tasks/${taskId}/toggle-completion`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json().then(data => ({status: response.status, body: data}));
    })
    .then(({status, body}) => {
        console.log('Response data:', body);
        if (status === 200 && body.success) {
            statusBadge.textContent = body.completed ? 'Completada' : 'En Progreso';
            statusBadge.classList.toggle('status-completed', body.completed);
            statusBadge.classList.toggle('status-in-progress', !body.completed);
            
            toggleButton.textContent = body.completed ? 'Marcar como En Progreso' : 'Marcar como Completada';
            toggleButton.classList.toggle('toggle-status-button-completed', body.completed);
            toggleButton.classList.toggle('toggle-status-button-in-progress', !body.completed);
        } else {
            throw new Error(body.message || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el estado de la tarea: ' + error.message);
    });
}
</script>