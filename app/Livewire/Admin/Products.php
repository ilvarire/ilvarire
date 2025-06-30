<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]
class Products extends Component
{
    use WithPagination, WithFileUploads;

    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $name, $is_active = '', $is_featured = '', $brief, $price, $description, $quantity, $tag_ids = [], $weight, $dimensions, $materials, $category_id, $imagees = [], $productId;
    public $newImages = [];
    public $existingImages = [];

    public $deleteId;
    public $tags = [];

    public $category = '';

    public $selectedCategory = '';

    #[Validate('nullable|regex:/^[a-zA-Z0-9\s]+$/|max:255')]
    public $search = '';
    #[Validate('nullable|numeric|min:0')]
    public $minPrice = null;
    #[Validate('nullable|numeric|min:0')]
    public $maxPrice = null;
    // #[Validate('nullable|exists:products,id')]
    public $product_id = '';

    protected $rules = [
        'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3',
        'brief' => 'required|string|min:3|max:500',
        'description' => 'required|string|min:5',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|numeric',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tag_ids' => 'array',
        'tag_ids.*' => 'exists:tags,id',
        'weight' => 'required|numeric',
        'dimensions' => 'string',
        'materials' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'newImages.*' => 'image|max:2048'  //2mb max
    ];

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function updating($property)
    {
        $this->validateOnly($property);
        $this->resetPage();
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->brief = $product->brief;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->tags = $product->tags;
        $this->description = $product->description;
        $this->weight = $product->weight;
        $this->dimensions = $product->dimensions;
        $this->materials = $product->materials;
        $this->category_id = $product->category_id;
        $this->existingImages = $product->images;
        $this->confirmingEdit = true;
    }

    public function updateProduct()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update([
            'name' => str($this->name)->trim()->lower()->ucfirst(),
            'brief' => str($this->brief)->trim()->lower()->ucfirst(),
            'price' => str($this->price)->trim()->lower()->ucfirst(),
            'quantity' => str($this->quantity)->trim()->lower()->ucfirst(),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'weight' => str($this->weight)->trim()->lower()->ucfirst(),
            'dimensions' => str($this->dimensions)->trim()->lower()->ucfirst(),
            'materials' => str($this->materials)->trim()->lower()->ucfirst(),
            'description' => str($this->description)->trim()->lower()->ucfirst(),
            'category_id' => str($this->category_id)->trim()->lower()->ucfirst()
        ]);

        if (!empty($this->tag_ids)) {
            $product->tags()->sync($this->tag_ids);
        }

        if (!empty($this->newImages)) {
            foreach ($this->newImages as $image) {
                $path = $image->store('producs', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }


        $this->resetForm();
        $this->dispatch('modal-close');
        session()->flash('success', 'Product updated!');
    }

    public function deleteProduct()
    {
        $product = Product::findOrFail($this->deleteId);
        $product->images()->delete();
        $product->delete();

        $this->deleteId = false;
        $this->confirmingDelete = false;
        session()->flash('success', 'Product deleted successfully!');
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'brief',
            'description',
            'price',
            'category_id',
            'tag_ids',
            'is_active',
            'is_featured',
            'newImages',
            'quantity',
            'weight',
            'dimensions',
            'materials',
            'existingImages',
            'productId',
            'confirmingEdit',
            'product_id'
        ]);
    }

    public function render()
    {
        $query = Product::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }
        if (!empty($this->product_id)) {
            $query->where('id', $this->product_id);
        }
        if (!empty($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }
        if (!is_null($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $products = $query->with('images', 'category', 'tags')->latest()->paginate(10);
        $categories = Category::all();
        $allTags = Tag::all();
        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => $categories,
            'allTags' => $allTags
        ]);
    }
}
