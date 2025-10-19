<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\MessageRecalled;
use Carbon\Carbon;

class ChatAdminController extends Controller
{
    /**
     * 🧍‍♂️ Danh sách khách hàng đã từng nhắn tin
     */
    public function index()
    {
        $customers = User::where('is_admin', false)
            ->whereHas('messages', fn($q) => $q->whereNotNull('content')->orWhereNotNull('file_path'))
            ->orderBy('name')
            ->get();

        return view('admin.chat.index', compact('customers'));
    }

    /**
     * 💬 Hiển thị toàn bộ cuộc trò chuyện giữa admin và khách hàng
     */
    public function show(Request $request, $userId)
    {
        $adminId = Auth::id();
        $customer = User::find($userId);

        if (!$customer) {
            return redirect()->route('admin.chat.index')->with('error', 'Không tìm thấy khách hàng.');
        }

        $query = Message::visibleFor($adminId)
            ->where(function ($q) use ($userId, $adminId) {
                $q->where('user_id', $userId)
                  ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('user_id', $adminId)
                  ->where('receiver_id', $userId);
            });

        // Polling (AJAX)
        if ($request->ajax()) {
            if ($request->filled('after')) {
                $query->where('id', '>', (int) $request->after);
            }

            $messages = $query->with('replyTo')->orderBy('created_at')->get();

            return response()->json([
                'success' => true,
                'messages' => $messages,
            ]);
        }

        // Lấy toàn bộ khi load lần đầu
        $messages = $query->with('replyTo')->orderBy('created_at')->get();

        // Đánh dấu đã đọc tất cả tin từ user -> admin
        Message::where('user_id', $userId)
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.chat.show', compact('customer', 'messages'));
    }

    /**
     * ✉️ Admin gửi tin nhắn đến khách hàng (Realtime + AJAX + hỗ trợ ảnh/file)
     */
    public function send(Request $request, $userId)
    {
        $wantsJson = $request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json';

        $request->validate([
            'content' => 'nullable|string|max:1000',
            'reply_to_id' => 'nullable|exists:messages,id',
            'file' => 'nullable|file|max:5120', // 5MB
        ]);

        $adminId = Auth::id();
        $receiver = User::find($userId);

        if (!$receiver) {
            if ($wantsJson) {
                return response()->json(['success' => false, 'error' => 'Người nhận không tồn tại.'], 404);
            }
            return redirect()->back()->with('error', 'Người nhận không tồn tại.');
        }

        // 📎 Xử lý file upload nếu có
        $type = 'text';
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $type = 'image';
            } else {
                $type = 'file';
            }

            $filePath = $file->store('chat_uploads', 'public');
        } elseif (empty($request->content)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập nội dung hoặc chọn tệp để gửi.'
            ], 422);
        }

        // ✍️ Tạo tin nhắn
        $message = Message::create([
            'user_id'     => $adminId,
            'receiver_id' => $userId,
            'content'     => $request->content,
            'is_read'     => false,
            'reply_to_id' => $request->reply_to_id,
            'type'        => $type,
            'file_path'   => $filePath,
        ]);

        $message->load('replyTo');

        event(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => [
                'id'           => $message->id,
                'sender_id'    => $message->user_id,
                'receiver_id'  => $message->receiver_id,
                'content'      => e($message->content),
                'type'         => $message->type,
                'file_url'     => $message->file_path ? asset('storage/'.$message->file_path) : null,
                'time'         => $message->created_at->format('H:i d/m/Y'),
                'created_at'   => $message->created_at->toDateTimeString(),
                'reply_to_id'  => $message->reply_to_id,
                'reply_to'     => $message->replyTo ? [
                    'id'      => $message->replyTo->id,
                    'content' => e($message->replyTo->content),
                    'sender'  => $message->replyTo->user_id == $adminId ? 'Hỗ trợ' : 'Khách',
                ] : null,
            ]
        ]);
    }

    /**
     * 🗑 Xóa tin nhắn phía admin (không ảnh hưởng người dùng)
     */
    public function deleteSelf($id)
    {
        $adminId = Auth::id();
        $message = Message::findOrFail($id);

        if ($message->user_id == $adminId) {
            $message->update(['deleted_by_sender' => true]);
        } elseif ($message->receiver_id == $adminId) {
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
        $adminId = Auth::id();
        $message = Message::findOrFail($id);

        if ($message->user_id != $adminId) {
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
            'content'     => null,
            'file_path'   => null,
            'type'        => 'text',
        ]);

        broadcast(new MessageRecalled($message))->toOthers();

        return response()->json(['success' => true]);
    }

    /**
     * 📌 Đánh dấu tin nhắn từ admin → user là đã đọc (nếu cần)
     */
    public function markAsRead()
    {
        $userId = Auth::id();
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin không tồn tại'], 404);
        }

        Message::where('user_id', $admin->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * 🔔 Đếm số lượng tin nhắn chưa đọc từ khách hàng gửi đến admin
     */
    public function getUnreadCount()
    {
        $adminId = Auth::id();

        $count = Message::where('receiver_id', $adminId)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
