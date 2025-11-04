<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * M2: Hiển thị danh sách dự án mà member tham gia
     */
    public function index()
    {
        $user = Auth::user();

        // Lấy các dự án mà user tham gia (qua bảng project_members)
        $projects = $user->projects()
            ->with(['leader', 'tasks']) // Eager loading để tránh N+1 query
            ->withCount('tasks') // Đếm số task
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.projects.index', compact('projects'));
    }

    /**
     * Xem chi tiết 1 dự án
     */
    public function show($id)
    {
        $user = Auth::user();

        // Kiểm tra xem user có tham gia dự án này không
        $project = $user->projects()
            ->with(['leader', 'tasks.assignee', 'members'])
            ->findOrFail($id);

        // Lấy các task của user trong dự án này
        $myTasks = $project->tasks()
            ->where('assignee_id', $user->id)
            ->get();

        return view('member.projects.show', compact('project', 'myTasks'));
    }
}
