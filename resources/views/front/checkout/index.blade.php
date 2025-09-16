@extends('layouts.front')

@section('title', 'Thanh toán')

@push('styles')
<style>
    :root {
        /* Color System */
        --primary: #5e35b1;
        --primary-light: #7e57c2;
        --primary-dark: #4527a0;
        --accent: #ffab00;
        --accent-light: #ffd740;
        --danger: #ff5252;
        --success: #4caf50;
        --dark: #263238;
        --dark-light: #455a64;
        --medium: #78909c;
        --light: #cfd8dc;
        --lighter: #eceff1;
        --lightest: #f5f7fa;
        --white: #ffffff;

        /* Typography */
        --font-heading: 'Montserrat', sans-serif;
        --font-body: 'Roboto', sans-serif;

        /* Effects */
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
        --shadow-xl: 0 15px 40px rgba(0,0,0,0.2);
        --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-xl: 32px;
    }

    /* ===== Base Styles ===== */
    body {
        font-family: var(--font-body);
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        color: var(--dark);
        line-height: 1.7;
    }

    /* ===== Checkout Container ===== */
    .checkout-container {
        max-width: 1400px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    /* ===== Animated Background ===== */
    .checkout-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }
    .checkout-particle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(94,53,177,0.08) 0%, rgba(69,39,160,0.08) 100%);
        filter: blur(30px);
        animation: float 15s infinite ease-in-out;
    }
    .particle-1 {
        width: 400px;
        height: 400px;
        top: 10%;
        right: -100px;
        animation-delay: 0s;
    }
    .particle-2 {
        width: 300px;
        height: 300px;
        bottom: 10%;
        left: -100px;
        animation-delay: 3s;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(5deg); }
    }

    /* ===== Page Header ===== */
    .checkout-header {
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
    }
    .checkout-title {
        font-family: var(--font-heading);
        font-size: 3rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
        letter-spacing: -1px;
    }
    .checkout-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        border-radius: 2px;
    }
    .checkout-subtitle {
        color: var(--medium);
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
    }

    /* ===== Checkout Grid ===== */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 3rem;
    }

    /* ===== Form Section ===== */
    .checkout-form {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-xl);
        padding: 3.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255,255,255,0.3);
        transition: var(--transition);
    }
    .checkout-form:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }
    .section-title {
        font-family: var(--font-heading);
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        position: relative;
        padding-left: 1.5rem;
    }
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 70%;
        width: 6px;
        background: linear-gradient(to bottom, var(--primary), var(--accent));
        border-radius: 3px;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }
    .form-label {
        font-weight: 600;
        color: var(--dark-light);
        margin-bottom: 0.8rem;
        display: block;
        font-size: 1rem;
    }
    .form-control {
        width: 100%;
        padding: 1.2rem 1.5rem;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: var(--radius-sm);
        font-size: 1rem;
        transition: var(--transition);
        background: rgba(255,255,255,0.7);
        font-family: var(--font-body);
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(94,53,177,0.2);
        outline: none;
        background: var(--white);
    }
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2378909C' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.5rem center;
        background-size: 14px;
    }

    /* Payment Methods */
    .payment-methods {
        margin: 3rem 0;
    }
    .payment-method {
        display: flex;
        align-items: center;
        padding: 1.8rem;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        cursor: pointer;
        transition: var(--transition);
        background: rgba(255,255,255,0.7);
        position: relative;
        overflow: hidden;
    }
    .payment-method::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        opacity: 0;
        transition: var(--transition);
        z-index: -1;
    }
    .payment-method:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-light);
    }
    .payment-method.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 1px var(--primary);
    }
    .payment-method.active::before {
        opacity: 0.05;
    }
    .payment-icon {
        width: 60px;
        height: 60px;
        background: rgba(94,53,177,0.1);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.8rem;
        color: var(--primary);
        font-size: 1.8rem;
        transition: var(--transition);
        flex-shrink: 0;
    }
    .payment-method.active .payment-icon {
        background: var(--primary);
        color: var(--white);
    }
    .payment-content {
        flex: 1;
    }
    .payment-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.3rem;
        font-size: 1.1rem;
    }
    .payment-desc {
        font-size: 0.95rem;
        color: var(--medium);
    }

    /* Submit Button */
    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 1.5rem;
        width: 100%;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-family: var(--font-heading);
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }
    .btn-submit:active {
        transform: translateY(0);
    }
    .btn-submit i {
        margin-right: 1rem;
        font-size: 1.3rem;
    }

    /* ===== Order Summary ===== */
    .order-summary {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-xl);
        padding: 3.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255,255,255,0.3);
        position: sticky;
        top: 2rem;
        transition: var(--transition);
    }
    .order-summary:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    /* Order Items */
    .order-items {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 1rem;
        margin-bottom: 2rem;
    }
    .order-items::-webkit-scrollbar {
        width: 8px;
    }
    .order-items::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.03);
        border-radius: 10px;
    }
    .order-items::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .order-items::-webkit-scrollbar-thumb:hover {
        background: rgba(0,0,0,0.2);
    }
    .product-item {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .product-item:last-child {
        border-bottom: none;
    }
    .product-info {
        flex: 1;
        padding-right: 1.5rem;
    }
    .product-name {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    .product-variant {
        font-size: 0.9rem;
        color: var(--medium);
        display: flex;
        align-items: center;
    }
    .product-variant::before {
        content: "•";
        margin: 0 0.5rem;
        color: var(--light);
    }
    .product-price {
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
        font-size: 1.1rem;
    }

    /* Summary Rows */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1.2rem 0;
        border-bottom: 1px dashed rgba(0,0,0,0.1);
    }
    .summary-row:last-child {
        border-bottom: none;
    }
    .summary-label {
        color: var(--medium);
        font-size: 1rem;
    }
    .summary-value {
        font-weight: 700;
        color: var(--dark);
    }
    .summary-total {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid rgba(0,0,0,0.1);
    }
    .summary-total .summary-label {
        font-weight: 800;
        color: var(--dark);
        font-size: 1.2rem;
    }
    .summary-total .summary-value {
        font-weight: 800;
        color: var(--primary);
        font-size: 1.5rem;
    }

    /* ===== Empty Cart ===== */
    .empty-cart {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-xl);
        padding: 5rem 4rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255,255,255,0.3);
        max-width: 700px;
        margin: 0 auto;
        transition: var(--transition);
    }
    .empty-cart:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }
    .empty-icon {
        font-size: 5rem;
        color: var(--light);
        margin-bottom: 2.5rem;
        display: inline-block;
        transition: var(--transition);
    }
    .empty-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-family: var(--font-heading);
    }
    .empty-text {
        color: var(--medium);
        margin-bottom: 3rem;
        font-size: 1.2rem;
    }
    .btn-continue {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 1.2rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: var(--shadow-md);
        letter-spacing: 0.5px;
    }
    .btn-continue:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }
    .btn-continue i {
        margin-right: 0.8rem;
    }

    /* ===== Form Validation ===== */
    .is-invalid {
        border-color: var(--danger) !important;
    }
    .invalid-feedback {
        color: var(--danger);
        font-size: 0.9rem;
        margin-top: 0.5rem;
        display: block;
    }

    /* ===== Loading State ===== */
    .btn-submit.loading {
        position: relative;
        pointer-events: none;
        opacity: 0.9;
    }
    .btn-submit.loading::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: var(--white);
        animation: spin 1s linear infinite;
        right: 20px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1200px) {
        .checkout-grid {
            gap: 2rem;
        }
        .checkout-form, .order-summary {
            padding: 3rem;
        }
    }
    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        .order-summary {
            position: static;
            margin-top: 2rem;
        }
        .checkout-title {
            font-size: 2.5rem;
        }
    }
    @media (max-width: 768px) {
        .checkout-container {
            padding: 0 1.5rem;
        }
        .checkout-title {
            font-size: 2.2rem;
        }
        .checkout-form, .order-summary {
            padding: 2.5rem;
        }
        .section-title {
            font-size: 1.8rem;
        }
        .payment-method {
            padding: 1.5rem;
        }
        .payment-icon {
            width: 50px;
            height: 50px;
            margin-right: 1.5rem;
        }
    }
    @media (max-width: 576px) {
        .checkout-container {
            padding: 0 1rem;
        }
        .checkout-title {
            font-size: 2rem;
        }
        .checkout-form, .order-summary {
            padding: 2rem;
        }
        .form-control {
            padding: 1rem;
        }
        .btn-submit {
            padding: 1.3rem;
            font-size: 1rem;
        }
        .empty-cart {
            padding: 4rem 2rem;
        }
        .empty-title {
            font-size: 1.8rem;
        }
    }
</style>
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
