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
     * A basic feature test example.
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

        $this->post('api/filepond/avatar/' . $user->id, ['filepond-avatar' => $avatar]);

        // Update Data
        $this->put('/api/users/' . $user->id, $data);

        // Get the new resource
        $this->get('api/users/' . $user->id)
            ->assertJsonFragment($data, $escape = true);

        Storage::assertExists('public/avatars/' . $avatar->hashName());

        // Delete Album Cover
        Storage::disk('public')->delete('avatars/' . $avatar->hashName());
    }
}
