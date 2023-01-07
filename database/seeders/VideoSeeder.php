<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoAlbum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $videoAlbum = VideoAlbum::all()->random();

        Video::factory()
            ->count(2)
            ->state(new Sequence([
                "genre" => "Afro",
                "genre" => "EDM",
            ]))
            ->state(new Sequence([
                "thumbnail" => "video-thumbnails/" . rand(1, 5) . '.jpg',
                "thumbnail" => "video-thumbnails/" . rand(1, 5) . '.jpg',
            ]))
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->create([
                'video_album_id' => $videoAlbum->id,
                'username' => $videoAlbum->username,
            ]);
    }
}
