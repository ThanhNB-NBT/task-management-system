<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportController;

//Leader Controllers
use App\Http\Controllers\Leader\DashboardController as LeaderDashboardController;
use App\Http\Controllers\Leader\ProjectController as LeaderProjectController;
use App\Http\Controllers\Leader\TaskController as LeaderTaskController;
use App\Http\Controllers\Leader\TeamController as LeaderTeamController;
use App\Http\Controllers\Leader\ReportController as LeaderReportController;

//Member Controllers
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProjectController as MemberProjectController;
use App\Http\Controllers\Member\TaskController;
use App\Http\Controllers\Member\TaskCommentController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\TaskAttachmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard tự động redirect theo role
Route::get('/dashboard', function () {
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'leader':
            return redirect()->route('leader.dashboard');
        case 'member':
            return redirect()->route('member.dashboard');
        default:
            abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::resource('users', UserController::class);
    
    // Projects Management
    Route::resource('projects', ProjectController::class);
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/users', [ReportController::class, 'users'])->name('reports.users');
    Route::get('reports/users/export/excel', [ReportController::class, 'exportUsersExcel'])->name('reports.users.export.excel');
    Route::get('reports/users/export/pdf', [ReportController::class, 'exportUsersPdf'])->name('reports.users.export.pdf');
    // Analytics
    Route::get('reports/analytics/users', [ReportController::class, 'analyticsUsers'])->name('reports.analytics.users');
    Route::get('reports/projects', [ReportController::class, 'projects'])->name('reports.projects');
    Route::get('reports/projects/export/excel', [ReportController::class, 'exportProjectsExcel'])->name('reports.projects.export.excel');
    Route::get('reports/projects/export/pdf', [ReportController::class, 'exportProjectsPdf'])->name('reports.projects.export.pdf');
    Route::get('reports/analytics/projects', [ReportController::class, 'analyticsProjects'])->name('reports.analytics.projects');
    Route::get('reports/tasks', [ReportController::class, 'tasks'])->name('reports.tasks');
    Route::get('reports/tasks/export/excel', [ReportController::class, 'exportTasksExcel'])->name('reports.tasks.export.excel');
    Route::get('reports/tasks/export/pdf', [ReportController::class, 'exportTasksPdf'])->name('reports.tasks.export.pdf');
    
    // System Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

// Leader routes
Route::middleware(['auth', 'leader'])->prefix('leader')->name('leader.')->group(function () {
    Route::get('/dashboard', [LeaderDashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [LeaderProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{id}', [LeaderProjectController::class, 'show'])->name('projects.show');
    Route::get('/tasks', [LeaderTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}', [LeaderTaskController::class, 'show'])->name('tasks.show');
    Route::get('/team', [LeaderTeamController::class, 'index'])->name('team');
    Route::get('/reports', [LeaderReportController::class, 'index'])->name('reports');
    // Task attachments for leaders (same controller)
    Route::post('/tasks/{id}/attachments', [\App\Http\Controllers\TaskAttachmentController::class, 'store'])->name('tasks.attachments.store');
    Route::get('/tasks/attachments/{id}/download', [\App\Http\Controllers\TaskAttachmentController::class, 'download'])->name('tasks.attachments.download');
    Route::delete('/tasks/attachments/{id}', [\App\Http\Controllers\TaskAttachmentController::class, 'destroy'])->name('tasks.attachments.destroy');
});


// Member routes
Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [MemberProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{id}', [MemberProjectController::class, 'show'])->name('projects.show');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::post('/tasks/{taskId}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');
    // Task attachments (upload/download/delete)
    Route::post('/tasks/{id}/attachments', [TaskAttachmentController::class, 'store'])->name('tasks.attachments.store');
    Route::get('/tasks/attachments/{id}/download', [TaskAttachmentController::class, 'download'])->name('tasks.attachments.download');
    Route::delete('/tasks/attachments/{id}', [TaskAttachmentController::class, 'destroy'])->name('tasks.attachments.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
});

require __DIR__ . '/auth.php';
