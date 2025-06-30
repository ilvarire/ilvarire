<?php

namespace App\Livewire\Customer;

use App\Models\Ad;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Hero;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('layouts.user')]

class HomePage extends Component
{

    use WithPagination;

    #[Validate('nullable|string|max:255')]
    public $search = '';

    #[Validate('nullable|exists:products,id')]
    public $selectedProduct = '';
    public $productId;
    public $category = null;
    public $tag = null;
    public $sort = 'default';
    public $priceRange = null;
    public $perPage = 20;
    public $quantity = 1;

    public array $wishlistProductIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
        'tag' => ['except' => null],
        'sort' => ['except' => 'default'],
        'priceRange' => ['except' => null]
    ];

    protected $updatesQueryString = [
        'search',
        'category',
        'tag',
        'priceRange',
        'sort'
    ];

    protected $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function setCategory($categoryName)
    {
        $this->category = is_string($categoryName) && ctype_alpha($categoryName) ? (string) $categoryName : null;
        $this->resetPage();
    }

    public function setTag($tagName)
    {
        $this->tag = is_string($tagName) && ctype_alpha($tagName) ? (string) $tagName : null;
        $this->resetPage();
    }
    public function setPriceRange($range)
    {
        $allowedRanges = ['0-50', '50-100', '100-150', '150-200', '200+'];
        if (in_array($range, $allowedRanges)) {
            $this->priceRange = $range;
            $this->resetPage();
        } else {
            $this->priceRange = null;
            $this->resetPage();
        }
    }

    public function setSort($sortOption)
    {
        $allowedSorts = ['default', 'popularity', 'newness', 'price_low_high', 'price_high_low'];
        if (in_array($sortOption, $allowedSorts)) {
            $this->sort = $sortOption;
            $this->resetPage();
        }
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    protected function applyPriceRange($query)
    {
        if ($this->priceRange === '0-50') {
            $query->whereBetween('price', [0, 50]);
        } elseif ($this->priceRange === '50-100') {
            $query->whereBetween('price', [50, 100]);
        } elseif ($this->priceRange === '100-150') {
            $query->whereBetween('price', [100, 150]);
        } elseif ($this->priceRange === '150-200') {
            $query->whereBetween('price', [150, 200]);
        } elseif ($this->priceRange === '200+') {
            $query->where('price', '>=', 200);
        }
        return $query;
    }

    public function applySorting($query)
    {
        return match ($this->sort) {
            'popularity' => $query->withCount('orderItems')->orderBy('order_items_count', 'desc'),
            'newness' => $query->orderBy('created_at', 'desc'),
            'price_low_high' => $query->orderBy('price', 'asc'),
            'price_high_low' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('name', 'asc')
        };
    }

    public function mount($productId = null)
    {
        $this->productId = $productId;
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


    public function updatingSearch($search)
    {
        $this->validateOnly($search);
        $this->resetPage();
    }

    public function viewProduct($id)
    {
        $this->selectedProduct = Product::with('images')->findOrFail($id);
        $this->dispatch('reinitmodal');
    }

    public function addToWishlist($productId)
    {
        $this->productService->addToWishlistOrRemove($productId);
        $this->dispatch('cartUpdated');
    }

    public function isInWishlist($productId)
    {
        $res = $this->productService->isInWishlist($productId);
        return $res;
    }

    public function render()
    {
        $productsQuery = Product::query()
            ->with(['category', 'tags', 'images'])
            ->where('is_active', true);

        if (!empty($this->search)) {
            $productsQuery->where('name', 'like', '%' . $this->search . '%');
        }
        if ($this->category) {
            $category = Category::where('name', $this->category)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        if ($this->tag) {
            $productsQuery->whereHas('tags', function ($q) {
                $q->where('tags.name', $this->tag);
            });
        }

        $productsQuery = $this->applyPriceRange($productsQuery);
        $productsQuery = $this->applySorting($productsQuery);

        $products = $productsQuery->paginate($this->perPage);

        $categories = Category::orderBy('name')->get();
        $heroDatas = Hero::all();
        $bannerDatas = Ad::all();
        $tags = Tag::orderBy('name')->get();
        $WishlistItems =  $this->productService->getWishlistItems();

        return view('livewire.customer.home-page', [
            'products' => $products,
            'categories' => $categories,
            'heroDatas' => $heroDatas,
            'bannerDatas' => $bannerDatas,
            'tags' => $tags,
            'wishlistItems' => $WishlistItems
        ]);
    }
}
