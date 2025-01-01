<?php

namespace App\Livewire;

use App\Models\Course;
use Illuminate\Http\Request;
use Livewire\Component;

class EditCourse extends Component
{
    public $course;
    public $title;
    public $description;
    public $category;

    protected $listeners = [
        'categorySelected' => 'handleCategorySelection',
    ];

    public function handleCategorySelection($categoryId)
    {
        $this->category->id = $categoryId;
    }

    public function mount($id)
    {
        $this->course = Course::with(['category','ageGroups'])->find($id);
        $this->title = $this->course->title;
        $this->description = $this->course->description;
        $this->category = $this->course->category;

    }

    public function update()
    {
        $this->course->update([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category->id
        ]);

        session()->flash('message', 'Curso actualizado exitosamente.');
    }

    public function render()
    {
        return view('livewire.edit-course');
    }
}
