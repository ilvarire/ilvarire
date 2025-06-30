<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class Customers extends Component
{
    public $confirmingEdit = false;
    public $confirmingDelete = false;
    public $name, $email;
    #[Validate('nullable|regex:/^[a-zA-Z0-9\s]+$/|max:255')]
    public $search = '';

    #[Validate('required|numeric|exists:roles,id|max:2')]
    public $role_id;
    public $is_active;

    #[Validate('required|numeric|exists:users,id')]
    public $customerId, $deleteId;

    public function edit($id)
    {
        $customer = User::where('id', $id)->where('role', 2)->firstOrFail();
        $this->customerId = $customer->id;
        $this->role_id = $customer->role;
        $this->name = $customer->name;
        $this->is_active = $customer->is_active;
        $this->email = $customer->email;
        $this->confirmingEdit = true;
    }
    public function updateCustomer()
    {
        $this->validate([
            'is_active' => 'boolean',
            'role_id' => 'required|numeric|min:1|max:2'
        ]);

        $customer = User::where('id', $this->customerId)->where('role', 2)->firstOrFail();
        $customer->update([
            'is_active' => $this->is_active,
            'role' => $this->role_id
        ]);
        $this->reset(['customerId', 'name', 'email', 'role_id', 'is_active']);
        $this->dispatch('modal-close');
        session()->flash('success', 'Customer info updated!');
    }

    public function deleteCustomer()
    {
        $customer = User::where('id', $this->deleteId)->where('role', 2)->firstOrFail();
        $customer->delete();

        $this->deleteId = false;
        $this->confirmingDelete = false;
        session()->flash('success', 'Customer deleted successfully!');
    }
    public function render()
    {
        $role = 2;
        // $query = User::query()->where('role', $role);

        $customers = User::where('role', $role)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orderBy('created_at', 'desc')
            ->paginate(5);

        $roles = Role::all();
        return view('livewire.admin.customers', [
            'customers' => $customers,
            'roles' => $roles
        ]);
    }
}