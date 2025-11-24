@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>{{ __('Cập Nhật Công Việc') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('leader.tasks.update', $task->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">{{ __('Thuộc Dự Án') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $task->project->name }}" readonly disabled>
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">{{ __('Tên Công Việc') }} <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $task->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Mô Tả Chi Tiết') }}</label>
                            <textarea id="description" class="form-control" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold">{{ __('Trạng Thái') }}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Đang thực hiện</option>
                                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Hoàn thành</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="priority" class="form-label fw-bold">{{ __('Độ Ưu Tiên') }}</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Thấp</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Cao</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-bold">{{ __('Hạn Chót') }}</label>
                                <input id="due_date" type="date" class="form-control" name="due_date" value="{{ old('due_date', $task->due_date) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="assignee_id" class="form-label fw-bold">{{ __('Người Thực Hiện') }}</label>
                            <select id="assignee_id" name="assignee_id" class="form-select">
                                <option value="">-- Chưa giao --</option>
                                @foreach($task->project->members as $member)
                                    <option value="{{ $member->id }}" {{ $task->assignee_id == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} ({{ $member->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Xóa task này?')) document.getElementById('delete-task-form').submit();">
                                <i class="fas fa-trash"></i> Xóa Task
                            </button>

                            <div class="d-flex gap-2">
                                <a href="{{ url()->previous() }}" class="btn btn-light px-4">{{ __('Hủy') }}</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-save me-1"></i> {{ __('Cập Nhật') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-task-form" action="{{ route('leader.tasks.destroy', $task->id) }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
