<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->create();

        $data = [
            "name" => "Black",
            'phone' => '0700123456',
            'bio' => 'Updated Bio',
            'withdrawal' => '500',
        ];

        // Update Data
        $this->put('/api/users/' . $user->id, $data);

        // Get the new resource
        $this->get('api/users/' . $user->id)
            ->assertJsonFragment([
                "name" => "Black",
                'phone' => '0700123456',
                'bio' => 'Updated Bio',
                'withdrawal' => '500',
            ], $escape = true);
    }
}
