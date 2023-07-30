<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "username" => User::all()->random()->username,
            "text" => fake()->realText($maxNbChars = 20, $indexSize = 2),
            "media" => [["image" => "stories/" . rand(1, 5) . ".jpg"]],
        ];
    }

    /*
     * Configure */
    public function configure()
    {
        return $this->afterMaking(function (Story $story) {
            //
        })->afterCreating(function (Story $story) {
            // Check if @blackmusic already follows
            $hasntFollowed = Follow::where("followed", $story->username)
                ->where("username", "@blackmusic")
                ->doesntExist();

            if ($hasntFollowed) {
                Follow::factory()
                    ->create([
                        "followed" => $story->username,
                        "username" => "@blackmusic",
                        "muted" => ["posts" => false, "stories" => false],
                    ]);
            }
        });
    }
}
