@extends('layouts.admin')

@section('title', 'Thêm Banner')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Thêm Banner Mới</h2>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-lg shadow-sm rounded-pill">
            <i class="bi bi-arrow-left-circle me-2"></i> Quay về
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.banners._form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Lưu Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.btn {
    transition: all 0.2s;
}
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endsection
