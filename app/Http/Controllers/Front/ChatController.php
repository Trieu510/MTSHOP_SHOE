<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * 🗨️ Hiển thị giao diện chat giữa khách hàng và admin
     */
    public function index()
    {
        $userId = Auth::id();

        // Lấy ID admin (mặc định lấy user có is_admin = true)
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            abort(404, 'Admin không tồn tại.');
        }
        $adminId = $admin->id;

        // Lấy tất cả tin nhắn giữa user và admin
        $messages = Message::where(function ($query) use ($userId, $adminId) {
                $query->where('user_id', $userId)
                      ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($query) use ($userId, $adminId) {
                $query->where('user_id', $adminId)
                      ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Cập nhật tất cả tin nhắn từ admin chưa đọc thành đã đọc
        Message::where('user_id', $adminId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('front.chat.index', compact('messages', 'adminId'));
    }

    /**
     * 🚀 Gửi tin nhắn từ khách hàng đến admin hoặc ngược lại
     */
    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id'
        ]);

        $senderId = Auth::id();

        // Lấy ID người nhận
        $receiverId = $request->receiver_id;
        if (!$receiverId) {
            // Mặc định gửi đến admin
            $admin = User::where('is_admin', true)->first();
            if (!$admin) {
                abort(404, 'Admin không tồn tại.');
            }
            $receiverId = $admin->id;
        }

        // Lưu tin nhắn
        $message = Message::create([
            'user_id'     => $senderId,
            'receiver_id' => $receiverId,
            'content'     => $request->content,
            'is_read'     => false,
        ]);

        // 🔔 Phát event realtime
        event(new MessageSent($message));

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
}
