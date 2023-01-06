<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(10)
            ->state(new Sequence(
                ['account_type' => 'normal'],
                ['account_type' => 'musician'],
            ))
            ->has(
                Post::factory()
                    ->state(new Sequence(
                        ['media' => 'img/1.jpg'],
                        ['parameter_1' => 'A'],
                    ))
                    ->count(2)
            )
            ->hasFollows(1, function (array $attributes, User $user) {
                return ['followed' => $user->username];
            })
            ->create();
    }
}
