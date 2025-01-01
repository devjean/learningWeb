<div>
    <!-- Filtros -->
    <div class="flex mb-4">
        <!-- Filtro de categoría -->
        <div class="mr-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
            <select wire:model="selectedCategory" id="category" class="mt-1 block w-full">
                <option value="">Seleccionar categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filtro de grupo de edad -->
        <div>
            <label for="age-group" class="block text-sm font-medium text-gray-700">Rango de Edad</label>
            <select wire:model="selectedAgeGroup" id="age-group" class="mt-1 block w-full">
                <option value="">Seleccionar rango de edad</option>
                @foreach($ageGroups as $ageGroup)
                    <option value="{{ $ageGroup['id'] }}">{{ $ageGroup['range'] }}</option>
                @endforeach
            </select>
        </div>
        <!-- Campo de búsqueda -->
        <div class="ml-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Buscar Curso</label>
            <input type="text" id="search" class="mt-1 block w-full p-2 border rounded" placeholder="Buscar ..." />
        </div>
    </div>

    <div id="coursesList" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        
    </div>
    
</div>
<script>
    const urlBase = 'http://127.0.0.1:8000/api';
    const apiToken = localStorage.getItem('api_token');

    const categoryFilter = document.getElementById('category');
    const ageGroupFilter = document.getElementById('age-group');
    const searchInput = document.getElementById('search');
    const coursesList = document.getElementById('coursesList');

    async function getCategories() {
        if (!apiToken) {
            window.location.href = '/login';
        }

        const response = await fetch('/api/categories', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const categories = await response.json();
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categoryFilter.appendChild(option);
            });
        }
    }
    async function getAgeGroups() {
        if (!apiToken) {
            window.location.href = '/login';
        }

        const response = await fetch('/api/age-groups', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const ageGroups = await response.json();
            ageGroups.forEach(ageGroup => {
                const option = document.createElement('option');
                option.value = ageGroup.id;
                option.textContent = ageGroup.range;
                ageGroupFilter.appendChild(option);
            });
        }
    }
    
    async function getCourses() {
       
        let url = `${urlBase}/courses?`;
        if (categoryFilter.value) {
            url += `&category=${categoryFilter.value}`;
        }
        if (ageGroupFilter.value) {
            url += `&age_group=${ageGroupFilter.value}`;
        }
        if (searchInput.value) {
            url += `&search=${searchInput.value}`;
        }

        const response = await fetch(url, {
            headers: {
                Authorization: `Bearer ${apiToken}`,
            },
        });

        if (response.ok) {
;            const data = await response.json();
            renderCourses(data);
        }
    }

    function renderCourses(courses) {
        coursesList.innerHTML = '';
        courses.forEach(course => {
            const div = document.createElement('div');
            div.className = 'p-4 border rounded';
            div.innerHTML = `
            <h3 class="font-bold text-lg">${course.title}</h3>
            <p class="text-gray-700">${course.description}</p>
            <button 
                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 view-course-button"
                data-course-id="${course.id}">
                Ver Curso
            </button>
        `;
            coursesList.appendChild(div);
        });

        document.querySelectorAll('.view-course-button').forEach(button => {
            button.addEventListener('click', (event) => {
                const courseId = event.target.getAttribute('data-course-id');
                viewCourse(courseId);
            });
        });
    }

    function viewCourse(courseId) {
        window.location.href = `/courses/${courseId}`;
    }

    getCategories();
    getAgeGroups();
    getCourses();

    categoryFilter.addEventListener('change', getCourses);
    ageGroupFilter.addEventListener('change', getCourses);
    searchInput.addEventListener('input', getCourses);

</script>