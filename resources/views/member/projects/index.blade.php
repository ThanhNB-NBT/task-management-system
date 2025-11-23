@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-project-diagram"></i> {{ __('My Projects') }}
            </h1>
            <p class="text-muted small">{{ __('Projects you are participating in') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($projects->count() > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 text-truncate" title="{{ $project->name }}">
                                {{ $project->name }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Project Leader -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Leader') }}</small>
                                <div class="badge bg-primary">
                                    {{ $project->leader->name ?? '—' }}
                                </div>
                            </div>

                            <!-- Project Description -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Description') }}</small>
                                <p class="small text-muted mb-0" style="max-height: 60px; overflow: hidden;">
                                    {{ $project->description ?? __('No description') }}
                                </p>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Status') }}</small>
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

                            <!-- Progress -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Progress') }}</small>
                                @php
                                    $totalTasks = $project->tasks_count ?? 0;
                                    $completedTasks = $project->tasks()->where('status', 'done')->count();
                                    $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks * 100) : 0;
                                @endphp
                                <div class="progress" style="height: 24px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $progress }}%;"
                                         aria-valuenow="{{ $progress }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        <small>{{ round($progress) }}%</small>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ $completedTasks }} / {{ $totalTasks }} {{ __('tasks completed') }}
                                </small>
                            </div>

                            <!-- Timeline -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Timeline') }}</small>
                                @php
                                    $start = $project->start_date ?? null;
                                    $end = $project->end_date ?? null;
                                    try {
                                        $startFormatted = $start ? \Illuminate\Support\Carbon::parse($start)->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        $startFormatted = (string) $start;
                                    }
                                    try {
                                        $endFormatted = $end ? \Illuminate\Support\Carbon::parse($end)->format('M d, Y') : '—';
                                    } catch (\Exception $e) {
                                        $endFormatted = (string) $end;
                                    }
                                @endphp
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $startFormatted }} → {{ $endFormatted }}
                                </small>
                            </div>

                            <!-- Team Members -->
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Team Members') }}</small>
                                <small class="text-muted">
                                    <i class="fas fa-users"></i> {{ $project->members->count() }} {{ __('members') }}
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('member.projects.show', $project) }}" 
                               class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye"></i> {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            {{ __('You are not participating in any projects yet.') }}
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
</style>
@endsection
