@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('leader.projects.index') }}" class="btn btn-light btn-sm shadow-sm text-secondary">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Quay lại danh sách') }}
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <h1 class="h3 mb-0 text-primary fw-bold">
                    <i class="fas fa-folder-open me-2"></i>{{ $project->name }}
                </h1>
                <span class="badge bg-secondary ms-3">#{{ $project->id }}</span>
            </div>
            <p class="text-muted mt-2 mb-0">{{ $project->description ?? 'Chưa có mô tả chi tiết' }}</p>
            <div class="mt-2 text-small text-muted">
                <i class="far fa-calendar-alt me-1"></i>
                {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}
                @if($project->end_date)
                    - {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}
                @endif
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <a href="{{ route('leader.projects.edit', $project->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Sửa Dự Án
                </a>
                <a href="{{ route('leader.tasks.create', ['project_id' => $project->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm Task
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <h3 class="fw-bold text-primary mb-0">{{ $project->tasks_count }}</h3>
                    <small class="text-muted text-uppercase">Tổng Task</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body text-center">
                    <h3 class="fw-bold text-warning mb-0">{{ $taskStats['pending'] }}</h3>
                    <small class="text-muted text-uppercase">Chờ xử lý</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body text-center">
                    <h3 class="fw-bold text-info mb-0">{{ $taskStats['in_progress'] }}</h3>
                    <small class="text-muted text-uppercase">Đang làm</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <h3 class="fw-bold text-success mb-0">{{ $taskStats['done'] }}</h3>
                    <small class="text-muted text-uppercase">Hoàn thành</small>
                </div>
            </div>
        </div>
    </div>

    @php
        $totalTasks = $project->tasks_count;
        $doneTasks = $taskStats['done'];
        $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
    @endphp
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-1">
                <span class="fw-bold text-muted small">Tiến độ tổng thể ({{ $doneTasks }}/{{ $totalTasks }})</span>
                <span class="fw-bold {{ $progress == 100 ? 'text-success' : 'text-primary' }}">{{ $progress }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}"
                     role="progressbar"
                     style="width: {{ $progress }}%"
                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 fixed-height-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-tasks text-primary me-2"></i>{{ __('Công Việc') }}</h5>
                    <small class="text-muted">Hiển thị 5 task/trang</small>
                </div>

                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-3" style="width: 35%;">Tên Task</th>
                                    <th style="width: 15%;">Độ ưu tiên</th>
                                    <th style="width: 20%;">Người làm</th>
                                    <th style="width: 15%;">Hạn chót</th>
                                    <th style="width: 15%;">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    <tr>
                                        <td class="ps-3">
                                            <a href="{{ route('leader.tasks.show', $task->id) }}" class="text-decoration-none fw-bold text-dark d-block text-truncate" style="max-width: 200px;">
                                                {{ $task->title }}
                                            </a>
                                        </td>

                                        <td>
                                            @if($task->priority == 'high')
                                                <span class="badge bg-danger">Cao</span>
                                            @elseif($task->priority == 'medium')
                                                <span class="badge bg-warning text-dark">Trung bình</span>
                                            @else
                                                <span class="badge bg-secondary">Thấp</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($task->assignee)
                                                <div class="d-flex align-items-center" title="{{ $task->assignee->name }}">
                                                    <div class="avatar-sm rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2 small" style="width: 24px; height: 24px; font-size: 10px;">
                                                        {{ substr($task->assignee->name, 0, 1) }}
                                                    </div>
                                                    <span class="small text-truncate" style="max-width: 80px;">{{ $task->assignee->name }}</span>
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
                                            @if($task->status == 'done')
                                                <span class="badge bg-success">Hoàn thành</span>
                                            @elseif($task->status == 'in_progress')
                                                <span class="badge bg-info text-dark">Đang thực hiện</span>
                                            @else
                                                <span class="badge bg-light text-dark border">Chờ xử lý</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Chưa có task nào.
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

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 fixed-height-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-users text-success me-2"></i>{{ __('Thành Viên') }}</h5>
                    <a href="{{ route('leader.team.index', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-cog"></i> Quản lý
                    </a>
                </div>
                <div class="card-body overflow-auto" style="max-height: 400px;">
                    <ul class="list-group list-group-flush">
                        @forelse($project->members as $member)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-light text-dark rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 38px; height: 38px; font-weight: 600;">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark small fw-bold">{{ $member->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $member->email }}</small>
                                    </div>
                                </div>
                                <span class="badge {{ $member->pivot->role_in_project == 'leader' ? 'bg-primary' : 'bg-light text-secondary border' }}">
                                    {{ ucfirst($member->pivot->role_in_project) }}
                                </span>
                            </li>
                        @empty
                            <li class="text-center text-muted py-3">Chưa có thành viên nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fixed-height-card {
        min-height: 500px;
        display: flex;
        flex-direction: column;
    }
    .border-bottom-dashed {
        border-bottom: 1px dashed #eff2f7 !important;
    }
    .pagination {
        margin-bottom: 0;
        justify-content: center;
    }
    .page-item .page-link {
        font-size: 0.85rem;
        padding: 0.3rem 0.6rem;
    }
</style>
@endsection
