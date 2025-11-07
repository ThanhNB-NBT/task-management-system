<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * M3: Hiển thị danh sách task được giao
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->tasks()->with(['project', 'assignee']);

        // Filter theo status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter theo priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter theo dự án
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Sắp xếp theo due_date
        $tasks = $query->orderBy('due_date', 'asc')
            ->orderBy('priority', 'desc')
            ->paginate(15);

        // Lấy danh sách dự án để filter
        $projects = $user->projects()->get();

        return view('member.tasks.index', compact('tasks', 'projects'));
    }

    /**
     * Xem chi tiết task
     */
    public function show($id)
    {
        $user = Auth::user();

        // Chỉ xem được task của mình
        $task = $user->tasks()
            ->with(['project', 'comments.user', 'histories.user'])
            ->findOrFail($id);

        return view('member.tasks.show', compact('task'));
    }

    /**
     * M4: Cập nhật trạng thái task
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,done'
        ]);

        $user = Auth::user();
        $task = $user->tasks()->findOrFail($id);

        $oldStatus = $task->status;
        $newStatus = $request->status;

        $task->update([
            'status' => $newStatus,
            'completed_at' => $newStatus === 'done' ? now() : null,
        ]);

        // Ghi lịch sử thay đổi
        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'update_status',
            'old_value' => json_encode(['status' => $oldStatus]),
            'new_value' => json_encode(['status' => $newStatus]),
        ]);

        // Gửi thông báo cho leader (nếu có)
        if ($task->project && $task->project->leader) {
            $task->project->leader->notifications()->create([
                'message' => "{$user->name} đã cập nhật trạng thái task '{$task->title}' thành: {$newStatus}",
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('member.tasks.show', $task->id)
            ->with('success', 'Cập nhật trạng thái thành công!');
    }
}
