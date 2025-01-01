<div>
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('message') }}
        </div>
    @endif
    <section class="flex items-center justify-center min-h-screen bg-gray-100">
        <form class="w-full max-w-md p-6 bg-white rounded-lg shadow-md" wire:submit.prevent="update">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-6">
                    <h2 class="text-base/7 font-semibold text-gray-900">
                        Editar curso
                    </h2>

                    <div class="mt-10 col-span-full">
                        <label for="first-name" class="block text-sm/6 font-medium text-gray-900">Titulo</label>
                        <div class="mt-2">
                            <input wire:model="title" type="text" name="title" id="title" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>

                    <div class="mt-10 col-span-full">
                        <label for="about" class="block text-sm/6 font-medium text-gray-900">Descripcion</label>
                        <div class="mt-2">
                            <textarea wire:model="description" name="description" id="description" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                        </div>
                    </div>


                    <div class="mt-10 sm:grid-cols-6">
                        <label for="country" class="block text-sm/6 font-medium text-gray-900">Categoria</label>
                        <div class="mt-2 grid grid-cols-1">
                            @livewire('categories-select', ['category' => $course->category->id])
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
            </div>
        </form>
    </section>
</div>
