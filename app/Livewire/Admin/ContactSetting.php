<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class ContactSetting extends Component
{
    public $address, $email, $phone, $facebook_link, $tiktok_link, $instagram_link, $x_link;
    public function mount()
    {
        $contact = Contact::where('id', 1)->firstOrFail();
        $this->address = $contact->address;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->facebook_link = $contact->facebook_link;
        $this->tiktok_link = $contact->tiktok_link;
        $this->instagram_link = $contact->instagram_link;
        $this->x_link = $contact->x_link;
    }

    public function updateContact()
    {
        $this->validate([
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'facebook_link' => 'required|string|max:200',
            'instagram_link' => 'required|string|max:200',
            'tiktok_link' => 'required|string|max:200',
            'x_link' => 'required|string|max:200'
        ]);

        $contact = Contact::where('id', 1)->firstOrFail();
        $contact->update([
            'address' => str($this->address)->trim(),
            'email' => str($this->email)->trim()->lower(),
            'phone' => str($this->phone)->trim(),
            'facebook_link' => str($this->facebook_link)->trim(),
            'instagram_link' => str($this->instagram_link)->trim(),
            'tiktok_link' => str($this->tiktok_link)->trim(),
            'x_link' => str($this->x_link)->trim()
        ]);
        session()->flash('success', 'Contact details updated successfully');
    }
    public function render()
    {
        return view('livewire.admin.contact-setting');
    }
}
