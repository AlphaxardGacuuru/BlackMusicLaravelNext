<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kopokopo>
 */
class KopokopoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "kopokopo_id" => "49b2bf39-0bff-4f37-8b19-43ca21ab3bf2",
            "type" => "incoming_payment",
            "initiation_time" => "2020-10-21T09:30:34.331+03:00",
            "status" => "Success",
            "event_type" => "Incoming Payment Request",
            "resource_id" => "f39-0bff-44ef4-0629-481f-83cd-d101f",
            "reference" => "OJL7OW3J59",
            "origination_time" => "2020-10-21T09:30:40+03:00",
            "sender_phone_number" => fake()->phoneNumber(),
            "amount" => "1000.0",
            "currency" => "KES",
            "till_number" => "K000000",
            "system" => "Lipa Na M-PESA",
            "resource_status" => "Received",
            "sender_first_name" => fake()->unique()->firstName(),
            "sender_middle_name" => fake()->unique()->firstName(),
            "sender_last_name" => fake()->unique()->lastName(),
            "username" => '@' . fake()->unique()->firstName(),
        ];
    }
}
