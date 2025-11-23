<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\TaskAttachment;

class TaskAttachmentController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        // Simple authorization: assignee, project leader, or admin
        if (! ($user->id === $task->assignee_id || optional($task->project->leader)->id === $user->id || $user->role === 'admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'attachment' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip,rar,txt',
        ]);

        $file = $validated['attachment'];
        $originalName = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();

        $path = $file->store("task_attachments/{$task->id}", 'public');

        $attachment = TaskAttachment::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'path' => $path,
            'original_name' => $originalName,
            'mime_type' => $mime,
            'size' => $size,
        ]);

        return redirect()->back()->with('success', __('Attachment uploaded.'));
    }

    public function download($id)
    {
        $attachment = TaskAttachment::findOrFail($id);
        $task = $attachment->task;
        $user = Auth::user();

        if (! ($user->id === $task->assignee_id || optional($task->project->leader)->id === $user->id || $user->role === 'admin')) {
            abort(403);
        }

        return Storage::disk('public')->download($attachment->path, $attachment->original_name);
    }

    public function destroy($id)
    {
        $attachment = TaskAttachment::findOrFail($id);
        $task = $attachment->task;
        $user = Auth::user();

        // Only uploader or admin or project leader can delete
        if (! ($user->id === $attachment->user_id || optional($task->project->leader)->id === $user->id || $user->role === 'admin')) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($attachment->path);
        } catch (\Exception $e) {
            // ignore
        }

        $attachment->delete();

        return redirect()->back()->with('success', __('Attachment removed.'));
    }
}
