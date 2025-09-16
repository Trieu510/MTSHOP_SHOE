<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReturnStatusUpdatedNotification;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use App\Models\ReturnLog;

class ReturnRequestController extends Controller
{
    // Danh sách các yêu cầu hoàn trả
    public function index()
    {
        $returns = ReturnRequest::with('order', 'user')->latest()->paginate(10);
        return view('admin.returns.index', compact('returns'));
    }

    // Form chỉnh sửa 1 yêu cầu hoàn trả
    public function edit($id)
    {
        $return = ReturnRequest::with('order', 'user', 'images')->findOrFail($id);
        return view('admin.returns.edit', compact('return'));
    }

    // Cập nhật trạng thái hoặc ghi chú xử lý
    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected,exchanged',
        'admin_note' => 'nullable|string|max:1000',
    ]);

    $return = ReturnRequest::with('user')->findOrFail($id); // phải load user

    $return->update([
        'status' => $request->status,
        'admin_note' => $request->admin_note,
    ]);

    ReturnLog::create([
        'return_request_id' => $return->id,
        'admin_id' => Auth::id(),
        'status' => $request->status,
        'note' => $request->admin_note,
    ]);

    // 🎯 Gửi thông báo cho người dùng
    $return->user->notify(new ReturnStatusUpdatedNotification($return));

    return redirect()->route('admin.returns.index')
        ->with('success', 'Cập nhật trạng thái yêu cầu hoàn/trả hàng thành công.');
}

    // Xoá yêu cầu hoàn trả
    public function destroy($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->delete();

        return redirect()->back()->with('success', 'Đã xoá yêu cầu hoàn trả.');
    }
}
