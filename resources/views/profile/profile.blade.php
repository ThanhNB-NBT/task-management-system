<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Người Dùng</title>
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
                    <a class="nav-link" href="member-dashboard.html">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member-projects.html">
                        <i class="fas fa-project-diagram"></i> Dự Án
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member-tasks.html">
                        <i class="fas fa-list-check"></i> Công Việc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member-notifications.html">
                        <i class="fas fa-bell"></i> Thông Báo
                        <span class="badge bg-danger ms-2">3</span>
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="profile.html">
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
                    <h2>Hồ Sơ Người Dùng</h2>

                </div>
                <div class="user-info">
                    <span class="me-3">Xin chào, <strong>Nguyễn Văn A</strong></span>
                    <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
                </div>
            </div>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="row">
                    <!-- Profile Card -->
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="https://via.placeholder.com/120" alt="Avatar" class="rounded-circle mb-3"
                                    style="width: 120px; height: 120px;">
                                <h5 class="card-title">Nguyễn Văn A</h5>
                                <p class="text-muted mb-3">Member</p>
                                <div class="mb-3">
                                    <small class="text-muted">Email:</small>
                                    <p class="mb-0">nguyenvana@example.com</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Phòng Ban:</small>
                                    <p class="mb-0">Phòng Phát Triển Phần Mềm</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Ngày Tham Gia:</small>
                                    <p class="mb-0">2023-06-15</p>
                                </div>
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-edit"></i> Chỉnh Sửa Hồ Sơ
                                </button>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Thống Kê</h5>
                            </div>
                            <div class="card-body">
                                <div class="stat-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Dự Án Tham Gia</span>
                                        <strong>3</strong>
                                    </div>
                                </div>
                                <div class="stat-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Công Việc Giao</span>
                                        <strong>12</strong>
                                    </div>
                                </div>
                                <div class="stat-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Công Việc Hoàn Thành</span>
                                        <strong>6</strong>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Tỷ Lệ Hoàn Thành</span>
                                        <strong>50%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Form -->
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Thông Tin Cá Nhân</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Họ Tên</label>
                                            <input type="text" class="form-control" value="Nguyễn Văn A">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="nguyenvana@example.com">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input type="tel" class="form-control" value="0123456789">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phòng Ban</label>
                                            <input type="text" class="form-control" value="Phòng Phát Triển Phần Mềm">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Địa Chỉ</label>
                                        <input type="text" class="form-control" value="123 Đường ABC, Quận 1, TP.HCM">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tiểu Sử</label>
                                        <textarea class="form-control" rows="4"
                                            placeholder="Nhập tiểu sử của bạn...">Lập trình viên Full Stack với 3 năm kinh nghiệm. Chuyên về PHP, Laravel, JavaScript, React.</textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Lưu Thay Đổi
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary">
                                            <i class="fas fa-undo"></i> Hủy
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Đổi Mật Khẩu</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label">Mật Khẩu Hiện Tại</label>
                                        <input type="password" class="form-control"
                                            placeholder="Nhập mật khẩu hiện tại">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mật Khẩu Mới</label>
                                        <input type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Xác Nhận Mật Khẩu Mới</label>
                                        <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới">
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key"></i> Đổi Mật Khẩu
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Preferences -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Cài Đặt Thông Báo</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="notifyTask" checked>
                                    <label class="form-check-label" for="notifyTask">
                                        Nhận thông báo khi có công việc mới
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="notifyComment" checked>
                                    <label class="form-check-label" for="notifyComment">
                                        Nhận thông báo khi có bình luận mới
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="notifyDeadline" checked>
                                    <label class="form-check-label" for="notifyDeadline">
                                        Nhận thông báo khi công việc sắp hết hạn
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="notifyEmail">
                                    <label class="form-check-label" for="notifyEmail">
                                        Gửi thông báo qua email
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu Cài Đặt
                                </button>
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