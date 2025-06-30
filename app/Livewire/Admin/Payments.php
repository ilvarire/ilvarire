<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]
class Payments extends Component
{
    use WithPagination;
    public $search = '';
    public $status = '';
    public $orderId = '';
    public $selectedPayment = '';

    protected $queryString = ['search', 'status', 'orderId'];

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
    public function updatingOrderId()
    {
        $this->validate([
            'orderId' => 'regex:/^[a-zA-Z0-9\s\-]+$/'
        ]);
    }
    public function viewPayment($paymentId)
    {
        $this->selectedPayment = Payment::with(['order', 'user'])->findOrFail($paymentId);
        $this->dispatch('openPaymentModal');
    }

    public function cancelPayment($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->status === 'completed') {
            session()->flash('error', 'Cannot mark completed payment as failed');
            return;
        }
        $payment->status = 'failed';
        $payment->save();
        session()->flash('success', 'Payment marked as failed!');
    }

    public function processPayment($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->status === 'completed') {
            $payment->status = 'refunded';
            $payment->save();
            session()->flash('success', 'Payments marked as refunded');
            return;
        }

        $payment->status = 'completed';
        $payment->save();

        session()->flash('success', 'Order marked as processed');
    }

    public function render()
    {
        $payments = Payment::with('user')
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
            ->when(
                $this->orderId,
                fn($query) =>
                $query->where('order_id', $this->orderId)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('livewire.admin.payments', [
            'payments' => $payments
        ]);
    }
}
