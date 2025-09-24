@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@push('styles')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #f8fafc;
        --accent-color: #f59e0b;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --text-color: #1e293b;
        --text-light: #64748b;
        --text-lighter: #94a3b8;
        --bg-color: #ffffff;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --dark-color: #0f172a;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.12);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 8px;
        --border-radius-lg: 12px;
        --border-radius-xl: 16px;
    }

    /* ===== Page Header ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -1.5rem;
        left: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .reviews-count {
        background: var(--bg-light);
        color: var(--text-light);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* ===== Flash Messages ===== */
    .alert-success {
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-sm);
        font-weight: 500;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        transition: var(--transition);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success i {
        font-size: 1.2rem;
    }

    /* ===== Filter Section ===== */
    .filter-card {
        background: var(--bg-color);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .filter-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-title i {
        color: var(--primary-color);
    }

    .filter-form .row {
        align-items: end;
    }

    .form-control, .form-select {
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn-filter {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
        height: fit-content;
    }

    .btn-filter:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== Review Table Card ===== */
    .review-table-card {
        background: var(--bg-color);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .review-table-card:hover {
        box-shadow: var(--shadow-md);
    }

    .table-header {
        background: var(--bg-light);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0;
    }

    .review-table-card .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .review-table-card .table thead th {
        background: var(--bg-light);
        font-weight: 600;
        color: var(--text-light);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.25rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .review-table-card .table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid var(--border-color);
    }

    .review-table-card .table tbody tr:last-child {
        border-bottom: none;
    }

    .review-table-card .table tbody tr:hover {
        background: #fafafa;
    }

    .review-table-card .table td,
    .review-table-card .table th {
        padding: 1.25rem 1.25rem;
        vertical-align: middle;
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

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 500;
        color: var(--text-color);
    }

    .user-email {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .product-image {
        width: 40px;
        height: 40px;
        border-radius: var(--border-radius);
        object-fit: cover;
        background: var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }

    .product-name {
        font-weight: 500;
        color: var(--text-color);
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .rating-stars {
        display: flex;
        gap: 0.2rem;
    }

    .rating-stars i {
        font-size: 1.1rem;
        color: var(--accent-color);
    }

    .rating-value {
        margin-left: 0.5rem;
        font-weight: 600;
        color: var(--text-color);
        background: var(--bg-light);
        padding: 0.2rem 0.5rem;
        border-radius: var(--border-radius);
        font-size: 0.8rem;
    }

    .comment-cell {
        max-width: 300px;
        white-space: pre-wrap;
        font-size: 0.9rem;
        color: var(--text-color);
        line-height: 1.5;
    }

    .comment-preview {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .reply-section {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px dashed var(--border-color);
    }

    .reply-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--primary-color);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: var(--border-radius);
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .reply-content {
        font-size: 0.85rem;
        color: var(--text-color);
        background: var(--bg-light);
        padding: 0.75rem;
        border-radius: var(--border-radius);
        border-left: 3px solid var(--primary-color);
    }

    .reply-form {
        margin-top: 0.75rem;
    }

    .reply-form textarea {
        font-size: 0.85rem;
        resize: vertical;
        min-height: 80px;
    }

    .btn-reply {
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-reply:hover {
        background: #0da271;
        transform: translateY(-1px);
    }

    .date-cell {
        font-size: 0.85rem;
        color: var(--text-light);
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .btn-view {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        border: none;
    }

    .btn-view:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: none;
    }

    .btn-delete:hover {
        background: var(--danger-color);
        color: white;
        transform: translateY(-2px);
    }

    /* ===== Empty State ===== */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--text-light);
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
        opacity: 0.7;
    }

    .empty-state-text {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .empty-state-subtext {
        font-size: 0.9rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* ===== Pagination ===== */
    .pagination-container {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        font-size: 0.85rem;
        color: var(--text-light);
    }

    .pagination .page-link {
        border: 1px solid var(--border-color);
        color: var(--text-color);
        padding: 0.5rem 0.75rem;
        border-radius: var(--border-radius);
        margin: 0 0.15rem;
        transition: var(--transition);
    }

    .pagination .page-link:hover {
        background: var(--bg-light);
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .review-table-card .table {
            display: block;
            overflow-x: auto;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .reviews-count {
            align-self: flex-start;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .filter-card {
            padding: 1rem;
        }

        .review-table-card .table th,
        .review-table-card .table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        .comment-cell {
            max-width: 200px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 30px;
            height: 30px;
        }

        .pagination-container {
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
    }

    @media (max-width: 576px) {
        .filter-form .row {
            flex-direction: column;
        }

        .filter-form .col-md-1 {
            width: 100%;
        }

        .btn-filter {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header" data-aos="fade-up">
        <div>
            <h2 class="page-title">Quản lý Đánh giá</h2>
            <div class="reviews-count">
                <i class="bi bi-chat-square-text me-1"></i>
                Tổng số: {{ $reviews->total() }} đánh giá
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success" data-aos="fade-up" data-aos-delay="100">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-card" data-aos="fade-up" data-aos-delay="150">
        <div class="filter-title">
            <i class="bi bi-funnel"></i>
            Bộ lọc đánh giá
        </div>
        <form method="GET" class="filter-form">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Người đánh giá</label>
                    <input type="text" name="user" value="{{ request('user') }}" class="form-control" placeholder="Tìm theo tên...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Sản phẩm</label>
                    <input type="text" name="product" value="{{ request('product') }}" class="form-control" placeholder="Tìm theo tên sản phẩm...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Đánh giá sao</label>
                    <select name="rating" class="form-select">
                        <option value="">-- Tất cả đánh giá --</option>
                        @for($i=5; $i>=1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} sao
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-filter w-100">
                        <i class="bi bi-search me-2"></i>Lọc kết quả
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="review-table-card" data-aos="fade-up" data-aos-delay="200">
        <div class="table-header">
            <h3 class="table-title">Danh sách đánh giá</h3>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Người đánh giá</th>
                        <th>Sản phẩm</th>
                        <th width="140">Đánh giá</th>
                        <th>Nội dung</th>
                        <th width="140">Ngày tạo</th>
                        <th width="100">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $idx => $review)
                    <tr>
                        <td class="fw-semibold text-muted">{{ $idx + 1 + (($reviews->currentPage() - 1) * $reviews->perPage()) }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $review->user->name }}</div>
                                    <div class="user-email">{{ $review->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="product-info">
                                <div class="product-image">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <a href="{{ route('admin.products.edit', $review->product_id) }}" class="product-name" title="{{ $review->product->name }}">
                                    {{ Str::limit($review->product->name, 30) }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rating-stars">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <span class="rating-value">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td class="comment-cell">
                            @if($review->comment)
                                <div class="comment-preview">{{ $review->comment }}</div>
                            @else
                                <span class="text-muted fst-italic">Không có bình luận</span>
                            @endif

                            <!-- Reply Section -->
                            <div class="reply-section">
                                @if ($review->reply)
                                    <div class="reply-badge">
                                        <i class="bi bi-reply-fill"></i> Đã phản hồi
                                    </div>
                                    <div class="reply-content">
                                        {{ $review->reply->content }}
                                    </div>
                                @else
                                    <button class="btn btn-link text-primary p-0 text-decoration-none small" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $review->id }}">
                                        <i class="bi bi-reply me-1"></i> Phản hồi đánh giá
                                    </button>

                                    <div class="collapse mt-2" id="replyForm{{ $review->id }}">
                                        <form action="{{ route('admin.reviews.reply', $review) }}" method="POST" class="reply-form">
                                            @csrf
                                            <textarea name="admin_reply" class="form-control mb-2" rows="2" placeholder="Nhập phản hồi của bạn..."></textarea>
                                            <button type="submit" class="btn btn-reply">
                                                <i class="bi bi-send me-1"></i> Gửi phản hồi
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="date-cell">
                            <div>{{ $review->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $review->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.reviews.show', $review) }}"
                                   class="btn-action btn-view" title="Xem chi tiết">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}"
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Xóa đánh giá">
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
                                <i class="bi bi-chat-square-text empty-state-icon"></i>
                                <p class="empty-state-text">Chưa có đánh giá nào</p>
                                <p class="empty-state-subtext">Khi có đánh giá mới, chúng sẽ xuất hiện tại đây.</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Hiển thị {{ $reviews->firstItem() }} đến {{ $reviews->lastItem() }} của {{ $reviews->total() }} kết quả
            </div>
            <div>
                {{ $reviews->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
