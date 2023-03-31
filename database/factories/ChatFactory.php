<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "username" => User::all()->random()->username,
			"to" => User::all()->random()->username,
			"text" => fake()->realText($maxNbChars = 20, $indexSize = 2),
			"media" => "chat-media/1jpg"
        ];
    }
}
