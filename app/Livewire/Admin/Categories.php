<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class Categories extends Component
{

    #[Validate('required|alpha|unique:categories,name')]

    public $name;
    #[Validate('required|alpha|min:2')]
    public $editName;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $categoryId = '';
    function storeCategory()
    {
        $this->validateOnly('name');

        $category = Category::create([
            'name' => str(trim($this->name))->lower()
        ]);

        session()->flash('success', 'new category created');
        $this->reset('name');
    }
    public function updating($property)
    {
        $this->validateOnly($property);
    }

    function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->editName = $category->name;
        $this->confirmingEdit = true;
    }

    function updateCategory()
    {
        $this->validateOnly('editName');

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => str(trim($this->editName))->lower()
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editName', 'categoryId']);
        session()->flash('success', 'Category updated!');
    }

    public function deleteCategory()
    {
        $category = Category::findOrFail($this->deleteId);
        $category->delete();
        session()->flash('success', 'Category deleted!');
        $this->reset(['deleteId']);
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.categories', [
            'categories' => $categories
        ]);
    }
}
