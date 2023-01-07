<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\AudioAlbum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audioAlbum = AudioAlbum::all()->random();

        Audio::factory()
            ->count(2)
            ->state(new Sequence([
                "genre" => "Afro",
                "genre" => "EDM",
            ]))
            ->state(new Sequence([
                "thumbnail" => "audio-thumbnails/" . rand(1, 5) . '.jpg',
                "thumbnail" => "audio-thumbnails/" . rand(1, 5) . '.jpg',
            ]))
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->create([
                'audio_album_id' => $audioAlbum->id,
                'username' => $audioAlbum->username,
            ]);
    }
}
