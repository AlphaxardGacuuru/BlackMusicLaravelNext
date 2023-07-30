<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\User;
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
            'karaoke' => 'karaokes/' . rand(1, 4) . '.mp4',
            'username' => User::all()->random()->username,
            'audio_id' => Audio::all()->random()->id,
            'description' => fake()->realText($maxNbChars = 20, $indexSize = 2),
        ];
    }
}
