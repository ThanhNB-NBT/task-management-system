<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy ID của tất cả leaders
        $leaderIds = User::where('role', 'leader')->pluck('id');

        // Tạo 10 dự án
        Project::factory(10)
            ->sequence(fn () => [
                'leader_id' => $leaderIds->random() // Gán ngẫu nhiên 1 leader
            ])
            ->create();
    }
}
