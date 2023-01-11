<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Update
     *
     * @return void
     */
    public function test_user_can_update_profile()
    {
        $user = User::factory()->black()->create();

        // Create Image
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            "name" => "Black",
            'phone' => '0700123456',
            'bio' => 'Updated Bio',
            'withdrawal' => '500',
        ];

        $avatarUpload = $this->post('api/filepond/avatar/' . $user->id, ['filepond-avatar' => $avatar]);

        $avatarUpload->assertStatus(200);

        // Update Data
        $this->put('/api/users/' . $user->id, $data);

        // Get the new resource
        $this->get('api/users/' . $user->id)
            ->assertJsonFragment($data, $escape = true);

        Storage::assertExists('public/avatars/' . $avatar->hashName());

        // Delete Album Cover
        Storage::disk('public')->delete('avatars/' . $avatar->hashName());
    }

    /**
     * Update Bad
     *
     * @return void
     */
    public function test_user_cannot_update_profile_with_bad_data()
    {
        $user = User::factory()->black()->create();

        // Create Image
        $avatar = UploadedFile::fake()->image('avatar.mp3');

        $data = [
            "name" => "Black",
            'phone' => '070012345',
            'bio' => 'Updated Bio',
            'withdrawal' => '500',
        ];

        $avatarUpload = $this->post('api/filepond/avatar/' . $user->id, ['filepond-avatar' => $avatar]);

        $avatarUpload->assertStatus(302);

        // Update Data
        $response = $this->put('/api/users/' . $user->id, $data);

        $response->assertStatus(302);

        Storage::assertMissing('public/avatars/' . $avatar->hashName());

        // Delete Album Cover
        Storage::disk('public')->delete('avatars/' . $avatar->hashName());
    }
}
