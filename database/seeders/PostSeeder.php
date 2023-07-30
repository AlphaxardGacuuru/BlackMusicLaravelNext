<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create one post for @blackmusic
        Post::factory()->create(['username' => "@blackmusic"]);

        Post::factory()->count(10)->create();
    }
}
