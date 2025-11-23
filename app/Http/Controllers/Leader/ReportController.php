<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
