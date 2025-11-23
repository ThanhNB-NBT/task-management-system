<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\ProjectsExport;
use App\Exports\TasksExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $statistics = [
            'users' => User::count(),
            'projects' => Project::count(),
            'tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'done')->count(),
        ];
        
        $projectProgress = Project::with(['tasks'])
            ->get()
            ->map(function ($project) {
                $totalTasks = $project->tasks->count();
                $completedTasks = $project->tasks->where('status', 'done')->count();
                $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                
                return [
                    'name' => $project->name,
                    'progress' => $progress,
                    'total_tasks' => $totalTasks,
                    'completed_tasks' => $completedTasks,
                ];
            });

        $totalUsers = $statistics['users'];
        $totalProjects = $statistics['projects'];
        $totalTasks = $statistics['tasks'];

        $recentActivities = TaskHistory::with(['user', 'task'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($h) {
                return (object) [
                    'user_name' => $h->user?->name ?? 'System',
                    'action' => $h->action ?? ($h->new_value ?? 'updated'),
                    'task_title' => $h->task?->title ?? null,
                    'created_at' => $h->created_at,
                ];
            });

        return view('admin.reports.index', compact(
            'statistics', 'projectProgress',
            'totalUsers', 'totalProjects', 'totalTasks', 'recentActivities'
        ));
    }

    public function users()
    {
        $roleDistribution = [
            'admin' => User::where('role', 'admin')->count(),
            'leader' => User::where('role', 'leader')->count(),
            'member' => User::where('role', 'member')->count(),
        ];

        $users = User::withCount(['projects', 'tasks'])->get()->map(function ($u) {
            $u->projects_count = $u->projects_count ?? 0;
            $u->assigned_tasks_count = $u->tasks_count ?? 0;

            $totalAssigned = $u->assigned_tasks_count;
            $done = \App\Models\Task::where('assignee_id', $u->id)->where('status', 'done')->count();
            $u->completion_rate = $totalAssigned > 0 ? (int) round(($done / $totalAssigned) * 100) : 0;

            return $u;
        });

        return view('admin.reports.users', compact('roleDistribution', 'users'));
    }

    public function projects()
    {
        $statusDistribution = [
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0,
            'on_hold' => 0,
        ];

        $projects = Project::with(['leader', 'members'])
            ->withCount(['tasks', 'members'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) use (&$statusDistribution) {
                $total = $p->tasks_count;
                $done = $p->tasks()->where('status', 'done')->count();
                $p->completion_rate = $total > 0 ? (int) round(($done / $total) * 100) : 0;

                if ($p->completion_rate === 100) {
                    $p->status = 'completed';
                    $statusDistribution['completed']++;
                } elseif ($p->completion_rate > 0) {
                    $p->status = 'in_progress';
                    $statusDistribution['in_progress']++;
                } else {
                    $p->status = 'pending';
                    $statusDistribution['pending']++;
                }

                if (isset($p->end_date) && $p->completion_rate < 100 && \Illuminate\Support\Carbon::parse($p->end_date)->isPast()) {
                    $p->status = 'on_hold';
                    $statusDistribution['on_hold']++;
                    if ($statusDistribution['pending'] > 0) $statusDistribution['pending']--;
                    if ($statusDistribution['in_progress'] > 0 && $p->completion_rate > 0) $statusDistribution['in_progress']--;
                }

                return $p;
            });

        return view('admin.reports.projects', compact('statusDistribution', 'projects'));
    }

    public function tasks()
    {
        $statusDistribution = [
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'done' => Task::where('status', 'done')->count(),
        ];

        $overdueTasks = Task::where('status', '!=', 'done')
            ->where('due_date', '<', now())
            ->count();

        $priorityDistribution = [
            'low' => Task::where('priority', 'low')->count(),
            'medium' => Task::where('priority', 'medium')->count(),
            'high' => Task::where('priority', 'high')->count(),
        ];

        $tasks = Task::with(['project', 'assignee'])
            ->withCount('comments')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('admin.reports.tasks', compact('statusDistribution', 'overdueTasks', 'priorityDistribution', 'tasks'));
    }

    public function analyticsUsers()
    {
        $users = User::orderBy('name')->get()->map(function ($u) {
            $assigned = $u->tasks()->count();
            $completed = $u->tasks()->where('status', 'done')->count();
            $pending = $u->tasks()->where('status', 'pending')->count();
            $inProgress = $u->tasks()->where('status', 'in_progress')->count();
            $completionRate = $assigned > 0 ? (int) round(($completed / $assigned) * 100) : 0;

            return (object) [
                'id' => $u->id,
                'name' => $u->name,
                'assigned' => $assigned,
                'completed' => $completed,
                'pending' => $pending,
                'in_progress' => $inProgress,
                'completion_rate' => $completionRate,
            ];
        });

        $labels = $users->pluck('name');
        $assignedData = $users->pluck('assigned');
        $completedData = $users->pluck('completed');

        return view('admin.reports.analytics_users', compact('users', 'labels', 'assignedData', 'completedData'));
    }

    public function analyticsProjects()
    {
        $projects = Project::withCount('tasks')
            ->with(['tasks'])
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                $total = $p->tasks_count;
                $done = $p->tasks()->where('status', 'done')->count();
                $inProgress = $p->tasks()->where('status', 'in_progress')->count();
                $pending = $p->tasks()->where('status', 'pending')->count();
                $progress = $total > 0 ? (int) round(($done / $total) * 100) : 0;

                return (object) [
                    'id' => $p->id,
                    'name' => $p->name,
                    'total' => $total,
                    'done' => $done,
                    'in_progress' => $inProgress,
                    'pending' => $pending,
                    'progress' => $progress,
                ];
            });

        $labels = $projects->pluck('name');
        $totalData = $projects->pluck('total');
        $doneData = $projects->pluck('done');

        return view('admin.reports.analytics_projects', compact('projects', 'labels', 'totalData', 'doneData'));
    }

    // Exports
    public function exportUsersExcel()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function exportUsersPdf()
    {
        $users = \App\Models\User::orderBy('id')->get();
        $pdf = Pdf::loadView('admin.reports.users_pdf', compact('users'));
        return $pdf->download('users.pdf');
    }

    public function exportProjectsExcel()
    {
        return Excel::download(new ProjectsExport(), 'projects.xlsx');
    }

    public function exportProjectsPdf()
    {
        $projects = \App\Models\Project::with('leader')->orderBy('id')->get();
        $pdf = Pdf::loadView('admin.reports.projects_pdf', compact('projects'));
        return $pdf->download('projects.pdf');
    }

    public function exportTasksExcel()
    {
        return Excel::download(new TasksExport(), 'tasks.xlsx');
    }

    public function exportTasksPdf()
    {
        $tasks = \App\Models\Task::with(['project','assignee'])->orderBy('id')->get();
        $pdf = Pdf::loadView('admin.reports.tasks_pdf', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }
}