@extends('layouts.front')

@section('title', 'Lịch sử đơn hàng')

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #a5b4fc;
        --danger: #ef4444;
        --warning: #f59e0b;
        --success: #10b981;
        --dark: #1e293b;
        --medium: #475569;
        --light: #64748b;
        --lighter: #e2e8f0;
        --lightest: #f8fafc;
        --white: #ffffff;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
    }

    /* ===== Base Layout ===== */
    .order-history {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 1.5rem;
        position: relative;
    }

    /* ===== Animated Background ===== */
    .order-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }
    .order-bg .particle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(79,70,229,0.08) 100%);
        filter: blur(20px);
        animation: float 15s infinite ease-in-out;
    }
    .order-bg .particle-1 {
        width: 300px;
        height: 300px;
        top: 10%;
        right: -50px;
        animation-delay: 0s;
    }
    .order-bg .particle-2 {
        width: 200px;
        height: 200px;
        bottom: 10%;
        left: -50px;
        animation-delay: 3s;
    }
    .order-bg .particle-3 {
        width: 150px;
        height: 150px;
        top: 40%;
        left: 20%;
        animation-delay: 6s;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    /* ===== Page Header ===== */
    .order-header {
        margin-bottom: 3rem;
        position: relative;
    }
    .order-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }
    .order-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 4px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .order-subtitle {
        color: var(--medium);
        font-size: 1.1rem;
        max-width: 600px;
    }

    /* ===== Status Filter ===== */
    .status-filter {
        display: flex;
        gap: 0.75rem;
        margin: 2rem 0;
        flex-wrap: wrap;
    }
    .status-tab {
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        color: var(--medium);
        border: 1px solid var(--lighter);
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
    }
    .status-tab::before {
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
    .status-tab:hover {
        color: var(--primary);
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .status-tab.active {
        color: white;
        border-color: transparent;
        box-shadow: var(--shadow-md);
    }
    .status-tab.active::before {
        opacity: 1;
    }

    /* ===== Order Cards ===== */
    .order-card {
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(15px);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255,255,255,0.3);
        margin-bottom: 2.5rem;
        overflow: hidden;
        transition: var(--transition);
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(255,255,255,0.5);
    }

    /* Card Header */
    .order-card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-card-id {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }
    .order-card-date {
        opacity: 0.9;
        font-size: 0.95rem;
    }
    .order-status {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending {
        background: rgba(255,255,255,0.2);
    }
    .status-processing {
        background: rgba(6,182,212,0.2);
    }
    .status-completed {
        background: rgba(16,185,129,0.2);
    }
    .status-cancelled {
        background: rgba(239,68,68,0.2);
    }

    /* Card Body */
    .order-card-body {
        padding: 2rem;
    }

    /* Address Section */
    .address-section {
        background: rgba(241,245,249,0.5);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(226,232,240,0.5);
    }
    .address-title {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .address-title i {
        color: var(--primary);
    }
    .address-content {
        line-height: 1.6;
    }
    .address-form {
        margin-top: 1rem;
    }
    .address-form .form-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .address-input {
        flex: 1;
        min-width: 250px;
        padding: 0.8rem 1.2rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--lighter);
        background: rgba(255,255,255,0.8);
        transition: var(--transition);
    }
    .address-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .address-btn {
        padding: 0.8rem 1.5rem;
        border-radius: var(--radius-sm);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .address-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Order Summary */
    .order-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px dashed var(--lighter);
    }
    .summary-item {
        background: rgba(241,245,249,0.5);
        border-radius: var(--radius-md);
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(226,232,240,0.5);
        transition: var(--transition);
    }
    .summary-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }
    .summary-label {
        font-size: 0.9rem;
        color: var(--medium);
        margin-bottom: 0.5rem;
    }
    .summary-value {
        font-weight: 700;
        color: var(--dark);
        font-size: 1.2rem;
    }
    .summary-total {
        color: var(--primary);
        font-size: 1.3rem;
    }

    /* Order Items */
    .order-items-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .order-items-title::before {
        content: '';
        display: block;
        width: 20px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 2px;
    }
    .order-item {
        display: flex;
        padding: 1.25rem;
        border-radius: var(--radius-md);
        background: rgba(241,245,249,0.5);
        margin-bottom: 1rem;
        transition: var(--transition);
        align-items: center;
        border: 1px solid rgba(226,232,240,0.5);
    }
    .order-item:last-child {
        margin-bottom: 0;
    }
    .order-item:hover {
        background: rgba(241,245,249,0.8);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .order-item-img {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        margin-right: 1.5rem;
        border: 1px solid rgba(226,232,240,0.5);
        transition: var(--transition);
    }
    .order-item:hover .order-item-img {
        transform: scale(1.05);
    }
    .order-item-details {
        flex: 1;
    }
    .order-item-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .order-item-variant {
        font-size: 0.9rem;
        color: var(--medium);
        margin-bottom: 0.75rem;
    }
    .order-item-price {
        font-weight: 700;
        color: var(--dark);
        font-size: 1.1rem;
    }
    .order-item-qty {
        font-size: 0.9rem;
        color: var(--medium);
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    .order-btn {
        padding: 0.8rem 1.75rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
    }
    .order-btn i {
        transition: var(--transition);
    }
    .order-btn:hover i {
        transform: translateX(3px);
    }
    .btn-cancel {
        background: rgba(239,68,68,0.1);
        color: var(--danger);
    }
    .btn-cancel:hover {
        background: rgba(239,68,68,0.2);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .btn-reorder {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: var(--shadow-sm);
    }
    .btn-reorder:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Recommended Products */
    .recommended-section {
        background: rgba(241,245,249,0.3);
        border-top: 1px dashed var(--lighter);
        padding: 2rem;
    }
    .recommended-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .recommended-title::before {
        content: '';
        display: block;
        width: 20px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 2px;
    }
    .recommended-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    .product-card {
        background: white;
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(226,232,240,0.5);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .product-img {
        height: 180px;
        overflow: hidden;
    }
    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img img {
        transform: scale(1.1);
    }
    .product-info {
        padding: 1.25rem;
    }
    .product-name {
        font-size: 1rem;
        color: var(--dark);
        margin-bottom: 0.75rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
    }

    /* Empty State */
    .empty-state {
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255,255,255,0.3);
        margin: 3rem 0;
        transition: var(--transition);
    }
    .empty-state:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .empty-icon {
        font-size: 4rem;
        color: var(--lighter);
        margin-bottom: 1.5rem;
        display: inline-block;
        transition: var(--transition);
    }
    .empty-state:hover .empty-icon {
        transform: scale(1.1);
        color: var(--primary-light);
    }
    .empty-text {
        font-size: 1.25rem;
        color: var(--medium);
        margin-bottom: 1.5rem;
    }
    .empty-btn {
        padding: 0.8rem 2rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .empty-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Success Alert */
    .order-alert {
        background: rgba(16,185,129,0.1);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-md);
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-sm);
        color: var(--success);
        border-left: 4px solid var(--success);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: 1px solid rgba(255,255,255,0.3);
    }
    .order-alert:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Responsive Adjustments */
    @media (max-width: 1024px) {
        .order-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .order-title {
            font-size: 2rem;
        }
        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .order-actions {
            flex-direction: column;
        }
        .order-btn {
            width: 100%;
            justify-content: center;
        }
    }
    @media (max-width: 576px) {
        .order-history {
            padding: 0 1rem;
        }
        .order-title {
            font-size: 1.8rem;
        }
        .order-summary {
            grid-template-columns: 1fr;
        }
        .order-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .order-item-img {
            width: 100%;
            height: auto;
            aspect-ratio: 1/1;
            margin-right: 0;
            margin-bottom: 1rem;
        }
        .recommended-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .rating-stars {
    display: flex;
    gap: 8px;
    cursor: pointer;
}

.star-icon {
    font-size: 28px;
    color: #ccc;
    transition: color 0.3s;
}

.star-icon.selected {
    color: #fbbf24; /* Màu vàng cho sao đã chọn */
}

.star-icon.hovered {
    color: #fde68a; /* Màu vàng nhạt khi hover */
}

</style>
@endpush

@section('content')
<div class="order-history">
    <!-- Animated Background -->
    <div class="order-bg">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    @if(session('success'))
        <div class="order-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="order-header">
        <h1 class="order-title">Lịch sử đơn hàng</h1>
        <p class="order-subtitle">Xem lại chi tiết các đơn hàng bạn đã đặt và trạng thái hiện tại của chúng</p>
    </div>

    <!-- Status Filter -->
    @php
        $statuses = [
            'all' => 'Tất cả',
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã huỷ',
        ];
        $activeStatus = request('status', 'all');
    @endphp

    <div class="status-filter">
        @foreach($statuses as $key => $label)
            <a href="{{ route('orders.index', ['status' => $key]) }}"
               class="status-tab {{ $activeStatus === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($orders->count())
        @foreach($orders as $order)
        <div class="order-card">
            <!-- Card Header -->
            <div class="order-card-header">
                <div>
                    <div class="order-card-id">Đơn hàng #{{ $order->id }}</div>
                    <div class="order-card-date">Đặt vào {{ $order->created_at->format('H:i d/m/Y') }}</div>
                </div>
                <div class="order-status status-{{ $order->status }}">
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'processing' => 'Đang giao hàng',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã huỷ',
                        ];
                    @endphp
                    {{ $statusLabels[$order->status] ?? 'Không rõ' }}
                </div>
            </div>

            <!-- Card Body -->
            <div class="order-card-body">
                <!-- Address Section -->
                <div class="address-section">
                    <h3 class="address-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Địa chỉ giao hàng
                    </h3>
                    <div class="address-content">
                        {{ $order->address }}
                    </div>

                    @if($order->status === 'pending')
                    <form action="{{ route('orders.updateAddress', $order->id) }}" method="POST" class="address-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" name="address"
                                   class="address-input"
                                   value="{{ $order->address }}"
                                   placeholder="Cập nhật địa chỉ mới"
                                   required>
                            <button type="submit" class="address-btn">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="summary-item">
                        <div class="summary-label">Số lượng sản phẩm</div>
                        <div class="summary-value">{{ $order->items->sum('quantity') }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Tạm tính</div>
                        <div class="summary-value">{{ number_format($order->subtotal,0) }} ₫</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Phí vận chuyển</div>
                        <div class="summary-value">{{ number_format($order->shipping_fee,0) }} ₫</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Tổng cộng</div>
                        <div class="summary-value summary-total">{{ number_format($order->total_amount,0) }} ₫</div>
                    </div>
                </div>



                <!-- Order Items -->
                <h3 class="order-items-title">Sản phẩm đã đặt</h3>
                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <img src="{{ asset('storage/' . optional($item->variant->product->images->first())->path) }}"
                             alt="{{ $item->product_name }}"
                             class="order-item-img"
                             loading="lazy">

                        <div class="order-item-details">
                            <div class="order-item-name">{{ $item->product_name }}</div>
                            <div class="order-item-variant">Size {{ $item->variant->size }} • {{ $item->variant->color }}</div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="order-item-price">{{ number_format($item->price,0) }} ₫</div>
                                <div class="order-item-qty">Số lượng: x{{ $item->quantity }}</div>
                            </div>
                        </div>
                    </div>
                    @if($order->status === 'completed')
    @if($item->isReviewedBy(auth()->id()))
        <!-- ✅ Nếu đã đánh giá -->
        <div class="mt-2 text-success fw-bold">
            ✅ Đã đánh giá sản phẩm này
        </div>
    @else
        <!-- Nếu chưa đánh giá -->
        <div class="mt-3">
            <!-- Nút mở form -->
            <button class="btn btn-sm btn-outline-primary" onclick="toggleReviewForm({{ $item->id }})">
                <i class="fas fa-star"></i> Đánh giá sản phẩm
            </button>

            <!-- Form đánh giá -->
            <form action="{{ route('products.reviews.store', $item->product->slug) }}"
                  method="POST"
                  class="mt-2 d-none"
                  id="review-form-{{ $item->id }}"
                  onsubmit="return submitReview(event, {{ $item->id }})">
                @csrf
                <div class="mb-2">
                    <label>Chọn sao:</label><br>
                    <div class="rating-stars" data-rating="0">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star-icon" data-value="{{ $i }}"></i>
                        @endfor
                        <input type="hidden" name="rating" required>
                    </div>
                </div>
                <div class="mb-2">
                    <textarea name="comment" class="form-control" rows="2" placeholder="Viết đánh giá..."></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success">Gửi đánh giá</button>
            </form>
        </div>
    @endif
@endif

                    @endforeach
                </div>

                <!-- Order Actions -->
                <div class="order-actions">
                    @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="order-btn btn-cancel">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="order-btn btn-reorder">
                            <i class="fas fa-shopping-cart"></i> Đặt lại
                        </button>

                        @if($order->status === 'completed')
    <a href="{{ route('returns.create', $order->id) }}" class="order-btn btn-reorder" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <i class="fas fa-undo-alt"></i> Yêu cầu trả hàng
    </a>
@endif

                    </form>
                </div>
            </div>

            <!-- Recommended Products -->
            @if($order->recommendedProducts->count())
            <div class="recommended-section">
                <h3 class="recommended-title">Gợi ý cho bạn</h3>
                <div class="recommended-grid">
                    @foreach($order->recommendedProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                        <div class="product-img">
                            <img src="{{ asset('storage/' . optional($product->images->first())->path) }}"
                                 alt="{{ $product->name }}"
                                 loading="lazy">
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <div class="product-price">{{ number_format($product->price, 0) }} ₫</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="far fa-calendar-times"></i>
            </div>
            <h3 class="empty-text">Bạn chưa có đơn hàng nào</h3>
            <a href="{{ route('products.index') }}" class="empty-btn">
                <i class="fas fa-shopping-bag"></i> Mua sắm ngay
            </a>
        </div>
    @endif
</div>
@push('scripts')
<script>
    function toggleReviewForm(itemId) {
        const form = document.getElementById('review-form-' + itemId);
        if (form) {
            form.classList.toggle('d-none');
        }
    }
</script>
<script>
    document.querySelectorAll('.rating-stars').forEach(container => {
        const stars = container.querySelectorAll('.star-icon');
        const input = container.querySelector('input[name="rating"]');

        stars.forEach(star => {
            // Click để chọn sao
            star.addEventListener('click', function () {
                const rating = parseInt(this.dataset.value);
                input.value = rating;

                stars.forEach(s => {
                    const val = parseInt(s.dataset.value);
                    s.classList.toggle('selected', val <= rating);
                });
            });

            // Hover để highlight tạm thời
            star.addEventListener('mouseover', function () {
                const hoverVal = parseInt(this.dataset.value);
                stars.forEach(s => {
                    const val = parseInt(s.dataset.value);
                    s.classList.toggle('hovered', val <= hoverVal);
                });
            });

            // Rời chuột khỏi dãy sao
            star.addEventListener('mouseleave', function () {
                stars.forEach(s => s.classList.remove('hovered'));
            });
        });
    });
</script>
<script>
    function submitReview(event, itemId) {
        event.preventDefault(); // Ngăn reload form

        const form = document.getElementById('review-form-' + itemId);
        const done = document.getElementById('review-done-' + itemId);

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                form.classList.add('d-none');
                done.classList.remove('d-none');
            } else {
                alert("Đã xảy ra lỗi khi gửi đánh giá. Vui lòng thử lại.");
            }
        });

        return false;
    }
</script>
@endpush
@endsection
