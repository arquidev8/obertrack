<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Intranet - Bienvenido</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        'brand-purple': '#1e1b4b',
                        'brand-indigo': '#3b82f6',
                        'brand-light': '#ffffff',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes gradient {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        @keyframes blob {
            0% {transform: translate(0px, 0px) scale(1);}
            33% {transform: translate(30px, -50px) scale(1.1);}
            66% {transform: translate(-20px, 20px) scale(0.9);}
            100% {transform: translate(0px, 0px) scale(1);}
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
    </style>
</head>

<body class="font-sans bg-brand-purple text-brand-light overflow-hidden">
    <div class="relative min-h-screen flex items-center justify-center">
        
        <div class="absolute inset-0 animate-gradient bg-gradient-to-br from-brand-purple via-brand-indigo to-brand-light opacity-50"></div>
        
        <div id="particles-js" class="absolute inset-0"></div>

        <div class="relative z-10 text-center px-4">
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand-indigo to-brand-light">
                    Bienvenido a Obertrack
                </span>
            </h1>
            <p class="text-xl md:text-2xl mb-12 max-w-2xl mx-auto text-brand-light">Descubre un mundo de posibilidades y conecta con tu equipo como nunca antes.</p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/dashboard') }}" class="bg-brand-indigo hover:bg-brand-purple text-brand-light font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                    Acceder al Dashboard
                </a>
            </div>
        </div>

        <!-- <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-indigo rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div> -->
        <!-- <div class="absolute top-0 right-0 w-72 h-72 bg-brand-purple rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div> -->
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {"value": 80},
                "color": {"value": "#ffffff"},
                "shape": {"type": "circle"},
                "opacity": {"value": 0.5, "random": true},
                "size": {"value": 3, "random": true},
                "move": {"enable": true, "speed": 1, "direction": "none", "random": true, "out_mode": "out"}
            },
            "interactivity": {
                "events": {
                    "onhover": {"enable": true, "mode": "repulse"},
                    "onclick": {"enable": true, "mode": "push"}
                }
            }
        });

        // Animaciones con GSAP
        gsap.from("h1", {duration: 1, y: 50, opacity: 0, ease: "power3.out"});
        gsap.from("p", {duration: 1, y: 50, opacity: 0, ease: "power3.out", delay: 0.3});
        gsap.from("a", {duration: 1, y: 50, opacity: 0, ease: "power3.out", delay: 0.6, stagger: 0.2});
    </script>
</body>
</html>