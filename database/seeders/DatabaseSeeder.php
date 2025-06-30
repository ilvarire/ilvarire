<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductTag;
use App\Models\ShippingAddress;
use App\Models\ShippingFee;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            CouponSeeder::class,
            AboutSeeder::class,
            AdSeeder::class,
            ContactSeeder::class,
            HeroSeeder::class,
            NewsletterSeeder::class

        ]);
        User::factory(3)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@mail.com',
            'role' => '1',
            'password' => 'password123'
        ]);

        $this->call([
            // CategorySeeder::class,
            // ProductSeeder::class,
            // ProductImageSeeder::class,
            // ProductReviewSeeder::class,
            // TagSeeder::class,
            // ProductTagSeeder::class,
            // CountrySeeder::class,
            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // PaymentSeeder::class,
            // ShippingAddressSeeder::class,
            // ShippingFeeSeeder::class
        ]);
    }
}
