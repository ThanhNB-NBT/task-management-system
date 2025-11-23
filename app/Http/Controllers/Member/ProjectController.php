<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $projects = $user->projects()
            ->with(['leader', 'tasks']) 
            ->withCount('tasks') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.projects.index', compact('projects'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $project = $user->projects()
            ->with(['leader', 'tasks.assignee', 'members'])
            ->findOrFail($id);

        $myTasks = $project->tasks()
            ->where('assignee_id', $user->id)
            ->get();

        return view('member.projects.show', compact('project', 'myTasks'));
    }
}
