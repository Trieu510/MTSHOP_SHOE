@extends('layouts.admin')

@section('title', 'Nhập kho nhiều size')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Nhập kho cho sản phẩm: <span class="text-primary">{{ $product->name }}</span></h2>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <form action="{{ route('admin.inventory.update', $product->variants->first()->id) }}" method="POST">
            @csrf

            <div class="table-responsive p-3">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Size</th>
                            <th class="text-center">Tồn kho hiện tại</th>
                            <th class="text-center">Số lượng nhập</th>
                            <th class="text-center">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->variants as $variant)
                            <tr class="table-row">
                                <td class="text-center fw-bold">{{ $variant->size }}</td>
                                <td class="text-center">
                                    @if($variant->stock <= 5)
                                        <span class="badge bg-danger">{{ $variant->stock }} (Thấp)</span>
                                    @else
                                        {{ $variant->stock }}
                                    @endif
                                </td>
                                <td>
                                    <input type="number" name="quantities[{{ $variant->id }}]"
                                           class="form-control text-center"
                                           min="0" value="0"
                                           style="max-width: 100px; margin: 0 auto;">
                                </td>
                                <td>
                                    <input type="text" name="notes[{{ $variant->id }}]"
                                           class="form-control"
                                           placeholder="Ghi chú...">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-transparent border-0 d-flex justify-content-between p-4">
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Xác nhận nhập kho
                </button>
            </div>
        </form>
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

    .table th, .table td {
        font-size: 0.95rem;
        padding: 12px;
        vertical-align: middle;
    }

    .table-light {
        background-color: #f8f9fc !important;
    }

    input.form-control {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    input.form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-outline-secondary {
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    .btn-success {
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #146c43;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection
