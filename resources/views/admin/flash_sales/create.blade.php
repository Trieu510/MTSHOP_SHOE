@extends('layouts.admin')

@section('title', 'Tạo Flash Sale mới')

@section('content')
<style>
    .flash-sale-create-container {
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
        .flash-sale-create-container {
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

<div class="container-fluid flash-sale-create-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-dark fw-bold">Tạo Flash Sale mới</h1>
        <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <form action="{{ route('admin.flash-sales.store') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-body">
                {{-- Áp dụng cho --}}
                <div class="mb-3 form-group">
                    <label for="applies_to" class="form-label">Áp dụng cho</label>
                    <select name="applies_to" id="applies_to" class="form-select @error('applies_to') is-invalid @enderror" required>
                        <option value="all" {{ old('applies_to') == 'all' ? 'selected' : '' }}>Toàn bộ sản phẩm</option>
                        <option value="category" {{ old('applies_to') == 'category' ? 'selected' : '' }}>Danh mục cụ thể</option>
                        <option value="product" {{ old('applies_to') == 'product' ? 'selected' : '' }}>Sản phẩm cụ thể</option>
                    </select>
                    @error('applies_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Chọn danh mục --}}
                <div class="mb-3 form-group" id="category_field" style="display: none;">
                    <label for="category_id" class="form-label">Chọn danh mục</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Chọn sản phẩm --}}
                <div class="mb-3 form-group" id="product_field" style="display: none;">
                    <label for="product_id" class="form-label">Chọn sản phẩm</label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Giảm giá theo phần trăm --}}
                <div class="mb-3 form-group">
                    <label for="discount_percent" class="form-label">Giảm theo % (tuỳ chọn)</label>
                    <input type="number" name="discount_percent" id="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror" step="0.1" min="0" max="100"
                           value="{{ old('discount_percent') }}">
                    @error('discount_percent')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Giảm giá theo số tiền --}}
                <div class="mb-3 form-group">
                    <label for="discount_amount" class="form-label">Giảm theo số tiền (tuỳ chọn)</label>
                    <input type="number" name="discount_amount" id="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" step="1000" min="0"
                           value="{{ old('discount_amount') }}">
                    @error('discount_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Thời gian --}}
                <div class="mb-3 form-group">
                    <label for="start_time" class="form-label">Thời gian bắt đầu</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror"
                           value="{{ old('start_time') }}">
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-group">
                    <label for="end_time" class="form-label">Thời gian kết thúc</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror"
                           value="{{ old('end_time') }}">
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu Flash Sale
                    </button>
                    <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const appliesTo = document.getElementById('applies_to');
    const productField = document.getElementById('product_field');
    const categoryField = document.getElementById('category_field');

    function toggleFields() {
        const value = appliesTo.value;
        productField.style.display = value === 'product' ? 'block' : 'none';
        categoryField.style.display = value === 'category' ? 'block' : 'none';
    }

    appliesTo.addEventListener('change', toggleFields);
    window.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endpush
