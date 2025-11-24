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

        // [FIX] Bổ sung filter và sort
        $query = $user->tasks()->with(['project', 'assignee']);

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('priority')) $query->where('priority', $request->priority);
        if ($request->filled('project_id')) $query->where('project_id', $request->project_id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sắp xếp: Chưa xong lên đầu -> Deadline gần nhất
        $tasks = $query->orderByRaw("CASE WHEN status = 'done' THEN 2 ELSE 1 END")
            ->orderBy('due_date', 'asc')
            ->paginate(10)
            ->withQueryString();

        $projects = $user->projects()->get();

        return view('member.tasks.index', compact('tasks', 'projects'));
    }

    public function show($id)
    {
        $user = Auth::user();

        // [FIX] Load đầy đủ quan hệ: comments, histories, attachments
        $task = $user->tasks()
            ->with(['project.leader', 'comments.user', 'histories.user', 'attachments'])
            ->findOrFail($id);

        return view('member.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,done']);

        $user = Auth::user();
        $task = $user->tasks()->findOrFail($id);

        $oldStatus = $task->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) return back();

        $task->update([
            'status' => $newStatus,
            'completed_at' => $newStatus === 'done' ? now() : null,
        ]);

        // Ghi log
        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'update_status',
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'created_at' => now(),
        ]);

        // Notify Leader
        if ($task->project && $task->project->leader) {
            \App\Models\Notification::create([
                'user_id' => $task->project->leader_id,
                'message' => "{$user->name} đã cập nhật task '{$task->title}' thành: {$newStatus}",
                'is_read' => false,
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
