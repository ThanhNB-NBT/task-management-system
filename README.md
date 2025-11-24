<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📋 Hệ Thống Quản Lý Công Việc

> Hệ thống quản lý công việc toàn diện được xây dựng bằng Laravel, thiết kế cho cộng tác nhóm với phân quyền theo vai trò (Admin, Leader, Member).

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
# Chạy tất cả seeders
php artisan db:seed
```
### Chạy NPM
```bash
npm install

```


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

*Phiên bản tài liệu: 1.1*  
*Cập nhật lần cuối: 24 tháng 11, 2025*  
