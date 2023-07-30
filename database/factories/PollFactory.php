<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $parameters = ["A", "B", "C", "D", "E"];

        return [
            'post_id' => Post::all()->random()->id,
            'username' => User::all()->random()->username,
            'parameter' => $parameters[rand(0, 4)],
        ];
    }
}
