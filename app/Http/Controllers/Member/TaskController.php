<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->tasks()->with(['project', 'assignee']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->orderBy('due_date', 'asc')
            ->orderBy('priority', 'desc')
            ->paginate(15);

        $projects = $user->projects()->get();

        return view('member.tasks.index', compact('tasks', 'projects'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $task = $user->tasks()
            ->with(['project', 'comments.user', 'histories.user'])
            ->findOrFail($id);

        return view('member.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,done'
        ]);

        $user = Auth::user();
        $task = $user->tasks()->findOrFail($id);

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'update_status',
            'old_value' => ['status' => $oldStatus],
            'new_value' => ['status' => $request->status],
        ]);

        $task->project->leader->systemNotifications()->create([
            'message' => "{$user->name} đã cập nhật trạng thái task '{$task->title}' thành: {$request->status}",
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
