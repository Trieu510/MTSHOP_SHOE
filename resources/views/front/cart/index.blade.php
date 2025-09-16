@extends('layouts.front')

@section('title', 'Giỏ hàng')

@push('styles')
<style>
    /* ===== Global Variables ===== */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --accent-color: #ec4899;
        --secondary-color: #f8fafc;
        --dark-color: #1e293b;
        --text-color: #334155;
        --text-light: #64748b;
        --border-radius: 8px;
        --border-radius-lg: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        --transition: all 0.3s ease;
    }

    /* ===== Page Title ===== */
    .page-title {
        font-family: 'Inter', sans-serif;
        font-size: 2.75rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 2.5rem;
        position: relative;
        display: inline-block;
        letter-spacing: -0.025em;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    /* ===== Empty State ===== */
    .empty-state {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 5rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
        margin: 4rem 0;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .empty-state-icon {
        font-size: 5rem;
        color: #e2e8f0;
        margin-bottom: 2rem;
        display: inline-flex;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 50%;
    }
    .empty-state h4 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1.25rem;
        font-size: 1.5rem;
    }
    .empty-state p {
        color: var(--text-light);
        margin-bottom: 2.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
        font-size: 1.05rem;
    }
    .empty-state .btn {
        padding: 1rem 2.5rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        font-size: 1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
    }

    /* ===== Cart Table ===== */
    .cart-table {
        background: white;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 3.5rem;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .cart-table table {
        margin-bottom: 0;
    }
    .cart-table thead th {
        background: var(--secondary-color);
        font-weight: 700;
        color: var(--dark-color);
        padding: 1.5rem;
        border-bottom: none;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-top: none;
    }
    .cart-table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .cart-table tbody tr:last-child {
        border-bottom: none;
    }
    .cart-table tbody tr:hover {
        background: rgba(241, 245, 249, 0.5);
    }
    .cart-table td {
        padding: 1.5rem;
        vertical-align: middle;
        border-top: 1px solid rgba(0,0,0,0.03);
    }
    .product-info {
        display: flex;
        align-items: center;
    }
    .product-image {
        width: 90px;
        height: 90px;
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-right: 1.75rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .product-image:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-sm);
    }
    .product-image:hover img {
        transform: scale(1.08);
    }
    .product-name {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .product-variant {
        font-size: 0.9rem;
        color: var(--text-light);
        background: #f1f5f9;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-block;
    }
    .product-price {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1.1rem;
    }
    .quantity-control {
        display: flex;
        align-items: center;
    }
    .quantity-input {
        width: 70px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        padding: 0.65rem;
        font-weight: 600;
        margin: 0 0.5rem;
        transition: var(--transition);
        font-size: 1rem;
    }
    .quantity-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        outline: none;
    }
    .quantity-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--secondary-color);
        border: none;
        border-radius: 50%;
        font-weight: 600;
        color: var(--text-color);
        transition: var(--transition);
        cursor: pointer;
    }
    .quantity-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .remove-btn {
        color: #ef4444;
        background: none;
        border: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
        cursor: pointer;
    }
    .remove-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        transform: translateY(-2px);
    }

    /* ===== Cart Summary ===== */
    .cart-summary {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2.5rem;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .cart-summary h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    .cart-summary h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .summary-row:last-child {
        border-bottom: none;
    }
    .summary-label {
        color: var(--text-light);
        font-size: 0.95rem;
    }
    .summary-value {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95rem;
    }
    .summary-total .summary-label {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1.1rem;
    }
    .summary-total .summary-value {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.3rem;
    }

    /* ===== Action Buttons ===== */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 3rem;
    }
    .btn-continue {
        background: white;
        color: var(--text-color);
        border: 2px solid rgba(0,0,0,0.1);
        padding: 1rem 2.5rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        font-size: 1rem;
    }
    .btn-continue:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .btn-checkout {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 1rem 3rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        font-size: 1rem;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
    }
    .btn-checkout:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .btn-checkout i {
        margin-left: 0.75rem;
        transition: var(--transition);
    }
    .btn-checkout:hover i {
        transform: translateX(3px);
    }

    /* ===== Animation ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    [data-aos] {
        animation: fadeIn 0.6s ease forwards;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .product-image {
            width: 80px;
            height: 80px;
            margin-right: 1.25rem;
        }
        .cart-summary {
            padding: 2rem;
        }
    }
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.25rem;
        }
        .empty-state {
            padding: 3rem;
        }
        .empty-state-icon {
            font-size: 4rem;
            padding: 1.25rem;
        }
        .empty-state h4 {
            font-size: 1.35rem;
        }
        .product-info {
            flex-direction: column;
            align-items: flex-start;
        }
        .product-image {
            margin-bottom: 1.25rem;
            margin-right: 0;
        }
        .cart-table td {
            padding: 1.25rem;
        }
        .action-buttons {
            flex-direction: column;
            gap: 1rem;
        }
        .btn-continue, .btn-checkout {
            width: 100%;
            justify-content: center;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 2rem;
        }
        .empty-state {
            padding: 2rem;
        }
        .empty-state-icon {
            font-size: 3.5rem;
        }
        .empty-state h4 {
            font-size: 1.25rem;
        }
        .empty-state p {
            font-size: 0.95rem;
        }
        .cart-summary {
            padding: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <h1 class="page-title" data-aos="fade">Giỏ hàng của bạn</h1>

    @if(isset($activeCoupons) && $activeCoupons->count())
<div class="mb-4" data-aos="fade" data-aos-delay="50">
    <div class="p-4 rounded shadow-sm bg-light border">
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

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif



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
                                    @if($item['image'])
                                    <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                                    @else
                                    <i class="bi bi-image" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="product-name">{{ $item['name'] }}</div>
                                    <div class="product-variant">Size: {{ $item['variant'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="product-price">
    @if(isset($item['is_flash_sale']) && $item['is_flash_sale'])
        <span style="color: red; font-weight: bold;">
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
                        <td class="product-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫</td>
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
            <div class="col-lg-5 offset-lg-7">
                <div class="cart-summary" data-aos="fade" data-aos-delay="100">
                    <h5>Tóm tắt đơn hàng</h5>
                    <form action="{{ route('coupon.apply') }}" method="POST" class="mb-3">
    @csrf
    <div class="input-group">
        <input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã giảm giá" required>
        <button class="btn btn-primary" type="submit">Áp dụng</button>
    </div>
    @if(session('coupon'))
        <small class="text-success d-block mt-2">
            Đã áp dụng mã: <strong>{{ session('coupon.code') }}</strong>
            <a href="{{ route('coupon.remove') }}" class="text-danger ms-2">[Xoá mã]</a>
        </small>
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
    @if(session('coupon'))
<div class="summary-row">
    <span class="summary-label">Giảm giá ({{ session('coupon.code') }}):</span>
    <span class="summary-value">-{{ number_format(session('coupon.discount'), 0, ',', '.') }} ₫</span>
</div>
@endif

    <span class="summary-value">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
</div>

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

    // Simple fade-in animation for elements
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('[data-aos]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(el => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    });
</script>
@endpush
@endsection
