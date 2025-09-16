@extends('layouts.admin')

@section('title', 'Quản lý tồn kho')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Quản lý tồn kho theo size</h2>
        <!-- Có thể thêm nút tạo mới nếu cần -->
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="px-3 pt-3">
            <!-- Form lọc tìm kiếm -->
            <form method="GET" class="row g-2 align-items-center mb-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="low_stock" class="form-control">
                        <option value="">Tất cả tồn kho</option>
                        <option value="1" {{ request('low_stock') == '1' ? 'selected' : '' }}>Chỉ hiện tồn thấp (≤ 5)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Lọc
                    </button>
                </div>
                @if(request()->has('keyword') || request()->has('category_id') || request()->has('low_stock'))
                    <div class="col-md-auto mt-2">
                        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Xoá bộ lọc
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="table-responsive p-3 pt-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Tồn kho</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($variants as $variant)
                        <tr class="table-row">
                            <td class="text-center">
                                <img src="{{ $variant->product->primary_image ?? asset('images/default.jpg') }}"
                                     alt="Ảnh" width="50" class="rounded">
                            </td>
                            <td>{{ $variant->product->name }}</td>
                            <td>{{ $variant->product->category->name ?? '-' }}</td>
                            <td class="text-center">{{ $variant->size }}</td>
                            <td class="text-center">
                                @if($variant->stock <= 5)
                                    <span class="badge bg-danger">{{ $variant->stock }} (Thấp)</span>
                                @else
                                    {{ $variant->stock }}
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.inventory.edit', $variant->id) }}"
                                       class="btn btn-sm btn-warning btn-icon"
                                       title="Nhập kho">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <a href="{{ route('admin.inventory.logs.by_variant', $variant->id) }}"
                                       class="btn btn-sm btn-info btn-icon"
                                       title="Lịch sử">
                                        <i class="bi bi-clock-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không tìm thấy dữ liệu tồn kho.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Sử dụng lại các style từ giao diện trước */
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

    .btn-icon {
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-warning.btn-icon:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-info.btn-icon:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #fff;
        transform: scale(1.1);
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

        .btn-icon {
            width: 32px;
            height: 32px;
        }

        .d-flex.gap-2 {
            gap: 8px !important;
        }
    }
</style>
@endsection
