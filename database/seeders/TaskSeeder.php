<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use App\Models\ProjectMember;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            // Lấy ID của các thành viên (user_id) TRONG dự án này
            $memberIds = ProjectMember::where('project_id', $project->id)->pluck('user_id');

            if ($memberIds->isEmpty()) {
                continue; // Bỏ qua nếu dự án không có thành viên
            }

            // Tạo 10-20 tasks cho dự án
            Task::factory(rand(10, 20))
                ->sequence(fn () => [
                    'project_id' => $project->id,
                    'assignee_id' => $memberIds->random() // Gán cho 1 thành viên ngẫu nhiên
                ])
                ->create();
        }
    }
}
