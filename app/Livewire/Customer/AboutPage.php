<?php

namespace App\Livewire\Customer;

use App\Models\About;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]
class AboutPage extends Component
{
    public function render()
    {
        $about = About::findOrFail(1);
        return view('livewire.customer.about-page', [
            'about' => $about
        ]);
    }
}
