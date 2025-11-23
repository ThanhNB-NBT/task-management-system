@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-tachometer-alt"></i> {{ __('Member Dashboard') }}
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
                            <h6 class="text-primary text-uppercase small font-weight-bold">{{ __('Total Tasks') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <i class="fas fa-tasks fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning text-uppercase small font-weight-bold">{{ __('Pending') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['pending_tasks'] }}</div>
                        </div>
                        <i class="fas fa-hourglass-start fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info text-uppercase small font-weight-bold">{{ __('In Progress') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['in_progress_tasks'] }}</div>
                        </div>
                        <i class="fas fa-spinner fa-2x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success text-uppercase small font-weight-bold">{{ __('Completed') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['done_tasks'] }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-left-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary text-uppercase small font-weight-bold">{{ __('Projects') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_projects'] }}</div>
                        </div>
                        <i class="fas fa-project-diagram fa-2x text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-left-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-danger text-uppercase small font-weight-bold">{{ __('Unread Notifications') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['unread_notifications'] }}</div>
                        </div>
                        <i class="fas fa-bell fa-2x text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Upcoming Tasks -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-days"></i> {{ __('Upcoming Tasks') }}
                        <span class="badge bg-danger float-end">{{ count($upcomingTasks) }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($upcomingTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingTasks as $task)
                                <a href="{{ route('member.tasks.show', $task) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="badge bg-{{ $task->status === 'in_progress' ? 'info' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $task->project->name ?? 'N/A' }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No upcoming tasks.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-clock"></i> {{ __('Recent Tasks') }}
                        <span class="badge bg-info float-end">{{ count($recentTasks) }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTasks as $task)
                                <a href="{{ route('member.tasks.show', $task) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $task->project->name ?? 'N/A' }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $task->created_at->format('M d, Y H:i') }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No recent tasks.') }}
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
    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-danger {
        border-left: 4px solid #dc3545 !important;
    }
    .border-left-secondary {
        border-left: 4px solid #6c757d !important;
    }
    
    .opacity-50 {
        opacity: 0.5;
    }
    
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
