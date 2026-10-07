<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<InvitationGuest>
 */
class InvitationGuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'name' => fake()->name(),
            'phone' => '081234567890',
            'group_name' => 'Keluarga',
            'token' => Str::random(40),
            'rsvp_status' => null,
            'party_size' => null,
            'responded_at' => null,
            'marked_sent_at' => null,
        ];
    }
}
