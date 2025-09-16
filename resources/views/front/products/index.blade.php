@extends('layouts.front')

@section('title', 'Sản phẩm')

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

    /* ===== Layout Structure ===== */
    .products-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .products-container {
            grid-template-columns: 1fr;
        }
    }

    /* ===== Filter Section ===== */
    .filter-section {
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .filter-form {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-xl);
        transition: var(--transition-all);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 2rem;
    }

    .filter-form .form-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .filter-form .form-control,
    .filter-form .form-select {
        border-radius: 12px;
        border: 1px solid rgba(203, 213, 225, 0.5);
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
        width: 100%;
        margin-bottom: 1rem;
    }

    .filter-form .btn-primary {
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: var(--transition-all);
        background: var(--primary-gradient);
        border: none;
        width: 100%;
        margin-top: 0.5rem;
    }

    .filter-form .btn-outline-secondary {
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: rgba(226, 232, 240, 0.5);
        color: var(--text-dark);
        border: none;
        width: 100%;
        margin-top: 0.5rem;
    }

    /* ===== Products Grid ===== */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    /* New wrapper for products grid and pagination */
    .products-content {
        display: flex;
        flex-direction: column;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    @media (max-width: 576px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }

    /* ===== Page Header ===== */
    .page-header {
        margin-bottom: 2rem;
        grid-column: 1 / -1;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 1.1rem;
    }

    /* ===== Product Card ===== */
    .product-card {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        transition: var(--transition-all);
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
    }

    .product-card-img-container {
        position: relative;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
    }

    .product-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-card-img {
        transform: scale(1.05);
    }

    .product-card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .product-card-body {
        padding: 1.25rem;
    }

    .product-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card-price {
        margin-bottom: 1rem;
    }

    .product-card-price-current {
        font-size: 1.1rem;
        font-weight: 700;
        color: #dc2626;
    }

    .product-card-price-original {
        font-size: 0.85rem;
        color: var(--text-light);
        text-decoration: line-through;
        margin-left: 0.5rem;
    }

    .product-card-btn {
        width: 100%;
        border-radius: 12px;
        padding: 0.65rem;
        font-weight: 600;
        transition: var(--transition-all);
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        border: none;
        font-size: 0.9rem;
    }

    /* ===== Empty State ===== */
    .empty-state {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        grid-column: 1 / -1;
    }

    /* ===== Background Elements ===== */
    .products-bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }

    .products-bg-elements .circle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .products-bg-elements .circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }

    .products-bg-elements .circle-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
    }

    /* ===== Wishlist Button ===== */
    .wishlist-btn {
        background: rgba(255, 255, 255, 0.85);
        transition: all 0.3s ease;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .wishlist-btn:hover {
        background: #ef4444;
        color: #fff;
    }

    .wishlist-btn i {
        font-size: 1rem;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1200px) {
        .products-container {
            grid-template-columns: 250px 1fr;
        }
    }

    @media (max-width: 992px) {
        .products-container {
            grid-template-columns: 1fr;
        }

        .filter-section {
            position: static;
        }

        .filter-form {
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .product-card-img {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.75rem;
        }

        .product-card-img {
            height: 150px;
        }

        .product-card-body {
            padding: 1rem;
        }
    }
    /* ===== Pagination Styles ===== */
.pagination-wrapper .pagination {
    display: flex;
    gap: 0.5rem;
    margin-top: 2rem;
}

.pagination-wrapper .page-item {
    margin: 0;
}

.pagination-wrapper .page-link {
    border-radius: 12px !important;
    padding: 0.5rem 1rem;
    border: 1px solid rgba(203, 213, 225, 0.5);
    color: var(--text-dark);
    font-weight: 600;
    transition: var(--transition-all);
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
}

.pagination-wrapper .page-link:hover {
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
    border-color: rgba(99, 102, 241, 0.3);
}

.pagination-wrapper .page-item.active .page-link {
    background: var(--primary-gradient);
    border-color: transparent;
    color: white;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #cbd5e1;
    background: rgba(203, 213, 225, 0.2);
}

/* ===== Product Card Enhancements ===== */
.product-card {
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.product-card:hover::before {
    transform: scaleX(1);
}

.product-card-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(99, 102, 241, 0.1);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
    z-index: -1;
}

.product-card-btn:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

/* ===== Filter Section Enhancements ===== */
.filter-form {
    transition: all 0.3s ease;
}

.filter-form:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

/* ===== Price Badge Animation ===== */
.product-card-badge {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

/* ===== Responsive Pagination ===== */
@media (max-width: 576px) {
    .pagination-wrapper .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-wrapper .page-link {
        padding: 0.4rem 0.8rem;
        min-width: 36px;
    }
}

/* ===== Loading Animation ===== */
@keyframes shimmer {
    0% { background-position: -468px 0 }
    100% { background-position: 468px 0 }
}

.loading-card {
    animation-duration: 1.5s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: shimmer;
    animation-timing-function: linear;
    background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
    background-size: 800px 104px;
    height: 200px;
    border-radius: 16px;
    margin-bottom: 1rem;
}

/* ===== Scrollbar Styling ===== */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(203, 213, 225, 0.1);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.7);
}
</style>
@endpush

@section('content')
<div class="container py-5 position-relative">
    <!-- Background elements -->
    <div class="products-bg-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="products-container">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-up">
            <h1 class="page-title">Danh sách Sản phẩm</h1>
            <p class="page-subtitle">{{ $products->total() }} sản phẩm có sẵn</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form class="filter-form" action="{{ route('products.index') }}" method="GET" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-3">
                    <label class="form-label">Tìm kiếm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 ps-2" placeholder="Tên sản phẩm...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="unisex" {{ request('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label">Giá từ</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="₫0" min="0">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Giá đến</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="₫0" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="" {{ request('sort')=='' ? 'selected':'' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Giá giảm dần</option>
                        <option value="popular" {{ request('sort')=='popular'?'selected':'' }}>Bán chạy nhất</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i> Lọc kết quả
                </button>

                @if(request()->hasAny(['q', 'category_id', 'min_price', 'max_price', 'sort']))
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-2">
                    <i class="fas fa-sync-alt me-2"></i> Đặt lại
                </a>
                @endif
            </form>
        </div>

        <!-- Products Content -->
        <div class="products-content">
            <!-- Products Grid -->
            <div class="products-grid">
                @forelse($products as $product)
                <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="product-card-img-container">
                            @if($img = $product->images->first())
                            <img src="{{ asset('storage/'.$img->path) }}" class="product-card-img" alt="{{ $product->name }}">
                            @endif
                            @if($product->has_flash_sale)
                            <span class="product-card-badge">Flash Sale</span>
                            @elseif($product->discount > 0)
                            <span class="product-card-badge">-{{ $product->discount }}%</span>
                            @endif



                        </div>
                        <div class="product-card-body">
                            <h3 class="product-card-title">{{ Str::limit($product->name, 40) }}</h3>
                            <div class="product-card-price">
                                @if($product->has_flash_sale)
                                <span class="product-card-price-current">{{ number_format($product->flash_sale_price, 0) }} ₫</span>
                                <span class="product-card-price-original">{{ number_format($product->price, 0) }} ₫</span>
                                @elseif($product->discount > 0)
                                <span class="product-card-price-current">{{ number_format($product->price - ($product->price * $product->discount / 100), 0) }} ₫</span>
                                <span class="product-card-price-original">{{ number_format($product->price, 0) }} ₫</span>
                                @else
                                <span class="product-card-price-current">{{ number_format($product->price, 0) }} ₫</span>
                                @endif
                            </div>

                            <button class="product-card-btn">
                                <i class="fas fa-eye me-2"></i> Xem chi tiết
                            </button>
                            <form action="{{ route('compare.add', $product->id) }}" method="POST" class="mt-2">
    @csrf
    <button type="submit" class="product-card-btn" title="So sánh sản phẩm">
        <i class="bi bi-arrow-left-right me-2"></i> So sánh
    </button>
</form>

                        </div>
                    </a>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-state-title">Không tìm thấy sản phẩm phù hợp</h3>
                    <p class="empty-state-text">Hãy thử điều chỉnh bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i> Xem tất cả sản phẩm
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination - Now moved below products -->
            @if($products->hasPages())
            <div class="pagination-wrapper" data-aos="fade-up">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
