<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatAdminController extends Controller
{
    /**
     * ✅ Danh sách khách hàng đã từng nhắn tin
     */
    public function index()
    {
        // Lấy danh sách khách hàng có tin nhắn, loại bỏ admin
        $customers = User::whereHas('messages', function ($q) {
                $q->whereNotNull('content');
            })
            ->where('is_admin', false)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.chat.index', compact('customers'));
    }

    /**
     * ✅ Hiển thị toàn bộ cuộc trò chuyện giữa admin và khách hàng
     */
    public function show(Request $request, $userId)
    {
        $adminId = Auth::id();
        $customer = User::findOrFail($userId);

        // Lấy tất cả tin nhắn giữa admin và khách hàng
        $messages = Message::where(function ($q) use ($userId, $adminId) {
                $q->where('user_id', $userId)
                  ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('user_id', $adminId)
                  ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Cập nhật trạng thái 'is_read' cho tất cả tin nhắn chưa đọc
        Message::where('user_id', $userId)
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Nếu là request AJAX (polling)
        if ($request->ajax()) {
            return response()->json([
                'messages' => $messages->toArray(),
            ]);
        }

        return view('admin.chat.show', compact('customer', 'messages'));
    }

    /**
     * ✅ Admin gửi tin nhắn đến khách hàng (Realtime + AJAX)
     */
    public function send(Request $request, $userId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $adminId = Auth::id();

        // Tạo tin nhắn
        $message = Message::create([
            'user_id'     => $adminId,    // Người gửi: admin
            'receiver_id' => $userId,     // Người nhận: khách hàng
            'content'     => $request->content,
            'is_read'     => false,
        ]);

        // 🔔 Phát realtime event (Laravel Echo sẽ bắt được)
        event(new MessageSent($message));

        // ✅ Trả về JSON nếu gửi bằng AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'          => $message->id,
                    'sender_id'   => $message->user_id,
                    'receiver_id' => $message->receiver_id,
                    'content'     => $message->content,
                    'time'        => $message->created_at->format('H:i d/m/Y'),
                ]
            ]);
        }

        // ✅ Nếu gửi bằng form thông thường
        return redirect()->back()->with('success', '✅ Tin nhắn đã được gửi.');
    }
}
