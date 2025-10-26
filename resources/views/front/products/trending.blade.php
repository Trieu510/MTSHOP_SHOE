@extends('layouts.front')

@section('title', '🔥 Bảng xếp hạng sản phẩm hot')

@push('styles')
<style>
    .leaderboard-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all .3s ease;
    }
    .leaderboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .leaderboard-top {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 2.5rem;
    }

    .leaderboard-top .top-item {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .leaderboard-top .top-item img {
        border-radius: 12px;
        width: 100%;
        height: 280px;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .leaderboard-top .rank-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 2rem;
        font-weight: bold;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        line-height: 60px;
        text-align: center;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .rank-1 { background: linear-gradient(135deg, #FFD700, #FBBF24); }
    .rank-2 { background: linear-gradient(135deg, #C0C0C0, #94A3B8); }
    .rank-3 { background: linear-gradient(135deg, #CD7F32, #F97316); }

    .leaderboard-table th {
        background: #f8fafc;
        font-weight: 600;
        color: #334155;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .leaderboard-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .leaderboard-table .rank-number {
        font-weight: 700;
        color: #4f46e5;
    }

    .leaderboard-table img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .leaderboard-top .top-item img {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    {{-- 🏆 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="fw-bold mb-1">🔥 BẢNG XẾP HẠNG SẢN PHẨM HOT</h2>
            <p class="text-muted small mb-0">
                @if($filter == '7days')
                    Hiển thị top sản phẩm hot trong 7 ngày gần nhất
                @elseif($filter == '30days')
                    Hiển thị top sản phẩm hot trong 30 ngày gần nhất
                @else
                    Hiển thị top sản phẩm hot mọi thời đại
                @endif
            </p>
        </div>

        {{-- Bộ lọc thời gian --}}
        <form method="GET" action="{{ route('products.trending') }}">
            <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="7days" {{ $filter == '7days' ? 'selected' : '' }}>Top 7 ngày</option>
                <option value="30days" {{ $filter == '30days' ? 'selected' : '' }}>Top 30 ngày</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Toàn thời gian</option>
            </select>
        </form>
    </div>

    @if($products->count() > 0)
        {{-- 🥇 Top 3 nổi bật --}}
        <div class="leaderboard-top mb-5">
            @foreach($products->take(3) as $i => $product)
                <div class="top-item">
                    <span class="rank-badge rank-{{ $i+1 }}">{{ ['🥇','🥈','🥉'][$i] }}</span>
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset('storage/' . ($product->images->first()->path ?? 'images/default.jpg')) }}" alt="{{ $product->name }}">
                    </a>
                    <h5 class="mt-3 fw-semibold">{{ $product->name }}</h5>
                    <div class="text-primary fw-bold fs-5">{{ number_format($product->price) }}₫</div>
                    <small class="text-muted">
                        🛒 {{ $product->purchase_count ?? 0 }} | 👀 {{ $product->view_count ?? 0 }} | ❤️ {{ $product->wishlist_count ?? 0 }}
                    </small>
                </div>
            @endforeach
        </div>

        {{-- 📊 Bảng xếp hạng đầy đủ --}}
        <div class="leaderboard-card p-4">
            <div class="table-responsive">
                <table class="table leaderboard-table align-middle">
                    <thead>
                        <tr>
                            <th>Hạng</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Lượt xem</th>
                            <th>Lượt mua</th>
                            <th>Yêu thích</th>
                            <th>Điểm Hot 🔥</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                        <tr>
                            <td class="rank-number text-center fs-5">#{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . ($product->images->first()->path ?? 'images/default.jpg')) }}" class="me-3">
                                    <div>
                                        <a href="{{ route('products.show', $product->slug) }}" class="fw-semibold text-dark text-decoration-none">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold text-primary">{{ number_format($product->price) }}₫</td>
                            <td>👀 {{ $product->view_count ?? 0 }}</td>
                            <td>🛒 {{ $product->purchase_count ?? 0 }}</td>
                            <td>❤️ {{ $product->wishlist_count ?? 0 }}</td>
                            <td class="fw-bold text-danger">{{ $product->score ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-emoji-frown display-4 text-secondary"></i>
            <h4 class="mt-3">Chưa có sản phẩm nào đang hot</h4>
        </div>
    @endif
</div>
@endsection
