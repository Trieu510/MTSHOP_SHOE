@extends('layouts.front')

@section('title', 'Cảm ơn bạn đã đặt hàng')

@section('content')
<div class="container py-5">
    <div class="text-center" data-aos="fade-up">
        <h1 class="mb-4 text-success">
            <i class="bi bi-check-circle-fill"></i> Đặt hàng thành công!
        </h1>

        <p class="mb-3 fs-5">Cảm ơn bạn <strong>{{ $order->name }}</strong> đã mua sắm tại <strong>MTShop</strong>.</p>

        <p class="mb-4">Mã đơn hàng của bạn:
            <strong id="order-code">#{{ $order->id }}</strong>
            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyOrderCode()">
                <i class="bi bi-clipboard"></i> Copy
            </button>
        </p>

        <div class="alert alert-secondary text-start mx-auto" style="max-width: 600px;" data-aos="fade-up">
            <h5 class="fw-bold mb-2"><i class="bi bi-search"></i> Theo dõi đơn hàng của bạn</h5>
            <p class="mb-1">Hãy lưu lại mã đơn hàng: <span class="text-danger fw-bold">#{{ $order->id }}</span></p>
            <p class="mb-1">Bạn có thể tra cứu trạng thái đơn hàng tại:</p>
            <a href="{{ route('orders.track') }}" class="btn btn-outline-primary btn-sm mt-2">
                <i class="bi bi-box"></i> Tra cứu đơn hàng
            </a>
            <div class="text-center mt-3">
                <p class="mb-2 text-muted">Hoặc quét mã QR để mở nhanh:</p>
                <div id="qrcode"></div>
            </div>
        </div>

        @if($order->payment_method === 'cod')
            <div class="alert alert-info">
                <strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD).<br>
                Nhân viên giao hàng sẽ liên hệ với bạn sớm!
            </div>
        @elseif($order->payment_method === 'bank')
            <div class="alert alert-warning text-start mx-auto" style="max-width: 600px;">
                <strong>Vui lòng chuyển khoản với nội dung:</strong><br>
                <ul class="mt-2">
                    <li><strong>Ngân hàng:</strong> Vietcombank</li>
                    <li><strong>Số tài khoản:</strong> 1032930823</li>
                    <li><strong>Chủ tài khoản:</strong> CTY TNHH MTShop</li>
                    <li><strong>Nội dung:</strong> Thanh toán đơn hàng #{{ $order->id }}</li>
                </ul>
                <div class="text-center mt-3">
    <img src="{{ asset('storage/qr/bank.jpg') }}" alt="QR Ngân hàng" style="max-width: 200px;">
    <p class="text-muted mt-2">Quét mã QR để chuyển khoản nhanh</p>
</div>
            </div>
        @elseif($order->payment_method === 'momo')
            <div class="alert alert-success text-start mx-auto" style="max-width: 600px;">
                <strong>Hướng dẫn thanh toán bằng ví MoMo:</strong><br>
                <ul class="mt-2">
                    <li><strong>Số điện thoại MoMo:</strong> 0386302325</li>
                    <li><strong>Chủ tài khoản:</strong> CTY TNHH MTShop</li>
                    <li><strong>Nội dung:</strong> Thanh toán đơn hàng #{{ $order->id }}</li>
                </ul>
                <div class="text-center mt-3">
                    <img src="{{ asset('storage/qr/momo.jpg') }}" alt="QR MoMo" style="max-width: 200px;">
                    <p class="text-muted mt-2">Quét mã QR để thanh toán nhanh</p>
                </div>
            </div>
        @endif

        <a href="{{ route('home') }}" class="btn btn-primary mt-4">
            <i class="bi bi-house-door-fill"></i> Quay về trang chủ
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
function copyOrderCode() {
    const orderCode = document.getElementById("order-code").innerText;
    navigator.clipboard.writeText(orderCode).then(() => {
        alert("Đã sao chép mã đơn hàng: " + orderCode);
    });
}

new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('orders.track') }}",
    width: 150,
    height: 150
});
</script>
@endpush
