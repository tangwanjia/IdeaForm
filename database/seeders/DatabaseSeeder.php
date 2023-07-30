<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\user::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        \App\Models\user::factory(99)->create();
        $this->call([
            NoteSeeder::class
        ]);

        \App\Models\post::factory()->create([
            'user_id' => 'Number',
            'title' => ' Test title',
            'content' => 'Test Content'
        ]);

        \App\Models\post::factory(99)->create();
        $this->call([
            NoteSeeder::class
        ]);

        \App\Models\comment::factory()->create([
            'user_id' => 'user id',
            'post_id' => ' post number',
            'content' => 'Test Content'
        ]);

        \App\Models\comment::factory(99)->create();
        $this->call([
            NoteSeeder::class
        ]);

        \App\Models\vote::factory()->create([
            'user_id' => 'user id',
            'post_id' => ' post number',
            'vote_type' => Hash::make(false)
        ]);

        \App\Models\vote::factory(99)->create();
        $this->call([
            NoteSeeder::class
        ]);




    }
}
