<?php

namespace Database\Seeders;

use App\Models\_posts;
use App\Models\_postspost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        _posts::factory()->count(100)->create();
    }
}
