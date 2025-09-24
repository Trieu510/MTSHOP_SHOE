@extends('layouts.admin')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-star-half me-2"></i>Chi tiết đánh giá</h2>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary btn-back">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light mb-4">
        <div class="card-body p-4">
            {{-- Thông tin chung --}}
            <div class="row mb-5">
                <div class="col-12">
                    <h5 class="text-primary mb-3 fw-bold"><i class="bi bi-info-circle me-2"></i>Thông tin đánh giá</h5>
                    <div class="card bg-white border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-3 p-2 rounded-3"><i class="bi bi-person"></i></span>
                                        <div>
                                            <small class="text-muted">Người dùng</small>
                                            <p class="mb-0 fw-semibold">{{ $review->user->name ?? 'Ẩn danh' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-3 p-2 rounded-3"><i class="bi bi-box"></i></span>
                                        <div>
                                            <small class="text-muted">Sản phẩm</small>
                                            <p class="mb-0 fw-semibold">{{ $review->product->name ?? 'Đã xóa' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-3 p-2 rounded-3"><i class="bi bi-star"></i></span>
                                        <div>
                                            <small class="text-muted">Số sao</small>
                                            <div class="d-flex align-items-center">
                                                @if(!is_null($review->rating))
                                                    <div class="star-rating me-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="bi bi-star{{ $i <= (int) $review->rating ? '-fill text-warning' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="badge bg-warning text-dark rounded-pill">{{ $review->rating }}/5</span>
                                                @else
                                                    <em class="text-muted">Chưa có</em>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-3 p-2 rounded-3"><i class="bi bi-clock"></i></span>
                                        <div>
                                            <small class="text-muted">Ngày tạo</small>
                                            <p class="mb-0 fw-semibold">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-light text-dark me-3 p-2 rounded-3 mt-1"><i class="bi bi-chat-text"></i></span>
                                        <div class="flex-grow-1">
                                            <small class="text-muted">Bình luận</small>
                                            <p class="mb-0 fw-semibold bg-light p-3 rounded-3 border">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Media --}}
            @if($review->media && $review->media->count())
                <div class="row mb-5">
                    <div class="col-12">
                        <h5 class="text-primary mb-3 fw-bold"><i class="bi bi-images me-2"></i>Ảnh/Video đính kèm</h5>
                        <div class="card bg-white border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach($review->media as $media)
                                        <div class="col-xl-3 col-lg-4 col-md-6">
                                            <div class="media-card position-relative rounded-3 overflow-hidden border shadow-sm">
                                                @if($media->file_type === 'image')
                                                    <img src="{{ asset('storage/'.$media->file_path) }}"
                                                         class="img-fluid w-100"
                                                         style="height: 200px; object-fit: cover;"
                                                         alt="Ảnh đánh giá">
                                                @else
                                                    <video controls class="w-100" style="height: 200px; object-fit: cover;">
                                                        <source src="{{ asset('storage/'.$media->file_path) }}" type="video/mp4">
                                                        Trình duyệt không hỗ trợ video.
                                                    </video>
                                                @endif
                                                <div class="media-badge position-absolute top-0 end-0 m-2">
                                                    <span class="badge {{ $media->file_type === 'image' ? 'bg-success' : 'bg-info' }} rounded-pill">
                                                        {{ $media->file_type === 'image' ? 'Ảnh' : 'Video' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Phản hồi admin --}}
            <div class="row">
                <div class="col-12">
                    <h5 class="text-primary mb-3 fw-bold"><i class="bi bi-reply me-2"></i>Phản hồi của Admin</h5>
                    <div class="card bg-white border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            @if($review->reply)
                                <div class="alert alert-success border-0 rounded-3 shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <strong>Đã phản hồi</strong>
                                    </div>
                                    <p class="mb-3">{{ $review->reply->content }}</p>
                                    <div class="d-flex text-muted small">
                                        <span class="me-3">
                                            <i class="bi bi-person-shield me-1"></i>
                                            Admin (ID: {{ $review->reply->admin_id }})
                                        </span>
                                        <span>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $review->reply->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.reviews.reply', $review) }}" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="admin_reply" class="form-label fw-semibold">Nội dung phản hồi</label>
                                        <textarea name="admin_reply" id="admin_reply" rows="4"
                                                  class="form-control border-2"
                                                  placeholder="Nhập nội dung phản hồi cho đánh giá này..."
                                                  required></textarea>
                                        <div class="invalid-feedback">Vui lòng nhập nội dung phản hồi.</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4 btn-submit">
                                        <i class="bi bi-send me-2"></i>Gửi phản hồi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

    .btn-back {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #6c757d;
        color: white;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-submit {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #0052a3;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .star-rating {
        font-size: 1.2rem;
    }

    .media-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }

    .badge {
        font-size: 0.8em;
    }

    .form-control {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }

    .alert {
        border-radius: 12px;
    }

    h2, h5 {
        color: #1a1a1a;
    }

    h2 {
        font-size: 1.8rem;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .d-flex.align-items-center {
            margin-bottom: 1rem;
        }

        .media-card {
            margin-bottom: 1rem;
        }

        .btn-back, .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>

<script>
    // Validation form
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection
