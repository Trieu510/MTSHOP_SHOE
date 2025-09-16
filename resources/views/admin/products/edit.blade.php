@extends('layouts.admin')

@section('title', 'Chỉnh sửa Sản phẩm')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Chỉnh sửa: {{ $product->name }}</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay về
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.products._form')
                <button type="submit" class="btn btn-warning btn-save">
                    <i class="bi bi-save2 me-1"></i> Cập nhật
                </button>
            </form>
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

    .btn-back, .btn-save {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #5a6268;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-save:hover {
        background-color: #e0a800;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
    }

    @media (max-width: 768px) {
        .btn-back, .btn-save {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
    }
</style>
@endsection
