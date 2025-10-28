<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskComment;

class TaskCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();
        $userIds = User::inRandomOrder()->pluck('id'); // Bất kỳ user nào cũng có thể comment

        foreach ($tasks as $task) {
            TaskComment::factory(rand(1, 5))->create([
                'task_id' => $task->id,
                'user_id' => $userIds->random(),
            ]);
        }
    }
}
