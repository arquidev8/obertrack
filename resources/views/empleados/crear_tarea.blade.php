




<x-app-layout>




    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            {{ __('Gestión de Tareas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium leading-6 mb-4">Crear Nueva Tarea</h3>

                            {{-- @if ($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <strong class="font-bold">Oops!</strong>
                                    <span class="block sm:inline">Por favor corrige los siguientes errores:</span>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            @if (session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif

                            {{-- <form action="{{ route('tareas.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                                    <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" value="{{ old('title') }}">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('description') }}</textarea>
                                </div>
                   
                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duración (en horas)</label>
                                    <input type="number" id="duration" name="duration" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" step="0.01" min="0" value="{{ old('duration') }}">
                                </div>
                                <div>
                                    <label for="completed" class="inline-flex items-center">
                                        <input type="checkbox" id="completed" name="completed" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('completed') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Marcar como completada</span>
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                        Crear Tarea
                                    </button>
                                </div>
                            </form> --}}
                            <form action="{{ route('tareas.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                                    <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" value="{{ old('title') }}">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('description') }}</textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de inicio</label>
                                        <input type="date" id="start_date" name="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" value="{{ old('start_date') }}">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de fin</label>
                                        <input type="date" id="end_date" name="end_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" value="{{ old('end_date') }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prioridad</label>
                                    <select id="priority" name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        <option value="low">Baja</option>
                                        <option value="medium" selected>Media</option>
                                        <option value="high">Alta</option>
                                        <option value="urgent">Urgente</option>
                                    </select>
                                </div>
                                {{-- <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duración (en horas)</label>
                                    <input type="number" id="duration" name="duration" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" step="0.01" min="0" value="{{ old('duration') }}">
                                </div> --}}
                                <div>
                                    <label for="completed" class="inline-flex items-center">
                                        <input type="checkbox" id="completed" name="completed" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('completed') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Marcar como completada</span>
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                        Crear Tarea
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    @include('empleados.edit_tarea', ['tareas' => $tareas])
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>