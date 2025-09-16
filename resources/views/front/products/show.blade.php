@extends('layouts.front')

@section('title', $product->name)

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-effect: rgba(255, 255, 255, 0.15);
        --text-dark: #1e293b;
        --text-light: #64748b;
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition-all: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Flash Messages ===== */
    .alert {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-sm);
        font-weight: 500;
        transition: var(--transition-all);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .alert-success {
        background: rgba(236, 253, 245, 0.7);
        color: #065f46;
        border-left: 4px solid #10b981;
    }
    .alert-danger {
        background: rgba(254, 242, 242, 0.7);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    /* ===== Breadcrumbs ===== */
    .breadcrumb {
        padding: 0.75rem 0;
    }
    .breadcrumb-item a {
        color: #6366f1;
        text-decoration: none;
        transition: var(--transition-all);
    }
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    .breadcrumb-item.active {
        color: var(--text-light);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-light);
    }

    /* ===== Product Gallery ===== */
    .product-gallery {
        position: relative;
    }
    .main-image-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition-all);
    }
    .main-image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .main-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .main-image-container:hover .main-image {
        transform: scale(1.05);
    }
    .thumbnail-container {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid rgba(203, 213, 225, 0.5);
        cursor: pointer;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
    }
    .thumbnail:hover {
        border-color: #6366f1;
        transform: translateY(-3px);
    }
    .discount-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    /* ===== Product Info ===== */
    .product-info {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        height: 100%;
    }
    .product-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 1rem;
    }
    .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #dc2626;
        margin-bottom: 1.5rem;
    }
    .product-price-original {
        font-size: 1.2rem;
        color: var(--text-light);
        text-decoration: line-through;
        margin-left: 0.75rem;
    }
    .product-description {
        color: var(--text-light);
        line-height: 1.8;
        margin-bottom: 2rem;
    }
    .product-details {
        border: 1px solid rgba(203, 213, 225, 0.3);
        border-radius: 12px;
        padding: 1.25rem;
        background: rgba(255, 255, 255, 0.5);
        margin-bottom: 1.5rem;
    }
    .product-details li {
        margin-bottom: 0.5rem;
        display: flex;
    }
    .product-details li strong {
        min-width: 100px;
        color: var(--text-dark);
    }
    .rating-container {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    .rating-stars {
        color: #f59e0b;
        font-size: 1.2rem;
        margin-right: 0.5rem;
    }
    .rating-value {
        font-weight: 600;
        color: var(--text-dark);
        margin-right: 0.5rem;
    }
    .rating-count {
        color: var(--text-light);
        font-size: 0.9rem;
    }
    .no-rating {
        color: var(--text-light);
    }

    /* ===== Support Icons ===== */
    .support-icons {
        border-top: 1px dashed rgba(203, 213, 225, 0.5);
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
    .support-icon {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    .support-text {
        font-size: 0.85rem;
        color: var(--text-light);
    }

    /* ===== Add to Cart Form ===== */
    .add-to-cart-form {
        margin-bottom: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }
    .form-select, .quantity-input {
        border-radius: 12px;
        border: 1px solid rgba(203, 213, 225, 0.5);
        padding: 0.85rem 1.25rem;
        font-size: 0.95rem;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
    }
    .form-select:focus, .quantity-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: white;
    }
    .quantity-input {
        width: 80px;
        text-align: center;
    }
    .btn-add-to-cart {
        border-radius: 12px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: var(--primary-gradient);
        color: white;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .btn-add-to-cart::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transition: var(--transition-all);
        z-index: -1;
    }
    .btn-add-to-cart:hover::before {
        width: 100%;
    }
    .btn-add-to-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }
    .btn-buy-now {
        border-radius: 12px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        color: white;
        border: none;
    }
    .btn-buy-now:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
    }

    /* ===== Color Variants ===== */
    .color-variants {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: var(--transition-all);
    }
    .color-option:hover {
        transform: scale(1.1);
    }
    .color-option.active {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px white, 0 0 0 4px #6366f1;
    }

    /* ===== Wishlist Button ===== */
    .wishlist-btn {
        border-radius: 12px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(220, 38, 38, 0.5);
        color: #dc2626;
    }
    .wishlist-btn:hover {
        background: rgba(220, 38, 38, 0.1);
        transform: translateY(-3px);
    }
    .wishlist-btn.active {
        background: rgba(220, 38, 38, 0.1);
        border-color: #dc2626;
    }
    .wishlist-btn i {
        margin-right: 0.5rem;
    }

    /* Wishlist Icon for Product Cards */
    .wishlist-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.85);
        border-radius: 50%;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: var(--transition-all);
        z-index: 2;
    }
    .wishlist-icon:hover {
        background: #ef4444;
        color: white;
    }
    .wishlist-icon.active {
        color: #dc2626;
    }
    .wishlist-icon i {
        font-size: 1rem;
    }

    /* ===== Reviews Section ===== */
    .reviews-section {
        margin-top: 4rem;
    }
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        position: relative;
        padding-left: 1.5rem;
    }
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary-gradient);
    }
    .review-form-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 2rem;
    }
    .review-form textarea {
        border-radius: 12px;
        border: 1px solid rgba(203, 213, 225, 0.5);
        padding: 1rem;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
    }
    .review-form textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: white;
    }
    .btn-submit-review {
        border-radius: 12px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: var(--primary-gradient);
        color: white;
        border: none;
    }
    .btn-submit-review:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }
    .login-prompt {
        color: var(--text-light);
        margin-bottom: 2rem;
    }
    .login-link {
        color: #6366f1;
        font-weight: 500;
        text-decoration: none;
    }
    .login-link:hover {
        text-decoration: underline;
    }
    .review-item {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 1.5rem;
        transition: var(--transition-all);
    }
    .review-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .review-user {
        font-weight: 600;
        color: var(--text-dark);
    }
    .review-stars {
        color: #f59e0b;
        margin-left: 1rem;
    }
    .review-actions {
        display: flex;
        gap: 0.5rem;
    }
    .review-btn {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        transition: var(--transition-all);
    }
    .review-btn-edit {
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        border: none;
    }
    .review-btn-edit:hover {
        background: rgba(99, 102, 241, 0.2);
    }
    .review-btn-delete {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
        border: none;
    }
    .review-btn-delete:hover {
        background: rgba(220, 38, 38, 0.2);
    }
    .review-text {
        color: var(--text-light);
        line-height: 1.7;
        margin-bottom: 0.5rem;
    }
    .review-date {
        color: var(--text-light);
        font-size: 0.85rem;
    }
    .edit-review-form {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed rgba(203, 213, 225, 0.5);
    }
    .no-reviews {
        color: var(--text-light);
        text-align: center;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
    }

    /* ===== Recommended Products ===== */
    .recommended-products {
        margin-top: 4rem;
    }
    .recommended-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition-all);
        height: 100%;
    }
    .recommended-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .recommended-img-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    .recommended-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .recommended-card:hover .recommended-img {
        transform: scale(1.1);
    }
    .recommended-body {
        padding: 1.5rem;
        text-align: center;
    }
    .recommended-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .recommended-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #dc2626;
        margin-bottom: 1rem;
    }
    .btn-view-details {
        border-radius: 12px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        border: none;
    }
    .btn-view-details:hover {
        background: rgba(99, 102, 241, 0.2);
        transform: translateY(-2px);
    }
    .no-recommended {
        color: var(--text-light);
        text-align: center;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
    }

    /* ===== Background Elements ===== */
    .product-bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .product-bg-elements .circle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }
    .product-bg-elements .circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }
    .product-bg-elements .circle-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
    }

    /* ===== Size Guide Table ===== */
