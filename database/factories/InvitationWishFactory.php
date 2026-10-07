<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\InvitationWish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvitationWish>
 */
class InvitationWishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invitation = Invitation::factory();

        return [
            'invitation_id' => $invitation,
            'invitation_guest_id' => InvitationGuest::factory()->for($invitation),
            'message' => fake()->sentence(),
            'is_approved' => false,
        ];
    }
}
