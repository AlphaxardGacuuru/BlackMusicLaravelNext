<?php

namespace Database\Factories;

use App\Models\PostComment;
use App\Models\PostCommentLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComment>
 */
class PostCommentFactory extends Factory
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

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        // User Follows themselves and Black Music after creation
        return $this->afterMaking(function (PostComment $comment) {
            //
        })->afterCreating(function (PostComment $comment) {
            PostCommentLike::factory()
                ->count(rand(1, 5))
                ->create([
                    'username' => User::all()->random()->username,
                    'post_comment_id' => $comment->id,
                ]);
        });
    }
}
