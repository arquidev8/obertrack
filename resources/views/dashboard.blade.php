<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
        </h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
     
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>

    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 card-hover" data-aos="fade-right">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Menú</h3>
                            <nav>
                                @if (auth()->user()->tipo_usuario == 'empleado')
                                    <a href="{{ route('empleados.crear-tarea') }}" 
                                       class="flex items-center text-gray-700 hover:bg-indigo-50 p-3 rounded-md transition duration-150 ease-in-out">
                                        <span class="material-icons-outlined mr-3 text-blue-400">assignment</span>
                                        {{ __('Crear Tarea') }}
                                    </a>
                                @elseif (auth()->user()->tipo_usuario == 'empleador')
                                    <a href="{{ route('empleadores.tareas-asignadas') }}" 
                                       class="flex items-center text-gray-700 hover:bg-indigo-50 p-3 rounded-md transition duration-150 ease-in-out">
                                        <span class="material-icons-outlined mr-3 text-blue-400">assignment_turned_in</span>
                                        {{ __('Registro de Horas') }}
                                    </a>
                                @endif
                                <a href="/profile" class="flex items-center text-gray-700 hover:bg-indigo-50 p-3 rounded-md transition duration-150 ease-in-out">
                                    <span class="material-icons-outlined mr-3 text-blue-400">person</span>
                                    Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); this.closest('form').submit();"  
                                       class="flex items-center text-gray-700 hover:bg-indigo-50 p-3 rounded-md transition duration-150 ease-in-out">
                                        <span class="material-icons-outlined mr-3 text-blue-400">logout</span>
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                </form>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:w-3/4">
                    <!-- Welcome Card -->
                    <div class="bg-black rounded-lg shadow-md overflow-hidden border border-gray-200 mb-8 card-hover" data-aos="fade-up">
                        <div class="p-8 gradient-bg">
                            <h2 class="text-3xl font-bold text-white mb-4">Bienvenido, <span class="text-blue-400">{{ $nombreUsuario }}</span></h2>
                            <p class="text-gray-100 text-lg mb-6">¿Qué te gustaría hacer hoy?</p>
                            <a href="/empleados/crear-tarea" class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out">Ver tareas</a>
                        </div>
                    </div>

                    <!-- Messages Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 mb-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-8 bg-blue-400">
                            <h2 class="text-3xl font-bold text-white mb-4">Mensajes</h2>
                            <p class="text-gray-100 text-lg mb-6">Mantente conectado con tu equipo</p>
                            <a href="/chat" class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out">Ver mensajes</a>
                        </div>
                    </div>
                    @if (auth()->user()->tipo_usuario == 'empleado')
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 mb-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-8 bg-green-600">
                            <h2 class="text-3xl font-bold text-white mb-4">Registrar Horas</h2>
                            <p class="text-gray-100 text-lg mb-6">Registra las horas diariamente.</p>
                            <a href="{{ route('empleados.crear-tarea') }}" class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out">Registrar Horas</a>
                        </div>
                    </div>
                    @elseif (auth()->user()->tipo_usuario == 'empleador')
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 mb-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-8 bg-green-600">
                            <h2 class="text-3xl font-bold text-white mb-4">Registro de Horas</h2>
                            <p class="text-gray-100 text-lg mb-6">Mantente informado del registro de horas de los profesionales.</p>
                            <a href="{{ route('empleadores.tareas-asignadas') }}" class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out">Ver Resumen</a>
                        </div>
                    </div>
                    @endif

                    <!-- Resources Section -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 card-hover" data-aos="fade-up" data-aos-delay="200">
                        <div class="p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Centro de Recursos</h2>
                            
                            <!-- Video Section -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Visión Corporativa</h3>
                                <div class="aspect-w-16 aspect-h-9">
                                    {{-- <iframe class="w-full h-64 rounded-md shadow-sm" src="https://youtu.be/Pg0diJ_Smc8?si=orxQt_AIsD7-KAkT" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                                <iframe class="w-full h-64 rounded-md shadow-sm" src="https://www.youtube.com/embed/Pg0diJ_Smc8?si=orxQt_AIsD7-KAkT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            </div>

                            <!-- Tools Section -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Herramientas Esenciales</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <a href="https://www.timedoctor.com" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-4 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-150 ease-in-out border border-indigo-200 card-hover">
                                        <img src="https://www.timedoctor.com/favicon.ico" alt="Time Doctor" class="w-12 h-12 mb-3">
                                        <h4 class="text-md font-medium text-gray-900">Time Doctor</h4>
                                        <p class="text-sm text-gray-500 text-center">Gestión de tiempo y productividad</p>
                                    </a>
                                    <a href="https://asana.com" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-4 bg-green-50 rounded-md hover:bg-green-100 transition-colors duration-150 ease-in-out border border-green-200 card-hover">
                                        <img src="https://asana.com/favicon.ico" alt="Asana" class="w-12 h-12 mb-3">
                                        <h4 class="text-md font-medium text-gray-900">Asana</h4>
                                        <p class="text-sm text-gray-500 text-center">Gestión de proyectos y tareas</p>
                                    </a>
                                    <a href="https://slack.com" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-4 bg-purple-50 rounded-md hover:bg-purple-100 transition-colors duration-150 ease-in-out border border-purple-200 card-hover">
                                        <img src="https://slack.com/favicon.ico" alt="Slack" class="w-12 h-12 mb-3">
                                        <h4 class="text-md font-medium text-gray-900">Slack</h4>
                                        <p class="text-sm text-gray-500 text-center">Comunicación de equipo</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
</x-app-layout>




   {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <form action="{{ route('tasks.store') }}" method="post">
    @csrf
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <button type="submit">Create Task</button>
</form> --}}