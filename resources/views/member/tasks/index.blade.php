@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-tasks"></i> {{ __('My Tasks') }}
            </h1>
            <p class="text-muted small">{{ __('Tasks assigned to you') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0">
                <i class="fas fa-filter"></i> {{ __('Filters') }}
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('member.tasks.index') }}" class="row g-3">
                <!-- Status Filter -->
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            {{ __('Pending') }}
                        </option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>
                            {{ __('In Progress') }}
                        </option>
                        <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>
                            {{ __('Done') }}
                        </option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="col-md-3">
                    <label for="priority" class="form-label">{{ __('Priority') }}</label>
                    <select class="form-select" id="priority" name="priority">
                        <option value="">{{ __('All Priorities') }}</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>
                            {{ __('Low') }}
                        </option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>
                            {{ __('Medium') }}
                        </option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>
                            {{ __('High') }}
                        </option>
                    </select>
                </div>

                <!-- Project Filter -->
                <div class="col-md-3">
                    <label for="project_id" class="form-label">{{ __('Project') }}</label>
                    <select class="form-select" id="project_id" name="project_id">
                        <option value="">{{ __('All Projects') }}</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> {{ __('Filter') }}
                    </button>
                    <a href="{{ route('member.tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks List -->
    @if($tasks->count() > 0)
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card border-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}" style="border-left: 4px solid {{ $task->status === 'done' ? '#28a745' : ($task->status === 'in_progress' ? '#17a2b8' : '#ffc107') }};">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-0 text-truncate flex-grow-1" title="{{ $task->title }}">
                                    {{ $task->title }}
                                </h6>
                                <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }} ms-2" style="white-space: nowrap;">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Project -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Project') }}</small>
                                <a href="{{ route('member.projects.show', $task->project) }}" class="badge bg-primary text-decoration-none">
                                    {{ $task->project->name ?? 'N/A' }}
                                </a>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Description') }}</small>
                                <p class="small text-muted mb-0" style="max-height: 60px; overflow: hidden;">
                                    {{ $task->description ?? __('No description') }}
                                </p>
                            </div>

                            <!-- Priority -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Priority') }}</small>
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
                            </div>

                            <!-- Due Date -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Due Date') }}</small>
                                @php
                                    try {
                                        $dueDate = $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date) : null;
                                        $isOverdue = $dueDate && $dueDate->isPast() && $task->status !== 'done';
                                        $dueFormatted = $dueDate ? $dueDate->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        $isOverdue = false;
                                        $dueFormatted = '—';
                                    }
                                @endphp
                                <small class="text-{{ $isOverdue ? 'danger' : 'muted' }}">
                                    <i class="fas fa-calendar-alt"></i> {{ $dueFormatted }}
                                    @if($isOverdue)
                                        <span class="badge bg-danger">{{ __('Overdue') }}</span>
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="card-footer bg-light">
                            <div class="d-flex gap-2">
                                <a href="{{ route('member.tasks.show', $task) }}" class="btn btn-info btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> {{ __('View') }}
                                </a>
                                @if($task->status !== 'done')
                                    <form action="{{ route('member.tasks.updateStatus', $task) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="done">
                                        <button type="submit" class="btn btn-success btn-sm w-100">
                                            <i class="fas fa-check"></i> {{ __('Mark Done') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            {{ __('No tasks assigned to you yet.') }}
        </div>
    @endif
</div>

<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .border-success {
        border: 1px solid #28a745 !important;
    }

    .border-info {
        border: 1px solid #17a2b8 !important;
    }

    .border-warning {
        border: 1px solid #ffc107 !important;
    }
</style>
@endsection
