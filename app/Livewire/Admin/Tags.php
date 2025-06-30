<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class Tags extends Component
{
    #[Validate('required|alpha|unique:tags,name|min:2')]

    public $name;
    #[Validate('required|alpha|min:2')]
    public $editName;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $tagId = '';
    function storeTag()
    {
        $this->validateOnly('name');

        Tag::create([
            'name' => str(trim($this->name))->lower()
        ]);

        session()->flash('success', 'New tag created');
        $this->reset('name');
    }
    public function updating($property)
    {
        $this->validateOnly($property);
    }

    function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->editName = $tag->name;
        $this->confirmingEdit = true;
    }

    function updateTag()
    {
        $this->validateOnly('editName');

        $tag = Tag::findOrFail($this->tagId);
        $tag->update([
            'name' => str(trim($this->editName))->title()
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editName', 'tagId']);
        session()->flash('success', 'Tag updated!');
    }

    public function deleteTag()
    {
        $tag = Tag::findOrFail($this->deleteId);
        $tag->delete();
        session()->flash('success', 'Tag deleted!');
        $this->reset(['deleteId']);
    }

    public function render()
    {
        $tags = Tag::all();
        return view('livewire.admin.tags', [
            'tags' => $tags
        ]);
    }
}
