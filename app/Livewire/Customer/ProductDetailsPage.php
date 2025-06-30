<?php

namespace App\Livewire\Customer;

use App\Models\Product;
use App\Models\ProductReview;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;


#[Layout('layouts.user')]
class ProductDetailsPage extends Component
{
    #[Validate('nullable|exists:products,id')]
    public $selectedProduct = '';
    public Product $product;
    public $quantity = 1;
    public bool $canReview = false;
    protected $productService;
    public $productId;
    public string $message = '';
    public int $rating = 0;

    public $reviews;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function mount($slug)
    {
        $this->product = Product::with(['images', 'category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();
        $this->reviews = ProductReview::with('user')
            ->where('product_id', $this->product->id)
            ->where('status', 'approved')->get();
        $productId = $this->product->id;

        if (Auth::check()) {
            $this->canReview = $this->userCanReview(Auth::id(), $productId);
        }
    }

    protected function userCanReview($userId, $productId): bool
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.status', 'delivered')
            ->exists();
    }

    public function submitReview()
    {
        $this->validate([
            'message' => 'required|string|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existingReview = ProductReview::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $this->rating,
                'message' => $this->message,
                'status' => 'pending', // must be re-approved after edit
            ]);
        } else {
            ProductReview::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'comment' => $this->message,
                'rating' => $this->rating,
            ]);
        }

        session()->flash('success', 'Review submitted successfully!');
        $this->reset('message', 'rating');
    }

    public function addToCart($productId)
    {

        $this->validate([
            'quantity' => 'required|min:1|max:200'
        ]);

        $this->productService->addToCart($productId, $this->quantity);

        $this->dispatch('cartUpdated');
        $this->dispatch('reinitmodal');
        $this->quantity = 1; // reset quantity
    }

    public function addToWishlist($productId)
    {
        $this->productService->addToWishlistOrRemove($productId);
        $this->dispatch('cartUpdated');
        $this->dispatch('reinitmodal');
    }

    public function viewProduct($id)
    {
        $this->selectedProduct = Product::with('images')->findOrFail($id);
        $this->dispatch('reinitmodal');
    }

    public function isInWishlist($productId)
    {
        $res = $this->productService->isInWishlist($productId);
        return $res;
    }

    public function render()
    {
        $WishlistItems =  $this->productService->getWishlistItems();
        $relatedProducts = Product::with(['images', 'category'])->where('category_id', $this->product->category->id)
            ->where('id', '!=', $this->product->id)->get();
        return view('livewire.customer.product-details-page', [
            'relatedProducts' => $relatedProducts,
            'wishlistItems' => $WishlistItems
        ]);
    }
}