.size-guide {
    margin-top: 1.5rem;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
.size-guide h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
}
.size-guide table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1.5rem;
}
.size-guide th, .size-guide td {
    padding: 0.75rem;
    text-align: center;
    border: 1px solid rgba(203, 213, 225, 0.5);
    color: var(--text-dark);
}
.size-guide th {
    background: rgba(99, 102, 241, 0.1);
    font-weight: 600;
}
.size-guide td {
    background: rgba(255, 255, 255, 0.8);
}
.care-instructions {
    color: var(--text-light);
    line-height: 1.7;
}
.care-instructions h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
}
.care-instructions ul {
    padding-left: 1.25rem;
}
.care-instructions li {
    margin-bottom: 0.5rem;
}

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1200px) {
        .main-image {
            height: 400px;
        }
    }
    @media (max-width: 992px) {
        .product-title {
            font-size: 1.8rem;
        }
        .product-price {
            font-size: 1.6rem;
        }
        .main-image {
            height: 350px;
        }
    }
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.6rem;
        }
        .product-price {
            font-size: 1.4rem;
        }
        .main-image {
            height: 300px;
        }
        .thumbnail {
            width: 60px;
            height: 60px;
        }
        .product-info,
        .review-form-card {
            padding: 1.5rem;
        }
        .review-item {
            padding: 1.25rem;
        }
    }
    @media (max-width: 576px) {
        .product-title {
            font-size: 1.4rem;
        }
        .product-price {
            font-size: 1.2rem;
        }
        .main-image {
            height: 250px;
        }
        .thumbnail {
            width: 50px;
            height: 50px;
        }
        .product-info,
        .review-form-card {
            padding: 1.25rem;
        }
        .add-to-cart-form .d-flex {
            flex-direction: column;
            gap: 1rem;
        }
        .add-to-cart-form .quantity-input {
            width: 100%;
        }
        .support-icons .col {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 position-relative">
    <!-- Background elements -->
    <div class="product-bg-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent px-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success mb-4" data-aos="fade-up">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4" data-aos="fade-up">{{ session('error') }}</div>
    @endif

    @php
        $isInWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
    @endphp

    <div class="row g-4">
        {{-- Gallery --}}
        <div class="col-lg-6 product-gallery" data-aos="zoom-in" data-aos-delay="100">
            <div class="main-image-container">
                @if($product->discount > 0)
                <span class="discount-badge">-{{ $product->discount }}%</span>
                @endif
                <img id="mainImage"
                     src="{{ asset('storage/'.$product->images->first()->path) }}"
                     class="main-image"
                     alt="{{ $product->name }}">
            </div>
            <div class="thumbnail-container">
                @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->path) }}"
                         class="thumbnail"
                         alt="{{ $product->name }}"
                         onclick="document.getElementById('mainImage').src='{{ asset('storage/'.$img->path) }}'">
                @endforeach
            </div>
            <div class="size-guide">
    <h4>Hướng dẫn chọn size</h4>
    <table>
        <thead>
            <tr>
                <th>Size</th>
                <th>Độ dài chân (cm)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>35</td><td>22.0 - 22.5</td></tr>
            <tr><td>36</td><td>22.5 - 23.0</td></tr>
            <tr><td>37</td><td>23.0 - 23.5</td></tr>
            <tr><td>38</td><td>23.5 - 24.0</td></tr>
            <tr><td>39</td><td>24.0 - 24.5</td></tr>
            <tr><td>40</td><td>24.5 - 25.0</td></tr>
            <tr><td>41</td><td>25.0 - 25.5</td></tr>
            <tr><td>42</td><td>25.5 - 26.0</td></tr>
            <tr><td>43</td><td>26.0 - 26.5</td></tr>
            <tr><td>44</td><td>26.5 - 27.0</td></tr>
            <tr><td>45</td><td>27.0 - 27.5</td></tr>
        </tbody>
    </table>
    <div class="care-instructions">
        <h5>Hướng dẫn bảo quản</h5>
        <ul>
            <li>Lau sạch giày bằng khăn ẩm và chất tẩy rửa nhẹ, không sử dụng chất tẩy mạnh.</li>
            <li>Phơi giày ở nơi khô ráo, thoáng mát, tránh ánh nắng trực tiếp.</li>
            <li>Bảo quản giày trong hộp hoặc túi chống ẩm khi không sử dụng.</li>
            <li>Không giặt giày bằng máy giặt để tránh làm hỏng chất liệu.</li>
        </ul>
    </div>
