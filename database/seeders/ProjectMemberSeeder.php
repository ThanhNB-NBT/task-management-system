<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;

class ProjectMemberSeeder extends Seeder
{

    public function run(): void
    {
        $projects = Project::all();
        $memberIds = User::where('role', 'member')->pluck('id');

        foreach ($projects as $project) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $project->leader_id,
                'role_in_project' => 'leader',
            ]);

            $randomMemberIds = $memberIds->random(rand(3, 5));
            foreach ($randomMemberIds as $memberId) {
                ProjectMember::factory()->create([
                    'project_id' => $project->id,
                    'user_id' => $memberId,
                    'role_in_project' => 'member', 
                ]);
            }
        }
    }
}
