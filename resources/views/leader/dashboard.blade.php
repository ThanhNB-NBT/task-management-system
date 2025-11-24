@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Bảng Điều Khiển') }}
            </h1>
            <p class="text-muted small mb-0">{{ __('Chào mừng quay trở lại,') }} <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <div>
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="far fa-calendar-alt"></i> {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('Tổng Dự Án') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_projects'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300 text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Tổng Task') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300 text-success opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Thành Viên') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_members'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300 text-info opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Tỷ lệ Hoàn thành') }}</div>
                            @php
                                $percent = $stats['total_tasks'] > 0 ? round(($stats['done'] / $stats['total_tasks']) * 100) : 0;
                            @endphp
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $percent }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300 text-warning opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie me-1"></i> {{ __('Thống Kê Trạng Thái') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-2 pb-2">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-warning"></i> Pending: <b>{{ $stats['pending'] }}</b></span>
                        <span class="mr-2"><i class="fas fa-circle text-info"></i> In Progress: <b>{{ $stats['in_progress'] }}</b></span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Done: <b>{{ $stats['done'] }}</b></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fire me-1"></i> {{ __('Việc Cần Xử Lý Gấp') }}</h6>
                </div>
                <div class="card-body p-0">
                    @if($criticalTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($criticalTasks as $task)
                                <a href="{{ route('leader.tasks.show', $task->id) }}" class="list-group-item list-group-item-action p-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 text-dark fw-bold">{{ $task->title }}</h6>
                                        @if($task->due_date < now())
                                            <span class="badge bg-danger">Quá hạn</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Sắp tới hạn</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-folder me-1"></i> {{ $task->project->name }}
                                            <span class="mx-1">•</span>
                                            <i class="fas fa-user me-1"></i> {{ $task->assignee->name ?? 'Chưa giao' }}
                                        </small>
                                        <small class="text-danger fw-bold">
                                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m H:i') : '' }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                            <p>Tuyệt vời! Không có công việc nào quá hạn.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">{{ __('Tiến Độ Dự Án') }}</h6>
                    <a href="{{ route('leader.projects.index') }}" class="btn btn-sm btn-link">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3">Dự án</th>
                                    <th>Thành viên</th>
                                    <th>Tiến độ</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects->take(5) as $project)
                                    @php
                                        $total = $project->tasks_count;
                                        // Tính lại done dựa trên quan hệ tasks đã load (hoặc query count riêng nếu cần chính xác tuyệt đối)
                                        // Ở Controller ta đã loadCount, nhưng để tính done phải loadCount có điều kiện.
                                        // Cách nhanh nhất dùng collection filter vì số lượng task ko quá lớn ở view này
                                        $done = $project->tasks->where('status', 'done')->count();
                                        $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-dark">{{ $project->name }}</div>
                                            <small class="text-muted">{{ $total }} tasks</small>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                @foreach($project->members->take(3) as $m)
                                                    <span class="avatar-circle-sm bg-secondary text-white d-inline-flex align-items-center justify-content-center rounded-circle small" style="width: 25px; height: 25px; font-size: 10px;" title="{{ $m->name }}">
                                                        {{ substr($m->name, 0, 1) }}
                                                    </span>
                                                @endforeach
                                                @if($project->members_count > 3)
                                                    <span class="small text-muted ms-1">+{{ $project->members_count - 3 }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="width: 30%;">
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="fw-bold">{{ $progress }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($progress == 100) <span class="badge bg-success">Hoàn thành</span>
                                            @elseif($progress > 0) <span class="badge bg-primary">Đang chạy</span>
                                            @else <span class="badge bg-secondary">Mới tạo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">{{ __('Hoạt Động Mới') }}</h6>
                </div>
                <div class="card-body">
                    <div class="timeline-small">
                        @foreach($recentActivities as $activity)
                            <div class="d-flex mb-3">
                                <div class="me-3 text-center" style="width: 40px;">
                                    <div class="avatar-circle bg-light text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px;">
                                        <i class="fas {{ $activity->action == 'create' ? 'fa-plus' : ($activity->action == 'done' ? 'fa-check' : 'fa-history') }} small"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small">
                                        <span class="fw-bold">{{ $activity->user->name ?? 'System' }}</span>
                                        <span class="text-muted">
                                            @if($activity->action == 'create') đã tạo task
                                            @elseif($activity->action == 'update_status') cập nhật trạng thái
                                            @elseif($activity->action == 'add_comment') bình luận
                                            @else cập nhật
                                            @endif
                                        </span>
                                    </div>
                                    <div class="small text-dark fst-italic">{{ Str::limit($activity->task->title ?? 'Task deleted', 30) }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("taskStatusChart");
    if (ctx) {
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Pending", "In Progress", "Done"],
                datasets: [{
                    data: [{{ $stats['pending'] }}, {{ $stats['in_progress'] }}, {{ $stats['done'] }}],
                    backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a'],
                    hoverBackgroundColor: ['#dda20a', '#2c9faf', '#17a673'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 70,
            },
        });
    }
});
</script>

<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .chart-pie { position: relative; height: 250px; width: 100%; }
</style>
@endsection
