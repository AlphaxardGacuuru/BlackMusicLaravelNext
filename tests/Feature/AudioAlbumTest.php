<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AudioAlbumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_create_audio_album()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $cover = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'name' => 'Audio Album 1',
            'released' => '2020-04-01',
            'cover' => $cover,
            // 'audio' => 'audios/audio.mp3',
            // 'thumbnail' => 'audio-thumbnails/audio.mp3',
            // 'name' => 'Audio 1',
            // 'username' => '@blackmusic',
            // 'ft' => '',
            // 'audio_album_id' => 1,
            // 'genre' => 'Country',
            // 'released' => '2020-04-01',
            // 'description' => 'This is video',
        ];

        $response = $this->post('api/audio-albums', $data);

        $response->assertStatus(200);

        Storage::assertExists('public/audio-album-covers/' . $cover->hashName());

        Storage::delete('public/audio-album-covers/' . $cover->hashName());
    }
}
