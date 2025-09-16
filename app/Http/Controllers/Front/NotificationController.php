<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // bắt buộc đăng nhập
    }

    /**
     * Hiển thị danh sách thông báo
     */
    public function index()
{
    $notifications = auth()->user()->notifications()->paginate(10); // ✅ đúng

    return view('front.notifications.index', compact('notifications'));
}

public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id); // ✅ đúng

    if (is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    return redirect()->back()->with('success', 'Đã đánh dấu là đã đọc.');
}

}
