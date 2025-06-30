<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class Countries extends Component
{
    #[Validate("required|regex:/^[a-zA-Z0-9\s\,&']+$/|min:2")]
    public $name;

    #[Validate('required|alpha|unique:countries|max:8')]
    public $code;
    public $editName;
    public $editCode;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $countryId = '';
    function storeCountry()
    {
        $this->validate();

        Country::create([
            'name' => str($this->name)->trim()->lower()->title(),
            'code' => str($this->code)->trim()->upper()
        ]);

        session()->flash('success', 'New country created');
        $this->reset(['name', 'code']);
    }
    public function updating($property)
    {
        $this->validateOnly($property);
    }

    function edit($id)
    {
        $country = Country::findOrFail($id);
        $this->countryId = $country->id;
        $this->editName = $country->name;
        $this->editCode = $country->code;
        $this->confirmingEdit = true;
    }

    function updateCountry()
    {
        $this->validate([
            'editName' => "required|regex:/^[a-zA-Z0-9\s\,&']+$/|min:2",
            'editCode' => 'required|alpha|unique:countries|max:8',
            'countryId' => 'required|exists:countries,id'
        ]);

        $country = Country::findOrFail($this->countryId);
        $country->update([
            'name' => str($this->editName)->trim()->lower()->title(),
            'code' => str($this->editCode)->trim()->upper()
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editName', 'editCode', 'countryId']);
        session()->flash('success', 'Country updated!');
    }

    public function deleteCountry()
    {
        $country = Country::findOrFail($this->deleteId);
        $country->delete();
        session()->flash('success', 'Country deleted!');
        $this->reset(['deleteId']);
    }

    public function render()
    {
        $countries = Country::all();
        return view('livewire.admin.countries', [
            'countries' => $countries
        ]);
    }
}
