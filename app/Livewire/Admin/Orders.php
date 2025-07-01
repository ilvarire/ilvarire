<?php

namespace App\Livewire\Admin;

use App\Mail\OrderDelivered;
use App\Mail\OrderRefunded;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]
class Orders extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $selectedOrder = '';

    protected $queryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->validate([
            'search' => 'regex:/^[a-zA-Z0-9\s]+$/'
        ]);
    }
    public function updatingStatus()
    {
        $this->validate([
            'status' => 'regex:/^[a-zA-Z0-9\s]+$/'
        ]);
    }
    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['orderItems.product.images', 'user', 'shippingAddress.shippingFee.country', 'coupon'])->findOrFail($orderId);
        $this->dispatch('openOrderModal');
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === 'delivered') {
            session()->flash('error', 'Cannot cancel delivered orders');
            return;
        }
        if ($order->payment_status != 'paid') {
            session()->flash('error', 'Cannot cancel unpaid orders');
            return;
        }
        $order->status = 'cancelled';
        $order->payment_status = 'refunded';
        $order->save();

        // send order cancelled email
        Mail::to($order->user->email)->queue(
            new OrderRefunded($order->reference)
        );
        session()->flash('success', 'Order cancelled!');
    }

    public function shipOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'processed') {
            session()->flash('error', 'Only processing orders can be shipped');
            return;
        }

        $order->status = 'shipped';
        $order->save();

        //send order shipped email
        Mail::to($order->user->email)->queue(
            new OrderShipped($order->reference)
        );
        session()->flash('success', 'Order marked as shipped');
    }

    public function deliverOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'shipped') {
            session()->flash('error', 'Only shipped orders can be delivered');
            return;
        }

        $order->status = 'delivered';
        $order->save();
        //send order delivered email
        Mail::to($order->user->email)->queue(
            new OrderDelivered($order->reference)
        );
        session()->flash('success', 'Order marked as delivered');
    }

    public function render()
    {
        $orders = Order::with('user')
            ->when($this->search, fn($query) =>
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            ))
            ->when(
                $this->status,
                fn($query) =>
                $query->where('status', $this->status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('livewire.admin.orders', [
            'orders' => $orders
        ]);
    }
}
