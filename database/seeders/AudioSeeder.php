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
        $audio = Audio::factory()
            ->state(new Sequence([
                "genre" => "Afro",
                "genre" => "EDM",
            ]))
            ->state(new Sequence([
                "thumbnail" => "audio-thumbnails/1.jpg",
                "thumbnail" => "audio-thumbnails/2.jpg",
            ]))
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        $audio2 = Audio::factory()
            ->state(new Sequence([
                "genre" => "Gospel",
                "genre" => "Hiphop",
            ]))
            ->state(new Sequence([
                "thumbnail" => "audio-thumbnails/3.jpg",
                "thumbnail" => "audio-thumbnails/4.jpg",
            ]))
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        for ($i = 0; $i < 5; $i++) {
            $audio->create([
                'audio_album_id' => AudioAlbum::all()->random()->id,
                'username' => AudioAlbum::all()->random()->username,
            ]);

            $audio2->create([
                'audio_album_id' => AudioAlbum::all()->random()->id,
                'username' => AudioAlbum::all()->random()->username,
            ]);
        }
    }
}
