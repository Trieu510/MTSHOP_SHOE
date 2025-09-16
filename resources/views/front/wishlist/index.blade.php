@extends('layouts.front')

@section('title', 'Danh sách yêu thích')

@push('styles')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --accent-color: #ec4899;
        --dark-color: #1e293b;
        --text-color: #334155;
        --text-light: #64748b;
        --border-radius: 10px;
        --border-radius-lg: 16px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Flash Messages ===== */
    .alert {
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-sm);
        font-weight: 500;
        transition: var(--transition);
        border: none;
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
        border-left: 4px solid;
        margin-bottom: 1.5rem;
    }
    .alert-success {
        border-left-color: #10b981;
        color: #065f46;
        background-color: rgba(16, 185, 129, 0.1);
    }
    .alert-danger {
        border-left-color: #ef4444;
        color: #991b1b;
        background-color: rgba(239, 68, 68, 0.1);
    }

    /* ===== Page Header ===== */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }
    .page-title {
        font-size: 2.75rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }
    .page-subtitle {
        color: var(--text-light);
        font-size: 1.15rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .page-title-decoration {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    /* ===== Empty State ===== */
    .empty-state {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 5rem 3rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
        margin: 3rem auto;
        max-width: 600px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 2rem;
        color: #e2e8f0;
        display: inline-flex;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 50%;
    }
    .empty-state-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1.25rem;
    }
    .empty-state-text {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 2.5rem;
        line-height: 1.6;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    .empty-state-btn {
        padding: 1rem 2.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3), 0 2px 4px rgba(79, 70, 229, 0.1);
    }
    .empty-state-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== Wishlist Grid ===== */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    /* ===== Wishlist Card ===== */
    .wishlist-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        overflow: hidden;
        border: none;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .wishlist-card-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--accent-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }
    .wishlist-card-img {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .wishlist-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .wishlist-card:hover .wishlist-card-img img {
        transform: scale(1.05);
    }
    .wishlist-card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }
    .wishlist-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .wishlist-card-title a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }
    .wishlist-card-title a:hover {
        color: var(--primary-color);
    }
    .wishlist-card-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ef4444;
        display: inline-block;
        background: rgba(239, 68, 68, 0.1);
        padding: 0.35rem 1rem;
        border-radius: 20px;
    }
    .wishlist-card-footer {
        padding: 1.25rem;
        background: #f8fafc;
        border-top: 1px solid rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .wishlist-card-btn {
        border-radius: var(--border-radius);
        padding: 0.65rem 1.25rem;
        font-size: 0.95rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .wishlist-card-btn-outline {
        border: 2px solid #ef4444;
        color: #ef4444;
        background: white;
    }
    .wishlist-card-btn-outline:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);
    }
    .wishlist-card-btn-primary {
        background: var(--primary-color);
        border: none;
        color: white;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);
    }
    .wishlist-card-btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(37, 99, 235, 0.1);
    }

    /* ===== Wishlist Actions ===== */
    .wishlist-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        gap: 0.5rem;
        z-index: 2;
    }
    .wishlist-action-btn {
        width: 36px;
        height: 36px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        color: var(--text-color);
        transition: var(--transition);
        border: none;
    }
    .wishlist-action-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }
    .wishlist-action-btn-remove {
        color: #ef4444;
    }
    .wishlist-action-btn-remove:hover {
        background: rgba(239, 68, 68, 0.1);
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .page-title {
            font-size: 2.5rem;
        }
        .wishlist-card-img {
            height: 200px;
        }
    }
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.25rem;
        }
        .empty-state {
            padding: 4rem 2rem;
        }
        .empty-state-title {
            font-size: 1.5rem;
        }
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        .wishlist-card-img {
            height: 180px;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 2rem;
        }
        .page-subtitle {
            font-size: 1rem;
        }
        .empty-state {
            padding: 3rem 1.5rem;
        }
        .empty-state-icon {
            font-size: 4rem;
            padding: 1.25rem;
        }
        .wishlist-card-img {
            height: 160px;
        }
        .wishlist-card-footer {
            flex-direction: column;
            gap: 0.75rem;
        }
        .wishlist-card-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="page-header" data-aos="fade-up">
        <h1 class="page-title">Danh sách yêu thích</h1>
        <p class="page-subtitle">Những sản phẩm bạn đã lưu lại để xem sau</p>
        <div class="page-title-decoration"></div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success" data-aos="fade-up" data-aos-delay="50">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="50">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if($items->isEmpty())
        <div class="empty-state" data-aos="fade-up" data-aos-delay="100">
            <div class="empty-state-icon">
                <i class="bi bi-heart"></i>
            </div>
            <h3 class="empty-state-title">Danh sách yêu thích trống</h3>
            <p class="empty-state-text">Bạn chưa có sản phẩm nào trong danh sách yêu thích. Hãy khám phá cửa hàng và thêm những sản phẩm bạn quan tâm!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary empty-state-btn">
                <i class="bi bi-shop me-1"></i> Khám phá sản phẩm
            </a>
        </div>
    @else
        <div class="wishlist-grid" data-aos="fade-up" data-aos-delay="100">
            @foreach($items as $item)
                @php
                    $product = $item->product;
                    $img = $product?->images->first();
                @endphp

                <div class="wishlist-card">
                    @if($product && $product->isNew())
    <div class="wishlist-card-badge">Mới</div>
@endif


                    <div class="wishlist-actions">
                        <form action="{{ route('wishlist.destroy', $product->slug) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="wishlist-action-btn wishlist-action-btn-remove" title="Xóa khỏi danh sách">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('products.show', $product->slug) }}" class="wishlist-card-img">
                        @if($img)
                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }}">
                        @else
                            <div class="h-100 w-100 bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                    </a>

                    <div class="wishlist-card-body">
                        <h3 class="wishlist-card-title">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="wishlist-card-price">{{ number_format($product->price, 0, ',', '.') }} ₫</div>
                    </div>

                    <div class="wishlist-card-footer">
                        <form action="{{ route('wishlist.destroy', $product->slug) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="wishlist-card-btn wishlist-card-btn-outline">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if($product->variants->isNotEmpty())
                                <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                            @endif
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="wishlist-card-btn wishlist-card-btn-primary">
                                <i class="bi bi-cart-plus"></i> Thêm
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Simple animation for elements
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
