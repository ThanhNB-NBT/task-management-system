@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold"><i class="fas fa-list-check me-2"></i>{{ __('Quản Lý Công Việc') }}</h1>
            <p class="text-muted small mb-0">Tất cả công việc trong các dự án của bạn</p>
        </div>
        <a href="{{ route('leader.tasks.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> {{ __('Tạo Task Mới') }}
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body py-3">
            <form action="{{ route('leader.tasks.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <select name="project_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Tất cả dự án --</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang thực hiện</option>
                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Hoàn thành</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Tìm tên task..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-secondary btn-sm">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small text-secondary">
                        <tr>
                            <th class="ps-3" style="width: 30%;">Tên Task</th>
                            <th style="width: 20%;">Dự Án</th>
                            <th style="width: 15%;">Độ ưu tiên</th>
                            <th style="width: 15%;">Người làm</th>
                            <th style="width: 10%;">Hạn chót</th>
                            <th style="width: 10%;">Trạng thái</th>
                            <th class="text-end pe-3">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td class="ps-3">
                                    <a href="{{ route('leader.tasks.show', $task->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('leader.projects.show', $task->project_id) }}" class="badge bg-light text-secondary border text-decoration-none">
                                        {{ \Illuminate\Support\Str::limit($task->project->name, 20) }}
                                    </a>
                                </td>
                                <td>
                                    @if($task->priority == 'high') <span class="badge bg-danger">Cao</span>
                                    @elseif($task->priority == 'medium') <span class="badge bg-warning text-dark">Trung bình</span>
                                    @else <span class="badge bg-secondary">Thấp</span>
                                    @endif
                                </td>
                                <td>
                                    @if($task->assignee)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 10px;">
                                                {{ substr($task->assignee->name, 0, 1) }}
                                            </div>
                                            <span class="small">{{ $task->assignee->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted small fst-italic">--</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="small {{ ($task->due_date && $task->due_date < now() && $task->status != 'done') ? 'text-danger fw-bold' : 'text-muted' }}">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : '--' }}
                                    </span>
                                </td>
                                <td>
                                    @if($task->status == 'done') <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($task->status == 'in_progress') <span class="badge bg-info text-dark">Đang làm</span>
                                    @else <span class="badge bg-secondary">Chờ</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('leader.tasks.edit', $task->id) }}"><i class="fas fa-edit text-warning me-2"></i>Sửa</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('leader.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Xóa task này?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash text-danger me-2"></i>Xóa</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-clipboard-list fa-2x mb-3 opacity-50"></i>
                                    <p class="mb-0">Không tìm thấy công việc nào phù hợp.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3 border-top">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