</div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>

                @php
    $flashPrice = $product->flash_sale_price;
@endphp

<div class="product-price">
    @if ($flashPrice)
        <span class="text-danger fw-bold">{{ number_format($flashPrice, 0, ',', '.') }} ₫</span>
        <span class="product-price-original text-muted text-decoration-line-through">
            {{ number_format($product->price, 0, ',', '.') }} ₫
        </span>
        <div class="badge bg-danger mt-1">🔥 Đang Flash Sale</div>

        @if ($product->has_flash_sale && isset($flashSale))
            <div class="text-danger fw-semibold mb-2">
                Kết thúc sau: <span id="countdown-timer" class="fw-bold"></span>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const endTime = new Date("{{ $flashSale->end_time }}").getTime();
                    const countdownEl = document.getElementById("countdown-timer");

                    const timer = setInterval(function () {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        if (distance < 0) {
                            clearInterval(timer);
                            countdownEl.innerText = "Đã kết thúc";
                            return;
                        }

                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countdownEl.innerText = `${hours}h ${minutes}m ${seconds}s`;
                    }, 1000);
                });
            </script>
        @endif
    @else
        <span class="fw-semibold text-dark">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
    @endif
</div>


                <p class="product-description">{{ $product->description }}</p>

                {{-- Product Details --}}
                <table class="table table-bordered" style="margin-top: 1rem; font-size: 0.95rem;">
    <tbody>
        <tr>
            <th style="width: 120px;">SKU</th>
            <td>{{ $product->sku }}</td>
        </tr>
        <tr>
            <th>Thương hiệu</th>
            <td>{{ $product->brand }}</td>
        </tr>
        <tr>
            <th>Chất liệu</th>
            <td>
                @if($product->material)
                    {!! nl2br(e($product->material)) !!}
                @else
                    <em>Chưa cập nhật</em>
                @endif
            </td>
        </tr>
        <tr>
            <th>Bảo quản</th>
            <td>
                @if($product->care_instructions)
                    {!! nl2br(e($product->care_instructions)) !!}
                @else
                    <em>Chưa cập nhật</em>
                @endif
            </td>
        </tr>
    </tbody>
