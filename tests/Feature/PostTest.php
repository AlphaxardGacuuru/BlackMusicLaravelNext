<?php

namespace Tests\Feature;

use App\Models\Post;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
  
	/**
     * Index
     *
     * @return void
     */
    public function test_user_can_view_post_resource()
    {
        // Create Users with @blackmusic first
        User::factory()->black()->create();
        User::factory()->count(10)->create();

        Post::factory()
            ->count(10)
            ->create(['username' => User::all()->random()->username]);

        $response = $this->get('api/posts');

        $response->assertStatus(200);
    }
  
	/**
     * Show
     *
     * @return void
     */
    public function test_user_can_view_one_post_resource()
    {
        // Create Users with @blackmusic first
        User::factory()->black()->create();

        $post = Post::factory()
            ->create(['username' => User::all()->random()->username]);

        $response = $this->get('api/posts/' . $post->id);

        $response->assertStatus(200);
    }

    /**
     * Store
     *
     * @return void
     */
    public function test_user_can_create_post()
    {
        Sanctum::actingAs(
            User::factory()->black()->create(),
            ['*']
        );

        $image = UploadedFile::fake()->image('avatar.jpg');

        // Upload media
        $uploadImage = $this->post('api/filepond/posts', ['filepond-media' => $image]);

        $uploadImage->assertStatus(200);

        $response = $this->post('api/posts', [
            'text' => 'Some text',
            'media' => $image,
        ]);

        $response->assertStatus(200);

        Storage::assertExists('public/post-media/' . $image->hashName());

        Storage::disk('public')->delete('post-media/' . $image->hashName());
    }

    /**
     * Destroy
     *
     * @return void
     */
    public function test_user_can_delete_post()
    {
        Sanctum::actingAs(
            User::factory()->black()->create(),
            ['*']
        );

        $image = UploadedFile::fake()->image('avatar.jpg');

        // Upload media
        $uploadImage = $this->post('api/filepond/posts', ['filepond-media' => $image]);

        $uploadImage->assertStatus(200);

		// Store
        $response = $this->post('api/posts', [
            'text' => 'Some text',
            'media' => $image,
        ]);

        $response->assertStatus(200);

        Storage::assertExists('public/post-media/' . $image->hashName());

        Storage::disk('public')->delete('post-media/' . $image->hashName());
    }
}
