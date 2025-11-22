<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
        ]);

        User::factory(5)->create([
            'role' => 'leader',
            'password' => Hash::make('password'),
        ]);

        User::factory(20)->create([
            'role' => 'member',
            'password' => Hash::make('password'),
        ]);
    }
}
