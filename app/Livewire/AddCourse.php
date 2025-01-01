<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class AddCourse extends Component
{
    public $title;
    public $description;
    public $categoryId;
    public $groupId;
    public $videoUrls = [];  
    public $videoUrlsInput = '';
    public $videoTitle;
    public $videoDescription;
    public $videoUrl;
    public $videoCategoryId;
    public $categories;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required',
        'videoUrls' => 'nullable|array', 
        'videoUrls.*' => 'url',
        'videoTitle' => 'required|string|max:255',
        'videoDescription' => 'nullable|string',
        'videoUrl' => 'required|url',
        'videoCategoryId' => 'nullable|exists:video_categories,id',  
    ];

    protected $listeners = [
        'categorySelected' => 'handleCategorySelection',
        'groupSelected' => 'handleGroupSelection'
    ];

    public function handleCategorySelection($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function handleGroupSelection($groupId)
    {
        $this->groupId = $groupId;
    }

    public function addVideo()
    {
        $this->videoUrls[] = [
            'title' => $this->videoTitle,
            'description' => $this->videoDescription,
            'url' => $this->videoUrl,
            'category_id' => $this->videoCategoryId,
        ];

        $this->videoTitle = '';
        $this->videoDescription = '';
        $this->videoUrl = '';
        $this->videoCategoryId = null;
    }

    public function updatedVideoUrlsInput($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError('videoUrlsInput', 'El enlace debe ser una URL válida.');
        } else {
            $this->resetErrorBag('videoUrlsInput');
        }
    }

    public function removeVideoUrl($index)
    {
        unset($this->videoUrls[$index]);
        $this->videoUrls = array_values($this->videoUrls); 
    }

    public function store()
    {
        $this->validate();

        $course = new Course([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->categoryId
        ]);

        $course->save();

        $course->ageGroups()->attach($this->groupId);

        foreach ($this->videoUrls as $videoData) {
            $course->videos()->create([
                'title' => $videoData['title'],
                'description' => $videoData['description'],
                'video_url' => $videoData['url'],
                'video_category_id' => $videoData['category_id'],
            ]);
        }

        $this->title = '';
        $this->description = '';
        $this->groupId = null;
        $this->categoryId = null;
        
        session()->flash('message', 'Curso dado de alta exitosamente.');
    }

    public function render()
    {
        return view('livewire.add-course');
    }

    public function mount()
{
    $this->categories = \App\Models\VideoCategory::all();
}
}