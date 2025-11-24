<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;

class ReportController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $projects = $user->ledProjects()
            ->with(['tasks', 'members'])
            ->withCount(['tasks', 'members'])
            ->get();

        $taskStats = [
            'pending' => 0,
            'in_progress' => 0,
            'done' => 0,
        ];

        foreach ($projects as $project) {
            $taskStats['pending'] += $project->tasks()->where('status', 'pending')->count();
            $taskStats['in_progress'] += $project->tasks()->where('status', 'in_progress')->count();
            $taskStats['done'] += $project->tasks()->where('status', 'done')->count();
        }

        return view('leader.reports', compact('projects', 'taskStats'));
    }

    public function projectProgress(Request $request)
    {
        $projectId = $request->get('project_id');
        $project = Project::withCount(['tasks', 'tasks as done_count' => function ($q) {
            $q->where('status', 'done');
        }])->findOrFail($projectId);

        $total = $project->tasks_count;
        $done = $project->done_count;
        $progress = $total ? round($done / $total * 100) : 0;

        return response()->json([
            'project_id' => $project->id,
            'progress' => $progress,
            'total' => $total,
            'done' => $done,
        ]);
    }

    public function exportCsv(Request $request)
    {
        // Placeholder
        return back()->with('info', 'CSV export not implemented in skeleton.');
    }

    public function exportPdf(Request $request)
    {
        // Placeholder
        return back()->with('info', 'PDF export not implemented in skeleton.');
    }
}
