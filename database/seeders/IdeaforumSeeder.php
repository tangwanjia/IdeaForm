<?php

namespace Database\Seeders;

use App\Models\ideaforum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdeaforumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ideaforum::factory()->count(100)->create(); //generate 100 data inside from tables
    }
}
