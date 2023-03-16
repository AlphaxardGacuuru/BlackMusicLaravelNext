<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\Karaoke;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class KaraokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $karaoke = Karaoke::factory()
            ->state(new Sequence(
                ['karaoke' => 'karaokes/1.mp4'],
                ['karaoke' => 'karaokes/2.mp4']))
            ->hasLikes(1, fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        $karaoke2 = Karaoke::factory()
            ->state(new Sequence(
                ['karaoke' => 'karaokes/3.mp4'],
                ['karaoke' => 'karaokes/4.mp4']))
            ->hasLikes(1, fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        for ($i = 0; $i < 5; $i++) {
            $karaoke->create([
                'audio_id' => Audio::all()->random()->id,
                'username' => User::all()->random()->username,
            ]);

            $karaoke2->create([
                'audio_id' => Audio::all()->random()->id,
                'username' => User::all()->random()->username,
            ]);
        }
    }
}
