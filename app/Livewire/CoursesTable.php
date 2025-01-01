<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CoursesTable extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = Course::with(['category','ageGroups'])->get();
    }

    public function render()
    {
        return view('livewire.courses-table');
    }
}
