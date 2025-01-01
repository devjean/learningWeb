<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto flex justify-between items-center py-4 px-6">
                <div class="text-2xl font-bold text-gray-700">
                    <a href="{{ route('home') }}">Learning Web</a>
                </div>
                <nav class="space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Inicio</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800">Sobre Nosotros</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800">Contacto</a>
                    <span id="auth-links"></span>
                </nav>
            </div>
        </header>
    
        <!-- Contenido Principal -->
        <main class="flex-grow">
            <div class="font-sans text-gray-900 antialiased">
                @yield('content')
            </div>
        </main>
    
        @livewireScripts
    
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto text-center">
                <p>&copy; {{ date('Y') }} Learning Web. Todos los derechos reservados.</p>
            </div>
        </footer>
    </body>
</html>
<script>
    async function checkAuth() {
        
        const token = localStorage.getItem('api_token');
        if (!token) {
            
            window.location.href = '/login'; 
        }

        const response = await fetch('/api/user', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const data = await response.json();
            isAdmin = false
            data.roles.forEach(role => {
                if(role.name == "admin"){
                    isAdmin = true
                }
            });
            if(!isAdmin){
                window.location.href = '/'; 
            }
            document.getElementById('auth-links').innerHTML = `
                <a href="#" class="text-gray-600 hover:text-gray-800">Mi Cuenta</a>
                <a href="#" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="logout()">Cerrar Sesión</a>
            `;
        } else {
            localStorage.removeItem('api_token');
            document.getElementById('auth-links').innerHTML = `
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Registrarse</a>
            `;
        }
    }

    async function logout() {
        const token = localStorage.getItem('api_token');
        
        if (!token) {
            alert('No se encontró el token de sesión');
            return;
        }

        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        });

        if (response.ok) {
            localStorage.removeItem('api_token'); 
            window.location.href = '/'; 
        } else {
            alert('Ocurrió un error al cerrar la sesión');
        }
    }

    checkAuth();
</script>