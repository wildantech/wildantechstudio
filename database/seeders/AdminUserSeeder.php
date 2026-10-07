<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('wildantech.admin_email');
        $password = config('wildantech.admin_password');

        if (! $email || ! $password) {
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('wildantech.admin_name', 'WildanTech Admin'),
                'password' => $password,
                'is_admin' => true,
            ],
        );
    }
}
