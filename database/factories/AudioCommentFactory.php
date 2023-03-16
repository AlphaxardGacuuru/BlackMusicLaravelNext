<?php

namespace Database\Factories;

use App\Models\AudioComment;
use App\Models\AudioCommentLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AudioComment>
 */
class AudioCommentFactory extends Factory
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
        return $this->afterMaking(function (AudioComment $comment) {
            //
        })->afterCreating(function (AudioComment $comment) {
            AudioCommentLike::factory()
                ->count(1)
                ->create([
                    'username' => User::all()->random()->username,
                    'audio_comment_id' => $comment->id,
                ]);
        });
    }
}
