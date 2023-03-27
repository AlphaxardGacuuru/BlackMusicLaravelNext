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
            ->state(new Sequence([
                "audio" => "audios/1.mp3",
                "audio" => "audios/2.mp3",
            ]))
            ->hasLikes(1, fn(array $attributes) => ['username' => User::all()->random()->username])
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
            ->state(new Sequence([
                "audio" => "audios/3.mp3",
                "audio" => "audios/4.mp3",
            ]))
            ->hasLikes(1, fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        for ($i = 0; $i < 5; $i++) {
            $album1 = AudioAlbum::all()->random();
            $album2 = AudioAlbum::all()->random();
            // $album1 = AudioAlbum::where('username', '@blackmusic')->get()->random();
            // $album2 = AudioAlbum::where('username', '@blackmusic')->get()->random();
			
            $audio->create([
                'audio_album_id' => $album1->id,
                'username' => $album1->username,
            ]);

            $audio2->create([
                'audio_album_id' => $album2->id,
                'username' => $album2->username,
            ]);
        }
    }
}
