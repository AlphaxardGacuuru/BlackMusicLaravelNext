<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\Post;
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
            'text' => fake()->realText($maxNbChars = 20, $indexSize = 2),
        ];
    }

    /*
     * Configure */
    public function configure()
    {
        return $this->afterMaking(function (Post $post) {
            //
        })->afterCreating(function (Post $post) {
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
