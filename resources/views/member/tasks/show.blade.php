@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Navigation -->
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('member.tasks.index') }}" class="btn btn-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Tasks') }}
            </a>
        </div>
    </div>

    <!-- Task Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="mb-0">{{ $task->title }}</h2>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-project-diagram"></i>
                                <a href="{{ route('member.projects.show', $task->project) }}">
                                    {{ $task->project->name }}
                                </a>
                            </p>
                        </div>
                        @php
                            $statusMap = [
                                'pending' => 'warning',
                                'in_progress' => 'info',
                                'done' => 'success'
                            ];
                            $statusClass = $statusMap[$task->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="text-muted">{{ __('Description') }}</h6>
                        <p>{{ $task->description ?? __('No description provided') }}</p>
                    </div>

                    <!-- Task Details Grid -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Priority') }}</h6>
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

                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Due Date') }}</h6>
                            <p>
                                @php
                                    try {
                                        echo $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        echo '—';
                                    }
                                @endphp
                            </p>
                        </div>

                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Assigned By') }}</h6>
                            <p>{{ $task->project->leader->name ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-3">
                            <h6 class="text-muted">{{ __('Created On') }}</h6>
                            <p>
                                @php
                                    try {
                                        echo $task->created_at ? $task->created_at->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        echo '—';
                                    }
                                @endphp
                            </p>
                        </div>
                    </div>

                    <!-- Status Update Form -->
                    @if($task->status !== 'done')
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">{{ __('Update Status') }}</h6>
                            <form action="{{ route('member.tasks.updateStatus', $task) }}" method="POST" class="row g-2">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <select class="form-select" name="status" required>
                                        <option value="">{{ __('Select New Status') }}</option>
                                        @if($task->status === 'pending')
                                            <option value="in_progress">{{ __('In Progress') }}</option>
                                        @endif
                                        <option value="done">{{ __('Done') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-save"></i> {{ __('Update Status') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Task Timeline -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-history"></i> {{ __('Task History') }}
                    </h6>
                </div>
                <div class="card-body">
                    @if($task->histories->count() > 0)
                        <div class="timeline">
                            @foreach($task->histories as $history)
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted d-block">
                                            {{ $history->user->name }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-clock"></i>
                                            @php
                                                try {
                                                    echo $history->created_at->diffForHumans();
                                                } catch (\Exception $e) {
                                                    echo '—';
                                                }
                                            @endphp
                                        </small>
                                        <p class="small mb-0 mt-1">
                                            {{ ucfirst(str_replace('_', ' ', $history->action)) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <small class="text-muted">{{ __('No history available') }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-comments"></i> {{ __('Comments') }}
                        <span class="badge bg-info float-end">{{ $task->comments->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Attachments Upload -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">{{ __('Attachments') }}</h6>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


                        @if($task->attachments->count() > 0)
                            <ul class="list-group">
                                @foreach($task->attachments as $att)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-paperclip"></i>
                                            <strong>{{ $att->original_name }}</strong>
                                            <div class="small text-muted">{{ number_format($att->size / 1024, 2) }} KB • {{ $att->mime_type }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('member.tasks.attachments.download', $att->id) }}" class="btn btn-sm btn-outline-secondary me-2">{{ __('Download') }}</a>
                                            @if(auth()->id() === $att->user_id || auth()->user()->role === 'admin' || optional($task->project->leader)->id === auth()->id())
                                                <form action="{{ route('member.tasks.attachments.destroy', $att->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            
                        @endif
                    </div>

                    <!-- original comment area continues -->

                <div class="card-body">
                    <!-- Add Comment Form -->
                    <form action="{{ route('member.tasks.comments.store', $task) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf

                        <div class="mb-3">
                            <label for="content" class="form-label">{{ __('Add a Comment') }}</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      rows="3"
                                      placeholder="{{ __('Enter your comment...') }}"></textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">{{ __('Attach a file (optional)') }}</label>
                            <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> {{ __('Post Comment') }}
                        </button>
                    </form>

                    <!-- Comments List -->
                    @if($task->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($task->comments as $comment)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $comment->user->name }}</strong>
                                                <small class="text-muted d-block">
                                                    @php
                                                        try {
                                                            echo $comment->created_at->diffForHumans();
                                                        } catch (\Exception $e) {
                                                            echo '—';
                                                        }
                                                    @endphp
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $comment->content }}</p>

                                        @if($comment->attachments->count() > 0)
                                            <div class="mt-3">
                                                @foreach($comment->attachments as $att)
                                                    <div class="mb-2">
                                                        @php $isImage = is_string($att->mime_type) && strpos($att->mime_type, 'image/') === 0; @endphp
                                                        @if($isImage)
                                                            <img src="{{ asset('storage/' . $att->path) }}" alt="{{ $att->original_name }}" class="img-fluid rounded" style="max-width: 300px;" />
                                                        @else
                                                            <a href="{{ asset('storage/' . $att->path) }}" target="_blank">{{ $att->original_name }}</a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No comments yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 30px;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 3px;
        width: 12px;
        height: 12px;
        background-color: #007bff;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #007bff;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 4px;
        top: 15px;
        bottom: -15px;
        width: 2px;
        background-color: #dee2e6;
    }
</style>
@endsection
