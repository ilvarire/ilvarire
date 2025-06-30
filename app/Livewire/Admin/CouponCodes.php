<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class CouponCodes extends Component
{
    #[Validate('required|string|unique:coupons|min:2')]
    public $code;

    #[Validate('required|numeric|max:90')]
    public $discount;
    #[Validate('required|date')]
    public $startDate;
    #[Validate('required|date')]
    public $endDate;
    public $editCode, $editDiscount, $editStartDate, $editEndDate;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $couponId = '';
    function storeCoupon()
    {
        $this->validate();

        Coupon::create([
            'code' => str($this->code)->trim()->upper(),
            'discount_percentage' => str($this->discount)->trim(),
            'start_date' => str($this->startDate)->trim(),
            'end_date' => str($this->endDate)->trim()
        ]);

        session()->flash('success', 'New coupon code created');
        $this->reset(['discount', 'code', 'startDate', 'endDate']);
    }
    public function updating($property)
    {
        $this->validateOnly($property);
    }

    function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $coupon->id;
        $this->editCode = $coupon->code;
        $this->editDiscount = $coupon->discount_percentage;
        $this->editStartDate = $coupon->start_date;
        $this->editEndDate = $coupon->end_date;
        $this->confirmingEdit = true;
    }

    function updateCoupon()
    {
        $this->validate([
            'editCode' => 'required|alpha_num|max:25|min:3',
            'editDiscount' => 'required|numeric|max:100|min:5',
            'editStartDate' => 'date',
            'editEndDate' => 'date'
        ]);

        $coupon = Coupon::findOrFail($this->couponId);
        $coupon->update([
            'code' => str($this->editCode)->trim()->upper(),
            'discount_percentage' => str($this->editDiscount)->trim(),
            'start_date' => str($this->editStartDate)->trim(),
            'end_date' => str($this->editEndDate)->trim(),
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editDiscount', 'editCode', 'editStartDate', 'editEndDate', 'couponId']);
        session()->flash('success', 'Coupons updated!');
    }

    public function deleteCoupon()
    {
        $coupon = Coupon::findOrFail($this->deleteId);
        $coupon->delete();
        session()->flash('success', 'Coupon deleted!');
        $this->reset(['deleteId']);
    }

    public function render()
    {
        $coupons = Coupon::all();
        return view('livewire.admin.coupon-codes', [
            'coupons' => $coupons
        ]);
    }
}
