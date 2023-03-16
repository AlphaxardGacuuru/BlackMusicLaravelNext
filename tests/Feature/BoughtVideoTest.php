<?php

namespace Tests\Feature;

use App\Models\Kopokopo;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoAlbum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BoughtVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test User can buy Videos.
     *
     * @return void
     */
    public function test_user_can_buy_videos()
    {
        // Run the DatabaseSeeder...
        $this->seed();

        Sanctum::actingAs(
            $user = User::all()->random(),
            ['*']
        );

        $musician = User::all()->random();

        Video::factory()
            ->count(10)
            ->create([
                'video_album_id' => VideoAlbum::all()->random()->id,
                "username" => $musician->username,
            ]);

        $response = $this->post('api/bought-videos');

        $response->assertStatus(200);

        $this->assertDatabaseCount('bought_videos', 20);
        $this->assertDatabaseCount('decos', 1);
    }
}
