<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskHistory;

class TaskHistorySeeder extends Seeder
{

    public function run(): void
    {
        $tasks = Task::all();
        $userIds = User::pluck('id');

        foreach ($tasks as $task) {
            TaskHistory::factory(rand(2, 5))->create([
                'task_id' => $task->id,
                'user_id' => $userIds->random(),
            ]);
        }
    }
}
