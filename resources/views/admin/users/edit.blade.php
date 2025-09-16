@extends('layouts.admin')

@section('title', 'Chỉnh sửa Người dùng')

@push('styles')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #f8fafc;
        --accent-color: #f59e0b;
        --text-color: #1e293b;
        --text-light: #64748b;
        --bg-color: #ffffff;
        --dark-color: #0f172a;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.12);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 12px;
        --border-radius-lg: 20px;
    }

    /* ===== Page Header ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        position: relative;
        display: inline-block;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .page-header .btn-secondary {
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border: 2px solid #6b7280;
        color: #6b7280;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-header .btn-secondary:hover {
        background: #6b7280;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    /* ===== Edit Form Card ===== */
    .edit-form-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: none;
        overflow: hidden;
    }

    .edit-form-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .edit-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .edit-form-card .card-body {
        padding: 2rem;
    }

    .edit-form-card .form-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .edit-form-card .form-select {
        border-radius: var(--border-radius);
        border: 1px solid #d1d5db;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        width: 100%;
        max-width: 400px;
        background-color: #f9fafb;
    }

    .edit-form-card .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        background-color: white;
        outline: none;
    }

    .edit-form-card .is-invalid {
        border-color: #dc2626;
    }

    .edit-form-card .invalid-feedback {
        font-size: 0.85rem;
        color: #dc2626;
        margin-top: 0.25rem;
    }

    .edit-form-card .btn-primary {
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        background: var(--primary-color);
        border: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .edit-form-card .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-header .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .edit-form-card .card-body {
            padding: 1.5rem;
        }

        .edit-form-card .form-select {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header" data-aos="fade-up">
        <h2 class="page-title">Chỉnh sửa: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Quay về
        </a>
    </div>

    @include('admin.partials.alerts')

    <!-- Edit Form -->
    <div class="card edit-form-card mt-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="form-label">Trạng thái tài khoản</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="locked" {{ $user->status == 'locked' ? 'selected' : '' }}>Locked</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save2"></i> Lưu thay đổi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
