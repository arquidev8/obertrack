<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Experiencia Inmersiva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-shape-divider-bottom-1628127602 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .custom-shape-divider-bottom-1628127602 svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }
        .custom-shape-divider-bottom-1628127602 .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-purple-900 via-indigo-800 to-blue-900 overflow-hidden">
    <div id="vanta-background" class="fixed inset-0 z-0"></div>
    
    <div class="relative z-10 max-w-md w-full">
        <div class="glassmorphism p-10 rounded-3xl shadow-2xl space-y-8">
            <div class="text-center">
                <h2 class="text-4xl font-extrabold text-white mb-2">Bienvenido</h2>
                <p class="text-indigo-200">Inicia tu viaje con nosotros</p>
            </div>
            
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="relative">
                        <input id="email" name="email" type="email" required 
                               class="w-full px-4 py-3 bg-white bg-opacity-10 rounded-lg text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                               placeholder="Correo electrónico">
                        <svg class="absolute right-3 top-3 h-6 w-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                               class="w-full px-4 py-3 bg-white bg-opacity-10 rounded-lg text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                               placeholder="Contraseña">
                        <svg class="absolute right-3 top-3 h-6 w-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-indigo-300 rounded">
                        <label for="remember_me" class="ml-2 block text-indigo-200">
                            Recordarme
                        </label>
                    </div>
                    <!-- <a href="{{ route('password.request') }}" class="font-medium text-indigo-300 hover:text-indigo-100 transition duration-150 ease-in-out">
                        ¿Olvidaste tu contraseña?
                    </a> -->
                </div>

                <button type="submit" 
                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    Iniciar sesión
                </button>
            </form>
            
            <div class="text-center">
                <!-- <p class="text-sm text-indigo-200">
                    ¿No tienes una cuenta? 
                    <a href="#" class="font-medium text-indigo-300 hover:text-indigo-100 transition duration-150 ease-in-out">
                        Regístrate aquí
                    </a>
                </p> -->
            </div>
        </div>
    </div>

    <!-- <div class="custom-shape-divider-bottom-1628127602">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div> -->

    <script>
        VANTA.NET({
            el: "#vanta-background",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x3b82f6,
            backgroundColor: 0x1e1b4b,
            points: 10.00,
            maxDistance: 25.00,
            spacing: 17.00
        })
    </script>
</body>
</html>