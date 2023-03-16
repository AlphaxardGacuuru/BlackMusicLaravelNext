<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Post
        $post = Post::factory()
            ->create([
                'parameter_1' => 'A',
                'parameter_2' => 'B',
                'parameter_3' => 'C',
                'parameter_4' => 'D',
                'parameter_5' => 'E',
                'username' => User::all()->random()->username,
                'created_at' => Carbon::now()->subHours(24),
            ]);

        // Add for each user
        $users = User::all();

        foreach ($users as $user) {
            Poll::factory()
                ->state(new Sequence(
                    ['parameter' => $post->parameter_1],
                    ['parameter' => $post->parameter_2]))
                ->create([
                    'post_id' => $post->id,
                    'username' => $user->username,
                ]);
        }
    }
}
