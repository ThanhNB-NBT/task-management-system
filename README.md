<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📋 Hệ Thống Quản Lý Công Việc

> Hệ thống quản lý công việc toàn diện được xây dựng bằng Laravel, thiết kế cho cộng tác nhóm với phân quyền theo vai trò (Admin, Leader, Member).

---

## 📑 Mục Lục

- [Giới Thiệu Dự Án](#giới-thiệu-dự-án)
- [Tính Năng](#tính-năng)
- [Công Nghệ Sử Dụng](#công-nghệ-sử-dụng)
- [Bắt Đầu](#bắt-đầu)
  - [Yêu Cầu Hệ Thống](#yêu-cầu-hệ-thống)
  - [Cài Đặt](#cài-đặt)
  - [Thiết Lập Database](#thiết-lập-database)
- [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
- [Phân Công Nhóm](#phân-công-nhóm)
- [Quy Trình Git](#quy-trình-git)
- [Hướng Dẫn Phát Triển](#hướng-dẫn-phát-triển)
- [Xử Lý Sự Cố](#xử-lý-sự-cố)
- [Đóng Góp](#đóng-góp)
- [Giấy Phép](#giấy-phép)

---

## 🎯 Giới Thiệu Dự Án

Hệ Thống Quản Lý Công Việc là một ứng dụng web được thiết kế để cộng tác nhóm và theo dõi dự án hiệu quả. Hệ thống triển khai 3 vai trò chính:

- **Admin**: Quản lý người dùng, giám sát hệ thống và thống kê
- **Leader**: Tạo dự án, quản lý nhóm và phân công công việc
- **Member**: Thực hiện công việc, cập nhật tiến độ và giao tiếp nhóm

### Xây Dựng Với

- **[Laravel](https://laravel.com)** - Framework PHP cho Web
- **MySQL** - Quản Lý Cơ Sở Dữ Liệu
- **Bootstrap 5** / **Tailwind CSS** - Framework Frontend
- **jQuery** - Thư Viện JavaScript
- **Blade Template** - Engine Template của Laravel

---

## ✨ Tính Năng

### Chức Năng Admin
- 👥 Quản lý người dùng (Thêm, Xem, Sửa, Xóa)
- 📊 Dashboard hệ thống với thống kê
- 🔍 Tổng quan và giám sát dự án
- 🔐 Quản lý vai trò và phân quyền

### Chức Năng Leader
- 📁 Tạo và quản lý dự án
- 👨‍👩‍👧‍👦 Phân công thành viên vào nhóm
- ✅ Tạo và phân công công việc
- 📈 Theo dõi tiến độ dự án
- 📋 Lịch sử và nhật ký công việc

### Chức Năng Member
- 📝 Xem công việc được giao
- 🔄 Cập nhật trạng thái công việc
- 💬 Bình luận về công việc
- 🔔 Nhận thông báo
- 📊 Dashboard cá nhân

---

## 🛠️ Công Nghệ Sử Dụng

### Backend
```
- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Composer
```

### Frontend
```
- Blade Template Engine
- Bootstrap 5 / Tailwind CSS
- jQuery 3.x
- Font Awesome Icons
```

### Công Cụ Phát Triển
```
- Laragon (Windows LAMP Stack)
- Visual Studio Code
- Git & GitHub
- HeidiSQL / phpMyAdmin
```

---

## 🚀 Bắt Đầu

### Yêu Cầu Hệ Thống

Trước khi bắt đầu, đảm bảo bạn đã cài đặt:

- **Laragon** (bao gồm PHP, MySQL, Apache)
  - Tải về: [https://laragon.org/download/](https://laragon.org/download/)
- **Composer**
  - Có sẵn trong Laragon hoặc tải tại: [https://getcomposer.org/](https://getcomposer.org/)
- **Git**
  - Tải về: [https://git-scm.com/download/win](https://git-scm.com/download/win)
- **Visual Studio Code**
  - Tải về: [https://code.visualstudio.com/](https://code.visualstudio.com/)

### Extensions VS Code (Khuyên Dùng)

```
- Laravel Extension Pack
- PHP Intelephense
- GitLens
- Blade Formatter
- Prettier - Code formatter
- Auto Rename Tag
```

---

## 💻 Cài Đặt

### Bước 1: Clone Repository

```bash
# Di chuyển vào thư mục www của Laragon
cd C:\laragon\www

# Clone repository về
git clone https://github.com/ThanhNB-NBT/task-management-system.git

# Di chuyển vào thư mục dự án
cd task-management-system
```

### Bước 2: Cài Đặt Dependencies

```bash
# Cài đặt các thư viện PHP
composer install

# Sao chép file môi trường
copy .env.example .env

# Tạo application key
php artisan key:generate
```

### Bước 3: Cấu Hình Môi Trường

Chỉnh sửa file `.env`:

```env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄️ Thiết Lập Database

### Tạo Database

**Cách 1: Dùng phpMyAdmin**
1. Mở: `http://localhost/phpmyadmin`
2. Click **New** → Tên database: `task_management`
3. Collation: `utf8mb4_unicode_ci`

**Cách 2: Dùng HeidiSQL**
1. Mở HeidiSQL từ Laragon
2. Chuột phải → Create new → Database
3. Tên: `task_management`

### Chạy Migrations

```bash
# Chạy tất cả migrations
php artisan migrate

# Chạy migrations kèm seeders
php artisan migrate --seed

# Migration mới hoàn toàn (xóa tất cả bảng và chạy lại)
php artisan migrate:fresh --seed
```

### Thêm Dữ Liệu Mẫu

```bash
# Chạy seeder cụ thể
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=UserSeeder

# Chạy tất cả seeders
php artisan db:seed
```

---

## 📁 Cấu Trúc Dự Án

```
task-management-system/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/              # Các Controllers
│   │   │   ├── Admin/               # Controllers cho Admin
│   │   │   │   ├── UserController.php
│   │   │   │   ├── ProjectController.php
│   │   │   │   └── DashboardController.php
│   │   │   ├── Leader/              # Controllers cho Leader
│   │   │   │   ├── ProjectController.php
│   │   │   │   ├── TaskController.php
│   │   │   │   └── TeamController.php
│   │   │   └── Member/              # Controllers cho Member
│   │   │       ├── TaskController.php
│   │   │       └── CommentController.php
│   │   │
│   │   └── Middleware/              # Middleware tùy chỉnh
│   │       ├── AdminMiddleware.php
│   │       ├── LeaderMiddleware.php
│   │       └── MemberMiddleware.php
│   │
│   └── Models/                      # Các Models
│       ├── User.php
│       ├── Project.php
│       ├── ProjectMember.php
│       ├── Task.php
│       ├── TaskComment.php
│       ├── TaskHistory.php
│       └── Notification.php
│
├── database/
│   ├── migrations/                  # Các file migration
│   │   ├── xxxx_create_users_table.php
│   │   ├── xxxx_create_projects_table.php
│   │   ├── xxxx_create_tasks_table.php
│   │   └── ...
│   │
│   └── seeders/                     # Các file seeder
│       ├── AdminSeeder.php
│       ├── UserSeeder.php
│       └── ProjectSeeder.php
│
├── resources/
│   └── views/                       # Các Blade Templates
│       ├── layouts/
│       │   ├── app.blade.php       # Layout chính
│       │   ├── sidebar.blade.php   # Component sidebar
│       │   └── navbar.blade.php    # Component navigation
│       │
│       ├── admin/                   # Views cho Admin
│       │   ├── dashboard.blade.php
│       │   ├── users/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   └── projects/
│       │
│       ├── leader/                  # Views cho Leader
│       │   ├── dashboard.blade.php
│       │   ├── projects/
│       │   └── tasks/
│       │
│       └── member/                  # Views cho Member
│           ├── dashboard.blade.php
│           └── tasks/
│
├── routes/
│   └── web.php                      # Định nghĩa routes
│
├── public/
│   ├── css/                         # File CSS
│   ├── js/                          # File JavaScript
│   └── images/                      # Hình ảnh
│
├── .env.example                     # File môi trường mẫu
├── composer.json                    # Thư viện PHP
└── README.md                        # File này
```

---

## 🌳 Quy Trình Git

### Chiến Lược Branch

```
main (production - sản phẩm)
  │
  ├── dev (development - phát triển)
  │     │
  │     ├── feature/frontend-layout
  │     ├── feature/frontend-pages
  │     ├── feature/admin-users
  │     ├── feature/admin-dashboard
  │     ├── feature/leader-projects
  │     ├── feature/leader-tasks
  │     ├── feature/member-tasks
  │     └── feature/member-comments
```

### Quy Trình Làm Việc Hàng Ngày

#### 1. Bắt Đầu Feature Mới

```bash
# Chuyển sang branch dev và cập nhật code mới nhất
git checkout dev
git pull origin dev

# Tạo branch feature mới
git checkout -b feature/ten-feature-cua-ban
```

#### 2. Làm Việc Trên Feature

```bash
# Kiểm tra trạng thái
git status

# Thêm các thay đổi
git add .

# Commit với message rõ ràng
git commit -m "[ADD] Thêm trang danh sách user"
```

#### 3. Đẩy Lên GitHub

```bash
# Push branch lên remote
git push origin feature/ten-feature-cua-ban
```

#### 4. Tạo Pull Request

1. Vào GitHub repository
2. Click **Compare & pull request**
3. Chọn base: `dev` và compare: `feature/ten-feature-cua-ban`
4. Viết mô tả rõ ràng
5. Tag 1-2 người review
6. Tạo Pull Request

#### 5. Sau Khi Merge

```bash
# Quay lại branch dev
git checkout dev

# Cập nhật code đã merge
git pull origin dev

# Xóa branch feature (tùy chọn)
git branch -d feature/ten-feature-cua-ban
```

### Quy Tắc Commit Message

```bash
# Format: [LOẠI] Mô tả ngắn gọn

[ADD]      - Thêm tính năng mới
[FIX]      - Sửa lỗi
[UPDATE]   - Cập nhật code hiện có
[DELETE]   - Xóa code/file
[REFACTOR] - Tái cấu trúc code
[DOCS]     - Cập nhật tài liệu
[STYLE]    - Thay đổi style code
[TEST]     - Thêm hoặc cập nhật tests

# Ví dụ:
git commit -m "[ADD] Tạo hệ thống xác thực người dùng"
git commit -m "[FIX] Sửa lỗi validate form đăng nhập"
git commit -m "[UPDATE] Cải thiện hiệu suất danh sách task"
git commit -m "[DOCS] Cập nhật README với hướng dẫn setup"
```

### Xử Lý Xung Đột (Conflict)

```bash
# Cập nhật dev mới nhất
git checkout dev
git pull origin dev

# Quay lại branch feature của bạn
git checkout feature/ten-feature-cua-ban

# Merge dev vào branch feature
git merge dev

# Nếu có conflict, mở file bị conflict và sửa
# Sau đó:
git add .
git commit -m "[FIX] Giải quyết conflict với branch dev"
git push origin feature/ten-feature-cua-ban
```

---

## 📋 Hướng Dẫn Phát Triển

### Phong Cách Code

- Tuân theo [chuẩn PSR-12](https://www.php-fig.org/psr/psr-12/)
- Đặt tên biến và hàm có ý nghĩa
- Thêm comment cho logic phức tạp
- Giữ các hàm ngắn gọn và tập trung

### Quy Tắc Đặt Tên

```php
// Controllers: PascalCase + hậu tố Controller
UserController, ProjectController

// Models: PascalCase, số ít
User, Project, Task

// Bảng database: snake_case, số nhiều
users, projects, tasks, project_members

// Biến: camelCase
$userName, $projectList, $taskStatus

// Hàm: camelCase
getUserById(), createProject(), updateTaskStatus()

// Hằng số: UPPER_SNAKE_CASE
MAX_UPLOAD_SIZE, DEFAULT_ROLE
```

### Quy Ước Database

```php
// Khóa chính
id (unsigned big integer, auto increment)

// Khóa ngoại
user_id, project_id, task_id

// Timestamps
created_at, updated_at, deleted_at

// Trường boolean
is_active, is_completed, is_deleted

// Trường trạng thái
status (enum hoặc string)
```

---

## ✅ Checklist Kiểm Tra

### Trước Khi Commit

```
□ Code chạy không có lỗi
□ Test thủ công tất cả tính năng mới
□ Kiểm tra lỗi console (trình duyệt/server)
□ Xác minh các query database được tối ưu
□ Xóa code debug và console.log
□ Format code đúng chuẩn
□ Cập nhật comment nếu cần
```

### Trước Khi Tạo PR

```
□ Pull branch dev mới nhất
□ Giải quyết mọi conflict
□ Chạy php artisan test (nếu có tests)
□ Test trên database mới (migrate:fresh)
□ Kiểm tra responsive (cho frontend)
□ Xác minh không có dữ liệu nhạy cảm trong code
□ Viết mô tả PR rõ ràng
```

---

## 🐛 Xử Lý Sự Cố

### Các Vấn Đề Thường Gặp & Giải Pháp

#### 1. Không Pull Được Code

```bash
# Reset về phiên bản remote
git fetch origin
git reset --hard origin/dev
```

#### 2. Commit Nhầm Vào Branch Khác

```bash
# Hoàn tác commit nhưng giữ lại thay đổi
git reset --soft HEAD~1

# Tạo branch đúng và chuyển qua
git checkout -b feature/branch-dung
```

#### 3. Xóa Nhầm Code

```bash
# Khôi phục file đã xóa
git checkout HEAD -- filename.php
```

#### 4. Composer Install Lỗi

```bash
# Xóa cache composer
composer clear-cache

# Cài đặt bỏ qua yêu cầu platform
composer install --ignore-platform-reqs
```

#### 5. Lỗi Migration

```bash
# Rollback và chạy lại
php artisan migrate:rollback
php artisan migrate

# Hoặc cài đặt mới hoàn toàn
php artisan migrate:fresh
```

#### 6. Lỗi Phân Quyền (Windows)

```bash
# Chạy Laragon với quyền Administrator
# Hoặc set phân quyền thư mục trong Windows Explorer
```

#### 7. Port Đã Được Sử Dụng

```bash
# Kiểm tra cái gì đang dùng port 80
netstat -ano | findstr :80

# Đổi port Apache trong settings Laragon
# Hoặc dừng service đang conflict
```

---

## 🤝 Đóng Góp

Mọi đóng góp đều làm cho dự án này tốt hơn. Mọi đóng góp của bạn đều được **đánh giá cao**.

1. Tạo Feature Branch của bạn (`git checkout -b feature/TinhNangTuyetVoi`)
2. Commit thay đổi (`git commit -m '[ADD] Thêm tính năng tuyệt vời'`)
3. Push lên Branch (`git push origin feature/TinhNangTuyetVoi`)
4. Mở Pull Request
5. Đợi code review
6. Thực hiện thay đổi nếu được yêu cầu

### Hướng Dẫn Pull Request

- Viết tiêu đề và mô tả PR rõ ràng
- Tham chiếu đến issues liên quan nếu có
- Thêm ảnh chụp màn hình cho thay đổi UI
- Tag ít nhất một người review
- Đảm bảo CI/CD checks pass
- Giữ PR tập trung và nhỏ gọn

---

## 🎓 Các Lệnh Nhanh

```bash
# Khởi động server phát triển
php artisan serve

# Chạy migrations
php artisan migrate

# Chạy seeder
php artisan db:seed

# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tạo controller mới
php artisan make:controller TenController

# Tạo model mới kèm migration
php artisan make:model TenModel -m

# Tạo migration mới
php artisan make:migration create_ten_bang_table

# Tạo seeder mới
php artisan make:seeder TenSeeder

# Chạy seeder cụ thể
php artisan db:seed --class=TenSeeder
```

---

**Quy Tắc Vàng**: Khi gặp vấn đề → Hỏi ngay, đừng ngồi một mình! 🚀

---

*Phiên bản tài liệu: 1.0*  
*Cập nhật lần cuối: 28 tháng 10, 2025*  
*Duy trì bởi: ThanhNB-NBT*
