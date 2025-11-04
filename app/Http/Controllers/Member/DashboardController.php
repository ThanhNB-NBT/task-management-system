<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard cho Member
     */
    public function index()
    {
        $user = Auth::user();

        // Thống kê tổng quan
        $stats = [
            'total_tasks' => $user->tasks()->count(),
            'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
            'done_tasks' => $user->tasks()->where('status', 'done')->count(),
            'total_projects' => $user->projects()->count(),
            'unread_notifications' => $user->notifications()->where('is_read', false)->count(),
        ];

        // Task sắp hết hạn (trong 3 ngày tới)
        $upcomingTasks = $user->tasks()
            ->where('status', '!=', 'done')
            ->whereBetween('due_date', [now(), now()->addDays(3)])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Task mới nhất
        $recentTasks = $user->tasks()
            ->with(['project'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact('stats', 'upcomingTasks', 'recentTasks'));
    }
}
