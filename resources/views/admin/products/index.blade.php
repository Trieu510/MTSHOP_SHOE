@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-box-seam me-2"></i>Danh sách Sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-add">
            <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Tìm theo tên sản phẩm" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="price_min" class="form-control" placeholder="Giá từ" value="{{ request('price_min') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="price_max" class="form-control" placeholder="Giá đến" value="{{ request('price_max') }}">
                </div>
                <div class="col-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-icon">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->anyFilled(['name', 'category', 'price_min', 'price_max']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-icon">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="table-responsive p-3">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Kho</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $i => $prod)
                        <tr class="table-row">
                            <th scope="row">{{ $i + 1 }}</th>
                            <td>
                                @if($img = $prod->images->first())
                                    <div class="image-wrapper">
                                        <img src="{{ asset('storage/'.$img->path) }}"
                                             alt="{{ $prod->name }}"
                                             class="img-thumbnail rounded-3"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $prod->name }}</td>
                            <td>{{ $prod->category->name }}</td>
                            <td>{{ number_format($prod->price, 0) }} ₫</td>
                            <td>{{ $prod->variants->sum('stock') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.products.edit', $prod) }}"
                                       class="btn btn-sm btn-outline-warning btn-icon">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $prod) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Xác nhận xóa sản phẩm này?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-icon">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <i class="bi bi-info-circle me-1"></i>Không tìm thấy sản phẩm nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>

<style>
    /* Giữ nguyên các style từ giao diện danh mục */
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

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .table-row {
        transition: background-color 0.3s ease;
    }

    .table-row:hover {
        background-color: #f1f3f5;
    }

    .btn-add {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background-color: #0052a3;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-icon {
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-outline-warning.btn-icon:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-outline-danger.btn-icon:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        transform: scale(1.1);
    }

    .image-wrapper {
        transition: transform 0.3s ease;
    }

    .image-wrapper:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .img-thumbnail {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
    }

    .table th, .table td {
        font-size: 0.95rem;
        padding: 12px;
    }

    .table-light {
        background-color: #f8f9fc !important;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .img-thumbnail {
            width: 60px !important;
            height: 60px !important;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
        }

        .btn-add {
            width: 100%;
            text-align: center;
        }

        .d-flex.gap-2 {
            gap: 8px !important;
        }
    }
</style>
@endsection
