<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng #{{ $order->id }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; line-height: 1.6;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #5e35b1;">🎉 Cảm ơn bạn đã đặt hàng tại <strong>MTShop</strong>!</h2>

        <p>Xin chào <strong>{{ $order->name }}</strong>,</p>

        <p>
            Chúng tôi đã nhận được đơn hàng của bạn với mã đơn <strong>#{{ $order->id }}</strong><br>
            Vào lúc {{ $order->created_at->format('H:i d/m/Y') }}.
        </p>

        <hr>

        <h3 style="color: #333;">📦 Thông tin đơn hàng:</h3>
        <ul style="padding-left: 20px;">
            <li><strong>Số Điện Thoại:</strong> {{ $order->phone }}</li>
            <li><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}, {{ $order->province }}</li>
            <li><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }}₫</li>
            @if($order->subtotal && $order->subtotal != $order->total_amount - $order->shipping_fee)
                <li><strong>Tạm tính:</strong> {{ number_format($order->subtotal, 0, ',', '.') }}₫</li>
            @endif
            <li><strong>Tổng thanh toán:</strong> <span style="color: #e53935;">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span></li>
            <li><strong>Phương thức thanh toán:</strong>
                @switch($order->payment_method)
                    @case('cod')
                        Thanh toán khi nhận hàng (COD)
                        @break
                    @case('bank')
                        Chuyển khoản ngân hàng
                        @break
                    @case('momo')
                        Ví MoMo
                        @break
                    @default
                        Không xác định
                @endswitch
            </li>
        </ul>

        <h3 style="color: #333;">🛍️ Sản phẩm đã đặt:</h3>
        <ul style="padding-left: 20px;">
            @foreach($order->items as $item)
                <li>
                    {{ $item->product_name }} - SL: {{ $item->quantity }} - {{ number_format($item->price, 0, ',', '.') }}₫
                </li>
            @endforeach
        </ul>

        {{-- CTA: Link đến đơn hàng nếu có --}}
        @auth
        <p style="margin-top: 20px;">
            👉 <a href="{{ route('orders.index') }}" style="color: #5e35b1; font-weight: bold;">Xem chi tiết đơn hàng của bạn</a>
        </p>
        @endauth

        <hr>

        <p style="color: #555;">
            Nếu bạn có bất kỳ thắc mắc nào, đừng ngần ngại liên hệ chúng tôi qua email hoặc hotline hỗ trợ.
        </p>

        <p>Trân trọng,<br><strong>Đội ngũ MTShop</strong></p>
    </div>
</body>
</html>
