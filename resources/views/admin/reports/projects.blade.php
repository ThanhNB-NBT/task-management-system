@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Projects Report') }}</span>
                    <a href="{{ route('admin.reports') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Reports') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>{{ __('Pending') }}</h5>
                                    <h3>{{ $statusDistribution['pending'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>{{ __('In Progress') }}</h5>
                                    <h3>{{ $statusDistribution['in_progress'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>{{ __('Completed') }}</h5>
                                    <h3>{{ $statusDistribution['completed'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <h5>{{ __('On Hold') }}</h5>
                                    <h3>{{ $statusDistribution['on_hold'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Project') }}</th>
                                    <th>{{ __('Leader') }}</th>
                                    <th>{{ __('Members') }}</th>
                                    <th>{{ __('Tasks') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Progress') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td>{{ $project->leader->name }}</td>
                                    <td>{{ $project->members->count() }}</td>
                                    <td>{{ $project->tasks_count }}</td>
                                    <td>
                                        <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'info' : ($project->status === 'on_hold' ? 'secondary' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" 
                                                 role="progressbar" 
                                                 style="width: {{ $project->completion_rate }}%;" 
                                                 aria-valuenow="{{ $project->completion_rate }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ $project->completion_rate }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection