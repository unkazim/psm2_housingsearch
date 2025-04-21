<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@uthm.edu.my',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Create 10 Landlords
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Landlord $i",
                'email' => "landlord{$i}@example.com",
                'password' => Hash::make('password123'),
                'role' => 'landlord'
            ]);
        }

        // Create 10 Students
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Student $i",
                'email' => "student{$i}@uthm.edu.my",
                'password' => Hash::make('password123'),
                'role' => 'student'
            ]);
        }
    }
}
