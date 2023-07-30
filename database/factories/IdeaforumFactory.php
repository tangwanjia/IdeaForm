<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ideaforum>
 */
class IdeaforumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this ->faker->sentence(10),
            'email' => $this -> faker -> sentence(15),
            'password' => $this ->faker ->sentence(20),
            'user_id' => $this -> faker -> numberBetween(1,100),
            'post_id'=>$this -> faker -> numberBetween(1,1000),
            'content'=> $this ->faker -> paragraph(10)
        ];
    }
}
