@extends('layouts.admin')

@section('title', 'Chỉnh sửa Phí Vận Chuyển')

@section('content')
<style>
    .shipping-fee-edit-container {
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
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .btn-success, .btn-secondary {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: #28a745;
        border: none;
    }

    .btn-success:hover {
        background: #218838;
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

    .alert {
        border-radius: 10px;
        padding: 1rem;
        animation: fadeIn 0.5s ease-in;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: none;
    }

    @media (max-width: 768px) {
        .shipping-fee-edit-container {
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

<div class="container-fluid shipping-fee-edit-container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark fw-bold"><i class="bi bi-truck me-2"></i>Chỉnh sửa Phí Vận Chuyển</h2>
        <a href="{{ route('admin.shipping_fees.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.shipping_fees.update', $shippingFee) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.shipping_fees._form', ['shippingFee' => $shippingFee])
            </form>
        </div>
    </div>
</div>
@endsection
