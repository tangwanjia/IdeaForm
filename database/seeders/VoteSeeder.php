<?php

namespace Database\Seeders;

use App\Models\vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        vote::factory()->count(100)->create();
    }
}
