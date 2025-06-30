<?php


use App\Http\Controllers\PaystackController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Customer\AboutPage;
use App\Livewire\Customer\AddressPage;
use App\Livewire\Customer\CartPage;
use App\Livewire\Customer\ContactPage;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\OrderDetailsPage;
use App\Livewire\Customer\OrdersPage;
use App\Livewire\Customer\OrderSuccessPage;
use App\Livewire\Customer\PaymentsPage;
use App\Livewire\Customer\ProductDetailsPage;
use App\Livewire\Customer\ProductsPage;
use App\Livewire\Customer\ProfilePage;
use App\Livewire\Customer\WishlistPage;
use Illuminate\Support\Facades\Route;

//public routes
Route::get('/', HomePage::class)->name('homepage'); //home

Route::get('/products', ProductsPage::class)->name('products'); //product list + filter
Route::get('/product/{slug}', ProductDetailsPage::class)->name('products.show'); // product details
Route::get('/cart', CartPage::class)->name('cart'); // both guest & auth 
Route::get('/wishlist', WishlistPage::class)->name('wishlist'); // both guest & auth 
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');


Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {
    //protected login routes
    Route::get('/orders', OrdersPage::class)->name('orders');
    Route::get('/orders/{reference}', OrderDetailsPage::class)->name('orders.show');


    Route::get('/payments', PaymentsPage::class)->name('payments');

    //payment gateway routes
    Route::get('/paystack/callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack.callback');
    Route::post('/paystack/webhook', [PaystackController::class, 'handle']);

    Route::get('/order/success/{transaction_reference}', OrderSuccessPage::class)->name('order.success');

    Route::get('/profile', ProfilePage::class)->name('profile');
});
