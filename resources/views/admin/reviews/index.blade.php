@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

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

    /* ===== Page Title ===== */
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 2rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    /* ===== Flash Messages ===== */
    .alert-success {
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-sm);
        font-weight: 500;
        background: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    /* ===== Review Table Card ===== */
    .review-table-card {
        background: var(--bg-color);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        overflow: hidden;
        border: none;
    }

    .review-table-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .review-table-card .table {
        margin-bottom: 0;
    }

    .review-table-card .table thead th {
        background: #f8fafc;
        font-weight: 600;
        color: var(--text-light);
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .review-table-card .table tbody tr {
        transition: var(--transition);
    }

    .review-table-card .table tbody tr:hover {
        background: #f8fafc;
    }

    .review-table-card .table td,
    .review-table-card .table th {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
    }

    .review-table-card .table td a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .review-table-card .table td a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .rating-stars {
        display: flex;
        gap: 0.25rem;
    }

    .rating-stars i {
        font-size: 1rem;
        color: var(--accent-color);
    }

    .comment-cell {
        max-width: 300px;
        white-space: pre-wrap;
        font-size: 0.95rem;
        color: var(--text-light);
        line-height: 1.5;
    }

    .text-muted {
        font-size: 0.95rem;
        color: var(--text-light);
    }

    .action-btn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-outline-danger {
        border-radius: var(--border-radius);
        padding: 0.5rem;
        font-size: 0.9rem;
        border: 2px solid #dc2626;
        color: #dc2626;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
    }

    .btn-outline-danger:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
    }

    /* ===== Empty State ===== */
    .empty-state {
        padding: 2rem;
        text-align: center;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .review-table-card .table {
            display: block;
            overflow-x: auto;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }

        .alert-success {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }

        .review-table-card .table th,
        .review-table-card .table td {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .comment-cell {
            max-width: 200px;
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <h2 class="page-title" data-aos="fade-up">Danh sách Đánh giá</h2>

    @if(session('success'))
        <div class="alert alert-success" data-aos="fade-up" data-aos-delay="100">
            {{ session('success') }}
        </div>
    @endif
        <form method="GET" class="row g-3 mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="col-md-4">
        <input type="text" name="user" value="{{ request('user') }}" class="form-control" placeholder="Người đánh giá">
    </div>
    <div class="col-md-4">
        <input type="text" name="product" value="{{ request('product') }}" class="form-control" placeholder="Sản phẩm">
    </div>
    <div class="col-md-3">
        <select name="rating" class="form-select">
            <option value="">-- Tất cả sao --</option>
            @for($i=5; $i>=1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                    {{ $i }} sao
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-1 d-grid">
        <button class="btn btn-primary">Lọc</button>
    </div>
</form>

    <div class="card review-table-card" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Người đánh giá</th>
                        <th>Sản phẩm</th>
                        <th>Đánh giá</th>
                        <th>Bình luận</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $idx => $review)
                    <tr>
                        <td>{{ $idx+1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div>{{ $review->user->name }}</div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $review->product_id) }}">
                                {{ Str::limit($review->product->name, 30) }}
                            </a>
                        </td>
                        <td>
                            <div class="rating-stars">
    @for($i=1; $i<=5; $i++)
        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
    @endfor
</div>

                        </td>
                        <td class="comment-cell">
    {{ $review->comment ?: '-' }}

    @if ($review->reply)
    <div class="mt-2 text-primary small">
        <strong>Phản hồi:</strong> {{ $review->reply->content }}
    </div>
    @else
        <button class="btn btn-sm btn-link text-primary p-0 mt-2" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $review->id }}">
            Phản hồi
        </button>

        <div class="collapse mt-2" id="replyForm{{ $review->id }}">
            <form action="{{ route('admin.reviews.reply', $review) }}" method="POST">
                @csrf
                <textarea name="admin_reply" class="form-control form-control-sm mb-2" rows="2" placeholder="Nhập phản hồi..."></textarea>
                <button type="submit" class="btn btn-sm btn-success">Gửi</button>
            </form>
        </div>
    @endif
</td>

                        <td>
                            <span class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td>
                            <div class="action-btn">
                                <form action="{{ route('admin.reviews.destroy', $review) }}"
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa đánh giá">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if($reviews->isEmpty())
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="bi bi-chat-square-text"></i>
                                <p>Chưa có đánh giá nào</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
