<?php

use App\Http\Controllers\ProfileController;
use App\Mail\OrderCreated;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return new OrderCreated('ref');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/customer.php';
