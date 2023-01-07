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
            // UserSeeder::class,
            PostSeeder::class,
            // CommentSeeder::class,
        ]);

        // Add Black Music first
        // DB::table('users')->insert([
            // 'name' => 'Black Music',
            // 'email' => 'al@black.co.ke',
            // 'avatar' => 'profile-pics/male_avatar.png',
            // 'backdrop' => 'profile-pics/male_avatar.png',
            // 'username' => '@blackmusic',
            // 'phone' => '0700000000',
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // ]);

        // \App\Models\User::factory(10)->create();
    }
}
