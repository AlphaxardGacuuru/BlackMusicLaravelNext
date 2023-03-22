<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoAlbum;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $video = Video::factory()
            ->state(new Sequence([
                "genre" => "Afro",
                "genre" => "EDM",
            ]))
            ->state(new Sequence([
                "thumbnail" => "video-thumbnails/1.jpg",
                "thumbnail" => "video-thumbnails/2.jpg",
            ]))
            ->state(new Sequence([
                "video" => "videos/1.mp4",
                "video" => "videos/2.mp4",
            ]))
            ->hasLikes(1, fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        $video2 = Video::factory()
            ->state(new Sequence([
                "genre" => "Gospel",
                "genre" => "Hiphop",
            ]))
            ->state(new Sequence([
                "thumbnail" => "video-thumbnails/3.jpg",
                "thumbnail" => "video-thumbnails/4.jpg",
            ]))
            ->state(new Sequence([
                "video" => "videos/3.mp4",
                "video" => "videos/4.mp4",
            ]))
            ->hasLikes(1, fn() => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn() => ['username' => User::all()->random()->username]);

        for ($i = 0; $i < 5; $i++) {
            $video->create([
                'video_album_id' => VideoAlbum::all()->random()->id,
                'username' => VideoAlbum::all()->random()->username,
            ]);

            $video2->create([
                'video_album_id' => VideoAlbum::all()->random()->id,
                'username' => VideoAlbum::all()->random()->username,
            ]);
        }
    }
}
