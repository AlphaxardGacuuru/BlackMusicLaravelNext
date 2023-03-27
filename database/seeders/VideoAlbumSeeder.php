<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VideoAlbum;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class VideoAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $video = VideoAlbum::factory()
            ->state(new Sequence(
                ['cover' => 'video-album-covers/1.jpg'],
                ['cover' => 'video-album-covers/2.jpg']));

        $video2 = VideoAlbum::factory()
            ->state(new Sequence(
                ['cover' => 'video-album-covers/3.jpg'],
                ['cover' => 'video-album-covers/4.jpg']));

        for ($i = 0; $i < 5; $i++) {
            $video->create(['username' => User::all()->random()->username]);
            $video2->create(['username' => User::all()->random()->username]);
            // $video->create(['username' => "@blackmusic"]);
            // $video2->create(['username' => "@blackmusic"]);
        }
    }
}
