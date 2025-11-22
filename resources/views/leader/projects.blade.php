@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-project-diagram"></i> {{ __('My Projects') }}
            </h1>
            <p class="text-muted small">{{ __('Projects managed by you') }}</p>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $project->name }}</h5>
                                <small class="text-muted">{{ $project->description ?? 'No description' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="text-muted small mb-1">{{ __('Tasks') }}</p>
                                <h6 class="mb-0">{{ $project->tasks_count }}</h6>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-1">{{ __('Team Members') }}</p>
                                <h6 class="mb-0">{{ $project->members_count }}</h6>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        @php
                            $total = $project->tasks_count;
                            $done = $project->tasks()->where('status', 'done')->count();
                            $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                        @endphp
                        <div class="mb-3">
                            <p class="text-muted small mb-1">{{ __('Progress') }}</p>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $progress }}%;" 
                                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $progress }}%
                                </div>
                            </div>
                        </div>

                        <!-- Task Status -->
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <small class="text-muted">{{ __('Pending') }}</small>
                                <div class="badge bg-warning">{{ $project->tasks()->where('status', 'pending')->count() }}</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">{{ __('In Progress') }}</small>
                                <div class="badge bg-info">{{ $project->tasks()->where('status', 'in_progress')->count() }}</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">{{ __('Done') }}</small>
                                <div class="badge bg-success">{{ $done }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="{{ route('leader.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> {{ __('View Details') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> {{ __('You are not managing any projects yet.') }}
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
