<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ads')->insert([
            ['name' => 'big_one', 'main_text' => 'Women', 'sub_text' => 'Spring 2025', 'image_path' => 'image_url', 'link' => 'url_link', 'text_color' => 'red'],
            ['name' => 'big_two', 'main_text' => 'Men', 'sub_text' => 'Spring 2025', 'image_path' => 'image_url', 'link' => 'url_link', 'text_color' => 'red'],
            ['name' => 'small_one', 'main_text' => 'Accessories', 'sub_text' => 'New Trend', 'image_path' => 'image_url', 'link' => 'url_link', 'text_color' => 'red']
        ]);
    }
}
