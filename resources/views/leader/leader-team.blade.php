<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đội Nhóm - Leader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-tasks"></i> Task Manager</h3>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="leader-dashboard.html">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leader-projects.html">
                        <i class="fas fa-project-diagram"></i> Dự Án
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leader-tasks.html">
                        <i class="fas fa-list-check"></i> Công Việc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="leader-team.html">
                        <i class="fas fa-users"></i> Đội Nhóm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leader-reports.html">
                        <i class="fas fa-chart-bar"></i> Báo Cáo
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="profile.html">
                        <i class="fas fa-user"></i> Hồ Sơ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </a>
                </li>
            </ul>
        </nav>

        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Đội Nhóm</h2>
            </x-slot>

            <div class="container py-4">
                <h1 class="h4 mb-4">Đội Nhóm</h1>
                <div class="row">
                    @forelse(($teamMembers ?? collect()) as $member)
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/80' }}" class="rounded-circle mb-2" alt="">
                                    <h5>{{ $member->name }}</h5>
                                    <p class="text-muted">{{ ucfirst($member->role ?? 'member') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12"><p class="text-muted">Chưa có thành viên trong đội.</p></div>
                    @endforelse
                </div>
            </div>
        </x-app-layout>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" title="Sửa" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted">Công Việc</small>
                                        <p class="mb-0"><strong>8</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Hoàn Thành</small>
                                        <p class="mb-0"><strong>6</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Tỷ Lệ</small>
                                        <p class="mb-0"><strong>75%</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex gap-3">
                                        <img src="https://via.placeholder.com/60" alt="Avatar" class="rounded-circle"
                                            style="width: 60px; height: 60px;">
                                        <div>
                                            <h6 class="mb-1">Lê Văn C</h6>
                                            <p class="text-muted small mb-2">levanc@example.com</p>
                                            <small class="badge bg-secondary">Member</small>
                                        </div>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" title="Sửa" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted">Công Việc</small>
                                        <p class="mb-0"><strong>6</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Hoàn Thành</small>
                                        <p class="mb-0"><strong>4</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Tỷ Lệ</small>
                                        <p class="mb-0"><strong>67%</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex gap-3">
                                        <img src="https://via.placeholder.com/60" alt="Avatar" class="rounded-circle"
                                            style="width: 60px; height: 60px;">
                                        <div>
                                            <h6 class="mb-1">Phạm Thị D</h6>
                                            <p class="text-muted small mb-2">phamthid@example.com</p>
                                            <small class="badge bg-secondary">Member</small>
                                        </div>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" title="Sửa" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted">Công Việc</small>
                                        <p class="mb-0"><strong>5</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Hoàn Thành</small>
                                        <p class="mb-0"><strong>3</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Tỷ Lệ</small>
                                        <p class="mb-0"><strong>60%</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex gap-3">
                                        <img src="https://via.placeholder.com/60" alt="Avatar" class="rounded-circle"
                                            style="width: 60px; height: 60px;">
                                        <div>
                                            <h6 class="mb-1">Trần Văn E</h6>
                                            <p class="text-muted small mb-2">tranvane@example.com</p>
                                            <small class="badge bg-secondary">Member</small>
                                        </div>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" title="Sửa" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted">Công Việc</small>
                                        <p class="mb-0"><strong>3</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Hoàn Thành</small>
                                        <p class="mb-0"><strong>1</strong></p>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">Tỷ Lệ</small>
                                        <p class="mb-0"><strong>33%</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Thành Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Chọn Thành Viên</label>
                            <select class="form-select">
                                <option value="">-- Chọn --</option>
                                <option value="1">Nguyễn Văn F</option>
                                <option value="2">Lê Thị G</option>
                                <option value="3">Phạm Văn H</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vai Trò</label>
                            <select class="form-select">
                                <option value="member" selected>Member</option>
                                <option value="leader">Leader</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div class="modal fade" id="editMemberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh Sửa Thành Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên Thành Viên</label>
                            <input type="text" class="form-control" value="Nguyễn Văn A" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="nguyenvana@example.com" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vai Trò</label>
                            <select class="form-select">
                                <option value="member" selected>Member</option>
                                <option value="leader">Leader</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dự Án</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="project1" checked>
                                <label class="form-check-label" for="project1">
                                    Website Quản Lý Công Việc
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="project2" checked>
                                <label class="form-check-label" for="project2">
                                    Mobile App
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="project3">
                                <label class="form-check-label" for="project3">
                                    Hệ Thống CRM
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>