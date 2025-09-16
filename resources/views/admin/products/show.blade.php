@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách Sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-add-product">
            <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm
        </a>
    </div>

    @include('admin.partials.alerts')

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
                    @foreach($products as $prod)
                    <tr class="table-row">
                        <th scope="row">{{ $loop->iteration + ($products->currentPage()-1)*$products->perPage() }}</th>
                        <td>
                            @if($prod->images->first())
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/'.$prod->images->first()->path) }}"
                                         alt=""
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
                            <a href="{{ route('admin.products.show', $prod) }}"
                               class="btn btn-sm btn-outline-info btn-icon">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $prod) }}"
                               class="btn btn-sm btn-outline-warning btn-icon">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $prod) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Xác nhận xóa sản phẩm?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger btn-icon">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
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

    .btn-add-product {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-add-product:hover {
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

    .btn-outline-info.btn-icon:hover {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
        transform: scale(1.1);
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
        box-shadow: 0 4px 10px rgba(0, 0, 00.15);
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

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #0066CC;
        color: #fff;
        transform: scale(1.05);
    }

    .pagination .page-item.active .page-link {
        background-color: #0066CC;
        border-color: #0066CC;
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

        .btn-add-product {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection
