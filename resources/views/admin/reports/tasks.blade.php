@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Tasks Report') }}</span>
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
                                    <h3>{{ $statusDistribution['done'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5>{{ __('Overdue') }}</h5>
                                    <h3>{{ $overdueTasks }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">{{ __('Task Priority Distribution') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-success">
                                                <div class="card-body text-white">
                                                    <h5>{{ __('Low Priority') }}</h5>
                                                    <h3>{{ $priorityDistribution['low'] }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-warning">
                                                <div class="card-body text-white">
                                                    <h5>{{ __('Medium Priority') }}</h5>
                                                    <h3>{{ $priorityDistribution['medium'] }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-danger">
                                                <div class="card-body text-white">
                                                    <h5>{{ __('High Priority') }}</h5>
                                                    <h3>{{ $priorityDistribution['high'] }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Task') }}</th>
                                    <th>{{ __('Project') }}</th>
                                    <th>{{ __('Assignee') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Priority') }}</th>
                                    <th>{{ __('Comments') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->project->name }}</td>
                                    <td>{{ $task->assignee->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'success') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td>{{ $task->comments_count }}</td>
                                    <td>
                                        <span class="{{ $task->status !== 'done' && $task->due_date < now() ? 'text-danger' : '' }}">
                                            {{ $task->due_date->format('Y-m-d') }}
                                        </span>
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