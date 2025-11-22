<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskHistory;

class DashboardController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

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

        $recentProjects = Project::with(['leader'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $criticalTasks = Task::with(['project', 'assignee'])
            ->where('status', '!=', 'done')
            ->where(function($query) {
                $query->where('due_date', '<', now())
                      ->orWhereBetween('due_date', [now(), now()->addDays(2)]);
            })
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        $users = User::orderBy('created_at', 'desc')->get();
        $projects = Project::orderBy('created_at', 'desc')->get();
        $tasks = Task::orderBy('created_at', 'desc')->get();
        $activities = TaskHistory::with(['user','task'])->orderBy('created_at', 'desc')->limit(10)->get();
        $topProjects = $recentProjects; 
        $systemStatus = [
            'Database' => 'online',
            'Server' => 'online',
            'API' => 'online',
            'Email Service' => 'warning',
        ];

        return view('admin.admin-dashboard', compact(
            'stats', 'recentProjects', 'recentUsers', 'criticalTasks',
            'users', 'projects', 'tasks', 'activities', 'topProjects', 'systemStatus'
        ));
    }
}
