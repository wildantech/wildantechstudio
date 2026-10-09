<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Writing;
use Illuminate\Database\Seeder;

class WritingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::query()->first();

        if (! $author) {
            return;
        }

        $author->update(['is_writer' => true]);

        Writing::factory()->count(3)->create([
            'user_id' => $author->id,
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
