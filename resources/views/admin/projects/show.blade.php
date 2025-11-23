@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $project->name }}</h5>
                    <div>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm me-2"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h6 class="text-muted">{{ __('Description') }}</h6>
                            <p>{{ $project->description ?? '—' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">{{ __('Project Info') }}</h6>
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

                            <p class="mb-1"><strong>{{ __('Leader') }}:</strong> {{ $project->leader->name ?? '—' }}</p>
                            <p class="mb-1"><strong>{{ __('Start') }}:</strong> {{ $startFormatted }}</p>
                            <p class="mb-1"><strong>{{ __('End') }}:</strong> {{ $endFormatted }}</p>
                            <p class="mb-1"><strong>{{ __('Members') }}:</strong> {{ $project->members->count() }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">{{ __('Members') }}</h6>
                    @if($project->members->isEmpty())
                        <p class="text-muted">{{ __('No members assigned to this project.') }}</p>
                    @else
                        <div class="list-group mb-4">
                            @foreach($project->members as $member)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $member->name }}</strong>
                                        <div class="text-muted small">{{ $member->email }}</div>
                                    </div>
                                    <div>
                                        <span class="badge bg-secondary">{{ $member->pivot->role ?? '' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <h6 class="mb-3">{{ __('Tasks') }}</h6>
                    @if($project->tasks->isEmpty())
                        <p class="text-muted">{{ __('No tasks for this project yet.') }}</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Assignee') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @php
                                                    $map = ['pending'=>'warning','in_progress'=>'info','done'=>'success'];
                                                    $cls = isset($task->status) && array_key_exists($task->status,$map) ? $map[$task->status] : 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $cls }}">{{ ucfirst(str_replace('_',' ',$task->status ?? 'unknown')) }}</span>
                                            </td>
                                            <td>{{ $task->assignee->name ?? '—' }}</td>
                                            <td>
                                                @if($task->due_date)
                                                    @php
                                                        try {
                                                            $due = \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d');
                                                        } catch (\Exception $e) {
                                                            $due = (string) $task->due_date;
                                                        }
                                                    @endphp
                                                    {{ $due }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
