<div>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-8 sm:grid-cols-2 lg:grid-cols-1 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Titulo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Categoria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Grupo
                        </th>

                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $course->title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $course->description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $course->category->name }}
                            </td>
                            <td class="px-6 py-4">
                                @foreach($course->ageGroups as $groups)
                                    {{ $groups->range }},
                                @endforeach
                            </td>
                            <td>
                                <a href="{{route('admin-edit-course', ['course' => $course->id])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
