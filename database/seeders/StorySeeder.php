<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create one post for @blackmusic
        Story::factory()->create(["username" => "@blackmusic"]);

        Story::factory()->count(10)->create();
    }
}
