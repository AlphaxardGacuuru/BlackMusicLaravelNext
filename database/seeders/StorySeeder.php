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
        $story1 = Story::factory()
            ->state(new Sequence(
                ["media" => [["image" => "stories/1.jpg"]]],
                ["media" => [["image" => "stories/2.jpg"]]]));

        $story2 = Story::factory()
            ->state(new Sequence(
                ["media" => [["image" => "stories/3.jpg"]]],
                ["media" => [["image" => "stories/4.jpg"]]]));

        // Create one post for @blackmusic
        $story1->create(['username' => "@blackmusic"]);

        for ($i = 0; $i < 4; $i++) {
            $story1->create(["username" => User::all()->random()->username]);
            $story2->create(["username" => User::all()->random()->username]);
        }
    }
}
