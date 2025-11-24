<!DOCTYPE html>
<html lang="vi">

<head>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Công Việc</h2>
        </x-slot>

        <div class="container py-4">
            <h1 class="h4 mb-4">Danh sách công việc</h1>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiêu Đề</th>
                                <th>Trạng Thái</th>
                                <th>Người Được Giao</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($tasks ?? collect()) as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->title }}</td>
                                    <td><span class="badge bg-{{ $task->status=='done' ? 'success' : ($task->status=='in_progress' ? 'warning' : 'secondary') }}">{{ ucfirst($task->status) }}</span></td>
                                    <td>{{ optional($task->assignee)->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('leader.tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                        <a href="{{ route('leader.tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-muted">Không có công việc.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-app-layout>
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Quản Lý Công Việc</h2>

                </div>
                <div class="user-info">
                    <span class="me-3">Xin chào, <strong>Trần Thị B</strong></span>
                    <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
                </div>
            </div>

            <!-- Content -->
            <div class="container-fluid p-4">
                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Dự Án</label>
                                <select class="form-select">
                                    <option value="">Tất Cả</option>
                                    <option value="1">Website Quản Lý Công Việc</option>
                                    <option value="2">Mobile App</option>
                                    <option value="3">Hệ Thống CRM</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Trạng Thái</label>
                                <select class="form-select">
                                    <option value="">Tất Cả</option>
                                    <option value="pending">Chưa Bắt Đầu</option>
                                    <option value="in_progress">Đang Thực Hiện</option>
                                    <option value="done">Hoàn Thành</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Ưu Tiên</label>
                                <select class="form-select">
                                    <option value="">Tất Cả</option>
                                    <option value="low">Thấp</option>
                                    <option value="medium">Trung Bình</option>
                                    <option value="high">Cao</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Người Thực Hiện</label>
                                <select class="form-select">
                                    <option value="">Tất Cả</option>
                                    <option value="1">Nguyễn Văn A</option>
                                    <option value="2">Lê Văn C</option>
                                    <option value="3">Phạm Thị D</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tìm Kiếm</label>
                                <input type="text" class="form-control" placeholder="Tìm kiếm công việc...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Table -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Danh Sách Công Việc</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createTaskModal">
                                <i class="fas fa-plus"></i> Tạo Công Việc
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Công Việc</th>
                                        <th>Dự Án</th>
                                        <th>Người Thực Hiện</th>
                                        <th>Trạng Thái</th>
                                        <th>Ưu Tiên</th>
                                        <th>Tiến Độ</th>
                                        <th>Hạn Chót</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="task-detail.html" class="text-decoration-none">Thiết kế giao diện
                                                trang chủ</a>
                                        </td>
                                        <td>Website Quản Lý Công Việc</td>
                                        <td>Nguyễn Văn A</td>
                                        <td><span class="badge bg-warning">Đang thực hiện</span></td>
                                        <td><span class="badge bg-danger">Cao</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 60%">60%</div>
                                            </div>
                                        </td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="task-detail.html" class="btn btn-outline-primary" title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa">
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
                                            <a href="task-detail.html" class="text-decoration-none">Viết API endpoint
                                                cho task</a>
                                        </td>
                                        <td>Website Quản Lý Công Việc</td>
                                        <td>Lê Văn C</td>
                                        <td><span class="badge bg-info">Chưa bắt đầu</span></td>
                                        <td><span class="badge bg-warning">Trung bình</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 0%">0%</div>
                                            </div>
                                        </td>
                                        <td>2024-01-20</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="task-detail.html" class="btn btn-outline-primary" title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa">
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
                                            <a href="task-detail.html" class="text-decoration-none">Kiểm thử chức năng
                                                đăng nhập</a>
                                        </td>
                                        <td>Website Quản Lý Công Việc</td>
                                        <td>Phạm Thị D</td>
                                        <td><span class="badge bg-success">Hoàn thành</span></td>
                                        <td><span class="badge bg-info">Thấp</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" style="width: 100%">100%</div>
                                            </div>
                                        </td>
                                        <td>2024-01-10</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="task-detail.html" class="btn btn-outline-primary" title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa">
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
                                            <a href="task-detail.html" class="text-decoration-none">Tích hợp
                                                database</a>
                                        </td>
                                        <td>Website Quản Lý Công Việc</td>
                                        <td>Nguyễn Văn A</td>
                                        <td><span class="badge bg-warning">Đang thực hiện</span></td>
                                        <td><span class="badge bg-danger">Cao</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" style="width: 40%">40%</div>
                                            </div>
                                        </td>
                                        <td>2024-01-25</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="task-detail.html" class="btn btn-outline-primary" title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" title="Sửa">
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

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Công Việc Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên Công Việc</label>
                            <input type="text" class="form-control" placeholder="Nhập tên công việc">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" rows="3" placeholder="Nhập mô tả công việc"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dự Án</label>
                                <select class="form-select">
                                    <option value="">Chọn dự án</option>
                                    <option value="1">Website Quản Lý Công Việc</option>
                                    <option value="2">Mobile App</option>
                                    <option value="3">Hệ Thống CRM</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Người Thực Hiện</label>
                                <select class="form-select">
                                    <option value="">Chọn người</option>
                                    <option value="1">Nguyễn Văn A</option>
                                    <option value="2">Lê Văn C</option>
                                    <option value="3">Phạm Thị D</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ưu Tiên</label>
                                <select class="form-select">
                                    <option value="low">Thấp</option>
                                    <option value="medium" selected>Trung Bình</option>
                                    <option value="high">Cao</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hạn Chót</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">Tạo Công Việc</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
