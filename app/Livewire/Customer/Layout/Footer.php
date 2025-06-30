<?php

namespace App\Livewire\Customer\Layout;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Newsletter;
use Livewire\Component;

class Footer extends Component
{
    public $email;

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email|unique:newsletters,email|max:30'
        ]);
        Newsletter::create([
            'email' => $this->email
        ]);
        $this->reset(['email']);

        return back()->with('status', 'subscribed');
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        $contact = Contact::findOrFail(1);
        return view('livewire.customer.layout.footer', [
            'categories' => $categories,
            'contact' => $contact
        ]);
    }
}
