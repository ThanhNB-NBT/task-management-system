<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * M6: Xem danh sách thông báo
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Đếm số thông báo chưa đọc
        $unreadCount = $user->notifications()
            ->where('is_read', false)
            ->count();

        return view('member.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Đánh dấu đã đọc
     */
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Đã đánh dấu đã đọc');
    }

    /**
     * Đánh dấu tất cả đã đọc
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        $user->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Đã đánh dấu tất cả đã đọc');
    }
}
