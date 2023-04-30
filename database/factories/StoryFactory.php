<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "username" => fake()->name(),
            "text" => fake()->realText($maxNbChars = 20, $indexSize = 2),
            "media" => "stories/1.jpg",
        ];
    }
}
