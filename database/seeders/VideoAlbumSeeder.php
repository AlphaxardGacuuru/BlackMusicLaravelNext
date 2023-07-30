<?php

namespace Database\Seeders;

use App\Models\VideoAlbum;
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
        VideoAlbum::factory()->create(['username' => '@blackmusic']);

        VideoAlbum::factory()->count(10)->create();
    }
}
