<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Query cơ bản lấy task từ các dự án của Leader
        $query = Task::whereIn('project_id', $user->ledProjects()->pluck('id'))
            ->with(['project', 'assignee']);

        // 1. Lọc theo Dự án (nếu chọn từ dropdown)
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // 2. Lọc theo Trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Tìm kiếm từ khóa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sắp xếp: Ưu tiên cao lên trước -> Hạn chót gần nhất -> Mới nhất
        $tasks = $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Giữ lại tham số lọc khi chuyển trang

        // Lấy danh sách dự án để làm bộ lọc
        $projects = $user->ledProjects()->get();

        return view('leader.tasks', compact('tasks', 'projects'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        // Lấy danh sách dự án kèm thành viên (để JS xử lý dropdown assignee)
        $projects = $user->ledProjects()->with('members')->get();

        // Nếu click "Thêm Task" từ trang chi tiết dự án, ta sẽ có project_id này
        $selectedProjectId = $request->get('project_id');

        return view('leader.tasks.create', compact('projects', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // Check quyền: Dự án phải thuộc Leader này
        $project = Auth::user()->ledProjects()->findOrFail($request->project_id);

        $task = Task::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending', // Mặc định
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assignee_id' => $request->assignee_id,
        ]);

        // Gửi thông báo cho người được gán (nếu có)
        if ($request->assignee_id) {
            \App\Models\Notification::create([
                'user_id' => $request->assignee_id,
                'message' => "Bạn được giao việc mới: " . $task->title,
                'is_read' => false,
                'created_at' => now(),
            ]);
        }

        return redirect()->route('leader.projects.show', $project->id)
            ->with('success', 'Đã tạo công việc mới thành công!');
    }

    public function show($id)
    {
        $task = Task::with(['project', 'assignee', 'comments.user', 'histories.user'])->findOrFail($id);

        // Security check
        if ($task->project->leader_id !== Auth::id()) {
            abort(403);
        }

        return view('leader.tasks-show', compact('task'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        if ($task->project->leader_id !== Auth::id())
            abort(403);

        // [MỚI] Check: Nếu đã Done thì chặn, đá về trang trước
        if ($task->status === 'done') {
            return redirect()->back()->with('error', 'Task này đã hoàn thành và bị khóa. Vui lòng "Mở lại" task nếu muốn chỉnh sửa.');
        }

        $projects = Auth::user()->ledProjects()->with('members')->get();
        return view('leader.tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($task->project->leader_id !== Auth::id())
            abort(403);

        // [MỚI] Check chặn update
        if ($task->status === 'done') {
            return redirect()->back()->with('error', 'Không thể cập nhật task đã hoàn thành.');
        }

        $request->validate([
            // ... (giữ nguyên validation cũ)
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,done',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());

        if ($request->status == 'done' && !$task->completed_at) {
            $task->completed_at = now();
            $task->save();
        }

        return redirect()->route('leader.projects.show', $task->project_id)
            ->with('success', 'Cập nhật công việc thành công!');
    }

    public function reopen($id)
    {
        $task = Task::findOrFail($id);
        if ($task->project->leader_id !== Auth::id())
            abort(403);

        if ($task->status !== 'done') {
            return redirect()->back();
        }

        // Cập nhật lại trạng thái và xóa thời gian hoàn thành
        $task->update([
            'status' => 'in_progress', // Mở lại thì thường chuyển về đang làm
            'completed_at' => null,
        ]);

        // Ghi log lịch sử
        $task->histories()->create([
            'user_id' => Auth::id(),
            'action' => 'reopen', // Bạn có thể thêm action này vào DB nếu cần
            'old_value' => 'done',
            'new_value' => 'in_progress',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Đã mở lại task. Bạn có thể chỉnh sửa ngay bây giờ.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task->project->leader_id !== Auth::id())
            abort(403);

        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('leader.projects.show', $projectId)
            ->with('success', 'Đã xóa công việc.');
    }
}
