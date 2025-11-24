@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card mb-4 shadow-sm border-0 bg-light">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h1 class="h3 mb-1"><i class="fas fa-users-cog"></i> {{ __('Quản Lý Đội Nhóm') }}</h1>
                <p class="text-muted small mb-0">{{ __('Chọn dự án để xem và quản lý thành viên') }}</p>
            </div>

            <form action="{{ route('leader.team.index') }}" method="GET" class="d-flex align-items-center mt-2 mt-md-0">
                <label class="me-2 fw-bold text-secondary">{{ __('Project:') }}</label>
                <select name="project_id" class="form-select border-primary" style="min-width: 250px;" onchange="this.form.submit()">
                    @forelse($projects as $proj)
                        <option value="{{ $proj->id }}" {{ (isset($selectedProject) && $selectedProject->id == $proj->id) ? 'selected' : '' }}>
                            {{ $proj->name }}
                        </option>
                    @empty
                        <option value="">{{ __('Bạn chưa có dự án nào') }}</option>
                    @endforelse
                </select>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($selectedProject)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-secondary mb-0">
                Thành viên của: <span class="text-primary fw-bold">{{ $selectedProject->name }}</span>
                <span class="badge bg-secondary ms-2">{{ $members->count() }}</span>
            </h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                <i class="fas fa-user-plus"></i> {{ __('Thêm Thành Viên') }}
            </button>
        </div>

        <div class="row">
            @forelse($members as $member)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow transition-all">
                        <div class="card-body text-center position-relative">

                            @if($member->id !== Auth::id())
                                <form action="{{ route('leader.team.destroy', $member->pivot->id) }}" method="POST" class="position-absolute top-0 end-0 m-2" onsubmit="return confirm('Bạn có chắc muốn xóa {{ $member->name }} khỏi dự án này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0" title="Xóa khỏi dự án">
                                        <i class="fas fa-times-circle fa-lg"></i>
                                    </button>
                                </form>
                            @endif

                            <div class="mb-3 mt-2">
                                <div class="avatar-circle mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.5rem; font-weight: bold;">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                            </div>

                            <h6 class="card-title fw-bold mb-1">{{ $member->name }}</h6>
                            <p class="text-muted small mb-2">{{ $member->email }}</p>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <span class="badge {{ $member->pivot->role_in_project == 'member' ? 'bg-info' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($member->pivot->role_in_project) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-users-slash fa-3x"></i>
                    </div>
                    <h5>Chưa có thành viên nào trong dự án này</h5>
                    <p class="text-muted">Hãy bấm nút "Thêm Thành Viên" để bắt đầu gán nhân sự.</p>
                </div>
            @endforelse
        </div>
    @else
        <div class="alert alert-info text-center">
            Vui lòng chọn hoặc tạo một dự án để quản lý thành viên.
        </div>
    @endif
</div>

@if($selectedProject)
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Thêm Thành Viên Mới') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('leader.team.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">{{ __('Dự án đang chọn') }}</label>
                        <input type="text" class="form-control bg-light" value="{{ $selectedProject->name }}" readonly disabled>
                        <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Email thành viên') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="nhanvien@example.com">
                        <div class="form-text">Email phải thuộc về một tài khoản User đã đăng ký.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Vào Dự Án
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
