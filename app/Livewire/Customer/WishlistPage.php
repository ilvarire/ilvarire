<?php

namespace App\Livewire\Customer;

use App\Services\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.user')]
class WishlistPage extends Component
{
    private $productService;
    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function render()
    {
        $wishlistItems = $this->productService->getWishlistItems();
        return view('livewire.customer.wishlist-page', [
            'wishlistItems' => $wishlistItems
        ]);
    }
}