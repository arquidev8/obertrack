<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Tareas Asignadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex-1">
                            <input type="text" id="search" placeholder="Buscar tareas..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('manager.tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Crear Nueva Tarea
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow overflow-y-auto relative">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white dark:bg-gray-900 table-striped relative">
                            <thead>
                                <tr class="text-left">
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Título</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Asignado a</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Fecha de inicio</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Fecha de finalización</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Prioridad</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Estado</th>
                                    <th class="bg-gray-100 dark:bg-gray-800 sticky top-0 border-b border-gray-200 dark:border-gray-700 px-6 py-3 text-gray-600 dark:text-gray-400 font-bold tracking-wider uppercase text-xs">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tareas as $tarea)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">{{ $tarea->title }}</td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">{{ $tarea->visibleTo->name }}</td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">{{ $tarea->start_date->format('d/m/Y') }}</td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">{{ $tarea->end_date->format('d/m/Y') }}</td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($tarea->priority == 'low') bg-green-100 text-green-800
                                            @elseif($tarea->priority == 'medium') bg-yellow-100 text-yellow-800
                                            @elseif($tarea->priority == 'high') bg-orange-100 text-orange-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($tarea->priority) }}
                                        </span>
                                    </td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($tarea->completed) bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                            {{ $tarea->completed ? 'Completada' : 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                                        <a href="{{ route('manager.tasks.edit', $tarea->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $tarea->id }}').submit();">Eliminar</a>
                                        <form id="delete-form-{{ $tarea->id }}" action="{{ route('manager.tasks.destroy', $tarea->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tareas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const rows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    </script>

</x-app-layout>