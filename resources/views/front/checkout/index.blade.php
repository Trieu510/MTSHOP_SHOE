@extends('layouts.front')

@section('title', 'Thanh toán')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
<div class="checkout-container">
    <!-- Animated Background -->
    <div class="checkout-bg">
        <div class="checkout-particle particle-1"></div>
        <div class="checkout-particle particle-2"></div>
    </div>

    <!-- Checkout Header -->
    <div class="checkout-header">
        <h1 class="checkout-title">Thanh toán đơn hàng</h1>
        <p class="checkout-subtitle">Hoàn tất thông tin để nhận được sản phẩm sớm nhất</p>
    </div>

    @if(empty($cart) || !count($cart))
        <div class="empty-cart">
            <div class="empty-icon">
                <i class="bi bi-cart-x"></i>
            </div>
            <h3 class="empty-title">Giỏ hàng của bạn đang trống</h3>
            <p class="empty-text">Hãy thêm sản phẩm vào giỏ hàng trước khi thanh toán</p>
            <a href="{{ route('products.index') }}" class="btn-continue">
                <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>
    @else
    <div class="checkout-grid">
        <!-- Checkout Form -->
        <div class="checkout-form">
            <h3 class="section-title">Thông tin giao hàng</h3>
            <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <input type="hidden" name="province" id="provinceField" value="">
                <input type="hidden" name="shipping_fee" id="shippingFeeField" value="30000">

                <div class="form-group">
                    <label for="name" class="form-label">Họ và tên *</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Số điện thoại *</label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Địa chỉ giao hàng *</label>
                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', auth()->user()->address ?? '') }}</textarea>
                    @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="province" class="form-label">Tỉnh/Thành phố *</label>
                    <select id="province" name="province" class="form-control @error('province') is-invalid @enderror" required>
                        <option value="">-- Chọn tỉnh/thành phố --</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ old('province') == $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                    @error('province')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="note" name="note" class="form-control" rows="2" placeholder="Ví dụ: Giao hàng giờ hành chính...">{{ old('note') }}</textarea>
                </div>

                <h3 class="section-title">Phương thức thanh toán</h3>
                <div class="payment-methods">
                    <label class="payment-method {{ old('payment_method', 'cod') === 'cod' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                        <div class="payment-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="payment-content">
                            <div class="payment-title">Thanh toán khi nhận hàng (COD)</div>
                            <div class="payment-desc">Bạn chỉ thanh toán khi nhận được hàng</div>
                        </div>
                    </label>

                    <label class="payment-method {{ old('payment_method') === 'momo' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="momo" {{ old('payment_method') === 'momo' ? 'checked' : '' }}>
                        <div class="payment-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="payment-content">
                            <div class="payment-title">Ví điện tử MoMo</div>
                            <div class="payment-desc">Thanh toán nhanh chóng qua ví MoMo</div>
                        </div>
                    </label>

                    <label class="payment-method {{ old('payment_method') === 'bank' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="bank" {{ old('payment_method') === 'bank' ? 'checked' : '' }}>
                        <div class="payment-icon">
                            <i class="bi bi-bank"></i>
                        </div>
                        <div class="payment-content">
                            <div class="payment-title">Chuyển khoản ngân hàng</div>
                            <div class="payment-desc">Chuyển khoản qua tài khoản ngân hàng</div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Hoàn tất đơn hàng
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="section-title">Tóm tắt đơn hàng</h3>


    @if(session('coupon'))
        <small class="text-success">Đã áp dụng mã: <strong>{{ session('coupon.code') }}</strong></small>
    @endif
    @if(session('coupon_error'))
        <small class="text-danger">{{ session('coupon_error') }}</small>
    @endif



            <div class="order-items">
                @foreach($cart as $item)
                @php
                    $item = array_merge([
                        'name' => 'Sản phẩm không có tên',
                        'price' => 0,
                        'quantity' => 1,
                        'variant' => 'Mặc định'
                    ], $item);
                @endphp
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-name">{{ $item['name'] }}</div>
                        <div class="product-variant">Size {{ $item['variant'] }} × {{ $item['quantity'] }}</div>
                    </div>
                    @php
    $originalPrice = $item['original_price'] ?? $item['price'];
    $finalPrice = $item['price'];
