<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\ReturnImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReturnRequestController extends Controller
{
    /**
     * Form gửi yêu cầu hoàn/trả hàng cho đơn hàng cụ thể
     */
    public function create(Order $order)
    {
        // Kiểm tra quyền truy cập đơn hàng
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front.returns.create', compact('order'));
    }

    /**
     * Xử lý lưu yêu cầu hoàn/trả hàng
     */
    public function store(Request $request, Order $order)
    {
        // Kiểm tra quyền truy cập đơn hàng
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Tạo yêu cầu hoàn hàng
        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // Lưu ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('return_images', 'public');
                ReturnImage::create([
                    'return_request_id' => $returnRequest->id,
                    'path' => $path,
                ]);
            }
        }

        // Gửi thông báo cho admin (tất cả user là admin)
        $admins = \App\Models\User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
        $admin->notify(new \App\Notifications\NewReturnRequestNotification($returnRequest));
        }

        return redirect()->route('orders.index')->with('success', 'Đã gửi yêu cầu hoàn hàng thành công.');
    }

    public function show(ReturnRequest $return)
{
    // Kiểm tra quyền truy cập (chỉ user gửi request được xem)
    if ($return->user_id !== auth()->id()) {
        abort(403);
    }

    return view('front.returns.show', compact('return'));
}

}
