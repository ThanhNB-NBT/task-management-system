@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>{{ __('Cập Nhật Dự Án') }}</h5>
                    <small class="fw-bold">#{{ $project->id }}</small>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('leader.projects.update', $project->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">{{ __('Tên Dự Án') }} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Mô Tả') }}</label>
                            <textarea id="description" class="form-control" name="description" rows="5">{{ old('description', $project->description) }}</textarea>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">{{ __('Ngày Bắt Đầu') }} <span class="text-danger">*</span></label>
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $project->start_date) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">{{ __('Ngày Kết Thúc') }}</label>
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $project->end_date) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                             <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn chắc chắn xóa dự án này?')) document.getElementById('delete-form-{{$project->id}}').submit();">
                                <i class="fas fa-trash"></i> Xóa Dự Án
                            </button>

                            <div class="d-flex gap-2">
                                <a href="{{ route('leader.projects.index') }}" class="btn btn-light px-4">{{ __('Hủy') }}</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-check me-1"></i> {{ __('Cập Nhật') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-form-{{$project->id}}" action="{{ route('leader.projects.destroy', $project->id) }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
