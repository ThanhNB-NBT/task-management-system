<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_tasks' => $user->tasks()->count(),
            'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
            'done_tasks' => $user->tasks()->where('status', 'done')->count(),
            'total_projects' => $user->projects()->count(),
            'unread_notifications' => $user->systemNotifications()->where('is_read', false)->count(),
        ];

        $upcomingTasks = $user->tasks()
            ->where('status', '!=', 'done')
            ->whereBetween('due_date', [now(), now()->addDays(3)])
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
