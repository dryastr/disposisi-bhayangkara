<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $announcements = Announcement::where('user_id', $user->id)->get();
        $unreadCount = Announcement::where('user_id', $user->id)->where('is_read', false)->count();

        return view('admin.admin.notifications.index', compact('announcements', 'unreadCount'));
    }

    public function markAsRead()
    {
        $user = auth()->user();

        Announcement::where('user_id', $user->id)
            ->update(['is_read' => true]);

        return redirect()->back();
    }

    // public function getUnreadCount()
    // {
    //     $user = auth()->user();

    //     // Menghitung jumlah notifikasi yang belum dibaca
    //     $unreadCount = Announcement::where('user_id', $user->id)
    //         ->where('is_read', false)
    //         ->count();

    //     return $unreadCount;
    // }
}
