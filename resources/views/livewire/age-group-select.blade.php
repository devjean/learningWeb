<div>
    <select wire:model="groupId" wire:change="selectedGroup" id="age-group" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        <option value="">Seleccionar rango de edad</option>
        @foreach($ageGroups as $ageGroup)
            <option value="{{ $ageGroup['id'] }}">{{ $ageGroup['range'] }}</option>
        @endforeach
    </select>
</div>
