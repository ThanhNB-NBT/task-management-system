@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Project Management') }}</span>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('Add Project') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Leader') }}</th>
                                    <th>{{ __('Members') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Progress') }}</th>
                                    <th>{{ __('Timeline') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $project->leader->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $project->members->count() }} {{ __('members') }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'pending' => 'warning',
                                                'in_progress' => 'info',
                                                'completed' => 'success',
                                                'on_hold' => 'secondary'
                                            ];
                                            // Safely get the class; default to 'secondary' if status missing or unknown
                                            $statusClass = isset($project->status) && array_key_exists($project->status, $statusMap)
                                                ? $statusMap[$project->status]
                                                : 'secondary';
                                            $statusLabel = $project->status ? ucfirst(str_replace('_', ' ', $project->status)) : 'Unknown';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ __($statusLabel) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $totalTasks = $project->tasks->count();
                                            $completedTasks = $project->tasks->where('status', 'completed')->count();
                                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks * 100) : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $progress }}%;" 
                                                 aria-valuenow="{{ $progress }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ round($progress) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $start = $project->start_date ?? null;
                                            $end = $project->end_date ?? null;
                                            try {
                                                $startFormatted = $start ? \Illuminate\Support\Carbon::parse($start)->format('Y-m-d') : '—';
                                            } catch (\Exception $e) {
                                                $startFormatted = (string) $start;
                                            }
                                            try {
                                                $endFormatted = $end ? \Illuminate\Support\Carbon::parse($end)->format('Y-m-d') : '—';
                                            } catch (\Exception $e) {
                                                $endFormatted = (string) $end;
                                            }
                                        @endphp
                                        <small>
                                            {{ __('Start') }}: {{ $startFormatted }}<br>
                                            {{ __('End') }}: {{ $endFormatted }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.projects.show', $project) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.edit', $project) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection