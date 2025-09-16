@extends('layouts.admin')

@section('title', 'Quản lý Khách hàng')

@push('styles')
<style>
    /* ===== Page Header ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* ===== User Table Card ===== */
    .user-table-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        overflow: hidden;
    }
    .user-table-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .user-table-card .table {
        margin-bottom: 0;
    }
    .user-table-card .table thead th {
        background: #f1f5f9;
        font-weight: 600;
        color: var(--text-color);
        border-bottom: 2px solid #e5e7eb;
        padding: 1rem;
    }
    .user-table-card .table tbody tr {
        transition: var(--transition);
    }
    .user-table-card .table tbody tr:hover {
        background: #f8fafc;
    }
    .user-table-card .table td, .user-table-card .table th {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }
    .user-table-card .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 500;
    }
    .user-table-card .badge.bg-success {
        background: #d1fae5;
        color: #065f46;
    }
    .user-table-card .badge.bg-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .user-table-card .btn-outline-warning, .user-table-card .btn-outline-danger {
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 0.9rem;
        border-width: 2px;
        transition: var(--transition);
    }
    .user-table-card .btn-outline-warning {
        border-color: #f59e0b;
        color: #f59e0b;
    }
    .user-table-card .btn-outline-warning:hover {
        background: #f59e0b;
        color: #fff;
        transform: translateY(-2px);
    }
    .user-table-card .btn-outline-danger {
        border-color: #dc2626;
        color: #dc2626;
    }
    .user-table-card .btn-outline-danger:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ===== Pagination ===== */
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 0.25rem;
        color: var(--primary-color);
        font-weight: 500;
        transition: var(--transition);
    }
    .pagination .page-link:hover {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }
    .pagination .page-item.active .page-link {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }
        .user-table-card .table th, .user-table-card .table td {
            font-size: 0.9rem;
            padding: 0.75rem;
        }
        .user-table-card .badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }
        .user-table-card .btn-outline-warning, .user-table-card .btn-outline-danger {
            font-size: 0.85rem;
            padding: 0.4rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <h2 class="page-title">Danh sách Khách hàng</h2>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end mb-4">
    <div class="col-md-4">
        <label for="keyword" class="form-label">Từ khóa</label>
        <input type="text" name="keyword" id="keyword" class="form-control"
               placeholder="Tìm theo tên, email hoặc SĐT" value="{{ request('keyword') }}">
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select name="status" id="status" class="form-select">
            <option value="">-- Tất cả --</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
            <option value="locked" {{ request('status') == 'locked' ? 'selected' : '' }}>Đã khóa</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Tìm kiếm
        </button>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Xóa lọc
        </a>
    </div>
</form>


    <div class="card user-table-card" data-aos="fade-up" data-aos-delay="100">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status=='active' ? 'success' : 'danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xác nhận xóa người dùng này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
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

    <div class="mt-3" data-aos="fade-up" data-aos-delay="200">
        {{ $users->links() }}
    </div>
</div>
@endsection
