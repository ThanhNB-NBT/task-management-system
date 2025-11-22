@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Chỉnh Sửa Dự Án') }}</h5>
                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Quay Lại') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Tên Dự Án') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Mô Tả') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">{{ __('Ngày Bắt Đầu') }}</label>
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d') ?? $project->start_date) }}" required>
                                @error('start_date')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">{{ __('Ngày Kết Thúc') }}</label>
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', optional($project->end_date)->format('Y-m-d') ?? $project->end_date) }}">
                                @error('end_date')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="leader_id" class="form-label">{{ __('Quản Lý (Leader)') }}</label>
                            <select id="leader_id" name="leader_id" class="form-select @error('leader_id') is-invalid @enderror" required>
                                <option value="">{{ __('Chọn leader') }}</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ old('leader_id', $project->leader_id) == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                            @error('leader_id')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="members" class="form-label">{{ __('Thành Viên') }}</label>
                            <select id="members" name="members[]" class="form-select" multiple>
                                @php $selected = old('members', $project->members->pluck('id')->toArray()); @endphp
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ in_array($u->id, $selected) ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                            <div class="form-text">{{ __('Chọn các thành viên để thêm vào dự án (tùy chọn)') }}</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Cập Nhật') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection