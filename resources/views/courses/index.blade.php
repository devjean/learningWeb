@extends('layouts.guest')
@section('content')
<section class="py-12">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center mb-8">Todos los cursos</h2>
        <div class="container mx-auto">
            @livewire('course-catalog')
        </div>
    </div>
</section>
@endsection