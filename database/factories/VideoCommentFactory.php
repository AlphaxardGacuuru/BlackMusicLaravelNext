<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VideoComment;
use App\Models\VideoCommentLike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoComment>
 */
class VideoCommentFactory extends Factory
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
        return $this->afterMaking(function (VideoComment $comment) {
            //
        })->afterCreating(function (VideoComment $comment) {
            VideoCommentLike::factory()
                ->count(1)
                ->create([
                    'username' => User::all()->random()->username,
                    'video_comment_id' => $comment->id,
                ]);
        });
    }
}
