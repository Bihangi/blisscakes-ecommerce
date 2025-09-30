<?php

// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@blisscakes.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '0771234567',
            'email_verified_at' => now(),
        ]);

        // Create Test Customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'phone' => '0777654321',
            'address' => '123, Colombo Road, Negombo',
            'email_verified_at' => now(),
        ]);
    }
}

