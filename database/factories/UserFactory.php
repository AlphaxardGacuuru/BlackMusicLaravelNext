<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'username' => '@' . fake()->unique()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'avatar' => 'avatars/male_avatar.png',
            'backdrop' => 'img/headphones.jpg',
            'phone' => fake()->phoneNumber(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'bio' => fake()->catchPhrase(),
        ];
    }

    /**
     * Add Black Music Account
     *
     * @return static
     */
    public function black()
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Black Music',
            'username' => '@blackmusic',
            'email' => 'al@black.co.ke',
            'email_verified_at' => now(),
            'avatar' => 'avatars/male_avatar.png',
            'backdrop' => 'img/headphones.jpg',
            'phone' => '0700000000',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'bio' => fake()->catchPhrase(),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        // User Follows themselves and Black Music after creation
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {
            Follow::factory()
                ->count(2)
                ->state(new Sequence(
                    ['followed' => $user->username],
                    ['followed' => '@blackmusic']
                ))
                ->create(['username' => $user->username]);
        });
    }
}
