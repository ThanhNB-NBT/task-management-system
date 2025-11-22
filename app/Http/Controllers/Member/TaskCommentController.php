<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{

    public function store(Request $request, $taskId)
    {
        $validated = $request->validate([
            'content' => 'required_without:attachment|string|max:1000',
            'attachment' => 'sometimes|file|max:10240|mimes:png,jpg,jpeg,gif,pdf,doc,docx,xls,xlsx,txt,zip,rar',
        ]);

        $user = Auth::user();

        $task = $user->tasks()->findOrFail($taskId);

        $comment = $task->comments()->create([
            'user_id' => $user->id,
            'content' => $validated['content'] ?? null,
        ]);

        // Handle optional attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $mime = $file->getClientMimeType();
            $size = $file->getSize();

            $path = $file->store("comment_attachments/{$task->id}", 'public');

            \App\Models\CommentAttachment::create([
                'comment_id' => $comment->id,
                'user_id' => $user->id,
                'path' => $path,
                'original_name' => $originalName,
                'mime_type' => $mime,
                'size' => $size,
            ]);
        }

        $task->histories()->create([
            'user_id' => $user->id,
            'action' => 'add_comment',
            'old_value' => null,
            'new_value' => ['comment' => $validated['content']],
        ]);

        $task->project->leader->systemNotifications()->create([
            'message' => "{$user->name} đã bình luận trên task '{$task->title}'",
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi!');
    }
}
