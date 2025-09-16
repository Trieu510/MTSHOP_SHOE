@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách Danh mục</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-add">
            <i class="bi bi-plus-circle me-1"></i> Thêm mới
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
    <div class="px-3 pt-3">
        <!-- Form lọc tìm kiếm -->
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 align-items-center mb-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Tìm theo tên danh mục..."
                       value="{{ request('name') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                @if(request()->has('name'))
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x-circle"></i> Xoá tìm kiếm
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive p-3 pt-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                    <tr class="table-row">
                        <th scope="row">{{ $i + 1 }}</th>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->slug }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="btn btn-sm btn-outline-warning btn-icon">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Xác nhận xóa danh mục này?')">
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
                        <td colspan="4" class="text-center text-muted">Không tìm thấy danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>

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
