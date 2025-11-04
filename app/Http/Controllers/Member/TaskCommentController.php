<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    /**
     * M5: Thêm comment vào task
     */
    public function store(Request $request, $taskId)
    {
        // Validate và lấy luôn data đã validate
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $user = Auth::user();

        // Kiểm tra task có phải của mình không
        $task = $user->tasks()->findOrFail($taskId);

        // Tạo comment
        $comment = $task->comments()->create([
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        // Ghi lịch sử
        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'add_comment',
            'old_value' => null,
            'new_value' => ['comment' => $validated['content']],
        ]);

        // Thông báo cho leader
        $task->project->leader->notifications()->create([
            'message' => "{$user->name} đã bình luận trên task '{$task->title}'",
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi!');
    }
}
