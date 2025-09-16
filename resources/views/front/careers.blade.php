@extends('layouts.front')

@section('title', 'Tuyển dụng')

@push('styles')
<style>
    /* Enhanced Career Page Styles */
    .career-hero {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.85), rgba(59, 130, 246, 0.85)),
                    url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 6rem 0;
        color: white;
        border-radius: var(--border-radius-lg);
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .career-hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 120px;
        background: linear-gradient(to top, var(--bg-color), transparent);
        z-index: 1;
    }

    .career-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .career-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 6px rgba(0,0,0,0.15);
        line-height: 1.2;
    }

    .career-hero p {
        font-size: 1.3rem;
        max-width: 700px;
        margin: 0 auto;
        opacity: 0.95;
        line-height: 1.7;
    }

    /* Enhanced Company Intro */
    .company-intro {
        background: var(--secondary-color);
        padding: 4rem;
        border-radius: var(--border-radius-lg);
        margin-bottom: 5rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .company-intro::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 250px;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');
        background-size: cover;
        background-position: center;
        opacity: 0.08;
        border-top-right-radius: var(--border-radius-lg);
        border-bottom-right-radius: var(--border-radius-lg);
    }

    .company-intro h2 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-color);
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
        font-size: 2.2rem;
    }

    .company-intro h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 70px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    .company-intro p {
        font-size: 1.15rem;
        line-height: 1.9;
        max-width: 800px;
        color: var(--text-color);
    }

    /* Enhanced Job Openings */
    .job-openings {
        margin-bottom: 5rem;
    }

    .job-openings h2 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-color);
        margin-bottom: 3rem;
        text-align: center;
        position: relative;
        font-size: 2.5rem;
    }

    .job-openings h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .job-card {
        border: none;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        height: 100%;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .job-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .job-card .card-body {
        padding: 2.5rem;
    }

    .job-card .card-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.2rem;
        font-size: 1.4rem;
    }

    .job-card .card-text {
        color: var(--text-light);
        margin-bottom: 2rem;
        line-height: 1.8;
    }

    .job-card .apply-btn {
        width: 100%;
        padding: 0.9rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        letter-spacing: 0.5px;
        transition: var(--transition);
    }

    .job-card .apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Enhanced Benefits Section */
    .benefits-section {
        background: linear-gradient(135deg, var(--secondary-color), white);
        padding: 5rem 0;
        margin: 5rem 0;
        border-radius: var(--border-radius-lg);
        position: relative;
        overflow: hidden;
    }

    .benefits-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232563eb' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .benefits-section h2 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-color);
        margin-bottom: 4rem;
        text-align: center;
        position: relative;
        font-size: 2.5rem;
        z-index: 2;
    }

    .benefits-section h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .benefit-item {
        text-align: center;
        padding: 2rem;
        transition: var(--transition);
        position: relative;
        z-index: 2;
        background: white;
        border-radius: var(--border-radius);
        margin: 0 1rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .benefit-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .benefit-item i {
        font-size: 2.8rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        background: rgba(37, 99, 235, 0.1);
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .benefit-item:hover i {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        transform: rotateY(180deg) scale(1.1);
    }

    .benefit-item h5 {
        font-weight: 700;
        margin-bottom: 1.2rem;
        color: var(--dark-color);
        font-size: 1.3rem;
    }

    .benefit-item p {
        color: var(--text-light);
        font-size: 1rem;
        line-height: 1.7;
    }

    /* Enhanced Call to Action */
    .cta-section {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        border-radius: var(--border-radius-lg);
        color: white;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(30deg);
        animation: shine 8s infinite linear;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) rotate(30deg); }
        100% { transform: translateX(100%) rotate(30deg); }
    }

    .cta-section h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .cta-section p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 2.5rem;
        opacity: 0.95;
        position: relative;
        z-index: 2;
        line-height: 1.7;
    }

    .cta-section .btn-apply {
        background: white;
        color: var(--primary-color);
        font-weight: 700;
        padding: 1rem 3rem;
        border-radius: 50px;
        transition: var(--transition);
        box-shadow: var(--shadow-lg);
        position: relative;
        z-index: 2;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        border: none;
    }

    .cta-section .btn-apply:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .cta-section a.text-white {
        border-bottom: 1px dashed rgba(255,255,255,0.7);
        transition: var(--transition);
    }

    .cta-section a.text-white:hover {
        opacity: 0.9;
        border-bottom-color: white;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .career-hero h1 {
            font-size: 3.2rem;
        }

        .company-intro::after {
            width: 200px;
        }
    }

    @media (max-width: 992px) {
        .career-hero {
            padding: 5rem 0;
        }

        .career-hero h1 {
            font-size: 2.8rem;
        }

        .career-hero p {
            font-size: 1.2rem;
        }

        .company-intro::after {
            display: none;
        }

        .job-card .card-body {
            padding: 2rem;
        }

        .benefit-item {
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 768px) {
        .career-hero {
            padding: 4rem 0;
            background-attachment: scroll;
        }

        .career-hero h1 {
            font-size: 2.4rem;
        }

        .company-intro {
            padding: 3rem;
        }

        .job-openings h2,
        .benefits-section h2 {
            font-size: 2.2rem;
        }

        .cta-section h3 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .career-hero {
            padding: 3rem 0;
        }

        .career-hero h1 {
            font-size: 2rem;
        }

        .career-hero p {
            font-size: 1rem;
        }

        .company-intro {
            padding: 2rem;
        }

        .company-intro h2 {
            font-size: 1.8rem;
        }

        .job-openings h2,
        .benefits-section h2 {
            font-size: 1.8rem;
        }

        .job-card .card-body {
            padding: 1.5rem;
        }

        .cta-section {
            padding: 3rem 1.5rem;
        }

        .cta-section h3 {
            font-size: 1.6rem;
        }

        .cta-section p {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <section class="career-hero" data-aos="fade">
        <div class="career-hero-content">
            <h1>Cơ hội nghề nghiệp tại ShoeSport</h1>
            <p>
                Gia nhập ShoeSport - nơi bạn biến đam mê thời trang thể thao thành sự nghiệp! Chúng tôi tìm kiếm những tài năng nhiệt huyết để cùng tạo nên những bước đi mạnh mẽ.
            </p>
        </div>
    </section>

    <!-- Company Intro Section -->
    <section class="company-intro" data-aos="fade-up">
        <h2>Về ShoeSport</h2>
        <p>
            ShoeSport là thương hiệu giày thể thao hàng đầu, mang đến sản phẩm chất lượng và phong cách cho mọi hành trình. Với sứ mệnh truyền cảm hứng sống năng động, chúng tôi xây dựng đội ngũ gắn kết, sáng tạo và luôn hướng tới sự đổi mới. Tại ShoeSport, chúng tôi tin rằng mỗi nhân viên là một phần quan trọng trong hành trình phát triển của công ty.
        </p>
    </section>

    <!-- Job Openings Section -->
    <section class="job-openings">
        <h2>Vị trí đang tuyển dụng</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="job-card" data-aos="fade-up">
                    <div class="card-body">
                        <h5 class="card-title">Chuyên viên kinh doanh</h5>
                        <p class="card-text">
                            - Tìm kiếm và phát triển khách hàng mới<br>
                            - Xây dựng chiến lược bán hàng hiệu quả<br>
                            - Quản lý quan hệ khách hàng<br>
                            - Yêu cầu: Tốt nghiệp ĐH, giao tiếp tốt, 1-2 năm kinh nghiệm
                        </p>
                        <a href="mailto:hr@shoesport.vn?subject=Ứng tuyển Chuyên viên kinh doanh" class="btn btn-primary apply-btn">Ứng tuyển</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="job-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body">
                        <h5 class="card-title">Nhân viên kho</h5>
                        <p class="card-text">
                            - Quản lý nhập/xuất hàng hóa<br>
                            - Kiểm tra chất lượng sản phẩm<br>
                            - Đảm bảo kho vận hành trơn tru<br>
                            - Yêu cầu: Cẩn thận, khỏe mạnh, không cần kinh nghiệm
                        </p>
                        <a href="mailto:hr@shoesport.vn?subject=Ứng tuyển Nhân viên kho" class="btn btn-primary apply-btn">Ứng tuyển</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="job-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body">
                        <h5 class="card-title">Nhân viên marketing</h5>
                        <p class="card-text">
                            - Lên kế hoạch quảng bá thương hiệu<br>
                            - Quản lý nội dung mạng xã hội<br>
                            - Phân tích hiệu quả chiến dịch<br>
                            - Yêu cầu: Sáng tạo, thành thạo công cụ digital, 1 năm kinh nghiệm
                        </p>
                        <a href="mailto:hr@shoesport.vn?subject=Ứng tuyển Nhân viên marketing" class="btn btn-primary apply-btn">Ứng tuyển</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <h2>Tại sao chọn ShoeSport?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="benefit-item" data-aos="fade-up">
                    <i class="bi bi-briefcase-fill"></i>
                    <h5>Cơ hội thăng tiến</h5>
                    <p>Phát triển sự nghiệp với lộ trình rõ ràng và hỗ trợ đào tạo liên tục từ chuyên gia.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-item" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-heart-fill"></i>
                    <h5>Môi trường thân thiện</h5>
                    <p>Làm việc trong đội ngũ gắn kết, khuyến khích sáng tạo và phát triển cá nhân.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-item" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-wallet-fill"></i>
                    <h5>Phúc lợi hấp dẫn</h5>
                    <p>Lương thưởng cạnh tranh, bảo hiểm, du lịch hàng năm và các ưu đãi đặc biệt.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section" data-aos="fade-up">
        <h3>Sẵn sàng gia nhập ShoeSport?</h3>
        <p>
            Gửi CV của bạn về <a href="mailto:hr@shoesport.vn" class="text-white fw-bold">hr@shoesport.vn</a> hoặc nhấn nút dưới đây để ứng tuyển ngay hôm nay!
        </p>
        <a href="mailto:hr@shoesport.vn" class="btn btn-apply">Ứng tuyển ngay</a>
    </section>
</div>
@endsection
