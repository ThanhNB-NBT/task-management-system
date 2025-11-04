<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    /**
     * Dashboard cho Admin
     */
    public function index()
    {
        $user = Auth::user();

        // Thống kê tổng quan toàn hệ thống
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_leaders' => User::where('role', 'leader')->count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_projects' => Project::count(),
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
            'done_tasks' => Task::where('status', 'done')->count(),
        ];

        // Dự án mới nhất
        $recentProjects = Project::with(['leader'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // User mới nhất
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Task cần chú ý (quá hạn hoặc sắp hết hạn)
        $criticalTasks = Task::with(['project', 'assignee'])
            ->where('status', '!=', 'done')
            ->where(function($query) {
                $query->where('due_date', '<', now())
                      ->orWhereBetween('due_date', [now(), now()->addDays(2)]);
            })
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentUsers', 'criticalTasks'));
    }
}
