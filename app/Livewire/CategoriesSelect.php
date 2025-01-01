<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesSelect extends Component
{
    public $categories;
    public $categoryId;

    public function mount($category = null)
    {
        $this->categoryId = $category;
        $this->categories = Category::all();
    }

    public function selectedCategory()
    {
        $this->dispatch('categorySelected', $this->categoryId);
    }

    public function render()
    {
        return view('livewire.categories-select');
    }
}
