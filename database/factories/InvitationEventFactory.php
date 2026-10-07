<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvitationEvent>
 */
class InvitationEventFactory extends Factory
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
            'title' => 'Akad Nikah',
            'starts_at' => now()->addMonth(),
            'ends_at' => now()->addMonth()->addHour(),
            'venue_name' => fake()->company(),
            'address' => fake()->address(),
            'maps_url' => 'https://maps.google.com/',
            'sort_order' => 0,
        ];
    }
}
