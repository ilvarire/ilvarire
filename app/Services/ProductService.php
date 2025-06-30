<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShippingFee;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    // Universal cart methods
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                ]);
            }
        } else {
            $cart = Session::get('guest_cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity'   => (int) $quantity,
                ];
            }
            Session::put('guest_cart', $cart);
        }
    }

    public function removeFromCart($productId)
    {
        if (Auth::check()) {
            $cart = Cart::firstWhere('user_id', Auth::id());
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $productId)
                    ->delete();
            }
        } else {
            $cart = Session::get('guest_cart', []);
            unset($cart[$productId]);
            Session::put('guest_cart', $cart);
        }
    }

    public static function getCartItems()
    {
        if (Auth::check()) {
            $cart = Cart::firstWhere('user_id', Auth::id());
            if (!$cart) return collect();

            return CartItem::where('cart_id', $cart->id)->with('product.images')->get();
        }

        return collect();
    }

    public static function getGuestCartItems()
    {
        $items = Session::get('guest_cart', []);
        $productIds = array_keys($items);
        $products = Product::whereIn('id', $productIds)->with('images')->get()->keyBy('id');

        return collect($items)->map(function ($item) use ($products) {
            $product = $products[$item['product_id']] ?? null;
            if ($product) {
                return (object)[
                    'product_id' => $product->id,
                    'product'    => $product,
                    'quantity'   => (int) $item['quantity'],
                ];
            }
            return null;
        })->filter();
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return CartItem::whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })->count();
        }

        return count(Session::get('guest_cart', []));
    }


    //checkout cart method
    public function calculateCartTotal($cartItems, ?array $appliedCoupon = null): array
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $discount = 0;
        if ($appliedCoupon) {
            $discount = $subtotal * ($appliedCoupon['discount'] / 100);
        }

        $total = $subtotal - $discount;

        return [
            'cartTotal' => $subtotal,
            'discount' => $discount,
            'grandTotal' => $total,
        ];
    }

    public function calculateCartWeight($cartItems): float
    {
        $weight = 0;
        foreach ($cartItems as $item) {
            $weight += $item->product->weight * $item->quantity;
        }
        return $weight;
    }

    public function calculateShippingFee(float $weight, int $countryId, ?string $state = null): float
    {
        $query = ShippingFee::where('country_id', $countryId);
        if ($state) {
            $query->where('state', $state);
        }

        $shipping = $query->first();
        if (!$shipping) return 0;

        return $shipping->base_fee + ($shipping->fee_per_kg * $weight);
    }

    public function applyCoupon(string $code): array
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['error' => 'Invalid coupon code.'];
        }

        $now = Carbon::now();

        if ($coupon->start_date && $coupon->start_date > $now) {
            return ['error' => 'This coupon is not yet active.'];
        }

        if ($coupon->end_date && $coupon->end_date < $now) {
            return ['error' => 'This coupon has expired.'];
        }

        return [
            'appliedCoupon' => [
                'code' => $coupon->code,
                'discount' => $coupon->discount_percentage,
            ]
        ];
    }

    public static function clearCart(): void
    {
        if (Auth::check()) {
            $cart = Cart::firstWhere('user_id', Auth::id());
            if ($cart) {
                $cart->items()->delete();
            }
        } else {
            session()->forget('guest_cart');
        }
    }

    public static function updateCartItemQuantity($productId, $quantity)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        } else {
            $cart = session()->get('guest_cart', []);
            foreach ($cart as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            session()->put('guest_cart', $cart);
        }
    }

    public function updateCartItems($items)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($items as $item) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item->product->id)
                    ->update(['quantity' => (int) $item->quantity]);
            }
        } else {
            $sessionCart = session()->get('guest_cart', []);

            foreach ($sessionCart as &$sessionItem) {
                foreach ($items as $item) {
                    if ((int) $sessionItem['product_id'] === (int) $item->product->id) {
                        $sessionItem['quantity'] = (int) $item->quantity;
                    }
                }
            }

            session()->put('guest_cart', $sessionCart);
        }
    }

    // WISHLIST FUNCTIONS >>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function addToWishlistOrRemove($productId)
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {

            $user = Auth::user();
            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

            $wishlistItem = WishlistItem::where('wishlist_id', $wishlist->id)
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
            } else {
                WishlistItem::create([
                    'wishlist_id'    => $wishlist->id,
                    'product_id' => $productId
                ]);
            }
        } else {
            // For guest users - store in session
            $wishlist = session()->get('wishlist', []);

            if (array_key_exists($productId, $wishlist)) {
                unset($wishlist[$productId]); // remove if exists
            } else {
                $wishlist[$productId] = [
                    'product_id' => $productId,
                ];
            }

            session()->put('wishlist', $wishlist);
        }

        return true;
    }

    public function getWishlistItems()
    {

        if (Auth::check()) {
            $wishlist = Wishlist::firstWhere('user_id', Auth::id());
            if (!$wishlist) return collect();

            return WishlistItem::where('wishlist_id', $wishlist->id)->with('product.images')->get()
                ->map(function ($item) {
                    return (object)[
                        'product_id' => $item->product_id,
                        'product' => $item->product,
                    ];
                });
        }

        $wishlist = session('wishlist', []);

        return collect($wishlist)->map(function ($item) {
            $product = Product::with('images')->find($item['product_id']);

            return (object)[
                'product_id' => $product->id,
                'product' => $product,
            ];
        });
    }

    public function getWishlistCount()
    {
        if (Auth::check()) {
            return WishlistItem::whereHas('wishlist', function ($query) {
                $query->where('user_id', Auth::id());
            })->count();
        }

        return count(session('wishlist', []));
    }

    public function removeFromWishlist($productId)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $wishlist = Wishlist::where('user_id', $user->id)->first();

            if ($wishlist) {
                WishlistItem::where('wishlist_id', $wishlist->id)
                    ->where('product_id', $productId)
                    ->delete();
            }
        } else {
            $wishlist = session()->get('wishlist', []);

            if (isset($wishlist[$productId])) {
                unset($wishlist[$productId]);
                session()->put('wishlist', $wishlist);
            }
        }

        return true;
    }

    public function isInWishlist($productId)
    {
        $product = Product::findOrFail($productId);
        if (Auth::check()) {
            $user = Auth::user();
            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

            $wishlistItem = WishlistItem::where('wishlist_id', $wishlist->id)
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                return true;
            } else {
                return false;
            }
        } else {
            $wishlistItems = $this->getWishlistItems();
            if (isset($wishlistItems[$product->id])) {
                return true;
            } else {
                return false;
            }
        }
    }


    // syc cart items on login
    public static function syncGuestCartToDatabase($user)
    {
        $guestCart = session('guest_cart', []);

        if (!$guestCart || !is_array($guestCart)) return;

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($guestCart as $item) {
            CartItem::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $item['product_id']],
                ['quantity' => (int) $item['quantity']]
            );
        }

        session()->forget('guest_cart');
    }
}
