@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-primary"><i class="fas fa-project-diagram"></i> {{ __('Dự Án Của Tôi') }}</h1>
                <p class="text-muted small mb-0">Quản lý các dự án bạn đang phụ trách</p>
            </div>
            <a href="{{ route('leader.projects.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> {{ __('Tạo Dự Án Mới') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @forelse($projects as $project)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between">
                            <h5 class="fw-bold mt-3">
                                <a href="{{ route('leader.projects.show', $project->id) }}"
                                    class="text-decoration-none text-dark stretched-link">
                                    {{ $project->name }}
                                </a>
                            </h5>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('leader.projects.edit', $project->id) }}">
                                            <i class="fas fa-edit text-warning me-2"></i> Chỉnh sửa
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('leader.projects.destroy', $project->id) }}" method="POST"
                                            onsubmit="return confirm('CẢNH BÁO: Xóa dự án sẽ xóa toàn bộ Tasks và thành viên liên quan. Bạn chắc chắn chứ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt me-2"></i> Xóa dự án
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">

                            <p class="text-muted small text-truncate mb-3" style="max-height: 40px;">
                                {{ $project->description ?? 'Chưa có mô tả' }}
                            </p>

                            <div class="d-flex justify-content-between small text-muted mb-3 bg-light p-2 rounded">
                                <div class="text-center px-2">
                                    <i class="fas fa-tasks text-primary"></i> <br>
                                    <strong>{{ $project->tasks_count }}</strong> Task
                                </div>
                                <div class="text-center px-2 border-start border-end">
                                    <i class="fas fa-users text-success"></i> <br>
                                    <strong>{{ $project->members_count }}</strong> Dev
                                </div>
                                <div class="text-center px-2">
                                    <i class="fas fa-clock text-info"></i> <br>
                                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m') : '--' }}
                                </div>
                            </div>

                            @php
                                $total = $project->tasks_count;
                                $done = $project->tasks()->where('status', 'done')->count();
                                $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                            @endphp
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Tiến độ</span>
                                <span
                                    class="fw-bold {{ $progress == 100 ? 'text-success' : 'text-primary' }}">{{ $progress }}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}"
                                    role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Empty" width="100"
                        class="mb-3 opacity-50">
                    <h5>Bạn chưa quản lý dự án nào.</h5>
                    <p class="text-muted">Hãy bắt đầu bằng cách tạo dự án đầu tiên.</p>
                    <a href="{{ route('leader.projects.create') }}" class="btn btn-primary mt-2">
                        Tạo Dự Án Ngay
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    <style>
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            transform: translateY(-2px);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        /* Fix stretched-link conflict with dropdown */
        .card {
            position: relative;
        }

        .dropdown {
            position: relative;
            z-index: 2;
        }
    </style>
@endsection
