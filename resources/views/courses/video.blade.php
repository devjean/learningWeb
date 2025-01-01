@extends('layouts.guest')

@section('content')
<section class="py-12">
    <div class="container mx-auto">
        <div class="container mx-auto">
            @livewire('course-video', ['courseId' => $courseId, 'videoId' => $videoId])
        </div>
    </div>
</section>
@endsection