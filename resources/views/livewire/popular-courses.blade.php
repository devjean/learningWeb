<div>
    @foreach($courses as $course)
        <div class="bg-white shadow-md rounded-lg p-4 mb-1.5">
            <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
            <p class="mt-2 text-gray-600">{{ $course->description }}</p>
            <a href="{{ route('courses.show', $course) }}" class="block mt-4 text-blue-500 hover:underline">
                Ver Curso
            </a>
        </div>
    @endforeach
</div>
