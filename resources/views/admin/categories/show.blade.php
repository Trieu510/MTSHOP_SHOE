@extends('layouts.admin')

@section('title', 'Chi tiết Danh mục')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Danh mục: {{ $category->name }}</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay về
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light mb-4">
        <div class="card-body">
            <p class="mb-2"><strong>Tên danh mục:</strong> {{ $category->name }}</p>
            <p class="mb-2"><strong>Slug:</strong> {{ $category->slug }}</p>
            <p class="mb-0"><strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <hr class="my-4">

    <h5 class="fw-semibold text-dark mb-3">Sản phẩm trong danh mục</h5>
    @if($products->count())
    <div class="row g-3">
        @foreach($products as $prod)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 shadow-lg border-0 rounded-4 bg-gradient-light product-card">
                @if($prod->images->first())
                <img src="{{ asset('storage/'.$prod->images->first()->path) }}" class="card-img-top rounded-top-4" style="height: 150px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light rounded-top-4 d-flex align-items-center justify-content-center" style="height: 150px;">
                    <span class="text-muted">No Image</span>
                </div>
                @endif
                <div class="card-body p-3">
                    <h6 class="card-title mb-1 fw-semibold text-dark">{{ $prod->name }}</h6>
                    <p class="card-text small mb-0 text-dark">{{ number_format($prod->price,0) }} ₫</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    @else
    <p class="text-muted fw-semibold">Chưa có sản phẩm nào.</p>
    @endif
</div>

<style>
    /* Custom CSS để cải tiến giao diện */
    body {
        background-color: #f8f9fc;
    }

    .bg-gradient-light {
        background: linear-gradient(180deg, #ffffff, #f8f9fc);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-back {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #5a6268;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
    }

    h5 {
        color: #1a1a1a;
        font-size: 1.2rem;
    }

    p {
        font-size: 0.95rem;
        color: #1a1a1a;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 0.95rem;
    }

    .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .pagination .page-link:hover {
        background-color: #0066CC;
        color: #fff;
        transform: scale(1.05);
    }

    .pagination .page-item.active .page-link {
        background-color: #0066CC;
        border-color: #0066CC;
        color: #fff;
    }

    @media (max-width: 768px) {
        .btn-back {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        p, .text-muted {
            font-size: 0.9rem;
        }

        .card-body {
            padding: 12px;
        }

        .pagination .page-link {
            font-size: 0.85rem;
        }
    }
</style>
@endsection
