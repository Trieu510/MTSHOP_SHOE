<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * 🗨️ Hiển thị giao diện chat giữa khách hàng và admin
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // ✅ Lấy admin đầu tiên
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            abort(404, 'Admin không tồn tại.');
        }
        $adminId = $admin->id;

        // ✅ Lấy tin nhắn giữa user & admin (chỉ tin chưa bị xóa 1 phía)
        $messages = Message::visibleFor($userId)
            ->where(function ($query) use ($userId, $adminId) {
                $query->where(function ($q) use ($userId, $adminId) {
                    $q->where('user_id', $userId)
                        ->where('receiver_id', $adminId);
                })
                ->orWhere(function ($q) use ($userId, $adminId) {
                    $q->where('user_id', $adminId)
                        ->where('receiver_id', $userId);
                });
            })
            ->with('replyTo')
            ->orderBy('created_at', 'asc')
            ->get();

        // ✅ Đánh dấu tin nhắn từ admin → user là đã đọc
        Message::where('user_id', $adminId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // ✅ Đếm số lượng tin chưa đọc (phục vụ chấm đỏ ngoài giao diện)
        $unreadCount = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        // ✅ Nếu là request AJAX (polling), trả JSON
        if ($request->ajax()) {
            return response()->json([
                'messages' => $messages
            ]);
        }

        return view('front.chat.index', compact('messages', 'adminId', 'unreadCount'));
    }

    /**
     * 🚀 Gửi tin nhắn từ khách hàng đến admin hoặc ngược lại
     */
    public function send(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id',
            'reply_to_id' => 'nullable|exists:messages,id',
            'file' => 'nullable|file|max:5120', // 5MB
        ]);

        $senderId = Auth::id();

        // ✅ Nếu không chỉ định người nhận → mặc định gửi cho admin
        $receiverId = $request->receiver_id;
        if (!$receiverId) {
            $admin = User::where('is_admin', true)->first();
            if (!$admin) {
                abort(404, 'Admin không tồn tại.');
            }
            $receiverId = $admin->id;
        }

        // ❌ Nếu không có nội dung và không có file → từ chối
        if (!$request->hasFile('file') && empty($request->content)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập nội dung hoặc chọn tệp để gửi.'
            ], 422);
        }

        // ✅ Xử lý file upload (nếu có)
        $type = 'text';
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());

            // Xác định loại file
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $type = 'image';
            } else {
                $type = 'file';
            }

            // Lưu file vào storage/app/public/chat_uploads
            $filePath = $file->store('chat_uploads', 'public');
        }

        // ✅ Tạo tin nhắn mới
        $message = Message::create([
            'user_id'     => $senderId,
            'receiver_id' => $receiverId,
            'content'     => $request->content,
            'reply_to_id' => $request->reply_to_id,
            'type'        => $type,
            'file_path'   => $filePath,
            'is_read'     => false,
        ]);

        // 🔔 Gửi realtime qua event (nếu có cấu hình)
        event(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $message->id,
                'sender_id'   => $message->user_id,
                'receiver_id' => $message->receiver_id,
                'content'     => $message->content,
                'type'        => $message->type,
                'file_url'    => $message->file_path ? asset('storage/'.$message->file_path) : null,
                'time'        => $message->created_at->format('H:i d/m/Y'),
                'reply_to_id' => $message->reply_to_id
            ]
        ]);
    }

    /**
     * 🗑 Xóa tin nhắn phía mình (không ảnh hưởng người còn lại)
     */
    public function deleteSelf($id)
    {
        $userId = Auth::id();
        $message = Message::findOrFail($id);

        if ($message->user_id == $userId) {
            $message->update(['deleted_by_sender' => true]);
        } elseif ($message->receiver_id == $userId) {
            $message->update(['deleted_by_receiver' => true]);
        } else {
            abort(403);
        }

        return response()->json(['success' => true]);
    }

    /**
     * 🔁 Thu hồi tin nhắn (xóa cho cả 2 bên)
     */
    public function recall($id)
    {
        $userId = Auth::id();
        $message = Message::findOrFail($id);

        if ($message->user_id != $userId) {
            abort(403);
        }

        // Giới hạn thời gian thu hồi: 10 phút
        if (Carbon::parse($message->created_at)->diffInMinutes(now()) > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Quá thời gian cho phép để thu hồi.'
            ]);
        }

        $message->update([
            'is_recalled' => true,
            'content' => null,
            'file_path' => null,
            'type' => 'text'
        ]);

        broadcast(new \App\Events\MessageRecalled($message))->toOthers();

        return response()->json(['success' => true]);
    }

    /**
     * 📩 Đếm số tin nhắn chưa đọc (phục vụ hiển thị chấm đỏ)
     */
    public function getUnreadCount()
    {
        // Nếu chưa đăng nhập thì không có tin nhắn
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * 🔔 API thông báo tin nhắn mới (polling)
     * Kiểm tra xem có tin nhắn mới từ admin gửi đến hay không
     */
    public function checkNewMessages(Request $request)
    {
        $lastId = $request->input('last_id', 0);
        $userId = Auth::id();

        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            return response()->json(['new' => false]);
        }

        // Tìm tin nhắn mới từ admin sau last_id
        $newMessages = Message::where('user_id', $admin->id)
            ->where('receiver_id', $userId)
            ->where('id', '>', $lastId)
            ->get();

        return response()->json([
            'new' => $newMessages->count() > 0,
            'count' => $newMessages->count(),
            'messages' => $newMessages
        ]);
    }
}
