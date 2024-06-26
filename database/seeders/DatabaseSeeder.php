<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
			// Must be ran in this order since there are some dependancies
            UserSeeder::class,
            PostSeeder::class,
            PollSeeder::class,
            VideoAlbumSeeder::class,
            AudioAlbumSeeder::class,
            VideoSeeder::class,
            AudioSeeder::class,
            KaraokeSeeder::class,
			StorySeeder::class
        ]);
    }
}
