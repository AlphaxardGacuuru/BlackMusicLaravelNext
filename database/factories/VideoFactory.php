<?php

namespace Database\Factories;

use App\Models\CartVideo;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'video' => 'videos/1.mp3',
            'name' => fake()->catchPhrase(),
            'genre' => fake()->catchPhrase(),
            'thumbnail' => 'video-thumbnails/1.jpg',
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
        return $this->afterMaking(function (Video $video) {
            //
        })->afterCreating(function (Video $video) {
            $users = User::all();

            foreach ($users as $user) {
                CartVideo::factory()->create([
                    'video_id' => $video->id,
                    'username' => $user->username,
                ]);
            }
        });
    }
}
