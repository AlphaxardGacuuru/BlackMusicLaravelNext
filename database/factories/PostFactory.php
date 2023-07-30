<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => User::all()->random()->username,
            'text' => fake()->realText($maxNbChars = 20, $indexSize = 2),
            'media' => 'post-media/' . rand(1, 5) . '.jpg',
        ];
    }

    /*
     * Configure */
    public function configure()
    {
        return $this->afterMaking(function (Post $post) {
            //
        })->afterCreating(function (Post $post) {
            // Create Post Likes
            PostLike::factory()
                ->create([
                    'post_id' => $post->id,
                    'username' => $post->username,
                ]);

            // Create Post Comments
            PostComment::factory()
                ->count(rand(1, 5))
                ->create([
                    'post_id' => $post->id,
                    'username' => User::all()->random()->username,
                ]);

            // Check if @blackmusic already follows
            $hasntFollowed = Follow::where("followed", $post->username)
                ->where("username", "@blackmusic")
                ->doesntExist();

            if ($hasntFollowed) {
                Follow::factory()
                    ->create([
                        "followed" => $post->username,
                        "username" => "@blackmusic",
                        "muted" => ["posts" => false, "stories" => false],
                    ]);
            }
        });
    }
}
