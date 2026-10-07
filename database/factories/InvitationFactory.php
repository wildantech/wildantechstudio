<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'user_id' => User::factory(),
            'title' => Str::title($title),
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'host_names' => fake()->name().' & '.fake()->name(),
            'bride_name' => fake()->firstName('female'),
            'bride_father' => fake()->name(),
            'bride_mother' => fake()->name(),
            'bride_child_order' => fake()->numberBetween(1, 4),
            'groom_name' => fake()->firstName('male'),
            'groom_father' => fake()->name(),
            'groom_mother' => fake()->name(),
            'groom_child_order' => fake()->numberBetween(1, 4),
            'theme' => 'niku-story',
            'is_published' => false,
            'published_at' => null,
        ];
    }
}
