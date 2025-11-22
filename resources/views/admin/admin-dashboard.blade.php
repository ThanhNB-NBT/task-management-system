@extends('layouts.app')

@section('content')

    <div class="container-fluid p-4">
        @if(isset($stats))
            <!-- Debug info -->
        
        @else
            <!-- Debug warning -->
            <div class="alert alert-warning">
                Stats variable is not set!
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h6>Tổng User</h6>
                        <h3>{{ $stats['total_users'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="stat-content">
                        <h6>Tổng Dự Án</h6>
                        <h3>{{ $stats['total_projects'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-content">
                        <h6>Tổng Công Việc</h6>
                        <h3>{{ $stats['total_tasks'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h6>Hoàn Thành</h6>
                        <h3>{{ $stats['done_tasks'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['total_tasks'] ? round(($stats['done_tasks']/$stats['total_tasks']*100),0) : 0 }}%</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0">Tổng Quan Hệ Thống</h5></div>
                    <div class="card-body">
                        <div class="row text-center mb-4">
                            <div class="col-md-4"><h6 class="text-muted">Admin</h6><h3>{{ $stats['total_admins'] ?? 0 }}</h3></div>
                            <div class="col-md-4"><h6 class="text-muted">Leader</h6><h3>{{ $stats['total_leaders'] ?? 0 }}</h3></div>
                            <div class="col-md-4"><h6 class="text-muted">Member</h6><h3>{{ $stats['total_members'] ?? 0 }}</h3></div>
                        </div>

                        <hr>

                        <h6 class="mb-3">Trạng Thái Công Việc</h6>
                        @php
                            $statuses = [
                                'pending' => ['label' => 'Chưa Bắt Đầu', 'count' => $stats['pending_tasks']],
                                'in_progress' => ['label' => 'Đang Thực Hiện', 'count' => $stats['in_progress_tasks']],
                                'done' => ['label' => 'Hoàn Thành', 'count' => $stats['done_tasks']]
                            ];
                        @endphp
                        @foreach($statuses as $status => $info)
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $info['label'] }}</span>
                                    <strong>{{ $info['count'] }}</strong>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" style="width: {{ $stats['total_tasks'] ? round(($info['count']/$stats['total_tasks']*100),0) : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Hoạt Động Gần Đây</h5></div>
                    <div class="card-body">
                        @forelse(($activities ?? collect()) as $act)
                            <div class="activity-item mb-3">
                                <div class="d-flex gap-3">
                                    <div class="activity-icon"><i class="fas fa-{{ $act->icon ?? 'user-plus' }} text-success"></i></div>
                                    <div class="flex-grow-1"><p class="mb-1">{!! $act->message !!}</p><small class="text-muted">{{ $act->created_at->diffForHumans() ?? '' }}</small></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Không có hoạt động gần đây.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4"><div class="card-header"><h5 class="mb-0">Hành Động Nhanh</h5></div>
                    <div class="card-body">
                        <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : url('/admin/users') }}" class="btn btn-primary w-100 mb-2"><i class="fas fa-user-plus"></i> Thêm User</a>
                        <a href="{{ Route::has('admin.projects.index') ? route('admin.projects.index') : url('/admin/projects') }}" class="btn btn-outline-primary w-100 mb-2"><i class="fas fa-project-diagram"></i> Xem Dự Án</a>
                        <a href="{{ Route::has('admin.reports') ? route('admin.reports') : url('/admin/reports') }}" class="btn btn-outline-primary w-100"><i class="fas fa-chart-bar"></i> Xem Báo Cáo</a>
                    </div>
                </div>

                <div class="card mb-4"><div class="card-header"><h5 class="mb-0">Trạng Thái Hệ Thống</h5></div>
                    <div class="card-body">
                        @foreach(($systemStatus ?? ['Database'=>'online','Server'=>'online','API'=>'online','Email Service'=>'warning']) as $k=>$v)
                            <div class="status-item mb-3">
                                <div class="d-flex justify-content-between align-items-center"><span>{{ $k }}</span><span class="badge bg-{{ $v=='online'?'success':'warning' }}">{{ ucfirst($v) }}</span></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card"><div class="card-header"><h5 class="mb-0">Dự Án Hàng Đầu</h5></div>
                    <div class="card-body">
                        @forelse(($topProjects ?? collect()) as $p)
                            <div class="project-item mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1"><small><strong>{{ $p->name }}</strong></small><small class="text-muted">{{ $p->progress ?? 0 }}%</small></div>
                                <div class="progress" style="height: 5px;"><div class="progress-bar" style="width: {{ $p->progress ?? 0 }}%"></div></div>
                            </div>
                        @empty
                            <p class="text-muted">Không có dự án nổi bật.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
