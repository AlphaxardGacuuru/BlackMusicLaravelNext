<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\AudioAlbum;
use App\Models\AudioComment;
use App\Models\AudioLike;
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
        $album = AudioAlbum::all()->random();

        $genres = ["Afro", "Benga", "Blues", "Boomba", "Country"];

        return [
            'audio' => 'audios/' . rand(1, 4) . '.mp3',
            'name' => fake()->catchPhrase(),
            'audio_album_id' => $album->id,
            'genre' => $genres[rand(0, 4)],
            "thumbnail" => 'audio-thumbnails/' . rand(1, 5) . '.jpg',
            'description' => fake()->realText($maxNbChars = 20, $indexSize = 2),
            'released' => fake()->dateTime(),
            'username' => $album->username,
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
            // Create Audio Likes
            AudioLike::factory()
                ->create([
                    'audio_id' => $audio->id,
                    'username' => $audio->username,
                ]);

            // Create Audio Comments
            AudioComment::factory()
                ->count(rand(1, 5))
                ->create([
                    'audio_id' => $audio->id,
                    'username' => User::all()->random()->username,
                ]);
            $users = User::all();

            foreach ($users as $user) {
                CartAudio::factory()
                    ->create([
                        'audio_id' => $audio->id,
                        'username' => $user->username,
                    ]);
            }
        });
    }
}
