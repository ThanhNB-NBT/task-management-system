<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;

class ProjectMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $memberIds = User::where('role', 'member')->pluck('id');

        foreach ($projects as $project) {
            // 1. Thêm Leader của dự án vào làm thành viên
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $project->leader_id,
                'role_in_project' => 'leader',
            ]);

            // 2. Thêm 3-5 member ngẫu nhiên
            $randomMemberIds = $memberIds->random(rand(3, 5));
            foreach ($randomMemberIds as $memberId) {
                ProjectMember::factory()->create([
                    'project_id' => $project->id,
                    'user_id' => $memberId,
                    'role_in_project' => 'member', // Mặc định
                ]);
            }
        }
    }
}
