<?php

namespace Database\Seeders;

use App\Models\AudioAlbum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AudioAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audio = AudioAlbum::factory()
            ->state(new Sequence(
                ['cover' => 'audio-album-covers/1.jpg'],
                ['cover' => 'audio-album-covers/2.jpg']));

        $audio2 = AudioAlbum::factory()
            ->state(new Sequence(
                ['cover' => 'audio-album-covers/3.jpg'],
                ['cover' => 'audio-album-covers/4.jpg']));

        for ($i = 0; $i < 5; $i++) {
            $audio->create(['username' => User::all()->random()->username]);
            $audio2->create(['username' => User::all()->random()->username]);
        }
    }
}
