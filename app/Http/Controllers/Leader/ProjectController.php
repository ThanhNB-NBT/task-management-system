<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // ... (Giữ nguyên index, create, store) ...
    public function index()
    {
        $user = Auth::user();
        $projects = $user->ledProjects()
            ->withCount(['tasks', 'members'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.projects', compact('projects'));
    }

    public function create()
    {
        return view('leader.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'leader_id' => $user->id,
        ]);

        $project->members()->attach($user->id, ['role_in_project' => 'leader']);

        return redirect()->route('leader.projects.index')
            ->with('success', 'Dự án mới đã được khởi tạo thành công!');
    }

    public function show($id)
    {
        $user = Auth::user();

        // 1. Lấy Project và đếm số lượng liên quan (tasks_count, members_count)
        $project = $user->ledProjects()->findOrFail($id);
        $project->loadCount(['tasks', 'members']);
        $project->load('members'); // Load danh sách member để hiển thị bên phải

        // 2. Thống kê trạng thái (Query trực tiếp để chính xác)
        $taskStats = [
            'pending' => $project->tasks()->where('status', 'pending')->count(),
            'in_progress' => $project->tasks()->where('status', 'in_progress')->count(),
            'done' => $project->tasks()->where('status', 'done')->count(),
        ];

        // 3. Lấy danh sách Task có Phân trang (5 task/trang)
        // Sắp xếp: Ưu tiên cao lên trước, sau đó đến hạn chót gần nhất
        $tasks = $project->tasks()
            ->with('assignee') // Eager load người thực hiện
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date', 'asc')
            ->paginate(5); // [FIX] Phân trang tại đây

        return view('leader.projects-show', compact('project', 'taskStats', 'tasks'));
    }

    public function edit($id)
    {
        $project = Auth::user()->ledProjects()->findOrFail($id);
        return view('leader.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Auth::user()->ledProjects()->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $project->update($request->all());
        return redirect()->route('leader.projects.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $project = Auth::user()->ledProjects()->findOrFail($id);
        $project->delete();
        return redirect()->route('leader.projects.index')->with('success', 'Đã xóa dự án!');
    }
}
