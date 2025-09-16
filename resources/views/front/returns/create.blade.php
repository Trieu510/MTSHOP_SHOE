@extends('layouts.front')

@section('title', 'Yêu cầu hoàn/trả hàng')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h2 class="mb-0 text-primary">Yêu cầu hoàn/trả hàng - Đơn hàng #{{ $order->id }}</h2>
        </div>

        <div class="card-body">
            <!-- Chính sách hoàn/trả hàng -->
            <div class="policy-card bg-light-blue p-4 mb-4 rounded-3 border border-primary">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-info-circle fs-4 text-primary me-2"></i>
                    <h5 class="mb-0 fw-bold">Chính sách hoàn/trả hàng</h5>
                </div>
                <ul class="list-unstyled mb-3">
                    <li class="mb-2 d-flex">
                        <span class="me-2">⏱️</span>
                        <div>
                            <strong>Thời gian yêu cầu:</strong> Trong vòng <strong class="text-danger">7 ngày</strong> kể từ ngày đơn hàng được giao thành công.
                        </div>
                    </li>
                    <li class="mb-2 d-flex">
                        <span class="me-2">📦</span>
                        <div>
                            <strong>Điều kiện hoàn trả:</strong>
                            <ul class="mt-1">
                                <li>Sản phẩm còn nguyên bao bì, chưa qua sử dụng, không bị dơ bẩn hoặc hư hỏng do người dùng.</li>
                                <li>Đầy đủ phụ kiện, quà tặng đi kèm (nếu có).</li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-2 d-flex">
                        <span class="me-2">📸</span>
                        <div>
                            <strong class="text-danger">Bắt buộc đính kèm hình ảnh thực tế</strong> nếu sản phẩm bị lỗi, hư hỏng hoặc giao sai.
                        </div>
                    </li>
                    <li class="mb-2 d-flex">
                        <span class="me-2">🚫</span>
                        <div>
                            <strong>Không áp dụng:</strong> Với các sản phẩm khuyến mãi, đồng giá, hàng thanh lý, sản phẩm bị tác động do người sử dụng.
                        </div>
                    </li>
                    <li class="mb-2 d-flex">
                        <span class="me-2">🔁</span>
                        <div>
                            <strong>Hình thức xử lý:</strong>
                            <ul class="mt-1">
                                <li>Đổi sản phẩm mới cùng loại nếu còn hàng.</li>
                                <li>Hoàn tiền qua hình thức ban đầu nếu không còn sản phẩm thay thế.</li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-2 d-flex">
                        <span class="me-2">🕐</span>
                        <div>
                            <strong>Thời gian phản hồi:</strong> Trong vòng <strong>24-48 giờ làm việc</strong> kể từ khi nhận được yêu cầu và hình ảnh.
                        </div>
                    </li>
                    <li class="d-flex">
                        <span class="me-2">🚚</span>
                        <div>
                            <strong>Chi phí vận chuyển:</strong>
                            <ul class="mt-1">
                                <li>Miễn phí nếu lỗi do nhà bán hàng hoặc vận chuyển.</li>
                                <li>Khách hàng chịu phí nếu yêu cầu đổi do không vừa, không thích,...</li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="contact-info mt-3 pt-2 border-top">
                    <p class="mb-0">Mọi thắc mắc, vui lòng liên hệ <strong>Hotline</strong>: <a href="tel:19001234" class="text-decoration-none">1900 1234</a> hoặc <strong>Email</strong>: <a href="mailto:hotro@mtshop.vn" class="text-decoration-none">hotro@mtshop.vn</a>.</p>
                </div>
            </div>

            <!-- Form gửi yêu cầu -->
            <div class="request-form bg-white p-4 rounded-3 border">
                <h5 class="mb-4 text-primary"><i class="fas fa-edit me-2"></i>Thông tin yêu cầu</h5>

                <form action="{{ route('returns.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="reason" class="form-label fw-bold">Lý do hoàn trả <span class="text-danger">*</span></label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ old('reason') }}</textarea>
                        <div class="form-text">Vui lòng mô tả chi tiết lý do và tình trạng sản phẩm</div>
                        @error('reason')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="images" class="form-label fw-bold">Hình ảnh sản phẩm lỗi (tối đa 3 ảnh)</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <div class="form-text">Chụp rõ sản phẩm và lỗi (nếu có), định dạng JPG/PNG, mỗi ảnh tối đa 2MB</div>
                        @error('images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 mt-4 pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-1">
                            <i class="fas fa-paper-plane me-2"></i> Gửi yêu cầu
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-1">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-blue {
        background-color: rgba(231, 243, 255, 0.5);
    }
    .policy-card li {
        padding: 4px 0;
    }
    .request-form {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>
@endsection
