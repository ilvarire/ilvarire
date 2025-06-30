<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\ShippingFee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]
class ShippingRates extends Component
{
    use WithPagination;
    public $shippingRateId, $country_id, $state, $base_fee, $fee_per_kg;
    public $confirmingEdit = false;
    public $confirmingDelete = false;
    public $deleteId;

    public $selectedCountry = '';

    #[Validate('nullable|regex:/^[a-zA-Z0-9\s]+$/|max:255')]
    public $search = '';
    public function edit($id)
    {
        $shippingRate = ShippingFee::with('country')->findOrFail($id);
        $this->shippingRateId = $shippingRate->id;
        $this->country_id = $shippingRate->country_id;
        $this->state = $shippingRate->state;
        $this->base_fee = $shippingRate->base_fee;
        $this->fee_per_kg = $shippingRate->fee_per_kg;
        $this->confirmingEdit = true;
    }

    public function updateShippingRate()
    {
        $this->validate([
            'country_id' => 'required|exists:countries,id|max:255',
            'state' => "required|regex:/^[a-zA-Z0-9\s\.,'&]+$/|max:255",
            'base_fee' => 'required|numeric|min:0',
            'fee_per_kg' => 'required|numeric|min:0',
            'shippingRateId' => 'required|exists:shipping_fees,id'
        ]);

        $shippingRate = ShippingFee::findOrFail($this->shippingRateId);
        $shippingRate->update([
            'country_id' => $this->country_id,
            'state' => str($this->state)->trim()->title(),
            'base_fee' => str($this->base_fee)->trim(),
            'fee_per_kg' => str($this->fee_per_kg)->trim()
        ]);

        $this->reset(['country_id', 'state', 'base_fee', 'fee_per_kg', 'shippingRateId']);
        $this->dispatch('modal-close');
        session()->flash('success', 'Shipping rate updated!');
    }
    public function deleteShippingRate()
    {
        $shippingRate = ShippingFee::findOrFail($this->deleteId);
        $shippingRate->delete();

        $this->deleteId = false;
        $this->confirmingDelete = false;
        session()->flash('success', 'Shipping rate deleted successfully!');
    }

    public function render()
    {
        $query = ShippingFee::query();

        if (!empty($this->search)) {
            $query->where('state', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->selectedCountry)) {
            $query->where('country_id', $this->selectedCountry);
        }

        $shippingRates = $query->with('country')->latest()->paginate(10);
        $countries = Country::all();

        return view('livewire.admin.shipping-rates', [
            'shippingRates' => $shippingRates,
            'countries' => $countries
        ]);
    }
}
