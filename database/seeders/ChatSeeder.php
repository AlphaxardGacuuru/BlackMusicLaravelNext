<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chat::factory()
            ->count(5)
            ->state(new Sequence([
                "media" => "chat-media/1.jpg",
                "media" => "",
            ]))
            ->create(["username" => "@blackmusic"]);
    }
}
