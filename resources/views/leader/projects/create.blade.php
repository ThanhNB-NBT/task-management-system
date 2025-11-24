@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>{{ __('Khởi Tạo Dự Án Mới') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('leader.projects.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">{{ __('Tên Dự Án') }} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Ví dụ: Website Bán Hàng 2024" autofocus>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Mô Tả Chi Tiết') }}</label>
                            <textarea id="description" class="form-control" name="description" rows="5" placeholder="Mục tiêu dự án, công nghệ sử dụng, yêu cầu...">{{ old('description') }}</textarea>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">{{ __('Ngày Bắt Đầu') }} <span class="text-danger">*</span></label>
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">{{ __('Ngày Kết Thúc (Dự kiến)') }}</label>
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">
                                <div class="form-text">Để trống nếu chưa xác định.</div>
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('leader.projects.index') }}" class="btn btn-light px-4">{{ __('Hủy bỏ') }}</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">
                                <i class="fas fa-save me-1"></i> {{ __('Tạo Dự Án') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
