<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => Str::title($title),
            'slug' => Str::slug($title),
            'category' => 'Web',
            'summary' => fake()->sentence(12),
            'description' => fake()->paragraph(),
            'technology_stack' => ['Laravel', 'PHP'],
            'cover_image' => null,
            'is_featured' => false,
            'is_published' => true,
            'sort_order' => 0,
        ];
    }
}
