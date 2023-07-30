<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\Karaoke;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class KaraokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Karaoke::factory()->count(10)->create();
    }
}
