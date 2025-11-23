@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-bar"></i> {{ __('Reports') }}
            </h1>
            <p class="text-muted small">{{ __('Project and task statistics') }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary text-uppercase small font-weight-bold">{{ __('Pending') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $taskStats['pending'] }}</div>
                        </div>
                        <i class="fas fa-hourglass-start fa-2x text-primary opacity-50"></i>
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

        <div class="col-md-3 mb-3">
            <div class="card border-left-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary text-uppercase small font-weight-bold">{{ __('Total') }}</h6>
                            <div class="h3 mb-0 font-weight-bold">{{ $taskStats['pending'] + $taskStats['in_progress'] + $taskStats['done'] }}</div>
                        </div>
                        <i class="fas fa-tasks fa-2x text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Overview -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-list"></i> {{ __('Project Details') }}
                    </h6>
                </div>
                <div class="card-body">
                    @if($projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Project Name') }}</th>
                                        <th>{{ __('Total Tasks') }}</th>
                                        <th>{{ __('Pending') }}</th>
                                        <th>{{ __('In Progress') }}</th>
                                        <th>{{ __('Done') }}</th>
                                        <th>{{ __('Progress') }}</th>
                                        <th>{{ __('Members') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                        @php
                                            $total = $project->tasks_count;
                                            $pending = $project->tasks()->where('status', 'pending')->count();
                                            $inProgress = $project->tasks()->where('status', 'in_progress')->count();
                                            $done = $project->tasks()->where('status', 'done')->count();
                                            $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $project->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $total }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $pending }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $inProgress }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $done }}</span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px; min-width: 100px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: {{ $progress }}%;" 
                                                         aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $progress }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $project->members_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> {{ __('No projects to report.') }}
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
    .border-left-secondary {
        border-left: 4px solid #6c757d !important;
    }
    .opacity-50 {
        opacity: 0.5 !important;
    }
</style>
@endsection
