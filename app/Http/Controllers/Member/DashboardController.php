<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Query thống kê 1 lần để tối ưu
        $taskCounts = $user->tasks()
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when status = 'in_progress' then 1 end) as in_progress")
            ->selectRaw("count(case when status = 'done' then 1 end) as done")
            ->first();

        $stats = [
            'total_tasks' => $taskCounts->total ?? 0,
            'pending_tasks' => $taskCounts->pending ?? 0,
            'in_progress_tasks' => $taskCounts->in_progress ?? 0,
            'done_tasks' => $taskCounts->done ?? 0,
            'total_projects' => $user->projects()->count(),
            'unread_notifications' => $user->systemNotifications()->where('is_read', false)->count(),
        ];

        $upcomingTasks = $user->tasks()
            ->where('status', '!=', 'done')
            ->whereBetween('due_date', [now(), now()->addDays(3)])
            ->with('project')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        $recentTasks = $user->tasks()
            ->with(['project'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact('stats', 'upcomingTasks', 'recentTasks'));
    }
}
