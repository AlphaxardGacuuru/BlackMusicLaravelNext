<?php

namespace Database\Seeders;

use App\Models\AudioAlbum;
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
        AudioAlbum::factory()->create(['username' => '@blackmusic']);

        AudioAlbum::factory()->count(10)->create();
    }
}
