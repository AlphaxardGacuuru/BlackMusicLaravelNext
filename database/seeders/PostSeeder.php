<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
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
        Post::factory()
            ->count(2)
            ->hasLikes(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->hasComments(rand(1, 5), fn(array $attributes) => ['username' => User::all()->random()->username])
            ->create(['username' => User::all()->random()->username]);
    }
}
