<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use App\Models\ProjectMember;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $memberIds = ProjectMember::where('project_id', $project->id)->pluck('user_id');

            if ($memberIds->isEmpty()) {
            }

            Task::factory(rand(10, 20))
                ->sequence(fn () => [
                    'project_id' => $project->id,
                    'assignee_id' => $memberIds->random() 
                ])
                ->create();
        }
    }
}
