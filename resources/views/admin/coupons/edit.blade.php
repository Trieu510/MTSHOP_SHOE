@extends('layouts.admin')

@section('title', 'Chỉnh sửa mã giảm giá')

@section('content')
<style>
    .coupon-edit-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-right: 0.5rem;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary, .btn-secondary {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .form-group {
        position: relative;
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .coupon-edit-container {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
        }
    }
</style>

<div class="container coupon-edit-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-dark fw-bold"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa mã giảm giá</h4>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-body">
                {{-- Mã giảm giá --}}
                <div class="mb-3 form-group">
                    <label for="code" class="form-label">Mã giảm giá</label>
                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $coupon->code) }}" required>
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Loại giảm giá --}}
                <div class="mb-3 form-group">
                    <label for="type" class="form-label">Loại giảm giá</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Số tiền (VNĐ)</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Giá trị --}}
                <div class="mb-3 form-group">
                    <label for="value" class="form-label">Giá trị giảm</label>
                    <input type="number" name="value" id="value" class="form-control @error('value') is-invalid @enderror"
                           value="{{ old('value', $coupon->value) }}" required min="0">
                    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Đơn hàng tối thiểu --}}
                <div class="mb-3 form-group">
                    <label for="min_order_amount" class="form-label">Đơn hàng tối thiểu (VNĐ)</label>
                    <input type="number" name="min_order_amount" id="min_order_amount"
                           class="form-control @error('min_order_amount') is-invalid @enderror"
                           value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                    @error('min_order_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Số lần sử dụng --}}
                <div class="mb-3 form-group">
                    <label for="usage_limit" class="form-label">Số lần sử dụng</label>
                    <input type="number" name="usage_limit" id="usage_limit"
                           class="form-control @error('usage_limit') is-invalid @enderror"
                           value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    @error('usage_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Ngày hết hạn --}}
                <div class="mb-3 form-group">
                    <label for="expires_at" class="form-label">Ngày hết hạn</label>
                    <input type="text" name="expires_at" id="expires_at"
                           class="form-control @error('expires_at') is-invalid @enderror"
                           value="{{ old('expires_at', optional($coupon->expires_at)->format('d/m/Y')) }}"
                           placeholder="dd/mm/yyyy">
                    @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Phạm vi áp dụng --}}
                <div class="mb-3 form-group">
                    <label for="scope" class="form-label">Phạm vi áp dụng</label>
                    <select name="scope" id="scope" class="form-select @error('scope') is-invalid @enderror" required>
                        <option value="all" {{ old('scope', $coupon->scope) === 'all' ? 'selected' : '' }}>Toàn bộ sản phẩm</option>
                        <option value="category" {{ old('scope', $coupon->scope) === 'category' ? 'selected' : '' }}>Theo danh mục</option>
                        <option value="product" {{ old('scope', $coupon->scope) === 'product' ? 'selected' : '' }}>Theo sản phẩm</option>
                    </select>
                    @error('scope') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Danh mục --}}
                <div class="mb-3 form-group" id="category-group" style="display: none;">
                    <label for="category_id" class="form-label">Chọn danh mục</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $coupon->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Sản phẩm --}}
                <div class="mb-3 form-group" id="product-group" style="display: none;">
                    <label for="product_id" class="form-label">Chọn sản phẩm</label>
                    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $coupon->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Trạng thái --}}
                <div class="form-check form-switch mb-4 form-group">
                    <input type="checkbox" name="is_active" id="is_active"
                           class="form-check-input" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Kích hoạt mã</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Cập nhật mã giảm giá
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleScopeFields() {
        const scope = document.getElementById('scope').value;
        document.getElementById('category-group').style.display = (scope === 'category') ? 'block' : 'none';
        document.getElementById('product-group').style.display = (scope === 'product') ? 'block' : 'none';
    }

    document.getElementById('scope').addEventListener('change', toggleScopeFields);
    window.addEventListener('DOMContentLoaded', toggleScopeFields);
</script>
@endpush
