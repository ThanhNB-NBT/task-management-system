<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Dự Án - Leader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dự Án của Leader</h2>
    </x-slot>

    <div class="container py-4">
        <h1 class="h4 mb-4">Dự Án</h1>
        <div class="row">
            @forelse(($projects ?? collect()) as $project)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">Progress: {{ $project->progress ?? 0 }}%</p>
                            <a href="{{ \\Illuminate\\Support\\Facades\\Route::has('leader.projects.manage') ? route('leader.projects.manage', $project->id) : url('/leader/projects/'.$project->id) }}" class="btn btn-sm btn-outline-primary">Quản lý</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><p class="text-muted">Bạn chưa có dự án nào.</p></div>
            @endforelse
        </div>
    </div>
</x-app-layout>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Quản Lý Dự Án</h2>

                </div>
                <div class="user-info">
                    <span class="me-3">Xin chào, <strong>Trần Thị B</strong></span>
                    <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
                </div>
            </div>

            <!-- Content -->
            <div class="container-fluid p-4">
                <!-- Toolbar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Tìm kiếm dự án...">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option value="">Tất Cả Trạng Thái</option>
                                    <option value="active">Đang Hoạt Động</option>
                                    <option value="completed">Hoàn Thành</option>
                                    <option value="paused">Tạm Dừng</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#createProjectModal">
                                    <i class="fas fa-plus"></i> Tạo Dự Án
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh Sách Dự Án</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên Dự Án</th>
                                        <th>Mô Tả</th>
                                        <th>Thành Viên</th>
                                        <th>Công Việc</th>
                                        <th>Tiến Độ</th>
                                        <th>Trạng Thái</th>
                                        <th>Hạn Chót</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Website Quản Lý Công Việc</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">Xây dựng website quản lý công việc nội
                                                bộ...</small>
                                        </td>
                                        <td>
                                            <small>4</small>
                                        </td>
                                        <td>
                                            <small>12</small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 60%">60%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Đang Hoạt Động</span>
                                        </td>
                                        <td>
                                            <small>2024-03-31</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="project-detail.html" class="btn btn-outline-primary"
                                                    title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa"
                                                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Mobile App - Task Manager</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">Phát triển ứng dụng mobile cho quản lý công
                                                việc...</small>
                                        </td>
                                        <td>
                                            <small>5</small>
                                        </td>
                                        <td>
                                            <small>18</small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 35%">35%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Đang Hoạt Động</span>
                                        </td>
                                        <td>
                                            <small>2024-04-30</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="project-detail.html" class="btn btn-outline-primary"
                                                    title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa"
                                                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Hệ Thống CRM</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">Phát triển hệ thống quản lý khách hàng...</small>
                                        </td>
                                        <td>
                                            <small>3</small>
                                        </td>
                                        <td>
                                            <small>20</small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 25%">25%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Tạm Dừng</span>
                                        </td>
                                        <td>
                                            <small>2024-05-31</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="project-detail.html" class="btn btn-outline-primary"
                                                    title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa"
                                                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Dự Án Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên Dự Án</label>
                            <input type="text" class="form-control" placeholder="Nhập tên dự án">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" rows="3" placeholder="Nhập mô tả dự án"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">Tạo Dự Án</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh Sửa Dự Án</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên Dự Án</label>
                            <input type="text" class="form-control" value="Website Quản Lý Công Việc">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control"
                                rows="3">Xây dựng website quản lý công việc nội bộ...</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control" value="2024-01-01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" value="2024-03-31">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select class="form-select">
                                <option value="active" selected>Đang Hoạt Động</option>
                                <option value="paused">Tạm Dừng</option>
                                <option value="completed">Hoàn Thành</option>
                            </select>
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