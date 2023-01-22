<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        $post = Post::factory()
            ->state(new Sequence(
                ["media" => "post-media/1.jpg"],
                ["media" => null]))
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username]);

        for ($i = 0; $i < 5; $i++) {
            $post->create(['username' => User::all()->random()->username]);
        }
    }
}
