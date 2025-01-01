<?php

namespace App\Livewire;

use App\Models\AgeGroup;
use Livewire\Component;

class AgeGroupSelect extends Component
{
    public $ageGroups;
    public $groupId;

    public function mount()
    {
        $this->ageGroups = AgeGroup::all();
    }

    public function selectedGroup()
    {
        $this->dispatch('groupSelected', $this->groupId);
    }

    public function render()
    {
        return view('livewire.age-group-select');
    }
}
