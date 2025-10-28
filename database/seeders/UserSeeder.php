<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 1 Admin cụ thể để test
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // dùng 'password' cho dễ nhớ
            'role' => 'admin',
        ]);

        // Tạo 5 Leaders
        User::factory(5)->create([
            'role' => 'leader',
            'password' => Hash::make('password'),
        ]);

        // Tạo 20 Members
        User::factory(20)->create([
            'role' => 'member',
            'password' => Hash::make('password'),
        ]);
    }
}
