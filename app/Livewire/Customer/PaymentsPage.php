<?php

namespace App\Livewire\Customer;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.user')]
class PaymentsPage extends Component
{
    public function render()
    {
        $payments = Payment::with('order')->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.customer.payments-page', [
            'payments' => $payments
        ]);
    }
}