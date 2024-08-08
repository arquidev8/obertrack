{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Tarea') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-2 py-12 sm:px-4 md:px-8">
        <div class="max-w-screen-md mx-auto sm:px-6 md:max-w-2xl lg:px-8 lg:max-w-4xl xl:max-w-6xl">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('tareas.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título:</label>
                            <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="title" name="title" required>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción:</label>
                            <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duración estimada (horas):</label>
                            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="time" id="duration" name="duration" min="0" required>
                        </div>
          
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Tarea
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    @include('empleados.edit_tarea', ['tareas' => $tareas])

</x-app-layout> --}}


{{-- 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Tareas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Creador de Tareas -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium leading-6 mb-4">Crear Nueva Tarea</h3>
                            <form action="{{ route('tareas.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                                    <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"></textarea>
                                </div>
                   
                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duración</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" id="duration" name="duration" readonly required class="flex-1 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" placeholder="00:00:00">
                                        <button type="button" id="startStopBtn" class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-500">
                                            Iniciar
                                        </button>
                                    </div>
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



                  <div class=" w-full lg:w-2/3">
                @include('empleados.edit_tarea', ['tareas' => $tareas])
            </div>

                
            </div>
        </div>
    </div>

    <script>
        // El mismo script de antes para el temporizador
        let timer;
        let isRunning = false;
        let seconds = 0;
        const durationInput = document.getElementById('duration');
        const startStopBtn = document.getElementById('startStopBtn');

        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            return [hours, minutes, seconds]
                .map(v => v < 10 ? "0" + v : v)
                .join(":");
        }

        function startStopTimer() {
            if (isRunning) {
                clearInterval(timer);
                startStopBtn.textContent = 'Reanudar';
                startStopBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                startStopBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                isRunning = false;
            } else {
                timer = setInterval(() => {
                    seconds++;
                    durationInput.value = formatTime(seconds);
                }, 1000);
                startStopBtn.textContent = 'Pausar';
                startStopBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                startStopBtn.classList.add('bg-red-500', 'hover:bg-red-600');
                isRunning = true;
            }
        }

        startStopBtn.addEventListener('click', startStopTimer);

        // Añade esta función al principio de tu script
function setInitialDuration() {
    durationInput.value = "00:00:00";
}

// Llama a esta función cuando se carga la página
document.addEventListener('DOMContentLoaded', setInitialDuration);

// Modifica la función de envío del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    if (durationInput.value === "") {
        e.preventDefault(); // Previene el envío del formulario
        alert("Por favor, inicia el contador o establece una duración.");
    }
});
    </script>
</x-app-layout> --}}






<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
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