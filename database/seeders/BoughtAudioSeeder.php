<?php

namespace Database\Seeders;

use App\Models\BoughtAudio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoughtAudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoughtAudio::factory()->count(10)->create();
    }
}
