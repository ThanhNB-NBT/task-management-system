<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Support\Str;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send {--days=2 : Number of days before due date to remind}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks that are due within the next N days';

    public function handle()
    {
        $days = (int) $this->option('days');
        $now = now()->startOfDay();
        $deadline = now()->addDays($days)->endOfDay();

        $this->info("Searching tasks due between {$now->toDateString()} and {$deadline->toDateString()}...");

        $tasks = Task::where('status', '!=', 'done')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$now->toDateString(), $deadline->toDateString()])
            ->with(['assignee', 'project', 'project.leader'])
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            $message = "Task #{$task->id} \"{$task->title}\" is due on {$task->due_date->format('Y-m-d')}";

            if ($task->assignee) {
                $exists = Notification::where('user_id', $task->assignee->id)
                    ->where('message', 'like', "%Task #{$task->id}%")
                    ->where('created_at', '>=', now()->subDays($days))
                    ->exists();

                if (! $exists) {
                    Notification::create([
                        'user_id' => $task->assignee->id,
                        'message' => $message . '. Please take action.',
                        'created_at'=> $now,
                    ]);
                    $count++;
                }
            }

            if ($task->project && $task->project->leader && (! $task->assignee || $task->project->leader->id !== $task->assignee->id)) {
                $exists = Notification::where('user_id', $task->project->leader->id)
                    ->where('message', 'like', "%Task #{$task->id}%")
                    ->where('created_at', '>=', now()->subDays($days))
                    ->exists();

                if (! $exists) {
                    Notification::create([
                        'user_id' => $task->project->leader->id,
                        'message' => "[Leader] " . $message . '. Please follow up.',
                        'created_at'=> $now,
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Created {$count} reminder notifications.");
        return 0;
    }
}
