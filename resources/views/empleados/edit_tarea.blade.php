<div class="bg-gray-100 min-h-screen mt-20-">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 mt-10-">Mis Tareas</h1>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($tareas as $tarea)
                    @if($tarea->created_by == auth()->id())
                        <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-medium text-gray-900 truncate">{{ $tarea->title }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $tarea->description }}</p>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 mt-2 sm:mt-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tarea->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $tarea->completed ? 'Completada' : 'En Progreso' }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $tarea->duration ?? 'N/A' }} horas</span>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <button onclick="toggleTaskCompletion({{ $tarea->id }}, {{ $tarea->completed ? 0 : 1 }})"
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white {{ $tarea->completed ? 'bg-green-600 hover:bg-green-700' : 'bg-yellow-600 hover:bg-yellow-700' }} transition duration-150 ease-in-out">
                                    {{ $tarea->completed ? 'Marcar como Pendiente' : 'Marcar como Completada' }}
                                </button>
                                <button onclick="showEditFields({{ $tarea->id }})" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                                    Editar
                                </button>
                                <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta tarea?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition duration-150 ease-in-out">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                            
                            <form id="editForm{{ $tarea->id }}" style="display:none;" action="{{ route('tareas.update', $tarea->id) }}" method="POST" class="mt-4 space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="title{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" id="title{{ $tarea->id }}" name="title" value="{{ $tarea->title }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="description{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="description{{ $tarea->id }}" name="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $tarea->description }}</textarea>
                                </div>
                                <div>
                                    <label for="duration{{ $tarea->id }}" class="block text-sm font-medium text-gray-700">Duración (horas)</label>
                                    <input type="time" id="duration{{ $tarea->id }}" name="duration" min="0" value="{{ $tarea->duration ?? '' }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar cambios
                                </button>
                            </form>
                            
                            @if(isset($tarea->comments) && $tarea->comments->isNotEmpty())
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900">Comentarios</h4>
                                    <ul class="mt-2 space-y-2">
                                        @foreach ($tarea->comments as $comment)
                                            <li class="text-sm text-gray-500">
                                                <span class="font-medium text-gray-900">{{ $comment->user->name }}:</span> {{ $comment->content }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
    function toggleTaskCompletion(taskId, newState) {
        fetch(`/tasks/${taskId}/toggle-completion`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ completed: newState }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el estado de la tarea.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function showEditFields(taskId) {
        const form = document.getElementById(`editForm${taskId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>