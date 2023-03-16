<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\CartAudio;
use App\Models\User;
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
            'released' => fake()->dateTime(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        // User Follows themselves and Black Music after creation
        return $this->afterMaking(function (Audio $audio) {
            //
        })->afterCreating(function (Audio $audio) {
            $users = User::all();

            foreach ($users as $user) {
                CartAudio::factory()->create([
                    'audio_id' => $audio->id,
                    'username' => $user->username,
                ]);
            }
        });
    }
}
