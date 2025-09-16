@extends('layouts.front')

@section('title', 'Chính sách bảo hành')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-effect: rgba(255, 255, 255, 0.15);
        --text-dark: #1e293b;
        --text-light: #64748b;
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition-all: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Page Title ===== */
    .page-title {
        font-size: 2.75rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 3rem;
        position: relative;
        display: inline-block;
        text-align: center;
        width: 100%;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* ===== Warranty Section ===== */
    .warranty-section {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-xl);
        transition: var(--transition-all);
        margin-bottom: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    .warranty-section:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .warranty-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--primary-gradient);
    }
    .warranty-section h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 1.5rem;
    }
    .warranty-section h2::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary-gradient);
    }
    .warranty-section p {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 1.05rem;
        margin-bottom: 1.25rem;
    }

    /* ===== Lists Styling ===== */
    .warranty-section ul, .warranty-section ol {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .warranty-section ul li, .warranty-section ol li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
        color: var(--text-light);
        font-size: 1.05rem;
        line-height: 1.7;
    }
    .warranty-section ul li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236676ea'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        background-size: contain;
    }
    .warranty-section ol {
        counter-reset: warranty-counter;
    }
    .warranty-section ol li {
        counter-increment: warranty-counter;
    }
    .warranty-section ol li::before {
        content: counter(warranty-counter);
        position: absolute;
        left: 0;
        top: 0;
        width: 24px;
        height: 24px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .warranty-section ul li strong,
    .warranty-section ol li strong {
        color: var(--text-dark);
        font-weight: 600;
    }

    /* ===== Contact Section ===== */
    .contact-section ul li a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition-all);
        display: inline-flex;
        align-items: center;
    }
    .contact-section ul li a:hover {
        color: #4f46e5;
        text-decoration: underline;
    }
    .contact-section ul li a i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    /* ===== FAQ Section ===== */
    .faq-section .faq-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px dashed rgba(203, 213, 225, 0.5);
    }
    .faq-section .faq-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .faq-section .faq-question {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        position: relative;
        padding-left: 1.5rem;
    }
    .faq-section .faq-question::before {
        content: 'Q:';
        position: absolute;
        left: 0;
        color: #6366f1;
        font-weight: 700;
    }
    .faq-section .faq-answer {
        color: var(--text-light);
        line-height: 1.8;
        position: relative;
        padding-left: 1.5rem;
    }
    .faq-section .faq-answer::before {
        content: 'A:';
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 700;
    }

    /* ===== Background Elements ===== */
    .warranty-bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .warranty-bg-elements .circle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }
    .warranty-bg-elements .circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }
    .warranty-bg-elements .circle-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .page-title {
            font-size: 2.5rem;
        }
        .warranty-section {
            padding: 2rem;
        }
    }
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.25rem;
        }
        .warranty-section h2 {
            font-size: 1.6rem;
        }
        .warranty-section {
            padding: 1.75rem;
        }
        .warranty-section p,
        .warranty-section ul li,
        .warranty-section ol li {
            font-size: 1rem;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 2rem;
        }
        .warranty-section {
            padding: 1.5rem;
            border-radius: 16px;
        }
        .warranty-section h2 {
            font-size: 1.4rem;
            padding-left: 1.25rem;
        }
        .warranty-section ul li,
        .warranty-section ol li {
            padding-left: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 position-relative">
    <!-- Background elements -->
    <div class="warranty-bg-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <h1 class="page-title" data-aos="fade-up">Chính sách bảo hành</h1>

    <section class="warranty-section" data-aos="fade-up" data-aos-delay="100">
        <h2>1. Phạm vi áp dụng</h2>
        <p>Chính sách này áp dụng cho tất cả các sản phẩm được mua tại hệ thống cửa hàng và website ShoeSport.vn kể từ ngày {{ date('Y') }}.</p>
    </section>

    <section class="warranty-section" data-aos="fade-up" data-aos-delay="150">
        <h2>2. Thời gian bảo hành</h2>
        <ul>
            <li><strong>Giày thể thao:</strong> 12 tháng kể từ ngày mua, áp dụng cho lỗi kỹ thuật do nhà sản xuất.</li>
            <li><strong>Phụ kiện (tất, dây giày, túi đựng):</strong> 3 tháng kể từ ngày mua.</li>
            <li><strong>Giày limited edition:</strong> 6 tháng kể từ ngày mua với điều kiện bảo quản nguyên tem.</li>
        </ul>
    </section>

    <section class="warranty-section" data-aos="fade-up" data-aos-delay="200">
        <h2>3. Điều kiện bảo hành</h2>
        <ul>
            <li>Sản phẩm còn trong thời gian bảo hành và chưa quá 7 ngày kể từ ngày hết hạn bảo hành kèm theo hóa đơn hoặc phiếu bảo hành.</li>
            <li>Tem bảo hành, nhãn mác, thẻ rời (nếu có) còn nguyên vẹn, không bị sửa chữa, rách, tẩy xóa.</li>
            <li>Lỗi do sản xuất: bong tróc đế, đứt chỉ, đứt keo—không áp dụng với mòn đế, trầy xước, oxi hóa tự nhiên.</li>
            <li>Sản phẩm không bị biến dạng do tác động ngoại lực hoặc sử dụng không đúng cách.</li>
        </ul>
    </section>

    <section class="warranty-section" data-aos="fade-up" data-aos-delay="250">
        <h2>4. Quy trình bảo hành</h2>
        <ol>
            <li>Khách hàng mang sản phẩm cùng hóa đơn/phiếu bảo hành đến bất kỳ cửa hàng ShoeSport nào.</li>
            <li>Nhân viên kiểm tra tình trạng sản phẩm theo điều kiện bảo hành (thời gian xử lý: 1-3 ngày làm việc).</li>
            <li>Nếu đủ điều kiện, chúng tôi sẽ tiến hành sửa chữa hoặc đổi mới (tùy tình trạng hư hỏng).</li>
            <li>Thời gian hoàn thành bảo hành: từ 3–7 ngày làm việc, không tính thứ bảy, chủ nhật và ngày lễ.</li>
            <li>Khách hàng sẽ được thông báo khi sản phẩm sẵn sàng để nhận lại.</li>
        </ol>
    </section>

    <section class="warranty-section contact-section" data-aos="fade-up" data-aos-delay="300">
        <h2>5. Liên hệ bảo hành</h2>
        <p>Để biết thêm chi tiết hoặc cần hỗ trợ, xin liên hệ:</p>
        <ul>
            <li><a href="tel:1900232464"><i class="fas fa-phone-alt"></i>Hotline bảo hành: 1900 232 464</a></li>
            <li><a href="mailto:service@shoesport.vn"><i class="fas fa-envelope"></i>Email CSKH: service@shoesport.vn</a></li>
            <li><i class="fas fa-map-marker-alt"></i>Địa chỉ trung tâm bảo hành: Số 256, đường Nguyễn Văn Cừ, phường An Hòa, quận Ninh Kiều, TP Cần Thơ</li>
        </ul>
    </section>

    <section class="warranty-section faq-section" data-aos="fade-up" data-aos-delay="350">
        <h2>6. Câu hỏi thường gặp</h2>
        <div class="faq-item">
            <div class="faq-question">Sản phẩm bị mòn đế có được bảo hành không?</div>
            <div class="faq-answer">Không. Mòn đế do sử dụng thuộc hao mòn tự nhiên, không được bảo hành theo chính sách của chúng tôi.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Tôi có thể gửi bảo hành qua đường bưu điện không?</div>
            <div class="faq-answer">Có. Xin liên hệ hotline để được hướng dẫn quy trình gửi và nhận. Lưu ý: Khách hàng chịu trách nhiệm đóng gói và chi phí vận chuyển đến trung tâm bảo hành.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Sản phẩm hết bảo hành có được hỗ trợ sửa chữa không?</div>
            <div class="faq-answer">Có. Chúng tôi vẫn hỗ trợ sửa chữa với chi phí phát sinh. Vui lòng liên hệ hotline để được báo giá cụ thể.</div>
        </div>
    </section>
</div>
@endsection
