@extends('layouts.guest')

@section('content')
<div class="bg-gray-50">
    <section class="bg-blue-500 text-white py-20 ">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold">Aprende lo que siempre quisiste</h1>
            <p class="mt-4 text-lg">Encuentra cursos de alta calidad impartidos por expertos en diversas áreas.</p>
            <div class="mt-6 space-x-4">
                <a href="{{ route('courses') }}" class="px-6 py-3 bg-white text-blue-500 font-semibold rounded-lg hover:bg-gray-100">
                    Explorar Cursos
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600">
                    Regístrate Gratis
                </a>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-8">Nuestros cursos</h2>
            <livewire:popular-courses />
        </div>
    </section>
</div>
@endsection