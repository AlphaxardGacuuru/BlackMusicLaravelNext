<?php

namespace Tests\Feature;

use App\Models\Audio;
use App\Models\AudioAlbum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BoughtAudioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test User can buy Audios.
     *
     * @return void
     */
    public function test_user_can_buy_audios()
    {
        // Run the DatabaseSeeder...
        $this->seed();

        Sanctum::actingAs(
            $user = User::all()->random(),
            ['*']
        );

        $musician = User::all()->random();

        Audio::factory()
            ->count(10)
            ->create([
                'audio_album_id' => AudioAlbum::all()->random()->id,
                "username" => $musician->username,
            ]);

        $response = $this->post('api/bought-audios');

        $response->assertStatus(200);

        $this->assertDatabaseCount('bought_audios', 20);
        $this->assertDatabaseCount('decos', 1);
    }
}
