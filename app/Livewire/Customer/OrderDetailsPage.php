<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]

class OrderDetailsPage extends Component
{
    public Order $order;

    public function mount($reference)
    {
        $this->order = Order::with(['orderItems.product.images', 'shippingAddress.shippingFee.country', 'coupon'])
            ->where('reference', $reference)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();
    }
    public function render()
    {
        return view('livewire.customer.order-details-page');
    }
}