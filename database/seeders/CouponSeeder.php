<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            ['code' => 'BLACKFRIDAY', 'discount_percentage' => '20'],
            ['code' => 'ANILAG', 'discount_percentage' => '15']
        ]);
    }
}
