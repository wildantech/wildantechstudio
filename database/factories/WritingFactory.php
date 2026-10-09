<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Writing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Writing>
 */
class WritingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(5),
            'slug' => fake()->unique()->slug(),
            'type' => fake()->randomElement(['article', 'book', 'poem']),
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(8, true),
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
