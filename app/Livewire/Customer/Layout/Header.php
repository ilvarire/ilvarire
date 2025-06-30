<?php

namespace App\Livewire\Customer\Layout;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Wishlist;
use App\Services\ProductService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Header extends Component
{
    public  $cartItems = [];
    public $cartCount = 0;
    public $wishlistCount = 0;
    public $subTotal = 0;

    protected $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->cartItems = Auth::check()
            ? $this->productService->getCartItems()
            : $this->productService->getGuestCartItems();

        $this->calculateCartTotal();
        $this->cartCount = $this->productService->getCartCount();
        $this->wishlistCount = $this->productService->getWishlistCount();
    }

    public function calculateCartTotal()
    {
        $result = $this->productService->calculateCartTotal($this->cartItems);
        $this->subTotal = $result['cartTotal'];
    }

    public function removeFromCart($productId)
    {
        $this->productService->removeFromCart($productId);
        $this->loadData();
    }

    protected $listeners = [
        'cartUpdated' => 'loadData',
        'wishlistUpdated' => 'loadData'
    ];
    public function render()
    {
        return view('livewire.customer.layout.header');
    }
}
