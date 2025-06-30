<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'address' => 'National Petroleum Corporation',
                'phone' => '+1234567890',
                'email' => 'ecom@mail.com',
                'facebook_link' => 'facebook.com',
                'instagram_link' => 'instagram.com',
                'tiktok_link' => 'tiktok.com',
                'x_link' => 'x.com'
            ]
        ]);
    }
}
