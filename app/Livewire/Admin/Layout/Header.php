<?php

namespace App\Livewire\Admin\Layout;

use App\Models\Order;
use Livewire\Component;

class Header extends Component
{
    public $pendingOrders;

    public function mount()
    {
        // $this->authorizeAccess();
        $this->loadHeaderData();
    }

    public function authorizeAccess()
    {
        if (!auth()->user() || auth()->user()->role !== 1) {
            abort(403, 'Unauthorized');
        }
    }

    public function loadHeaderData()
    {
        $this->pendingOrders = Order::where('status', 'processed')->count();
    }
    public function render()
    {
        return view('livewire.admin.layout.header');
    }
}