</table>


                @if ($product->youtube_id)
    <div class="mt-4">
        <h5 class="fw-bold text-dark mb-2">Video giới thiệu sản phẩm</h5>
        <div class="ratio ratio-16x9 rounded shadow overflow-hidden">
            <iframe
                src="https://www.youtube.com/embed/{{ $product->youtube_id }}"
                title="YouTube video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>
@endif


                {{-- Average Rating --}}
                <div class="rating-container">
                    @if($product->average_rating > 0)
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas {{ $i <= round($product->average_rating) ? 'fa-star' : 'fa-star-half-alt' }}"></i>
                            @endfor
                        </div>
                        <span class="rating-value">{{ number_format($product->average_rating,1) }}</span>
                        <span class="rating-count">({{ $product->reviews_count }} đánh giá)</span>
                    @else
                        <span class="no-rating">Chưa có đánh giá</span>
                    @endif
                </div>

                {{-- Color Variants --}}
                @if($product->variants->pluck('color')->unique()->filter()->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">Màu sắc</label>
                        <div class="color-variants">
                            @foreach($product->variants->pluck('color')->unique() as $color)
                                @if($color)
                                    <div class="color-option"
                                         style="background-color: {{ $color }}"
                                         title="{{ $color }}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Add to Cart Form --}}
                {{-- Form thêm vào giỏ --}}
<form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    @php
    $lowStockThreshold = 5;
@endphp

<div class="mt-3">
    <label class="form-label fw-bold">Chọn size:</label>
    <div class="d-flex flex-wrap gap-2">
        @foreach($product->variants as $variant)
            <input type="radio" class="btn-check" name="variant_id" id="size{{ $variant->id }}" value="{{ $variant->id }}" autocomplete="off">
            <label class="btn btn-outline-dark" for="size{{ $variant->id }}">
                Size {{ $variant->size }}
            </label>
        @endforeach
    </div>

    {{-- Cảnh báo tồn kho thấp --}}
    <div id="stock-warning" class="mt-2 text-warning fw-semibold" style="display: none;">
        ⚠️ Size <span id="selected-size"></span> chỉ còn <span id="stock-count"></span> sản phẩm!
    </div>
</div>



    <div class="d-flex align-items-center gap-3">
        <!-- Input số lượng -->
<div class="mt-3">
    <label for="quantityInput" class="form-label fw-bold">Số lượng:</label>
    <div class="input-group" style="width: 150px;">
        <button class="btn btn-outline-secondary" type="button" onclick="adjustQuantity(-1)">-</button>
        <input type="number" id="quantityInput" name="quantity" class="form-control text-center" value="1" min="1" max="10" readonly>
        <button class="btn btn-outline-secondary" type="button" onclick="adjustQuantity(1)">+</button>
    </div>
</div>
    </div>
    <div class="mt-3">
    <button type="submit" class="btn btn-add-to-cart w-100">
        <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
    </button>
</div>
</form>

{{-- Form yêu thích - TÁCH RA NGOÀI --}}
<div class="mb-3">
    @auth
        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline-block wishlist-toggle-form">
            @csrf
            <button type="submit" class="wishlist-btn {{ $isInWishlist ? 'active' : '' }}">
                <i class="fas fa-heart me-2"></i> {{ $isInWishlist ? 'Đã yêu thích' : 'Yêu thích' }}
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="wishlist-btn">
            <i class="fas fa-heart me-2"></i> Yêu thích
        </a>
    @endauth
</div>

                {{-- Buy Now Button --}}
                <form action="{{ route('cart.buyNow') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant_id" id="buyNowVariantId">
    <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
    <button type="submit" class="btn btn-warning w-100 mt-2">⚡ Mua ngay</button>
</form>



                {{-- Support Icons --}}
                <div class="row text-center support-icons">
                    <div class="col">
                        <div class="support-icon text-primary">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <p class="support-text">Bảo hành vĩnh viễn</p>
                    </div>
                    <div class="col">
                        <div class="support-icon text-success">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <p class="support-text">Miễn phí giao hàng từ 150k</p>
                    </div>
                    <div class="col">
                        <div class="support-icon text-danger">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <p class="support-text">Đổi trả 7 ngày</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews-section" data-aos="fade-up" data-aos-delay="100">
        @php
    $totalReviews = $product->reviews->count();
    $starStats = $product->reviews->groupBy('rating')->map->count();
@endphp

<div class="review-form-card mb-4">
    <h5 class="mb-3">Đánh giá cho {{ $product->name }}</h5>
    @for ($i = 5; $i >= 1; $i--)
        @php
            $percent = $totalReviews ? round(($starStats[$i] ?? 0) / $totalReviews * 100) : 0;
        @endphp
        <div class="d-flex align-items-center mb-2">
            <div class="me-2" style="width: 60px">{{ $i }} <i class="fas fa-star text-warning"></i></div>
            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
            </div>
            <div>{{ $percent }}%</div>
        </div>
    @endfor
</div>

        <h3 class="section-title">Đánh giá sản phẩm</h3>

        @auth
    @if(auth()->user()->hasPurchasedProduct($product->id))
        {{-- Review Form --}}
        <div class="review-form-card">
            <form action="{{ route('products.reviews.store', $product->slug) }}" method="POST" class="review-form row">
    @csrf
    <div class="mb-3 col-md-3">
        <label class="form-label">Đánh giá của bạn</label>
        <select name="rating" class="form-select">
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} sao</option>
            @endfor
        </select>
    </div>

    <div class="mb-3 col-md-9">
        <label class="form-label">Bình luận</label>
        <textarea name="comment" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm...">{{ old('comment') }}</textarea>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-submit-review">
            <i class="fas fa-paper-plane me-2"></i> Gửi đánh giá ngay
        </button>
    </div>
