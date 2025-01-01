@extends('layouts.guest')
@section('content')
<div class="bg-gray-50">
    <section class="py-12 mx-96">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center">Iniciar Sesión</h2>

            <form id="loginForm" class="mx-44">
                @csrf
    
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="email" name="email" required autofocus autocomplete="username" />
                </div>
    
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="password" name="password" required autocomplete="current-password" />
                </div>
    
                <div class="flex items-center justify-center mt-4">
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-700">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('api_token', data.token);
            window.location.href = '/';
        } else {
            alert('Credenciales incorrectas.');
        }
    });
</script>
@endsection