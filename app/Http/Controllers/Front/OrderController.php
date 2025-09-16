<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['showTrackingForm', 'track', 'quickOrderForm', 'submitQuickOrder']);
    }

    // Lịch sử đơn hàng
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->orders()
            ->with(['items.variant.product.images'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        foreach ($orders as $order) {
            $categoryIds = $order->items
                ->filter(fn($item) => $item->variant && $item->variant->product)
                ->pluck('variant.product.category_id')
                ->unique();

            $purchasedProductIds = $order->items->pluck('product_id')->unique();

            $order->recommendedProducts = \App\Models\Product::with('images')
                ->whereIn('category_id', $categoryIds)
                ->whereNotIn('id', $purchasedProductIds)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        return view('front.orders.index', compact('orders'));
    }

    // Đặt lại đơn hàng -> thêm vào giỏ nhưng KHÔNG vượt tồn
    public function reorder($id)
    {
        $user = Auth::user();
        $order = Order::with('items.variant.product.images')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $cart = session('cart', []);
        $warnings = [];

        foreach ($order->items as $item) {
            $variant = $item->variant;
            if (!$variant || !$variant->product) {
                $warnings[] = "{$item->product_name} không còn biến thể.";
                continue;
            }

            $rowId    = $variant->id;
            $current  = isset($cart[$rowId]) ? (int)$cart[$rowId]['quantity'] : 0;
            $freeSlot = max(0, $variant->stock - $current);

            if ($freeSlot <= 0) {
                $warnings[] = "{$variant->product->name} (size {$variant->size}) đã hết hàng.";
                continue;
            }

            $addQty = min($item->quantity, $freeSlot);

            if (isset($cart[$rowId])) {
                $cart[$rowId]['quantity'] = $current + $addQty;
            } else {
                $cart[$rowId] = [
                    'product_id' => $variant->product->id,
                    'name'       => $variant->product->name,
                    'price'      => $variant->product->price,
                    'variant'    => $variant->size,
                    'quantity'   => $addQty,
                    'image'      => optional($variant->product->images->first())->path,
                ];
            }

            if ($addQty < $item->quantity) {
                $warnings[] = "{$variant->product->name} (size {$variant->size}) chỉ thêm được {$addQty}/{$item->quantity} do giới hạn tồn.";
            }
        }

        session(['cart' => $cart]);

        $msg = 'Đã thêm lại sản phẩm vào giỏ hàng.';
        if ($warnings) {
            $msg .= ' ' . implode(' ', $warnings);
        }

        return redirect()->route('cart.index')->with('success', $msg);
    }

    // Hủy đơn
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403, 'Không thể hủy đơn hàng.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    // Cập nhật địa chỉ (khi pending)
    public function updateAddress(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403, 'Không thể cập nhật địa chỉ.');
        }

        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $order->update([
            'address' => $request->address,
        ]);

        return redirect()->route('orders.index')->with('success', 'Cập nhật địa chỉ giao hàng thành công.');
    }

    // TRA CỨU ĐƠN HÀNG
    public function showTrackingForm()
    {
        return view('front.orders.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_code' => ['required', 'regex:/^#\d+$/'],
        ], [
            'order_code.regex' => 'Mã đơn hàng phải có định dạng #SỐ (ví dụ: #61)',
        ]);

        $orderId = ltrim($request->order_code, '#');
        $order   = Order::with('items.product')->find($orderId);

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        return view('front.orders.track_result', compact('order'));
    }

    // Xác nhận đã nhận hàng
    public function confirmReceived(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xác nhận đơn hàng này.'
            ], 403);
        }

        $order->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã xác nhận đã nhận hàng.'
        ]);
    }

    // Hiển thị form đặt hàng nhanh
    public function quickOrderForm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        return view('front.checkout.quick_order', compact('cart'));
    }

    // Lưu đơn hàng nhanh (CÓ KHÓA TỒN)
    public function submitQuickOrder(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank,momo',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();

        try {
            $shippingFee = 30000; // tạm
            $subtotal    = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
            $total       = $subtotal + $shippingFee;

            $order = Order::create([
                'user_id'        => null,
                'name'           => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'shipping_fee'   => $shippingFee,
                'subtotal'       => $subtotal,   // thêm subtotal
                'total_amount'   => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            // KHÓA tồn kho cho các variant trong giỏ
            $ids      = array_keys($cart);
            $variants = ProductVariant::whereIn('id', $ids)
                        ->lockForUpdate()->get()->keyBy('id');

            foreach ($cart as $variantId => $item) {
                $qty     = (int)$item['quantity'];
                $variant = $variants[$variantId] ?? null;

                if (!$variant || $variant->stock < $qty) {
                    throw new \Exception("Sản phẩm {$item['name']} (size {$item['variant']}) không đủ tồn.");
                }

                // Trừ kho an toàn (đang bị khóa)
                $variant->decrement('stock', $qty);

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $item['product_id'],
                    'product_variant_id' => $variantId,
                    'product_name'       => $item['name'],
                    'price'              => $item['price'],
                    'quantity'           => $qty,
                    'subtotal'           => $item['price'] * $qty,
                ]);
            }

            session()->forget('cart');
            DB::commit();

            // Gửi thông báo đến admin
            $admins = \App\Models\User::where('is_admin', true)->get();
            Notification::send($admins, new NewOrderNotification($order));

            return redirect()
                ->route('checkout.thankyou', ['order' => $order->id])
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
