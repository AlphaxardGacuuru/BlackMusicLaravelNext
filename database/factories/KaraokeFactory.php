<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karaoke>
 */
class KaraokeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
			'karaoke' => 'karaokes/1.mp4',
            'description' => fake()->realText($maxNbChars = 20, $indexSize = 2),
        ];
    }
}
