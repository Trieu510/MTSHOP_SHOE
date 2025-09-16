<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng.
     */
    public function index(Request $request)
{
    $query = Order::with('user')->orderBy('created_at', 'desc');

    // Lọc theo Mã đơn (ID)
    if ($request->filled('order_id')) {
        $query->where('id', $request->order_id);
    }

    // Lọc theo Khách hàng (tên user hoặc tên người đặt)
    if ($request->filled('customer')) {
        $query->where(function ($q) use ($request) {
            $q->whereHas('user', function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->customer . '%');
            })->orWhere('name', 'like', '%' . $request->customer . '%'); // khách vãng lai
        });
    }

    // Lọc theo khoảng Tổng tiền
    if ($request->filled('total_min')) {
        $query->where('total_amount', '>=', $request->total_min);
    }

    if ($request->filled('total_max')) {
        $query->where('total_amount', '<=', $request->total_max);
    }

    // Lọc theo Trạng thái
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Lọc theo Ngày đặt (YYYY-MM-DD)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $orders = $query->paginate(15)->withQueryString();

    return view('admin.orders.index', compact('orders'));
}


    /**
     * Hiển thị chi tiết một đơn hàng.
     */
    public function show(Order $order)
    {
        // load các items và các variant liên quan
        $order->load(['items.variant.product', 'user']);
        $order->load(['items.variant.product.images', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng.
     */
    public function update(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,processing,completed,canceled',
    ]);

    // Gán mức độ cho từng trạng thái để so sánh
    $statusOrder = [
        'pending'    => 1,
        'confirmed'  => 2,
        'processing' => 3,
        'completed'  => 4,
        'canceled'   => 5
    ];

    $currentStatus = $order->status;
    $newStatus = $request->status;

    // Ngăn quay lại trạng thái trước đó
    if ($statusOrder[$newStatus] < $statusOrder[$currentStatus]) {
        return redirect()
            ->route('admin.orders.show', $order)
            ->with('error', 'Không thể cập nhật về trạng thái trước đó!');
    }

    // ✅ Cập nhật nếu hợp lệ
    $order->update([
        'status' => $newStatus,
    ]);

    // Gửi thông báo nếu có user
    if ($order->user) {
        $order->user->notify(new OrderStatusUpdated($order, $newStatus));
    }

    return redirect()
        ->route('admin.orders.show', $order)
        ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
}

    /**
 * In đơn hàng.
 */
public function print(Order $order)
{
    $order->load(['items.variant.product.images', 'user']);

    return view('admin.orders.print', compact('order'));
}

}
