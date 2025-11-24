<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy danh sách ID các dự án mà Leader quản lý
        $projectIds = $user->ledProjects()->pluck('id');

        // 1. Thống kê số liệu tổng quan
        // [FIX] Đổi tên alias 'high_priority' -> 'priority_high' để tránh lỗi từ khóa MySQL
        $taskStats = Task::whereIn('project_id', $projectIds)
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when status = 'in_progress' then 1 end) as in_progress")
            ->selectRaw("count(case when status = 'done' then 1 end) as done")
            ->selectRaw("count(case when priority = 'high' then 1 end) as priority_high")     // Sửa ở đây
            ->selectRaw("count(case when priority = 'medium' then 1 end) as priority_medium") // Sửa ở đây
            ->selectRaw("count(case when priority = 'low' then 1 end) as priority_low")       // Sửa ở đây
            ->first();

        // Đếm số thành viên (Unique)
        $totalMembers = $user->ledProjects()
            ->with('members')
            ->get()
            ->pluck('members')
            ->flatten()
            ->unique('id')
            ->count();

        $stats = [
            'total_projects' => $user->ledProjects()->count(),
            'total_tasks' => $taskStats->total ?? 0,
            'total_members' => $totalMembers,
            'pending' => $taskStats->pending ?? 0,
            'in_progress' => $taskStats->in_progress ?? 0,
            'done' => $taskStats->done ?? 0,
            'priority' => [
                // [FIX] Cập nhật tên thuộc tính tương ứng
                'high' => $taskStats->priority_high ?? 0,
                'medium' => $taskStats->priority_medium ?? 0,
                'low' => $taskStats->priority_low ?? 0,
            ]
        ];

        // 2. Các task khẩn cấp (Ưu tiên cao + Sắp hết hạn)
        $criticalTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', '!=', 'done')
            ->where(function($query) {
                $query->where('due_date', '<', now()) // Đã quá hạn
                      ->orWhereBetween('due_date', [now(), now()->addDays(3)]) // Hoặc sắp hết hạn 3 ngày tới
                      ->orWhere('priority', 'high'); // Hoặc ưu tiên cao
            })
            ->with(['project', 'assignee'])
            ->orderBy('due_date', 'asc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->limit(5)
            ->get();

        // 3. Hoạt động gần đây
        $recentActivities = \App\Models\TaskHistory::whereHas('task', function($q) use ($projectIds) {
                $q->whereIn('project_id', $projectIds);
            })
            ->with(['user', 'task'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 4. Danh sách dự án
        $projects = $user->ledProjects()
            ->withCount(['tasks', 'members'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.dashboard', compact('stats', 'projects', 'criticalTasks', 'recentActivities'));
    }
}
