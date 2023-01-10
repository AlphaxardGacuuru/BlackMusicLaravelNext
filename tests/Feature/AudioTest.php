<?php

namespace Tests\Feature;

use App\Models\Audio;
use App\Models\AudioAlbum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AudioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index
     *
     * @return void
     */
    public function test_user_can_view_audio_resource()
    {
        // Create Users with @blackmusic first
        User::factory()->black()->create();
        User::factory()->count(10)->create();

        $username = User::all()->random()->username;

        // Create Audio Album
        AudioAlbum::factory()->create(['username' => $username]);

        $album = AudioAlbum::first()->id;

        Audio::factory()
            ->count(10)
            ->create([
                'username' => $username,
                'audio_album_id' => $album,
            ]);

        $response = $this->get('api/audios');

        $response->assertStatus(200);
    }

    /**
     * Show
     *
     * @return void
     */
    public function test_user_can_view_one_audio_resource()
    {
        // Create Users with @blackmusic first
        User::factory()->black()->create();
        User::factory()->count(10)->create();

        $username = User::all()->random()->username;

        // Create Audio Album
        AudioAlbum::factory()->create(['username' => $username]);

        $album = AudioAlbum::first()->id;

        Audio::factory()
            ->create([
                'username' => $username,
                'audio_album_id' => $album,
            ]);

        $audio = Audio::first()->id;

        $response = $this->get('api/audios/' . $audio);

        $response->assertStatus(200);
    }

    /**
     * Store
     *
     * @return void
     */
    public function test_user_can_create_audio()
    {
        Sanctum::actingAs(
            $user = User::factory()->black()->create(),
            ['*']
        );

        $user2 = User::factory()->create();

        $album = AudioAlbum::factory()->create(['username' => $user->username]);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $audio = UploadedFile::fake()->create('audio.mp3');

        // Upload audio and thumbnail
        $this->post('api/filepond/audio-thumbnail', ['filepond-thumbnail' => $thumbnail]);
        $this->post('api/filepond/audio', ['filepond-audio' => $audio]);

        $response = $this->post('api/audios', [
            'audio' => 'audios/' . $audio->hashName(),
            'thumbnail' => 'audio-thumbnails/' . $thumbnail->hashName(),
            'name' => 'Audio 1',
            'ft' => $user2->username,
            'audio_album_id' => $album->id,
            'genre' => 'Country',
            'released' => '2020-04-01',
            'description' => 'This is video',
        ]);

        $response->assertStatus(200);

        Storage::assertExists('public/audio-thumbnails/' . $thumbnail->hashName());
        Storage::assertExists('public/audios/' . $audio->hashName());

        Storage::disk('public')->delete('audio-thumbnails/' . $thumbnail->hashName());
        Storage::disk('public')->delete('audios/' . $audio->hashName());
    }

    /**
     * Store
     *
     * @return void
     */
    public function test_user_cannot_create_audio_with_bad_data()
    {
        Sanctum::actingAs(
            User::factory()->black()->create(),
            ['*']
        );

        $response = $this->post('api/audios', []);

        $response->assertStatus(302);
    }

    /**
     * Update
     *
     * @return void
     */
    public function test_user_can_update_audio()
    {
        Sanctum::actingAs(
            $user = User::factory()->black()->create(),
            ['*']
        );

        // Create Audio Album
        $album = AudioAlbum::factory()->create(['username' => $user->username]);

        $audio = Audio::factory()
            ->create([
                'username' => $user->username,
                'audio_album_id' => $album,
            ]);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $audioFile = UploadedFile::fake()->create('audio.mp3');

        // Upload audio and thumbnail
        $this->post('api/filepond/audio-thumbnail', ['filepond-thumbnail' => $thumbnail]);
        $this->post('api/filepond/audio', ['filepond-audio' => $audioFile]);

        $this->put('api/audios/' . $audio->id, [
            'audio' => 'audios/' . $audioFile->hashName(),
            'thumbnail' => 'audio-thumbnails/' . $thumbnail->hashName(),
            'name' => 'Audio 1',
            'ft' => '',
            'audio_album_id' => $album->id,
            'genre' => 'Country',
            'released' => '2020-04-01',
            'description' => 'This is video',
        ]);

        // Get the new resource
        $this->get('api/audios/' . $audio->id)
            ->assertJsonFragment([
                'audio' => 'audios/' . $audioFile->hashName(),
                'thumbnail' => 'audio-thumbnails/' . $thumbnail->hashName(),
                'name' => 'Audio 1',
                'ft' => null,
                'audio_album_id' => $album->id,
                'genre' => 'Country',
                'description' => 'This is video',
            ], $escape = true);

        Storage::assertExists('public/audio-thumbnails/' . $thumbnail->hashName());
        Storage::assertExists('public/audios/' . $audioFile->hashName());

        Storage::disk('public')->delete('audio-thumbnails/' . $thumbnail->hashName());
        Storage::disk('public')->delete('audios/' . $audioFile->hashName());
    }
}
