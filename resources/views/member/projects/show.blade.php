@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Navigation -->
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('member.projects.index') }}" class="btn btn-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Projects') }}
            </a>
        </div>
    </div>

    <!-- Project Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ $project->name }}</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Description') }}</h6>
                            <p>{{ $project->description ?? __('No description provided') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Project Leader') }}</h6>
                            <div class="badge bg-primary">
                                {{ $project->leader->name ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Status') }}</h6>
                            @php
                                $statusMap = [
                                    'pending' => 'warning',
                                    'in_progress' => 'info',
                                    'completed' => 'success',
                                    'on_hold' => 'secondary'
                                ];
                                $statusClass = isset($project->status) && array_key_exists($project->status, $statusMap)
                                    ? $statusMap[$project->status]
                                    : 'secondary';
                                $statusLabel = $project->status ? ucfirst(str_replace('_', ' ', $project->status)) : 'Unknown';
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ __($statusLabel) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Start Date') }}</h6>
                            <p>
                                @php
                                    try {
                                        echo $project->start_date ? \Illuminate\Support\Carbon::parse($project->start_date)->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        echo $project->start_date ?? '—';
                                    }
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('End Date') }}</h6>
                            <p>
                                @php
                                    try {
                                        echo $project->end_date ? \Illuminate\Support\Carbon::parse($project->end_date)->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        echo $project->end_date ?? '—';
                                    }
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Budget') }}</h6>
                            <p>{{ $project->budget ? '$' . number_format($project->budget, 2) : '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- My Tasks -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks"></i> {{ __('My Tasks') }}
                        <span class="badge bg-info float-end">{{ count($myTasks) }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($myTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($myTasks as $task)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $task->description ?? 'No description' }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i>
                                        Due: {{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No tasks assigned to you in this project.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Team Members -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-users"></i> {{ __('Team Members') }}
                        <span class="badge bg-secondary float-end">{{ $project->members->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($project->members->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($project->members as $member)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $member->name }}</h6>
                                            <small class="text-muted">{{ $member->email }}</small>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $member->role === 'leader' ? 'primary' : 'secondary' }}">
                                                {{ ucfirst($member->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No team members in this project.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- All Project Tasks -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-list-check"></i> {{ __('All Project Tasks') }}
                        <span class="badge bg-info float-end">{{ $project->tasks->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($project->tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Assigned To') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Priority') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $task->assignee->name ?? 'Unassigned' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    try {
                                                        echo $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('M d, Y') : '—';
                                                    } catch (\Exception $e) {
                                                        echo '—';
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $priorityMap = [
                                                        'low' => 'info',
                                                        'medium' => 'warning',
                                                        'high' => 'danger'
                                                    ];
                                                    $priorityClass = $priorityMap[$task->priority] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $priorityClass }}">
                                                    {{ ucfirst($task->priority ?? 'N/A') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No tasks in this project yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
