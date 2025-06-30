<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('abouts')->insert(
            [
                'story' => 'National Petroleum Corporation',
                'mission' => 'NPC',
                'story_image' => 'imageurl',
                'mission_image' => 'imageurl',
            ]
        );
    }
}
