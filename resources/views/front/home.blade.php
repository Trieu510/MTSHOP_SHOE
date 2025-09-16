@extends('layouts.front')

@section('title', 'Trang chủ')

@push('styles')
<style>
    /* ===== Color Variables ===== */
    :root {
        --primary: #667eea;
        --primary-dark: #5a67d8;
        --accent: #764ba2;
        --accent-light: #8a5fb3;
        --danger: #dc2626;
        --danger-light: #ef4444;
        --success: #10b981;
        --warning: #f59e0b;
        --dark: #1e293b;
        --light: #f8fafc;
        --gray: #64748b;
        --light-gray: #e2e8f0;
        --border-radius: 12px;
        --border-radius-lg: 16px;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Base Styles ===== */
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--light);
        color: var(--dark);
    }

    /* ===== Hero Carousel ===== */
    .hero-section {
        position: relative;
        margin-bottom: 4rem;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .carousel-item {
        height: 650px;
        position: relative;
        transition: var(--transition-slow);
    }

    .carousel-item img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .carousel-item:hover img {
        transform: scale(1.03);
    }

    .carousel-caption {
        position: absolute;
        bottom: 15%;
        left: 10%;
        right: auto;
        text-align: left;
        padding: 2.5rem;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: var(--border-radius-lg);
        max-width: 550px;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
        border-left: 4px solid var(--primary);
    }

    .carousel-item.active .carousel-caption {
        transform: translateY(0);
        opacity: 1;
    }

    .carousel-caption h2 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .carousel-caption p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1.5rem;
    }

    .carousel-caption .btn {
        padding: 0.9rem 2.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
    }

    .carousel-caption .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: var(--transition);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .hero-section:hover .carousel-control-prev,
    .hero-section:hover .carousel-control-next {
        opacity: 1;
    }

    .carousel-control-prev {
        left: 40px;
    }

    .carousel-control-next {
        right: 40px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-50%) scale(1.05);
    }

    /* ===== Section Title ===== */
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        font-weight: 700;
        color: var(--dark);
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
        padding-bottom: 1.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 5px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        border-radius: 3px;
    }

    .section-title .badge {
        position: relative;
        top: -12px;
        font-size: 1rem;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        background: linear-gradient(135deg, var(--accent), var(--accent-light));
        color: white;
        box-shadow: var(--shadow-md);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* ===== Product Card ===== */
    .product-card {
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        height: 100%;
        position: relative;
        box-shadow: var(--shadow-sm);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .product-card .card-img-container {
        height: 300px;
        overflow: hidden;
        position: relative;
    }

    .product-card img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-card:hover img {
        transform: scale(1.08);
    }

    .product-card .card-body {
        padding: 1.75rem;
        position: relative;
        z-index: 2;
        background: white;
    }

    .product-card .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card .price {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 1.25rem;
    }

    .product-card .price del {
        font-size: 1rem;
        color: var(--gray);
        margin-right: 0.5rem;
    }

    .product-card .btn-detail {
        width: 100%;
        padding: 0.8rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        transition: var(--transition);
        letter-spacing: 0.5px;
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary);
        border: none;
    }

    .product-card .btn-detail:hover {
        background: rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
    }

    .product-card .wishlist-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        transition: var(--transition);
        z-index: 3;
        box-shadow: var(--shadow-md);
        border: none;
    }

    .product-card .wishlist-btn:hover {
        color: var(--danger);
        transform: scale(1.15);
        background: white;
    }

    .product-card .wishlist-btn.active {
        color: var(--danger);
        animation: heartBeat 0.6s;
    }

    @keyframes heartBeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(1); }
        75% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    /* ===== Flash Sale Styles ===== */
    .product-card.border-danger {
        border: 2px solid var(--danger) !important;
    }

    .product-card.border-danger .btn-detail {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger);
    }

    .product-card.border-danger .btn-detail:hover {
        background: rgba(220, 38, 38, 0.2);
    }

    #flash-countdown {
        font-size: 1.5rem;
        color: var(--danger);
        font-weight: 700;
    }

    /* ===== Brand Styles ===== */
    .brand-logo {
        max-height: 80px;
        object-fit: contain;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .brand-logo:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .brand-card {
        transition: var(--transition);
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    /* ===== Empty State ===== */
    .empty-state {
        padding: 5rem 0;
        text-align: center;
        background: rgba(241, 245, 249, 0.5);
        border-radius: var(--border-radius-lg);
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--gray);
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }

    .empty-state h4 {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .empty-state p {
        color: var(--gray);
        max-width: 500px;
        margin: 0 auto 2.5rem;
        font-size: 1.1rem;
    }

    /* ===== View All Button ===== */
    .view-all-btn {
        padding: 1rem 3rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        letter-spacing: 0.5px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        margin-top: 4rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
    }

    .view-all-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--accent-light));
    }

    .view-all-btn i {
        transition: transform 0.3s ease;
    }

    .view-all-btn:hover i {
        transform: translateX(3px);
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1200px) {
        .carousel-item {
            height: 550px;
        }

        .carousel-caption {
            max-width: 500px;
            padding: 2rem;
        }

        .carousel-caption h2 {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 992px) {
        .carousel-item {
            height: 500px;
        }

        .carousel-caption {
            padding: 1.75rem;
            max-width: 450px;
        }

        .carousel-caption h2 {
            font-size: 2.2rem;
        }

        .carousel-caption p {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2.4rem;
        }

        .product-card .card-img-container {
            height: 260px;
        }
    }

    @media (max-width: 768px) {
        .carousel-item {
            height: 450px;
        }

        .carousel-caption {
            left: 50%;
            transform: translate(-50%, 20px);
            max-width: 90%;
            text-align: center;
            padding: 1.5rem;
        }

        .carousel-caption h2 {
            font-size: 2rem;
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 3rem;
        }

        .product-card .card-img-container {
            height: 220px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
        }
    }

    @media (max-width: 576px) {
        .carousel-item {
            height: 400px;
        }

        .carousel-caption {
            padding: 1.25rem;
            bottom: 10%;
        }

        .carousel-caption h2 {
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }

        .carousel-caption p {
            font-size: 0.95rem;
            margin-bottom: 1rem;
            display: none;
        }

        .section-title {
            font-size: 1.8rem;
            padding-bottom: 1rem;
        }

        .section-title::after {
            height: 4px;
            width: 80px;
        }

        .product-card .card-title {
            font-size: 1rem;
        }

        .product-card .price {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .empty-state {
            padding: 3rem 0;
        }

        .empty-state i {
            font-size: 3.5rem;
        }

        .empty-state h4 {
            font-size: 1.5rem;
        }

        #flash-countdown {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    {{-- Hero Carousel --}}
    <section class="hero-section">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($banners as $banner)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <a @if($banner->link_url) href="{{ $banner->link_url }}" @endif>
                        <img src="{{ asset('storage/'.$banner->image_path) }}"
                             class="w-100"
                             alt="{{ $banner->title }}">
                        <div class="carousel-caption">
                            <h2>{{ $banner->title }}</h2>
                            @if($banner->subtitle)
                            <p>{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="btn btn-primary">Xem ngay</a>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="container mb-5">
        <h2 class="section-title">SẢN PHẨM MỚI NHẤT <span class="badge">MỚI</span></h2>

        <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
            @forelse($products->take(8) as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        @if($img = $product->images->first())
                        <div class="card-img-container">
                            <img src="{{ asset('storage/'.$img->path) }}"
                                 alt="{{ $product->name }}">
                        </div>
                        @endif
                        <div class="card-body">
                            <button class="wishlist-btn" data-product-id="{{ $product->id }}">
                                <i class="bi bi-heart"></i>
                            </button>
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <div class="price">
                                @if($product->discount > 0)
                                <del>{{ number_format($product->price) }}₫</del>
                                {{ number_format($product->price - ($product->price * $product->discount / 100)) }}₫
                                @else
                                {{ number_format($product->price) }}₫
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-detail">
                                Xem chi tiết
                            </a>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 empty-state">
                <i class="bi bi-box-seam"></i>
                <h4>Không có sản phẩm nào</h4>
                <p>Hiện chúng tôi chưa có sản phẩm nào trong danh mục này. Vui lòng quay lại sau.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
            </div>
            @endforelse
        </div>

        @if($products->count() > 8)
        <div class="text-center">
            <a href="{{ route('products.index') }}" class="btn btn-primary view-all-btn">
                Xem tất cả sản phẩm <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </section>

    {{-- Flash Sale --}}
    @if($flashSale && $flashSale->isActive() && $flashSaleProducts->count())
    <section class="container mb-5">
        <h2 class="section-title">
            FLASH SALE <span class="badge bg-danger">🔥 GIẢM GIÁ GIỜ VÀNG</span>
        </h2>

        {{-- Countdown --}}
        <div class="text-center mb-4 fs-5 fw-bold text-danger">
            Kết thúc sau: <span id="flash-countdown"></span>
        </div>

        <div class="row g-4">
            @foreach($flashSaleProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card border-danger">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-img-container">
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <div class="price">
                                <del class="text-muted small me-2">{{ number_format($product->price) }}₫</del>
                                <span class="text-danger fw-bold">{{ number_format($product->flash_sale_price) }}₫</span>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-danger btn-detail">Xem chi tiết</a>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Brands Section --}}
    <section class="container mb-5">
        <h2 class="section-title">THƯƠNG HIỆU NỔI BẬT</h2>
        <div class="row justify-content-center align-items-center g-4">
            @php
                $brands = [
                    ['name' => 'Nike',        'slug' => 'nike',        'image' => 'storage/logos/nike.png'],
                    ['name' => 'Adidas',      'slug' => 'adidas',      'image' => 'storage/logos/adidas.png'],
                    ['name' => 'Puma',        'slug' => 'puma',        'image' => 'storage/logos/puma.png'],
                    ['name' => 'Vans',        'slug' => 'vans',        'image' => 'storage/logos/vans.png'],
                    ['name' => 'MLB',         'slug' => 'mlb',         'image' => 'storage/logos/mlb.png'],
                    ['name' => 'New Balance', 'slug' => 'newbalance',  'image' => 'storage/logos/newbalance.png'],
                ];
            @endphp

            @foreach($brands as $brand)
            <div class="col-6 col-md-4 col-lg-2 text-center">
                <a href="{{ route('products.index', ['category_id' => \App\Models\Category::where('slug', $brand['slug'])->value('id')]) }}"
                   title="Xem sản phẩm từ {{ $brand['name'] }}"
                   class="d-block bg-white p-3 shadow-sm rounded hover-shadow brand-card"
                   data-aos="zoom-in">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset($brand['image']) }}"
                             alt="{{ $brand['name'] }}"
                             class="img-fluid brand-logo mb-2">
                        <div class="fw-semibold text-dark text-center small">{{ $brand['name'] }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@push('scripts')
@if(isset($flashSale) && $flashSale->isActive())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const endTime = new Date("{{ $flashSale->end_time }}").getTime();

        const countdown = document.getElementById('flash-countdown');
        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                countdown.innerHTML = "Đã kết thúc";
                clearInterval(timer);
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdown.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
        }, 1000);
    });
</script>
@endif
@endpush
