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
        $runs = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $karaoke = Karaoke::factory()
            ->count(1)
            ->state(new Sequence(
                ['karaoke' => 'karaokes/1.mp4'],
                ['karaoke' => 'karaokes/2.mp4']));

        $karaoke2 = Karaoke::factory()
            ->count(1)
            ->state(new Sequence(
                ['karaoke' => 'karaokes/3.mp4'],
                ['karaoke' => 'karaokes/4.mp4']));

        foreach ($runs as $run) {
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
