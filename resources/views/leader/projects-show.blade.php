@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-project-diagram"></i> {{ $project->name }}
            </h1>
            <p class="text-muted small">{{ $project->description ?? 'No description' }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('leader.projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
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
                            <div class="h3 mb-0 font-weight-bold">{{ $project->tasks_count }}</div>
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
                            <div class="h3 mb-0 font-weight-bold">{{ $taskStats['pending'] }}</div>
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
                            <div class="h3 mb-0 font-weight-bold">{{ $taskStats['in_progress'] }}</div>
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
                            <h6 class="text-success text-uppercase small font-weight-bold">{{ __('Done') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $taskStats['done'] }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-2">{{ __('Overall Progress') }}</p>
                    @php
                        $total = $project->tasks_count;
                        $done = $taskStats['done'];
                        $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                    @endphp
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $progress }}%;" 
                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $progress }}% {{ __('Complete') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Upcoming Tasks -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-days"></i> {{ __('Upcoming Tasks') }}
                        <span class="badge bg-danger float-end">{{ $upcomingTasks->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($upcomingTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingTasks as $task)
                                <a href="{{ route('leader.tasks.show', $task) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="badge bg-{{ $task->status === 'in_progress' ? 'info' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $task->assignee->name ?? __('Unassigned') }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y H:i') : 'N/A' }}
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

        <!-- Project Info Sidebar -->
        <div class="col-md-4">
            <!-- Team Members -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-users"></i> {{ __('Team Members') }}
                        <span class="badge bg-secondary float-end">{{ $project->members_count }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($project->members_count > 0)
                        <div class="list-group list-group-flush">
                            @foreach($project->members as $member)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-0 small">{{ $member->name }}</h6>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </div>
                                    <span class="badge bg-{{ $member->role === 'admin' ? 'danger' : ($member->role === 'leader' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">{{ __('No team members assigned.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Project Details -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Project Details') }}</h6>
                </div>
                <div class="card-body small">
                    <p class="mb-2">
                        <strong>{{ __('Status') }}:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($project->status ?? 'active') }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>{{ __('Created At') }}:</strong><br>
                        {{ $project->created_at->format('M d, Y') }}
                    </p>
                    @if($project->end_date)
                        <p class="mb-0">
                            <strong>{{ __('End Date') }}:</strong><br>
                            {{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- All Tasks Table -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-list"></i> {{ __('All Tasks') }}
                    </h6>
                </div>
                <div class="card-body">
                    @if($project->tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Assigned To') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                            </td>
                                            <td>
                                                <small>{{ $task->assignee->name ?? __('Unassigned') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('leader.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No tasks in this project.') }}
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
    .opacity-50 {
        opacity: 0.5 !important;
    }
</style>
@endsection
