<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class SendEmails extends Component
{
    public function render()
    {
        return view('livewire.admin.send-emails');
    }
}
