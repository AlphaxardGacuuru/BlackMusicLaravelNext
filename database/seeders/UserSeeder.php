<?php

namespace Database\Seeders;

use App\Models\AudioAlbum;
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
            ->unverified()
            ->state(new Sequence(['account_type' => 'normal'], ['account_type' => 'musician'], ))
			->has(AudioAlbum::factory()->count(2)->state(new Sequence(['cover' => 'audio-album-covers/'. rand(1, 5) . '.jpg'])))
            ->create();
    }
}
