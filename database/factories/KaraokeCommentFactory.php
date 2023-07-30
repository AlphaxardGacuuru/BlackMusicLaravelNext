<?php

namespace Database\Factories;

use App\Models\KaraokeComment;
use App\Models\KaraokeCommentLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KaraokeComment>
 */
class KaraokeCommentFactory extends Factory
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
        return $this->afterMaking(function (KaraokeComment $comment) {
            //
        })->afterCreating(function (KaraokeComment $comment) {
            KaraokeCommentLike::factory()
                ->create([
                    'username' => User::all()->random()->username,
                    'karaoke_comment_id' => $comment->id,
                ]);
        });
    }
}
