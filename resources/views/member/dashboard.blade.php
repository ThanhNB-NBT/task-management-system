@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Tổng Quan Công Việc') }}
            </h1>
            <p class="text-muted small mb-0">{{ __('Xin chào,') }} <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <span class="badge bg-white text-dark border p-2">
            <i class="far fa-calendar-alt"></i> {{ now()->format('d/m/Y') }}
        </span>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('Việc Được Giao') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300 text-primary opacity-25"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Đang Thực Hiện') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_progress_tasks'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-spinner fa-2x text-gray-300 text-info opacity-25"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Đã Hoàn Thành') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['done_tasks'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300 text-success opacity-25"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Chờ Xử Lý') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_tasks'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-hourglass-start fa-2x text-gray-300 text-warning opacity-25"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie me-1"></i> {{ __('Hiệu Suất Của Tôi') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-2 pb-2">
                        <canvas id="myTaskChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-warning"></i> Pending</span>
                        <span class="mr-2"><i class="fas fa-circle text-info"></i> Doing</span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Done</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fire me-1"></i> {{ __('Việc Sắp Tới Hạn') }}</h6>
                    <span class="badge bg-danger">{{ $upcomingTasks->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($upcomingTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingTasks as $task)
                                <a href="{{ route('member.tasks.show', $task) }}" class="list-group-item list-group-item-action p-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 text-dark font-weight-bold">{{ $task->title }}</h6>
                                        <small class="text-danger font-weight-bold">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m H:i') }}
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><i class="fas fa-folder me-1"></i> {{ $task->project->name }}</small>
                                        <span class="badge bg-{{ $task->status == 'in_progress' ? 'info' : 'warning' }} text-dark">
                                            {{ $task->status == 'in_progress' ? 'Đang làm' : 'Chờ' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-check fa-3x mb-3 opacity-50"></i>
                            <p>Bạn không có việc nào gấp trong 3 ngày tới.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("myTaskChart");
    if(ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Pending", "In Progress", "Done"],
                datasets: [{
                    data: [{{ $stats['pending_tasks'] }}, {{ $stats['in_progress_tasks'] }}, {{ $stats['done_tasks'] }}],
                    backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a'],
                    hoverBackgroundColor: ['#dda20a', '#2c9faf', '#17a673'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                legend: { display: false },
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
