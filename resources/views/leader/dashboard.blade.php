@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-pie"></i> {{ __('Leader Dashboard') }}
            </h1>
            <p class="text-muted small">{{ __('Welcome back!') }} {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary text-uppercase small font-weight-bold">{{ __('Total Projects') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_projects'] }}</div>
                        </div>
                        <i class="fas fa-project-diagram fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info text-uppercase small font-weight-bold">{{ __('Total Tasks') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <i class="fas fa-tasks fa-2x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success text-uppercase small font-weight-bold">{{ __('Team Members') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_members'] }}</div>
                        </div>
                        <i class="fas fa-users fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning text-uppercase small font-weight-bold">{{ __('Completed') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['done'] }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('Pending Tasks') }}</h6>
                    <div class="h3 mb-0 font-weight-bold text-warning">{{ $stats['pending'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('In Progress Tasks') }}</h6>
                    <div class="h3 mb-0 font-weight-bold text-info">{{ $stats['in_progress'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('Done Tasks') }}</h6>
                    <div class="h3 mb-0 font-weight-bold text-success">{{ $stats['done'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Critical Tasks -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('Critical Tasks') }}
                        <span class="badge bg-danger float-end">{{ $criticalTasks->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($criticalTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($criticalTasks as $task)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="badge bg-{{ $task->status === 'in_progress' ? 'info' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $task->project->name ?? 'N/A' }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $task->assignee->name ?? 'Unassigned' }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No critical tasks.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-history"></i> {{ __('Recent Activities') }}
                        <span class="badge bg-secondary float-end">{{ $recentActivities->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        <div class="timeline">
                            @foreach($recentActivities as $activity)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex gap-2">
                                        <div class="timeline-marker">
                                            <i class="fas fa-circle text-primary" style="font-size: 0.5rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">
                                                <strong>{{ $activity->user->name ?? 'Unknown' }}</strong>
                                                {{ $activity->action }} 
                                                <em>{{ $activity->task->title ?? 'Task' }}</em>
                                            </p>
                                            <small class="text-muted">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No recent activities.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Overview -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-list"></i> {{ __('My Projects') }}
                        <span class="badge bg-secondary float-end">{{ $projects->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Project Name') }}</th>
                                        <th>{{ __('Tasks') }}</th>
                                        <th>{{ __('Members') }}</th>
                                        <th>{{ __('Progress') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>
                                                <strong>{{ $project->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $project->tasks_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $project->members_count }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $total = $project->tasks()->count();
                                                    $done = $project->tasks()->where('status', 'done')->count();
                                                    $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: {{ $progress }}%;" 
                                                         aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $progress }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No projects yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for card styling -->
<style>
    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }
    .border-left-danger {
        border-left: 4px solid #dc3545 !important;
    }
    .border-left-secondary {
        border-left: 4px solid #6c757d !important;
    }
    .opacity-50 {
        opacity: 0.5 !important;
    }
    .timeline-marker {
        min-width: 20px;
        text-align: center;
    }
</style>
@endsection
