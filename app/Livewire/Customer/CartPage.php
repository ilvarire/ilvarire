<?php

namespace App\Livewire\Customer;

use App\Mail\OrderCreated;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\ShippingFee;
use App\Services\PaymentGateway;
use App\Services\PaystackService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.user')]
class CartPage extends Component
{
    public $cartItems;
    public $quantities = [];
    public string $couponCode = '';
    public $couponError = null;
    public float $discount = 0;
    public float $grandTotal = 0;
    public float $cartTotal = 0;
    public float $totalWeight = 0;

    public ?array $appliedCoupon = null;
    public array $states = [];
    public ?int $selectedCountry = null;
    public ?string $selectedState = null;
    public string $address = '';
    public string $city = '';
    public string $phone_number = '';
    public float $shippingFee = 0;
    public string $zipCode = '';

    protected $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function mount(ProductService $productService)
    {
        $this->loadData();
    }
    public function loadData()
    {
        $this->cartItems = auth()->check()
            ? $this->productService->getCartItems()
            : $this->productService->getGuestCartItems();

        // $this->quantities = [];
        $this->setQuantities();

        foreach ($this->cartItems as $item) {
            $this->quantities[$item->product->id] = $item->quantity;
        }
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $totals = $this->productService->calculateCartTotal($this->cartItems, $this->appliedCoupon);
        $this->cartTotal = $totals['cartTotal'];
        $this->discount = $totals['discount'];
        $this->grandTotal = $totals['grandTotal'];

        $this->totalWeight = $this->productService->calculateCartWeight($this->cartItems);

        if ($this->selectedCountry) {
            $this->shippingFee = $this->productService->calculateShippingFee(
                $this->totalWeight,
                $this->selectedCountry,
                $this->selectedState
            );

            $this->grandTotal += $this->shippingFee;
        }
    }

    public function applyCoupon()
    {
        if (!$this->couponCode) {
            $this->addError('couponCode', 'Enter a coupon code');
            return;
        }

        $result = $this->productService->applyCoupon($this->couponCode);

        if (isset($result['error'])) {
            $this->addError('couponCode', $result['error']);
            return;
        }

        $this->appliedCoupon = $result['appliedCoupon'];
        $this->calculateTotals();
        session()->flash('success', 'Coupon applied successfully!');
    }

    public function updatedSelectedCountry($value)
    {
        $this->states = ShippingFee::where('country_id', $value)->pluck('state')->unique()->toArray();
        $this->selectedState = null;
        $this->shippingFee = 0;
        $this->calculateTotals();
    }

    public function updatedSelectedState($value)
    {
        $this->calculateTotals();
    }

    protected function setQuantities()
    {
        foreach ($this->cartItems as $item) {
            $this->quantities[$item->product->id] = is_array($item->quantity) ? $item->quantity['quantity'] : $item->quantity;
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        $validated = Validator::make(
            ['quantity' => $quantity],
            ['quantity' => 'required|integer|min:1']
        )->validate();

        $this->productService->updateCartItemQuantity($productId, (int)$quantity);
        $this->loadData();
        session()->flash('success', 'Quantity updated.');
    }

    public function updateCart()
    {
        foreach ($this->cartItems as $item) {
            $productId = $item->product->id;
            $newQuantity = $this->quantities[$productId] ?? $item->quantity;

            if (!is_numeric($newQuantity) || $newQuantity < 1) {
                session()->flash('error', 'Invalid quantity.');
                continue;
            }

            ProductService::updateCartItemQuantity($productId, (int)$newQuantity);
        }

        $this->loadData();
        session()->flash('success', 'Cart updated successfully.');
    }


    public function checkout(ProductService $productService)
    {
        // Ensure only authenticated users can proceed
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Validator::make([
            'address' => $this->address,
            'city' => $this->city,
            'phone_number' => $this->phone_number,
            'zipCode' => $this->zipCode,
            'selectedCountry' => $this->selectedCountry,
            'selectedState' => $this->selectedState,
            'cartItems' => $this->cartItems,
        ], [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:40',
            'phone_number' => 'required|string|max:20',
            'zipCode' => 'required|string|max:10',
            'selectedCountry' => 'required|integer|exists:countries,id',
            'selectedState' => 'required|string|max:30|exists:shipping_fees,state',
            'cartItems' => 'required'
        ])->validate();

        $state = ShippingFee::where('country_id', $this->selectedCountry)
            ->where('state', $this->selectedState)->first();

        if (!$state) {
            return back()->with('error', 'shipping state not found');
        }

        $cartData = $this->productService->getCartItems();
        $appliedCoupon = null;
        $coupon_id = null;

        if ($this->couponCode) {
            $result = $this->productService->applyCoupon($this->couponCode);
            if (isset($result['error'])) {
                $appliedCoupon = null;
                $coupon_id = null;
            } else {
                $appliedCoupon = $result['appliedCoupon'];
                $coupon_id = Coupon::where('code', $result['appliedCoupon']['code'])->value('id');
            }
        } else {
            $appliedCoupon = null;
            $coupon_id = null;
        }

        $weight = $this->productService->calculateCartWeight($cartData);
        $shippingFee = $this->productService->calculateShippingFee(
            $weight,
            $this->selectedCountry,
            $state->state
        );

        $totals = $this->productService->calculateCartTotal($cartData, $appliedCoupon);


        // values
        $total_amount = $totals['grandTotal'] + $shippingFee;

        if (intval($shippingFee) < 1) {
            return back()->with('error', 'shipping details incorrect');
        }

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'reference' => 'ord-' . date('Ymd') . Str::random(6),
                'total_price' => $total_amount,
                'status' => 'pending',
                'discount' => $this->discount,
                'coupon_id' => $coupon_id
            ]);

            ShippingAddress::create([
                'user_id' => Auth::id(),
                'country_id' => $this->selectedCountry,
                'order_id' => $order->id,
                'shipping_fee_id' => $state->id,
                'address' => $this->address,
                'city' => $this->city,
                'phone_number' => $this->phone_number,
                'zip_code' => $this->zipCode,
            ]);

            foreach ($cartData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            DB::commit();

            Mail::to($order->user->email)->send(
                new OrderCreated($order->reference)
            );

            $callbackUrl = route('paystack.callback');
            $paystackService = new PaystackService();
            $response = $paystackService->initializePayment(auth()->user()->email, $total_amount, $order->reference, $callbackUrl);

            if (isset($response['data']['authorization_url'])) {
                Payment::create([
                    'user_id' => auth()->user()->id,
                    'order_id' => $order->id,
                    'transaction_reference' => $response['data']['reference'],
                    'amount' => $total_amount,
                    'payment_method' => 'n/a'
                ]);
                return redirect($response['data']['authorization_url']);
            } else {
                return back()->with('error', 'Payment initialization failed.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'checkout failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.customer.cart-page', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}