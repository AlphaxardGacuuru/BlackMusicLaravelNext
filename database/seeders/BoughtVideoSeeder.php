<?php

namespace Database\Seeders;

use App\Models\BoughtVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoughtVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoughtVideo::factory()->count(10)->create();
    }
}
