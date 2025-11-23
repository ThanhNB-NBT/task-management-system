@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Thêm Người Dùng Mới') }}</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Quay Lại') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Họ Tên') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">{{ __('Vai Trò') }}</label>
                            <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">{{ __('Chọn vai trò') }}</option>
                                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                                <option value="leader" {{ old('role') === 'leader' ? 'selected' : '' }}>Leader</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Mật Khẩu') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            <div class="form-text">{{ __('Tối thiểu 8 ký tự') }}</div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Xác Nhận Mật Khẩu') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Thông Tin Thêm') }}</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" 
                                           value="{{ old('phone') }}" placeholder="{{ __('Số điện thoại') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="department" 
                                           value="{{ old('department') }}" placeholder="{{ __('Phòng ban') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Địa Chỉ') }}</label>
                            <textarea id="address" class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">{{ __('Giới Thiệu') }}</label>
                            <textarea id="bio" class="form-control" name="bio" rows="3">{{ old('bio') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">{{ __('Cài Đặt Thông Báo') }}</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notify_task" 
                                       name="notify_task" value="1" {{ old('notify_task', '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_task">
                                    {{ __('Nhận thông báo khi được gán công việc mới') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notify_comment" 
                                       name="notify_comment" value="1" {{ old('notify_comment', '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_comment">
                                    {{ __('Nhận thông báo khi có bình luận mới') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notify_deadline" 
                                       name="notify_deadline" value="1" {{ old('notify_deadline', '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_deadline">
                                    {{ __('Nhận thông báo về deadline') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notify_email" 
                                       name="notify_email" value="1" {{ old('notify_email', '0') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_email">
                                    {{ __('Nhận thông báo qua email') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> {{ __('Tạo Người Dùng') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection