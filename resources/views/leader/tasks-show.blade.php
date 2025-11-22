@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(!isset($task))
        <div class="alert alert-danger">Task data not found</div>
    @else
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-tasks"></i> {{ $task->title }}
            </h1>
            <p class="text-muted small">{{ $task->project->name ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('leader.tasks.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </div>

    <!-- Task Details -->
    <div class="row">
        <div class="col-md-8">
            <!-- Task Information -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Task Information') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">{{ __('Status') }}</p>
                            <p class="mb-0">
                                <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if($task->priority)
                                <p class="text-muted small mb-1">{{ __('Priority') }}</p>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">{{ __('Assigned To') }}</p>
                            <p class="mb-0">{{ $task->assignee->name ?? __('Unassigned') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">{{ __('Due Date') }}</p>
                            <p class="mb-0">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted small mb-1">{{ __('Description') }}</p>
                            <p class="mb-0">{{ $task->description ?? __('No description provided') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-comments"></i> {{ __('Comments') }}
                        <span class="badge bg-secondary float-end">{{ $task->comments->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($task->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($task->comments as $comment)
                                <div class="comment-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">{{ __('No comments yet.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Task History -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-history"></i> {{ __('Activity Log') }}
                        <span class="badge bg-secondary float-end">{{ $task->histories->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($task->histories->count() > 0)
                        <div class="timeline">
                            @foreach($task->histories as $history)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex gap-2">
                                        <div class="timeline-marker">
                                            <i class="fas fa-circle text-primary" style="font-size: 0.5rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">
                                                <strong>{{ $history->user->name ?? 'Unknown' }}</strong>
                                                {{ $history->action }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $history->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">{{ __('No activity yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Project Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Project') }}</h6>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">{{ $task->project->name ?? 'N/A' }}</h6>
                </div>
            </div>

            <!-- Created Info -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Details') }}</h6>
                </div>
                <div class="card-body small">
                    <p class="mb-2">
                        <strong>{{ __('Created At') }}:</strong><br>
                        {{ $task->created_at->format('M d, Y H:i') }}
                    </p>
                    <p class="mb-2">
                        <strong>{{ __('Updated At') }}:</strong><br>
                        {{ $task->updated_at->format('M d, Y H:i') }}
                    </p>
                    @if($task->assignee)
                        <p class="mb-0">
                            <strong>{{ __('Assigned To') }}:</strong><br>
                            {{ $task->assignee->name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    @endif

<style>
    .timeline-marker {
        min-width: 20px;
        text-align: center;
    }
</style>
@endsection