@endphp

<div class="product-price">
    @if($originalPrice > $finalPrice)
        <span style="text-decoration: line-through; color: #888; font-size: 0.9rem;">
            {{ number_format($originalPrice * $item['quantity'], 0, ',', '.') }} ₫
        </span><br>
        <span style="color: #e53935; font-weight: bold;">
            {{ number_format($finalPrice * $item['quantity'], 0, ',', '.') }} ₫
        </span>
    @else
        {{ number_format($finalPrice * $item['quantity'], 0, ',', '.') }} ₫
    @endif
</div>

                </div>
                @endforeach
            </div>

            @php
                $subtotal = array_reduce($cart, function($carry, $item) {
                    return $carry + ($item['price'] * ($item['quantity'] ?? 1));
                }, 0);
                $shippingFee = 30000;
                $discount = session('coupon.discount') ?? 0;
                $total = $subtotal - $discount + $shippingFee;

            @endphp

            <div class="summary-row">
                <span class="summary-label">Tạm tính:</span>
                <span class="summary-value">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
            </div>
            @if(session('coupon'))
    <div class="summary-row">
        <span class="summary-label">Giảm giá ({{ session('coupon.code') }}):</span>
        <span class="summary-value">-{{ number_format(session('coupon.discount'), 0, ',', '.') }} ₫</span>
    </div>
@endif


            <div class="summary-row">
                <span class="summary-label">Phí vận chuyển:</span>
                <span class="summary-value shipping-fee-value">{{ number_format($shippingFee, 0, ',', '.') }} ₫</span>
            </div>

            <div class="summary-row summary-total">
                <span class="summary-label">Tổng cộng:</span>
                <span class="summary-value summary-total-value">{{ number_format($total, 0, ',', '.') }} ₫</span>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Shipping fee calculation
    const provinceSelect = document.getElementById('province');
    const provinceField = document.getElementById('provinceField');
    const shippingFeeField = document.getElementById('shippingFeeField');
    const shippingFeeText = document.querySelector('.shipping-fee-value');
    const summaryTotalText = document.querySelector('.summary-total-value');
    const subtotal = {{ $subtotal ?? 0 }};
    const discount = {{ $discount ?? 0 }};

    async function fetchShippingFee(province) {
        try {
            const res = await fetch(`/api/shipping-fee?province=${encodeURIComponent(province)}`);
            const data = await res.json();

            if (data.success && data.fee !== undefined) {
                const fee = parseInt(data.fee);
                provinceField.value = province;
                shippingFeeField.value = fee;
                shippingFeeText.textContent = fee.toLocaleString('vi-VN') + ' ₫';
                summaryTotalText.textContent = (subtotal - discount + fee).toLocaleString('vi-VN') + ' ₫';
            }
        } catch (err) {
            console.error('Error fetching shipping fee:', err);
        }
    }

    // Province change event
    provinceSelect.addEventListener('change', function () {
        const selectedProvince = this.value;
        if (selectedProvince) {
            fetchShippingFee(selectedProvince);
        }
    });

    // Initialize if province is preselected
    if (provinceSelect.value) {
        fetchShippingFee(provinceSelect.value);
    }

    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function () {
            document.querySelectorAll('.payment-method').forEach(m => {
                m.classList.remove('active');
            });
            this.classList.add('active');
            this.querySelector('input').checked = true;
        });
    });

    // Form submission loading state
    const checkoutForm = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function () {
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Đang xử lý...';
        });
    }

    // Autofill address if available
    @if(auth()->check() && auth()->user()->address)
    const addressField = document.getElementById('address');
    if (addressField && !addressField.value) {
        addressField.value = '{{ auth()->user()->address }}';
    }
    @endif
});
</script>
@endpush
@endsection
