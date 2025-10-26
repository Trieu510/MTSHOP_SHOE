<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\ShippingFee;
use App\Models\User;
use App\Models\UserActivity; // ✅ thêm dòng này
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    /**
     * Hiển thị form checkout.
     */
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        // ✅ Cache danh sách tỉnh 1 giờ (3600 giây)
        $provinces = Cache::remember('shipping_provinces', 3600, function () {
            return ShippingFee::pluck('province')->unique()->toArray();
        });

        return view('front.checkout.index', compact('cart', 'total', 'provinces'));
    }

    /**
     * Lưu đơn hàng và chuyển hướng trang cảm ơn.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email',
            'address'        => 'required|string|max:500',
            'province'       => 'required|string|max:100',
            'shipping_fee'   => 'required|integer|min:0',
            'payment_method' => 'required|in:cod,bank,momo',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $order = $this->createOrder($request, $cart);

        // 🧹 Xóa giỏ hàng sau khi đặt xong
        session()->forget('cart');

        // 📧 Gửi mail xác nhận (queue)
        Mail::to($request->email)->queue(new OrderPlacedMail($order));

        // 🔔 Gửi thông báo admin (queue)
        $adminUsers = User::where('is_admin', true)->limit(2)->get();
        Notification::send($adminUsers, new NewOrderNotification($order));

        return redirect()->route('checkout.thankyou', ['order' => $order->id]);
    }

    /**
     * 🧾 Tạo đơn hàng trong transaction và cập nhật kho (có KHÓA)
     * Đồng thời ghi lại hành động "purchase" để hệ thống học hành vi.
     */
    protected function createOrder(Request $request, array $cart)
    {
        return DB::transaction(function () use ($request, $cart) {
            $productTotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
            $shippingFee  = (int) $request->shipping_fee;
            $totalAmount  = $productTotal + $shippingFee;

            // 🧾 Tạo đơn hàng
            $order = Order::create([
                'user_id'        => Auth::id(),
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'shipping_fee'   => $shippingFee,
                'subtotal'       => $productTotal,
                'total_amount'   => $totalAmount,
                'status'         => 'pending',
                'payment_method' => $request->payment_method,
                'note'           => $request->note ?? null,
            ]);

            $variantIds = array_keys($cart);

            // 🔒 Khóa tồn kho để tránh đặt trùng
            $variants = ProductVariant::whereIn('id', $variantIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($cart as $variantId => $item) {
                $qty     = (int) $item['quantity'];
                $variant = $variants[$variantId] ?? null;

                if (!$variant || $variant->stock < $qty) {
                    throw new \Exception("Sản phẩm {$item['name']} (size {$item['variant']}) không đủ tồn.");
                }

                // 📦 Trừ kho an toàn
                $variant->decrement('stock', $qty);

                // 🧾 Lưu từng sản phẩm trong đơn hàng
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $item['product_id'],
                    'product_variant_id' => $variantId,
                    'product_name'       => $item['name'],
                    'price'              => $item['price'],
                    'quantity'           => $qty,
                    'subtotal'           => $item['price'] * $qty,
                ]);

                // ✅ Ghi lại hành động "purchase" để hệ thống học hành vi mua hàng
                UserActivity::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $item['product_id'],
                    'action'     => 'purchase',
                ]);
            }

            return $order;
        });
    }

    /**
     * Trang cảm ơn sau khi đặt hàng.
     */
    public function thankyou(Order $order)
    {
        if ($order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front.checkout.thankyou', compact('order'));
    }
}
