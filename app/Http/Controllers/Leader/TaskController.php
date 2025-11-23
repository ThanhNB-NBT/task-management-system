<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        $tasks = Task::whereIn('project_id', $user->ledProjects()->pluck('id'))
            ->with(['project', 'assignee'])
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        return view('leader.tasks', compact('tasks'));
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $task = Task::findOrFail($id);

        $projectIds = $user->ledProjects()->pluck('id');
        if (!$projectIds->contains($task->project_id)) {
            abort(403, 'Unauthorized');
        }

        $task->load(['project', 'assignee', 'comments.user', 'histories.user']);

        return view('leader.tasks-show', compact('task'));
    }
}
