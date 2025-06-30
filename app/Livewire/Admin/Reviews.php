<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\ProductReview;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]
class Reviews extends Component
{
    use WithPagination, WithFileUploads;

    public $confirmingEdit = false;
    public $confirmingDelete = false;
    public $status, $comment, $rating, $reviewId, $review_product_name, $deleteId;
    public $selectedStatus = '';
    public $selectedProduct = '';
    protected $queryString = [
        'selectedStatus' => ['except' => ''],
        'selectedProduct' => ['except' => '']
    ];

    protected $rules = [
        'selectedStatus' => 'nullable|in:pending,approved,rejected',
        'selectedProduct' => 'nullable|exists:products,id'
    ];

    public function updatingSelectedStatus()
    {
        $this->reset(['selectedStatus', 'selectedProduct']);
    }

    public function updatingSelectedProduct()
    {
        $this->reset(['selectedStatus', 'selectedProduct']);
    }

    public function edit($id)
    {
        $review = ProductReview::with(['user', 'product'])->findOrFail($id);
        $this->reviewId = $review->id;
        $this->review_product_name = $review->product->name;
        $this->comment = $review->comment;
        $this->rating = $review->rating;
        $this->status = $review->status;
        $this->confirmingEdit = true;
    }
    public function updateReview()
    {

        $this->validate([
            'status' => 'nullable|in:pending,approved,rejected'
        ]);

        $review = ProductReview::findOrFail($this->reviewId);
        $review->update([
            'status' => $this->status
        ]);

        $this->reset('status');
        $this->dispatch('modal-close');
        session()->flash('success', 'Review updated!');
    }
    public function deleteReview()
    {
        $review = ProductReview::findOrFail($this->deleteId);
        $review->delete();

        $this->deleteId = false;
        $this->confirmingDelete = false;
        session()->flash('success', 'Review deleted successfully!');
    }
    public function resetFilters()
    {
        $this->reset(['selectedStatus', 'selectedProduct']);
    }
    public function render()
    {
        $this->validate();
        $reviews = ProductReview::with(['user', 'product'])
            ->when($this->selectedStatus, fn($q) => $q->where('status', $this->selectedStatus))
            ->when($this->selectedProduct, fn($q) => $q->where('product_id', $this->selectedProduct))
            ->latest()->paginate(20);

        $products = Product::select('id', 'name')->orderBy('name')->get();
        return view('livewire.admin.reviews', [
            'reviews' => $reviews,
            'products' => $products
        ]);
    }
}