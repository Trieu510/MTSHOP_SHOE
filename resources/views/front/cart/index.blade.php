@extends('layouts.front')

@section('title', 'Giỏ hàng')

@push('styles')
<style>
    /* ===== Global Variables ===== */
    :root {
        --primary-color: #6d28d9;
        --primary-hover: #5b21b6;
        --accent-color: #f472b6;
        --secondary-color: #f8fafc;
        --dark-color: #1e293b;
        --text-color: #2d3748;
        --text-light: #6b7280;
        --border-radius: 10px;
        --border-radius-lg: 16px;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 6px 12px rgba(0,0,0,0.1);
        --shadow-lg: 0 12px 24px rgba(0,0,0,0.15);
        --transition: all 0.3s ease-in-out;
    }

    /* ===== Page Title ===== */
    .page-title {
        font-family: 'Inter', sans-serif;
        font-size: 3rem;
        font-weight: 900;
        color: var(--dark-color);
        margin-bottom: 3rem;
        position: relative;
        display: inline-block;
        letter-spacing: -0.03em;
        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 120px;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* ===== Empty State ===== */
    .empty-state {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border-radius: var(--border-radius-lg);
        padding: 6rem 3rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
        margin: 4rem 0;
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }
    .empty-state::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top left, rgba(109, 40, 217, 0.05), transparent);
        z-index: 0;
    }
    .empty-state-icon {
        font-size: 5.5rem;
        color: #d1d5db;
        margin-bottom: 2rem;
        display: inline-flex;
        padding: 1.75rem;
        background: #f1f5f9;
        border-radius: 50%;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        transition: var(--transition);
    }
    .empty-state-icon:hover {
        transform: scale(1.05);
    }
    .empty-state h4 {
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }
    .empty-state p {
        color: var(--text-light);
        margin-bottom: 2.75rem;
        max-width: 550px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
        font-size: 1.1rem;
    }
    .empty-state .btn {
        padding: 1.25rem 3rem;
        font-weight: 700;
        border-radius: var(--border-radius);
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border: none;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }
    .empty-state .btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(90deg, var(--primary-hover), var(--accent-color));
    }

    /* ===== Cart Table ===== */
    .cart-table {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 4rem;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .cart-table table {
        margin-bottom: 0;
    }
    .cart-table thead th {
        background: linear-gradient(90deg, #f1f5f9, #e2e8f0);
        font-weight: 800;
        color: var(--dark-color);
        padding: 1.75rem;
        border-bottom: none;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.75px;
        border-top: none;
    }
    .cart-table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid rgba(0,0,0,0.02);
    }
    .cart-table tbody tr:last-child {
        border-bottom: none;
    }
    .cart-table tbody tr:hover {
        background: rgba(241, 245, 249, 0.4);
        transform: scale(1.005);
    }
    .cart-table td {
        padding: 1.75rem;
        vertical-align: middle;
        border-top: 1px solid rgba(0,0,0,0.02);
    }
    .product-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    .product-image {
        width: 100px;
        height: 100px;
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
        transition: var(--transition);
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .product-image:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }
    .product-image:hover img {
        transform: scale(1.1);
    }
    .product-name {
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
    }
    .product-variant {
        font-size: 0.95rem;
        color: var(--text-light);
        background: #e2e8f0;
        padding: 0.35rem 1rem;
        border-radius: 25px;
        display: inline-block;
        transition: var(--transition);
    }
    .product-variant:hover {
        background: var(--primary-color);
        color: white;
    }
    .product-price {
        font-weight: 800;
        color: var(--dark-color);
        font-size: 1.15rem;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .quantity-input {
        width: 80px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: var(--border-radius);
        padding: 0.75rem;
        font-weight: 700;
        margin: 0;
        transition: var(--transition);
        font-size: 1.05rem;
    }
    .quantity-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(109, 40, 217, 0.15);
        outline: none;
    }
    .quantity-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--secondary-color);
        border: none;
        border-radius: 50%;
        font-weight: 700;
        color: var(--text-color);
        transition: var(--transition);
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }
    .quantity-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }
    .remove-btn {
        color: #dc2626;
        background: none;
        border: none;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
        cursor: pointer;
    }
    .remove-btn:hover {
        background: rgba(220, 38, 38, 0.1);
        transform: scale(1.1);
        box-shadow: var(--shadow-sm);
    }

    /* ===== Cart Summary ===== */
    .cart-summary {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border-radius: var(--border-radius-lg);
        padding: 3rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 3rem;
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
        width: 100%;
    }
    .cart-summary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at bottom right, rgba(109, 40, 217, 0.05), transparent);
        z-index: 0;
    }
    .cart-summary h5 {
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 2rem;
        font-size: 1.5rem;
        position: relative;
        padding-bottom: 1rem;
        z-index: 1;
    }
    .cart-summary h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 3px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        z-index: 1;
    }
    .summary-row:last-child {
        border-bottom: none;
    }
    .summary-label {
        color: var(--text-light);
        font-size: 1rem;
        font-weight: 600;
    }
    .summary-value {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1rem;
    }
    .summary-total .summary-label {
        font-weight: 800;
        color: var(--dark-color);
        font-size: 1.25rem;
    }
    .summary-total .summary-value {
        font-weight: 800;
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    /* ===== Coupon Table ===== */
    .coupon-table {
        background: #f8fafc;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
    }
    .coupon-table .table {
        margin-bottom: 0;
    }
    .coupon-table th {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .coupon-table td {
        vertical-align: middle;
        font-size: 0.95rem;
    }
    .coupon-table .badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
    .copy-coupon-btn {
        background: var(--secondary-color);
        border: none;
        border-radius: var(--border-radius);
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-color);
        transition: var(--transition);
        cursor: pointer;
    }
    .copy-coupon-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    /* ===== Action Buttons ===== */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 3.5rem;
        gap: 1.5rem;
    }
    .btn-continue {
        background: white;
        color: var(--text-color);
        border: 2px solid rgba(0,0,0,0.08);
        padding: 1.25rem 3rem;
        font-weight: 700;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        box-shadow: var(--shadow-sm);
    }
    .btn-continue:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    .btn-checkout {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        color: white;
        border: none;
        padding: 1.25rem 3.5rem;
        font-weight: 700;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        box-shadow: var(--shadow-md);
    }
    .btn-checkout:hover {
        background: linear-gradient(90deg, var(--primary-hover), var(--accent-color));
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }
    .btn-checkout i {
        margin-left: 0.75rem;
        transition: var(--transition);
    }
    .btn-checkout:hover i {
        transform: translateX(5px);
    }

    /* ===== Animation ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    [data-aos] {
        animation: fadeIn 0.8s ease forwards;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .product-image {
            width: 90px;
            height: 90px;
        }
        .cart-summary {
            padding: 2.5rem;
        }
    }
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        .empty-state {
            padding: 3.5rem;
        }
        .empty-state-icon {
            font-size: 4.5rem;
            padding: 1.5rem;
        }
        .empty-state h4 {
            font-size: 1.5rem;
        }
        .product-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        .product-image {
            margin-bottom: 1.5rem;
        }
        .cart-table td {
            padding: 1.5rem;
        }
        .action-buttons {
            flex-direction: column;
            gap: 1.25rem;
        }
        .btn-continue, .btn-checkout {
            width: 100%;
            justify-content: center;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 2.25rem;
        }
        .empty-state {
            padding: 2.5rem;
        }
        .empty-state-icon {
            font-size: 4rem;
        }
        .empty-state h4 {
            font-size: 1.35rem;
        }
        .empty-state p {
            font-size: 1rem;
        }
        .cart-summary {
            padding: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-6">
    <h1 class="page-title" data-aos="fade">Giỏ hàng của bạn</h1>
    @if(empty($cart) || count($cart) == 0)
        <div class="empty-state" data-aos="fade">
            <div class="empty-state-icon">
                <i class="bi bi-cart-x"></i>
            </div>
            <h4>Giỏ hàng trống</h4>
            <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm mới nhất của chúng tôi và tìm kiếm những món đồ phù hợp với phong cách của bạn!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="cart-table" data-aos="fade">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
    @foreach($cart as $rowId => $item)
    <tr>
        <td>
            <div class="product-info">
                <div class="product-image">
                    @if(!empty($item['image']))
                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                        <i class="bi bi-image" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                    @endif
                </div>
                <div>
                    <div class="product-name">{{ $item['name'] }}</div>

                    {{-- Hiển thị Size đúng thay vì JSON --}}
                    <div class="product-variant">
                        Size:
                        @if(is_array($item['variant']))
                            {{ $item['variant']['size'] ?? '' }}
                        @elseif(is_object($item['variant']))
                            {{ $item['variant']->size ?? '' }}
                        @else
                            {{ $item['variant'] ?? '' }}
                        @endif
                    </div>
                </div>
            </div>
        </td>

        <td class="product-price">
            @if(isset($item['is_flash_sale']) && $item['is_flash_sale'])
                <span style="color: #dc2626; font-weight: bold;">
                    {{ number_format($item['price'], 0, ',', '.') }} ₫
                </span>
                <del class="text-muted ms-2">
                    {{ number_format($item['original_price'], 0, ',', '.') }} ₫
                </del>
            @else
                {{ number_format($item['price'], 0, ',', '.') }} ₫
            @endif
        </td>

        <td>
            <form action="{{ route('cart.update', $rowId) }}" method="POST" class="quantity-control">
                @csrf @method('PATCH')
                <button type="button" class="quantity-btn minus">-</button>
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                <button type="button" class="quantity-btn plus">+</button>
            </form>
        </td>

        <td class="product-price">
            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
        </td>

        <td>
            <form action="{{ route('cart.destroy', $rowId) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="remove-btn" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

            </table>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="cart-summary" data-aos="fade" data-aos-delay="100">
                    <h5>Tóm tắt đơn hàng</h5>

                    @if(!empty($activeCoupons) && count($activeCoupons) > 0)
                    <div class="mb-4 coupon-table" data-aos="fade" data-aos-delay="50">
                        <h5 class="mb-3 fw-bold text-primary">🎁 Các mã giảm giá hiện có:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã</th>
                                        <th>Loại</th>
                                        <th>Giá trị</th>
                                        <th>Đơn tối thiểu</th>
                                        <th>Số lần dùng</th>
                                        <th>Hạn dùng</th>
                                        <th>Phạm vi</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeCoupons as $coupon)
                                    <tr>
                                        <td><span class="badge bg-warning text-dark">{{ $coupon->code }}</span></td>
                                        <td>{{ $coupon->type === 'fixed' ? 'Cố định' : 'Phần trăm' }}</td>
                                        <td>
                                            {{ $coupon->type === 'fixed'
                                                ? number_format($coupon->value, 0, ',', '.') . ' ₫'
                                                : $coupon->value . '%' }}
                                        </td>
                                        <td>{{ number_format($coupon->min_order_amount ?? 0, 0, ',', '.') }} ₫</td>
                                        <td>{{ $coupon->usage_limit ?? '∞' }}</td>
                                        <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Không giới hạn' }}</td>
                                        <td>
                                            @if($coupon->scope === 'all')
                                                Tất cả
                                            @elseif($coupon->scope === 'category')
                                                Danh mục:
                                                @php
                                                    $categoryNames = [$coupon->category?->name ?? ''];
                                                @endphp
                                                <span class="text-muted">{{ implode(', ', $categoryNames) }}</span>
                                            @elseif($coupon->scope === 'product')
                                                Sản phẩm chỉ định
                                            @endif
                                        </td>
                                        <td>
                                            <button class="copy-coupon-btn" onclick="copyCoupon('{{ $coupon->code }}')">Sao chép</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    {{-- Coupon quay trúng từ vòng quay may mắn --}}
@if(!empty($wonCoupons))
    <div class="mt-4 p-4 rounded shadow-sm" style="background: linear-gradient(135deg, #ffefba, #ffffff); border: 2px dashed #ff9800;">
        <h5 class="fw-bold text-danger mb-3">
            🎉 Chúc mừng! Bạn đã quay trúng mã giảm giá
        </h5>
        <div class="d-flex flex-wrap gap-2">
            @foreach($wonCoupons as $code)
                <div class="coupon-box d-flex align-items-center justify-content-between px-3 py-2 rounded"
                     style="background: #fff8e1; border: 1px solid #ffb74d; min-width: 180px;">
                    <span class="coupon-code fw-bold text-dark me-2">{{ $code }}</span>
                    <button class="btn btn-sm btn-outline-danger copy-btn"
                            data-code="{{ $code }}">
                        📋 Sao chép
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endif


                    <form action="{{ route('coupon.apply') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã giảm giá" required>
                            <button class="btn btn-primary" type="submit" style="background: linear-gradient(90deg, var(--primary-color), var(--accent-color)); border: none;">Áp dụng</button>
                        </div>
                        @if(session('coupon'))
    <div class="mt-2">
        <small class="text-success">
            Đã áp dụng mã: <strong>{{ session('coupon.code') }}</strong>
        </small>

        <form action="{{ route('coupon.remove') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="code" value="{{ session('coupon.code') }}">
            <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline">
                [Xoá mã]
            </button>
        </form>
    </div>
@endif


                        @if(session('coupon_error'))
                            <small class="text-danger d-block mt-2">{{ session('coupon_error') }}</small>
                        @endif
                    </form>

                    @php
                        $subtotal = array_reduce($cart, function($carry, $item) {
                            return $carry + ($item['price'] * $item['quantity']);
                        }, 0);
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
                        <span class="summary-value">30.000 ₫</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span class="summary-label">Tổng cộng:</span>
                        <span class="summary-value">
                            {{ number_format($subtotal - (session('coupon.discount') ?? 0) + 30000, 0, ',', '.') }} ₫
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons" data-aos="fade" data-aos-delay="200">
            <a href="{{ route('products.index') }}" class="btn btn-continue">
                <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
            </a>
            <a href="{{ route('checkout.index') }}" class="btn btn-checkout">
                Thanh toán <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Quantity control buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value);

            if (this.classList.contains('minus') && value > 1) {
                input.value = value - 1;
            } else if (this.classList.contains('plus')) {
                input.value = value + 1;
            }

            // Submit the form when quantity changes
            this.parentElement.submit();
        });
    });

    // Copy coupon code
    function copyCoupon(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Đã sao chép mã: ' + code);
        }).catch(() => {
            alert('Không thể sao chép mã!');
        });
    }

    // Enhanced fade-in animation for elements
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('[data-aos]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.2 });

        animatedElements.forEach(el => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });
    });
</script>

{{-- JS copy to clipboard --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code).then(() => {
                        alert("✅ Đã sao chép mã: " + code);
                    });
                });
            });
        });
    </script>
@endpush
@endsection
