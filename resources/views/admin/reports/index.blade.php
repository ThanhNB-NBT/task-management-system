@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('System Reports') }}</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Users') }}</h5>
                                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Projects') }}</h5>
                                    <h2 class="mb-0">{{ $totalProjects }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Tasks') }}</h5>
                                    <h2 class="mb-0">{{ $totalTasks }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    {{ __('Recent Activities') }}
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('User') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                    <th>{{ __('Task') }}</th>
                                                    <th>{{ __('Time') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentActivities as $activity)
                                                <tr>
                                                    <td>{{ $activity->user_name }}</td>
                                                    <td>{{ $activity->action }}</td>
                                                    <td>{{ $activity->task_title }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    {{ __('Detailed Reports') }}
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('admin.reports.users') }}" class="text-decoration-none">{{ __('Users Report') }}</a>
                                                <a href="{{ route('admin.reports.analytics.users') }}" class="btn btn-sm btn-link ms-2">Analytics</a>
                                            </div>
                                            <span>
                                                <a href="{{ route('admin.reports.users.export.excel') }}" class="btn btn-sm btn-outline-primary me-1">Excel</a>
                                                <a href="{{ route('admin.reports.users.export.pdf') }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                                            </span>
                                        </div>

                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('admin.reports.projects') }}" class="text-decoration-none">{{ __('Projects Report') }}</a>
                                                <a href="{{ route('admin.reports.analytics.projects') }}" class="btn btn-sm btn-link ms-2">Analytics</a>
                                            </div>
                                            <span>
                                                <a href="{{ route('admin.reports.projects.export.excel') }}" class="btn btn-sm btn-outline-primary me-1">Excel</a>
                                                <a href="{{ route('admin.reports.projects.export.pdf') }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                                            </span>
                                        </div>

                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ route('admin.reports.tasks') }}" class="text-decoration-none">{{ __('Tasks Report') }}</a>
                                            <span>
                                                <a href="{{ route('admin.reports.tasks.export.excel') }}" class="btn btn-sm btn-outline-primary me-1">Excel</a>
                                                <a href="{{ route('admin.reports.tasks.export.pdf') }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection