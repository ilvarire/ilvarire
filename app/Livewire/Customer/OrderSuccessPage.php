<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]

class OrderSuccessPage extends Component
{
    public Payment $payment;

    public function mount($transaction_reference)
    {
        $this->payment = Payment::where('user_id', auth()->user()->id)
            ->where('status', 'completed')
            ->where('transaction_reference', $transaction_reference)
            ->firstOrFail();
    }
    public function render()
    {
        return view('livewire.customer.order-success-page');
    }
}
