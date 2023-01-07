<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Audio>
 */
class AudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'audio' => 'audios/1.mp3',
            'name' => fake()->catchPhrase(),
            'genre' => fake()->catchPhrase(),
            'thumbnail' => fake()->catchPhrase(),
            'description' => fake()->realText($maxNbChars = 20, $indexSize = 2),
            'released' => now(),
        ];
    }
}
