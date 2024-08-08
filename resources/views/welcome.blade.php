<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Intranet</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>


</style>

<body class="bg-black text-white">

    <div class="bg-cover bg-center bg-fixed"
        style="background-image: url('https://i.postimg.cc/k4tPqvKH/pexels-seven11nash-380769.jpg')">
        <div class="h-screen flex justify-center items-center">
            <div class="bg-white mx-4 p-8 rounded shadow-md w-full md:w-1/2 lg:w-2/3">
             <div class="flex flex-col items-center justify-center">
                <img src="https://i.postimg.cc/hvq6gWSJ/logo-oberstaff-8.png" alt="Logo" class="mb-4 w-60 h-auto">
                 <h1 class="text-4xl sm:text-8xl font-black text-pink-400 mb-8 text-center">Bienvenido</h1>
            </div>
                <div class="flex flex-wrap justify-center gap-4">
                    @auth
                        <!-- Solo muestra el enlace a Dashboard si el usuario está autenticado -->
                        <a href="{{ url('/dashboard') }}"
                            class="bg-black text-white px-4 py-2 rounded hover:bg-pink-400 transition-colors duration-200 ease-in-out">
                            Dashboard
                        </a>
                    @else
                        <!-- Muestra los enlaces a Login y Register si el usuario no está autenticado -->
                        <a href="{{ route('login') }}"
                            class="bg-black text-white px-4 py-2 rounded hover:bg-pink-400 transition-colors duration-200 ease-in-out">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-black text-white px-4 py-2 rounded hover:bg-pink-400 transition-colors duration-200 ease-in-out">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

</body>

</html>
