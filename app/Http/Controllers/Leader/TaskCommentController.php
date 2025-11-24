<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $task = Task::findOrFail($taskId);

        // Kiểm tra quyền: Project phải thuộc Leader này
        if ($task->project->leader_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // 1. Tạo Comment
        $task->comments()->create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        // 2. Ghi Log lịch sử (Nhớ thêm created_at nếu model TaskHistory không tự timestamps)
        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'add_comment',
            'old_value' => null,
            'new_value' => json_encode(['comment' => $request->content]),
            'created_at' => now(), // Đảm bảo không bị lỗi timestamp
        ]);

        // 3. Gửi thông báo cho Member
        if ($task->assignee_id && $task->assignee_id !== $user->id) {
            Notification::create([
                'user_id' => $task->assignee_id,
                'message' => "Leader {$user->name} đã bình luận trong task '{$task->title}'",
                'is_read' => false,
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'Đã gửi bình luận.');
    }
}
