<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CourseCatalog extends Component
{
    public $selectedCategory = null;
    public $selectedAgeGroup = null;
    public $categories = [];
    public $ageGroups = [];
    public $courses = [];
    public $currentPage = 1;
    public $lastPage = 1;
    public $urlBase = "";
    public $apiToken = '';


    public function render()
    {
        return view('livewire.course-catalog');
    }
}
