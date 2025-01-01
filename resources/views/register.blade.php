@extends('layouts.guest')
@section('content')
<div class="bg-gray-50 ">
    <section class="py-12 mx-96">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center">Crear cuenta</h2>
        
            <form id="registerForm" class="mx-44">
                @csrf
        
                <!-- Name -->
                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="text" name="name" required autofocus>
                    <span id="name-error" class="text-red-600 text-xs hidden"></span>
                </div>
        
                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="email" name="email" required>
                    <span id="email-error" class="text-red-600 text-xs hidden"></span>
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="password" name="password" required>
                    <span id="password-error" class="text-red-600 text-xs hidden"></span>
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" type="password" name="password_confirmation" required>
                </div>
        
                <div class="flex items-center justify-center mt-4">
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-700">
                        {{ __('Registrarse') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
            }),
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('api_token', data.token);
            window.location.href = '/';
        } else {
            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById('name-error').innerText = data.errors.name[0];
                    document.getElementById('name-error').classList.remove('hidden');
                }
                if (data.errors.email) {
                    document.getElementById('email-error').innerText = data.errors.email[0];
                    document.getElementById('email-error').classList.remove('hidden');
                }
                if (data.errors.password) {
                    document.getElementById('password-error').innerText = data.errors.password[0];
                    document.getElementById('password-error').classList.remove('hidden');
                }
            } else {
                alert('Error: ' + data.message);
            }
        }
    });
</script>
@endsection