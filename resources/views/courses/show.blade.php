@extends('layouts.guest')

@section('content')
<section class="py-12">
    <div class="container mx-auto">
        <div class="container mx-auto py-8" id="course-container">
        </div>
    </div>
</section>
@endsection

<script>
    const apiToken = localStorage.getItem('api_token'); 
    const courseId = "{{ $course->id }}"; 
    const videoRoute = "{{ route('video', ['courseId' => '__courseId__', 'videoId' => '__videoId__']) }}";

    async function fetchCourseData() {
        const response = await fetch(`/api/courses/${courseId}`, {
            headers: {
                'Authorization': `Bearer ${apiToken}`,  // Autenticación Bearer
            }
        });

        if (response.ok) {
            const data = await response.json();
            renderCourse(data);
        } else {
            console.error('No se pudo obtener el curso');
        }
    }

    function renderCourse(data) {
        const courseContainer = document.getElementById('course-container');
        const course = data.course;
        const isSubscribed = data.isSubscribed;
        const progress = data.progress;
        
        courseContainer.innerHTML = `
            <h1 class="text-3xl font-bold">${course.title}</h1>
            <p class="text-gray-700">${course.description}</p>
            <p><strong>Categoría:</strong> ${course.category ? course.category.name : 'No disponible'}</p>
            <p><strong>Grupos de Edad:</strong> ${course.age_groups ? course.age_groups.map(ageGroup => ageGroup.range).join(', ') : 'No disponible'}</p>

            ${isSubscribed ? `
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold">Contenido del Curso</h2>
                    <ul class="list-disc list-inside mt-2">
                        ${course.videos ? course.videos.map(video => `
                            <li>
                                <a href="${videoRoute.replace('__courseId__', course.id).replace('__videoId__', video.id)}" class="text-blue-500 hover:underline">${video.title}</a>
                            </li>
                        `).join('') : 'No hay videos disponibles'}
                    </ul>
                    
                    <div class="mt-4">
                        <h3 class="text-xl">Progreso: ${progress}%</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                            <div class="bg-blue-500 h-4 rounded-full" 
                                style="width: ${progress}%">
                            </div>
                        </div>
                    </div>
                </div>
            ` : `
                <form id="subscribeForm" method="POST">
                    <button type="button" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="subscribeToCourse(${course.id})">
                        Suscribirse al Curso
                    </button>
                </form>
            `}
        `;
    }
    async function subscribeToCourse(courseId) {
        const apiToken = localStorage.getItem('api_token');
        const response = await fetch(`/api/courses/subscribe/${courseId}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (response.ok) {
            alert("Te has suscrito al curso exitosamente.");
            window.location.reload();
        } else {
            alert("Error al suscribirse al curso.");
        }
    }

    fetchCourseData();
</script>
