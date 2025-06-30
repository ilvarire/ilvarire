<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]

class OrdersPage extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->select('reference', 'total_price', 'status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.customer.orders-page', [
            'orders' => $orders
        ]);
    }
}
