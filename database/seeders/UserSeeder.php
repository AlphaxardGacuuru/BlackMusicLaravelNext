<?php

namespace Database\Seeders;

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
        // Check if @blackmusic exists
        $blackDoesntExist = User::where('username', '@blackmusic')
            ->doesntExist();

        if ($blackDoesntExist) {
            User::factory()
                ->black()
				->al()
                ->hasKopokopos(1)
                ->create();
        }
		
        User::factory()
            ->count(10)
            ->unverified()
            ->state(new Sequence(
                ['account_type' => 'normal'],
                ['account_type' => 'musician']))
            ->hasKopokopos(1)
            ->create();
    }
}
