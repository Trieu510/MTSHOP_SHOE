@extends('layouts.front')

@section('title', 'Đặt hàng nhanh')

@push('styles')
<style>
    .checkout-wrapper {
        background: linear-gradient(135deg, #eef2f3, #f9f9f9);
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }
    .checkout-title {
        font-weight: 700;
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 1rem;
    }
    .form-control {
        border-radius: 8px;
        padding: 0.75rem;
    }
    .order-summary {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .order-summary h5 {
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row g-4">
        {{-- Form giao hàng --}}
        <div class="col-md-7">
            <div class="checkout-wrapper">
                <h2 class="checkout-title">Thông tin giao hàng</h2>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('orders.quick.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                            <option value="momo">Chuyển khoản qua Momo</option>
                            <option value="bank">Chuyển khoản ngân hàng</option>
                        </select>
                    </div>

                    {{-- Thông tin chi tiết theo phương thức thanh toán --}}
                    <div id="payment-info" class="alert alert-secondary d-none"></div>

                    <button type="submit" class="btn btn-warning w-100 py-2">
                        <i class="bi bi-cart-check"></i> Hoàn tất đặt hàng
                    </button>
                </form>
            </div>
        </div>

        {{-- Tóm tắt đơn hàng --}}
        <div class="col-md-5">
            <div class="order-summary">
                <h5>Tóm tắt đơn hàng</h5>

                @php
                    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                    $shipping = 30000;
                    $total = $subtotal + $shipping;
                @endphp

                <ul class="list-group mb-3">
                    @foreach ($cart as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $item['name'] }} - Size {{ $item['variant'] }}</div>
                                <small>x{{ $item['quantity'] }}</small>
                            </div>
                            <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                        </li>
                    @endforeach
                </ul>

                <hr>

                <div class="d-flex justify-content-between">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Phí vận chuyển:</span>
                    <span>{{ number_format($shipping, 0, ',', '.') }}đ</span>
                </div>
                <div class="d-flex justify-content-between fw-bold mt-2">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const paymentSelect = document.querySelector('select[name="payment_method"]');
    const infoBox = document.getElementById('payment-info');

    const paymentDetails = {
        cod: `<strong>COD:</strong> Thanh toán khi nhận hàng. Bạn sẽ trả tiền mặt khi nhận được sản phẩm.`,
        momo: `<strong>Ví MoMo:</strong><br>
               - SĐT: <strong>0386302325</strong><br>
               - Chủ TK: <strong>CTY TNHH MTShop</strong><br>
               - Nội dung: Thanh toán đơn hàng.`,
        bank: `<strong>Ngân hàng Vietcombank:</strong><br>
               - Số TK: <strong>1032930823</strong><br>
               - Chủ TK: <strong>CTY TNHH MTShop</strong><br>
               - Nội dung: Thanh toán đơn hàng.`
    };

    paymentSelect.addEventListener('change', function () {
        const selected = this.value;
        infoBox.classList.remove('d-none');
        infoBox.innerHTML = paymentDetails[selected] || '';
    });

    // Hiển thị sẵn nếu reload
    document.addEventListener('DOMContentLoaded', () => {
        const selected = paymentSelect.value;
        if (selected) {
            infoBox.classList.remove('d-none');
            infoBox.innerHTML = paymentDetails[selected];
        }
    });
</script>
@endpush
