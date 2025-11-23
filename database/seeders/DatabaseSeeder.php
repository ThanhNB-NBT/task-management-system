<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            ProjectMemberSeeder::class,
            TaskSeeder::class,
            TaskCommentSeeder::class,
            TaskHistorySeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
