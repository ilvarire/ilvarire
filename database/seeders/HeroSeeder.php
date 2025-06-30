<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('heroes')->insert([
            ['heading' => 'Women Collection 2018', 'main_text' => 'NEW SEASON', 'link' => 'product.html', 'text_color' => 'seagreen', 'image_path' => 'img url'],
            ['heading' => 'Men New-Season', 'main_text' => 'Jackets & Coats', 'link' => 'product.html', 'text_color' => 'seagreen', 'image_path' => 'img url'],
            ['heading' => 'Men Collection 2025', 'main_text' => 'New arrivals', 'link' => 'product.html', 'text_color' => 'green', 'image_path' => 'img url'],
        ]);
    }
}
