<?php

namespace Database\Factories;

use App\Models\CartVideo;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoAlbum;
use App\Models\VideoComment;
use App\Models\VideoLike;
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
        $album = VideoAlbum::all()->random();

        $genres = ["Afro", "Benga", "Blues", "Boomba", "Country"];

        return [
            'video' => 'videos/' . rand(1, 5) . '.mp4',
            'name' => fake()->catchPhrase(),
            'video_album_id' => $album->id,
            'genre' => $genres[rand(0, 4)],
            "thumbnail" => 'video-thumbnails/' . rand(1, 4) . '.jpg',
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
        return $this->afterMaking(function (Video $video) {
            //
        })->afterCreating(function (Video $video) {
            // Create Video Likes
            VideoLike::factory()
                ->create([
                    'video_id' => $video->id,
                    'username' => $video->username,
                ]);

            // Create Video Comments
            VideoComment::factory()
                ->count(rand(1, 5))
                ->create([
                    'video_id' => $video->id,
                    'username' => User::all()->random()->username,
                ]);

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