</form>

        </div>
    @else
        <div class="alert alert-warning mt-3">
            Bạn cần mua sản phẩm này để có thể đánh giá.
        </div>
    @endif
@else
    <p class="login-prompt">
        <a href="{{ route('login') }}" class="login-link">Đăng nhập</a> để đánh giá sản phẩm
    </p>
@endauth


        {{-- List Reviews --}}
        @forelse($product->reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div>
                        <span class="review-user">{{ $review->user->name }}</span>
                        <span class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas {{ $i <= $review->rating ? 'fa-star' : 'fa-star-half-alt' }}"></i>
                            @endfor
                        </span>
                    </div>

                    @if(auth()->id() === $review->user_id)
                        <div class="review-actions">
                            <button class="review-btn review-btn-edit"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#editReview{{ $review->id }}">
                                <i class="fas fa-edit me-1"></i> Sửa
                            </button>
                            <form action="{{ route('products.reviews.destroy', [$product->slug, $review->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?');">
                                @csrf
                                @method('DELETE')
                                <button class="review-btn review-btn-delete">
                                    <i class="fas fa-trash me-1"></i> Xóa
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <p class="review-text">{{ $review->comment ?: 'Không có bình luận.' }}</p>
                <p class="review-date">{{ $review->created_at->format('d/m/Y H:i') }}</p>

                @if($review->reply)
    <div class="mt-3 px-3 py-2 rounded bg-light border-start border-primary border-4">
        <strong>Phản hồi từ quản trị viên:</strong>
        <p class="mb-0">{{ $review->reply->content }}</p>
    </div>
@endif



                {{-- Edit Review Form --}}
                @if(auth()->id() === $review->user_id)
                    <div class="collapse edit-review-form" id="editReview{{ $review->id }}">
    <form action="{{ route('products.reviews.update', [$product->slug, $review->id]) }}" method="POST" class="row">
        @csrf
        @method('PUT')

        <div class="mb-3 col-md-3">
            <label class="form-label">Chỉnh sửa đánh giá</label>
            <select name="rating" class="form-select">
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                @endfor
            </select>
        </div>

        <div class="mb-3 col-md-9">
            <label class="form-label">Chỉnh sửa bình luận</label>
            <textarea name="comment" class="form-control" rows="3">{{ old('comment', $review->comment) }}</textarea>
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check me-2"></i> Lưu thay đổi
            </button>
            <button type="button" class="btn btn-outline-secondary"
                    data-bs-toggle="collapse"
                    data-bs-target="#editReview{{ $review->id }}">
                Hủy
            </button>
        </div>
    </form>
</div>

                @endif
            </div>
        @empty
            <div class="no-reviews">
                <i class="far fa-comment-dots fa-2x mb-3"></i>
                <p>Chưa có đánh giá nào</p>
            </div>
        @endforelse
    </div>

    {{-- Recommended Products --}}
    <div class="recommended-products" data-aos="fade-up" data-aos-delay="200">
        <h3 class="section-title">Sản phẩm tương tự</h3>

        @if($recommended->isEmpty())
            <div class="no-recommended">
                <i class="fas fa-box-open fa-2x mb-3"></i>
                <p>Chưa có sản phẩm gợi ý</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($recommended as $item)
                    @php
                        $isRecommendedInWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $item->id)->exists();
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="recommended-card">
                            {{-- Wishlist Button --}}
                            @auth
                                <form action="{{ route('wishlist.toggle', $item->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                                    @csrf
                                    <button type="submit" class="wishlist-icon {{ $isRecommendedInWishlist ? 'active' : '' }}" title="{{ $isRecommendedInWishlist ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích' }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="wishlist-icon position-absolute top-0 end-0 m-2" title="Đăng nhập để thêm vào yêu thích">
                                    <i class="fas fa-heart"></i>
                                </a>
                            @endauth

                            <a href="{{ route('products.show', $item->slug) }}" class="text-decoration-none">
                                <div class="recommended-img-container">
                                    @if($img = $item->images->first())
                                        <img src="{{ asset('storage/'.$img->path) }}"
                                             class="recommended-img"
                                             alt="{{ $item->name }}">
                                    @endif
                                </div>
                                <div class="recommended-body">
                                    <h5 class="recommended-title">{{ $item->name }}</h5>
                                    <p class="recommended-price">{{ number_format($item->price,0) }} ₫</p>
                                    <button class="btn btn-view-details">Xem chi tiết</button>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if (!empty($recentProducts) && $recentProducts->isNotEmpty())
    <div class="container my-5" data-aos="fade-up">
        <h4 class="mb-4">👀 Bạn vừa xem</h4>
        <div class="row">
            @foreach ($recentProducts as $recent)
                <div class="col-6 col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="{{ route('products.show', $recent->slug) }}">
                            <img src="{{ $recent->images->first()?->path ? asset('storage/' . $recent->images->first()->path) : asset('images/default.jpg') }}"
                                 class="card-img-top"
                                 alt="{{ $recent->name }}">
                        </a>
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">
                                <a href="{{ route('products.show', $recent->slug) }}">{{ $recent->name }}</a>
                            </h6>
                            <div class="text-danger fw-bold">
                                {{ number_format($recent->price, 0, ',', '.') }} ₫
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ==== Hiển thị SweetAlert nếu có session ====
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // ==== Gán variant_id khi chọn size (radio) + kiểm tra khi nhấn Mua ngay ====
    document.addEventListener('DOMContentLoaded', function () {
    const buyNowForm = document.querySelector('form[action="{{ route('cart.buyNow') }}"]');
    const buyNowVariant = document.getElementById('buyNowVariantId');
    const buyNowQuantity = document.getElementById('buyNowQuantity');
    const quantityInput = document.getElementById('quantityInput');

    // Gán variant_id từ radio
    const radios = document.querySelectorAll('input[name="variant_id"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (buyNowVariant) {
                buyNowVariant.value = this.value;
            }
        });
    });

    // Kiểm tra và đồng bộ khi nhấn "Mua ngay"
    if (buyNowForm) {
        buyNowForm.addEventListener('submit', function (e) {
            // Kiểm tra đã chọn size chưa
            if (!buyNowVariant.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn size',
                    text: 'Bạn cần chọn size trước khi mua ngay!',
                });
                return;
            }

            // Gán số lượng đã chọn
            if (buyNowQuantity && quantityInput) {
                buyNowQuantity.value = quantityInput.value;
            }
        });
    }
});


    // ==== Nút + / - tăng giảm số lượng ====
    function adjustQuantity(amount) {
        const input = document.getElementById('quantityInput');
        let current = parseInt(input.value);
        if (isNaN(current)) current = 1;

        let newVal = current + amount;
        if (newVal < 1) newVal = 1;
        if (newVal > 10) newVal = 10;

        input.value = newVal;
    }
