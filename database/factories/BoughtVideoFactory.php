<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoughtVideo>
 */
class BoughtVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
	$video = Video::all()->random();

    return [
        "video_id" => $video->id,
        "price" => "10",
		"username" => User::all()->random()->username,
		"name" => $video->name,
		"artist" => $video->user->username
    ];
    }
}
