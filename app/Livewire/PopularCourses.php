<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class PopularCourses extends Component
{
    public function render()
    {
        $courses = Course::orderBy('id', 'desc')->take(4)->get();
        return view('livewire.popular-courses', ['courses' => $courses]);
    }
}
