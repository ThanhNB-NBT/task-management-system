<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $notifications = $user->systemNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = $user->systemNotifications()
            ->where('is_read', false)
            ->count();

        return view('member.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->systemNotifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Đã đánh dấu đã đọc');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();

        $user->systemNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Đã đánh dấu tất cả đã đọc');
    }
}
