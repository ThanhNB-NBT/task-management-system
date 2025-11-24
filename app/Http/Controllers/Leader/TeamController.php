<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Lấy tất cả dự án leader này quản lý
        $projects = $user->ledProjects()->orderBy('created_at', 'desc')->get();

        // 2. Xác định dự án đang được chọn
        // Nếu có request 'project_id' thì dùng, nếu không thì lấy dự án đầu tiên
        $selectedProjectId = $request->get('project_id', $projects->first()?->id);

        $selectedProject = null;
        $members = collect([]); // Mặc định rỗng

        if ($selectedProjectId) {
            // Tìm dự án trong danh sách đã lấy (đảm bảo quyền sở hữu)
            $selectedProject = $projects->find($selectedProjectId);

            if ($selectedProject) {
                // 3. Lấy thành viên của dự án này kèm thông tin pivot (role, id để xóa)
                $members = $selectedProject->members()
                    ->withPivot('id', 'role_in_project')
                    ->get();
            }
        }

        return view('leader.team', compact('projects', 'selectedProject', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Kiểm tra quyền sở hữu dự án
        $project = Auth::user()->ledProjects()->findOrFail($request->project_id);
        $userToAdd = User::where('email', $request->email)->first();

        // Kiểm tra đã tồn tại chưa
        $exists = ProjectMember::where('project_id', $project->id)
            ->where('user_id', $userToAdd->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Thành viên này đã có trong dự án rồi.');
        }

        ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => $userToAdd->id,
            'role_in_project' => 'member',
        ]);

        return back()->with('success', 'Đã thêm thành viên thành công.');
    }

    public function destroy($id)
    {
        $memberRecord = ProjectMember::findOrFail($id);

        // Security Check
        $project = Project::findOrFail($memberRecord->project_id);
        if ($project->leader_id !== Auth::id()) {
            abort(403);
        }

        $memberRecord->delete();

        return back()->with('success', 'Đã xóa thành viên khỏi dự án.');
    }
}