</script>
@endpush
@php
    $variantStocks = $product->variants->pluck('stock', 'id'); // [variant_id => stock]
@endphp

@push('scripts')
<script>
    const variantStocks = @json($variantStocks);

    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantityInput');
        const sizeRadios = document.querySelectorAll('input[name="variant_id"]');

        sizeRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                const stock = variantStocks[this.value] || 1;
                quantityInput.max = stock;
                quantityInput.value = 1;
            });
        });

        window.adjustQuantity = function(amount) {
            let current = parseInt(quantityInput.value);
            const max = parseInt(quantityInput.max);
            if (isNaN(current)) current = 1;
            let newVal = current + amount;

            if (newVal < 1) newVal = 1;
            if (newVal > max) newVal = max;

            quantityInput.value = newVal;
        };
    });
</script>
@endpush
@php
    $variantData = $product->variants->mapWithKeys(function ($variant) {
        return [$variant->id => ['size' => $variant->size, 'stock' => $variant->stock]];
    });
@endphp

@push('scripts')
<script>
    const variantData = @json($variantData);
    const threshold = 5; // cảnh báo nếu tồn kho <= 5

    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="variant_id"]');
        const stockWarning = document.getElementById('stock-warning');
        const stockCount = document.getElementById('stock-count');
        const selectedSize = document.getElementById('selected-size');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                const data = variantData[this.value];

                if (data.stock <= threshold) {
                    stockWarning.style.display = 'block';
                    stockCount.textContent = data.stock;
                    selectedSize.textContent = data.size;
                } else {
                    stockWarning.style.display = 'none';
                }

                // Cập nhật số lượng tối đa
                const qtyInput = document.getElementById('quantityInput');
                if (qtyInput) {
                    qtyInput.max = data.stock;
                    qtyInput.value = 1;
                }
            });
        });
    });
</script>
@endpush


