<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo - Leader</title>
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
                    <a class="nav-link" href="leader-team.html">
                        <i class="fas fa-users"></i> Đội Nhóm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="leader-reports.html">
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

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Báo Cáo</h2>

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
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Dự Án</label>
                                <select class="form-select">
                                    <option value="">Tất Cả</option>
                                    <option value="1">Website Quản Lý Công Việc</option>
                                    <option value="2">Mobile App</option>
                                    <option value="3">Hệ Thống CRM</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Từ Ngày</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Đến Ngày</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Tìm Kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="stat-content">
                                <h6>Tổng Công Việc</h6>
                                <h3>28</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h6>Hoàn Thành</h6>
                                <h3>14</h3>
                                <small class="text-muted">50%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-hourglass-start"></i>
                            </div>
                            <div class="stat-content">
                                <h6>Đang Thực Hiện</h6>
                                <h3>10</h3>
                                <small class="text-muted">36%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h6>Quá Hạn</h6>
                                <h3>2</h3>
                                <small class="text-muted">7%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mb-4">
                    <!-- Task Status Chart -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Trạng Thái Công Việc</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container"
                                    style="height: 300px; display: flex; align-items: flex-end; gap: 10px;">
                                    <div
                                        style="flex: 1; background: #0d6efd; height: 50%; border-radius: 5px; position: relative;">
                                        <span
                                            style="position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 12px;">Chưa
                                            Bắt Đầu<br>4</span>
                                    </div>
                                    <div
                                        style="flex: 1; background: #ffc107; height: 36%; border-radius: 5px; position: relative;">
                                        <span
                                            style="position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 12px;">Đang
                                            Thực Hiện<br>10</span>
                                    </div>
                                    <div
                                        style="flex: 1; background: #198754; height: 50%; border-radius: 5px; position: relative;">
                                        <span
                                            style="position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 12px;">Hoàn
                                            Thành<br>14</span>
                                    </div>
                                </div>
                                <div style="margin-top: 60px;">
                                    <div class="stat-item mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>Chưa Bắt Đầu</span>
                                            <strong>4 (14%)</strong>
                                        </div>
                                    </div>
                                    <div class="stat-item mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>Đang Thực Hiện</span>
                                            <strong>10 (36%)</strong>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="d-flex justify-content-between">
                                            <span>Hoàn Thành</span>
                                            <strong>14 (50%)</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Priority Distribution -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Phân Bố Ưu Tiên</h5>
                            </div>
                            <div class="card-body">
                                <div class="stat-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Cao</span>
                                        <strong>8</strong>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-danger" style="width: 29%">29%</div>
                                    </div>
                                </div>
                                <div class="stat-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Trung Bình</span>
                                        <strong>12</strong>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-warning" style="width: 43%">43%</div>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Thấp</span>
                                        <strong>8</strong>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-info" style="width: 29%">29%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Performance -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Hiệu Suất Đội Nhóm</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Thành Viên</th>
                                                <th>Công Việc Giao</th>
                                                <th>Hoàn Thành</th>
                                                <th>Đang Thực Hiện</th>
                                                <th>Quá Hạn</th>
                                                <th>Tỷ Lệ Hoàn Thành</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Nguyễn Văn A</strong></td>
                                                <td>8</td>
                                                <td><span class="badge bg-success">6</span></td>
                                                <td><span class="badge bg-warning">2</span></td>
                                                <td><span class="badge bg-danger">0</span></td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" style="width: 75%">75%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Lê Văn C</strong></td>
                                                <td>6</td>
                                                <td><span class="badge bg-success">4</span></td>
                                                <td><span class="badge bg-warning">1</span></td>
                                                <td><span class="badge bg-danger">1</span></td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-warning" style="width: 67%">67%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phạm Thị D</strong></td>
                                                <td>5</td>
                                                <td><span class="badge bg-success">3</span></td>
                                                <td><span class="badge bg-warning">2</span></td>
                                                <td><span class="badge bg-danger">0</span></td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-warning" style="width: 60%">60%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Trần Văn E</strong></td>
                                                <td>3</td>
                                                <td><span class="badge bg-success">1</span></td>
                                                <td><span class="badge bg-warning">1</span></td>
                                                <td><span class="badge bg-danger">1</span></td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-danger" style="width: 33%">33%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tổng Cộng</strong></td>
                                                <td><strong>22</strong></td>
                                                <td><span class="badge bg-success">14</span></td>
                                                <td><span class="badge bg-warning">6</span></td>
                                                <td><span class="badge bg-danger">2</span></td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" style="width: 64%">64%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Báo Cáo Dự Án</h2>
    </x-slot>

    <div class="container py-4">
        <h1 class="mb-4">Báo Cáo Dự Án</h1>
        <p>{!! $reportHtml ?? 'Thống kê chưa có.' !!}</p>
    </div>
</x-app-layout>