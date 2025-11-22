<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        $projects = $user->ledProjects()
            ->with(['tasks', 'members'])
            ->withCount(['tasks', 'members'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.projects', compact('projects'));
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $project = Project::findOrFail($id);
        
        if ($project->leader_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $project->load(['tasks', 'members']);
        $project->loadCount(['tasks', 'members']);

        $taskStats = [
            'pending' => $project->tasks()->where('status', 'pending')->count(),
            'in_progress' => $project->tasks()->where('status', 'in_progress')->count(),
            'done' => $project->tasks()->where('status', 'done')->count(),
        ];

        $upcomingTasks = $project->tasks()
            ->with(['assignee'])
            ->where('status', '!=', 'done')
            ->where(function($query) {
                $query->where('due_date', '<', now())
                      ->orWhereBetween('due_date', [now(), now()->addDays(3)]);
            })
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        return view('leader.projects-show', compact('project', 'taskStats', 'upcomingTasks'));
    }
}
