<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $myProjects = $user->ledProjects()->withCount('tasks', 'members')->get();

        $stats = [
            'total_projects' => $user->ledProjects()->count(),
            'total_tasks' => $user->ledProjects()->withCount('tasks')->get()->sum('tasks_count'),
            'total_members' => $user->ledProjects()->withCount('members')->get()->sum('members_count'),
        ];
        $taskStats = [
            'pending' => 0,
            'in_progress' => 0,
            'done' => 0,
        ];

        foreach ($myProjects as $project) {
            $taskStats['pending'] += $project->tasks()->where('status', 'pending')->count();
            $taskStats['in_progress'] += $project->tasks()->where('status', 'in_progress')->count();
            $taskStats['done'] += $project->tasks()->where('status', 'done')->count();
        }

        $stats = array_merge($stats, $taskStats);

        $projects = $user->ledProjects()
            ->with(['tasks', 'members'])
            ->withCount(['tasks', 'members'])
            ->orderBy('created_at', 'desc')
            ->get();

        $criticalTasks = collect();
        foreach ($myProjects as $project) {
            $tasks = $project->tasks()
                ->with(['assignee'])
                ->where('status', '!=', 'done')
                ->where(function($query) {
                    $query->where('due_date', '<', now())
                          ->orWhereBetween('due_date', [now(), now()->addDays(3)]);
                })
                ->orderBy('due_date', 'asc')
                ->limit(5)
                ->get();

            $criticalTasks = $criticalTasks->merge($tasks);
        }

        $criticalTasks = $criticalTasks->sortBy('due_date')->take(10);

        $recentActivities = collect();
        foreach ($myProjects as $project) {
            $histories = $project->tasks()
                ->with(['histories.user'])
                ->get()
                ->pluck('histories')
                ->flatten()
                ->sortByDesc('created_at')
                ->take(10);

            $recentActivities = $recentActivities->merge($histories);
        }

        $recentActivities = $recentActivities->sortByDesc('created_at')->take(10);

        return view('leader.dashboard', compact('stats', 'projects', 'criticalTasks', 'recentActivities'));
    }
}
