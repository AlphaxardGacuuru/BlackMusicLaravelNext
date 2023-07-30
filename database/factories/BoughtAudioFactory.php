<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoughtAudio>
 */
class BoughtAudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
	$audio = Audio::all()->random();

    return [
        "audio_id" => $audio->id,
        "price" => "10",
		"username" => User::all()->random()->username,
		"name" => $audio->name,
		"artist" => $audio->user->username
    ];
    }
}
