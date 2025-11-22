@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ isset($project) ? __('Edit Project') : __('Create Project') }}</span>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" 
                          action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
                        @csrf
                        @if(isset($project))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Project Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $project->name ?? '') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required>{{ old('description', $project->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                                   id="start_date" name="start_date" 
                                                   value="{{ old('start_date', isset($project) ? $project->start_date->format('Y-m-d') : '') }}" required>
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                                   id="end_date" name="end_date" 
                                                   value="{{ old('end_date', isset($project) ? $project->end_date->format('Y-m-d') : '') }}" required>
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leader_id" class="form-label">{{ __('Project Leader') }}</label>
                                    <select class="form-select @error('leader_id') is-invalid @enderror" 
                                            id="leader_id" name="leader_id" required>
                                        <option value="">{{ __('Select Leader') }}</option>
                                        @foreach($leaders as $leader)
                                            <option value="{{ $leader->id }}" 
                                                {{ (old('leader_id', $project->leader_id ?? '') == $leader->id) ? 'selected' : '' }}>
                                                {{ $leader->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leader_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="members" class="form-label">{{ __('Project Members') }}</label>
                                    <select class="form-select @error('members') is-invalid @enderror" 
                                            id="members" name="members[]" multiple required>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}"
                                                {{ (old('members', isset($project) ? $project->members->pluck('id')->toArray() : [])) && in_array($member->id, old('members', isset($project) ? $project->members->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('members')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @if(isset($project))
                                    <div class="mb-3">
                                        <label for="status" class="form-label">{{ __('Project Status') }}</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="pending" {{ $project->status === 'pending' ? 'selected' : '' }}>
                                                {{ __('Pending') }}
                                            </option>
                                            <option value="in_progress" {{ $project->status === 'in_progress' ? 'selected' : '' }}>
                                                {{ __('In Progress') }}
                                            </option>
                                            <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>
                                                {{ __('Completed') }}
                                            </option>
                                            <option value="on_hold" {{ $project->status === 'on_hold' ? 'selected' : '' }}>
                                                {{ __('On Hold') }}
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary me-2">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($project) ? __('Update Project') : __('Create Project') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection