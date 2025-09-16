@extends('layouts.front')

@section('title', 'Giới thiệu ShoeSport')

@push('styles')
<style>
    /* ===== Enhanced Hero Section ===== */
    .about-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(37, 99, 235, 0.85)),
                    url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 7rem 0;
        color: white;
        text-align: center;
        margin-bottom: 5rem;
        border-radius: var(--border-radius-lg);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .about-hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 150px;
        background: linear-gradient(to top, var(--bg-color), transparent);
        z-index: 1;
    }

    .about-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .about-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 6px rgba(0,0,0,0.15);
        line-height: 1.2;
    }

    .about-hero p {
        font-size: 1.3rem;
        max-width: 700px;
        margin: 0 auto;
        opacity: 0.95;
        line-height: 1.7;
    }

    /* ===== Enhanced About Sections ===== */
    .about-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 4rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .about-section:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .about-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.3rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }

    .about-section h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 70px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    .about-section p {
        color: var(--text-light);
        line-height: 1.9;
        font-size: 1.15rem;
        margin-bottom: 1.5rem;
    }

    .about-section ul {
        list-style: none;
        padding: 0;
    }

    .about-section ul li {
        position: relative;
        padding-left: 2.5rem;
        margin-bottom: 1.2rem;
        color: var(--text-light);
        font-size: 1.15rem;
        line-height: 1.7;
    }

    .about-section ul li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--primary-color);
        font-weight: bold;
        font-size: 1.5rem;
        top: -2px;
    }

    .about-section ul li strong {
        color: var(--dark-color);
        font-weight: 600;
    }

    /* ===== Enhanced Team Section ===== */
    .team-section {
        background: var(--secondary-color);
        padding: 5rem 0;
        margin: 5rem 0;
        border-radius: var(--border-radius-lg);
        position: relative;
        overflow: hidden;
    }

    .team-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232563eb' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .team-section h2 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-color);
        margin-bottom: 4rem;
        text-align: center;
        position: relative;
        font-size: 2.5rem;
        z-index: 2;
    }

    .team-section h2::after {
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

    .team-member {
        text-align: center;
        transition: var(--transition);
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .team-member:hover {
        transform: translateY(-10px);
    }

    .team-member-img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 2rem;
        border: 6px solid white;
        box-shadow: var(--shadow-lg);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .team-member:hover .team-member-img {
        transform: scale(1.1);
        box-shadow: var(--shadow-xl);
    }

    .team-member h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        font-size: 1.4rem;
    }

    .team-member p {
        color: var(--text-light);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .team-member .social-links {
        margin-top: 1.5rem;
    }

    .team-member .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(37, 99, 235, 0.1);
        border-radius: 50%;
        color: var(--primary-color);
        margin: 0 0.3rem;
        transition: var(--transition);
    }

    .team-member .social-links a:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    /* ===== Enhanced Milestones Section ===== */
    .milestones {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin: 4rem 0;
        gap: 2rem;
    }

    .milestone-item {
        text-align: center;
        padding: 2rem;
        min-width: 220px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
    }

    .milestone-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
    }

    .milestone-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .milestone-text {
        font-size: 1.1rem;
        color: var(--text-light);
        font-weight: 500;
    }

    /* ===== Enhanced Contact Section ===== */
    .contact-section {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        padding: 4rem;
        border-radius: var(--border-radius-lg);
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .contact-section::before {
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

    .contact-section h2 {
        font-family: 'Playfair Display', serif;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
        font-size: 2.3rem;
        z-index: 2;
    }

    .contact-section h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 70px;
        height: 4px;
        background: white;
        border-radius: 2px;
    }

    .contact-section p {
        font-size: 1.15rem;
        opacity: 0.95;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
        line-height: 1.7;
    }

    .contact-section ul {
        list-style: none;
        padding: 0;
        position: relative;
        z-index: 2;
    }

    .contact-section ul li {
        margin-bottom: 1.5rem;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
    }

    .contact-section ul li i {
        margin-right: 1.5rem;
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .contact-section ul li a {
        color: white;
        text-decoration: none;
        transition: var(--transition);
        border-bottom: 1px dashed rgba(255,255,255,0.5);
    }

    .contact-section ul li a:hover {
        color: var(--accent-color);
        border-bottom-color: white;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1200px) {
        .about-hero h1 {
            font-size: 3.5rem;
        }

        .team-member-img {
            width: 180px;
            height: 180px;
        }
    }

    @media (max-width: 992px) {
        .about-hero {
            padding: 6rem 0;
        }

        .about-hero h1 {
            font-size: 3rem;
        }

        .about-section {
            padding: 3rem;
        }

        .milestone-item {
            min-width: 180px;
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 5rem 0;
            background-attachment: scroll;
        }

        .about-hero h1 {
            font-size: 2.5rem;
        }

        .about-hero p {
            font-size: 1.1rem;
        }

        .about-section {
            padding: 2.5rem;
        }

        .about-section h2 {
            font-size: 2rem;
        }

        .team-section h2 {
            font-size: 2.2rem;
        }

        .contact-section h2 {
            font-size: 2rem;
        }

        .milestones {
            gap: 1rem;
        }

        .milestone-item {
            min-width: calc(50% - 1rem);
        }
    }

    @media (max-width: 576px) {
        .about-hero h1 {
            font-size: 2.2rem;
        }

        .about-hero p {
            font-size: 1rem;
        }

        .about-section {
            padding: 2rem;
        }

        .about-section h2 {
            font-size: 1.8rem;
        }

        .team-section {
            padding: 4rem 0;
        }

        .team-section h2 {
            font-size: 2rem;
        }

        .team-member-img {
            width: 160px;
            height: 160px;
        }

        .contact-section {
            padding: 3rem 2rem;
        }

        .milestone-item {
            min-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <section class="about-hero" data-aos="fade">
        <div class="about-hero-content">
            <h1>Về ShoeSport</h1>
            <p>
                Hành trình của chúng tôi - Đam mê thể thao, sáng tạo phong cách và cam kết chất lượng
            </p>
        </div>
    </section>

    <!-- Lịch sử hình thành -->
    <section class="about-section" data-aos="fade-up">
        <h2>Lịch sử hình thành</h2>
        <p>
            ShoeSport được chính thức thành lập vào năm 2025 bởi anh
            <strong>Nguyễn Minh Triều</strong> với khát vọng mang đến cho khách hàng
            những đôi giày thể thao không chỉ đẹp mắt mà còn bền bỉ, thoải mái.
            Từ cửa hàng đầu tiên tại trung tâm thành phố, ShoeSport nhanh chóng
            khẳng định vị thế trong cộng đồng yêu thể thao và streetwear.
        </p>
        <p>
            Chúng tôi tự hào về hành trình phát triển, không ngừng mở rộng chuỗi
            cửa hàng và kênh bán hàng trực tuyến, phục vụ hàng nghìn khách hàng
            trên khắp cả nước.
        </p>
    </section>

    <!-- Sứ mệnh & Giá trị cốt lõi -->
    <section class="about-section" data-aos="fade-up">
        <h2>Sứ mệnh & Giá trị cốt lõi</h2>
        <ul>
            <li><strong>Chất lượng hàng đầu:</strong> Lựa chọn kỹ lưỡng từ những thương hiệu uy tín và kiểm định nghiêm ngặt.</li>
            <li><strong>Đổi mới sáng tạo:</strong> Liên tục cập nhật xu hướng, thiết kế độc đáo, phù hợp với mọi phong cách.</li>
            <li><strong>Cộng đồng kết nối:</strong> Xây dựng sân chơi chung cho những ai đam mê vận động và streetwear.</li>
            <li><strong>Trách nhiệm xã hội:</strong> Ủng hộ các phong trào thể thao, khuyến khích lối sống năng động, lành mạnh.</li>
        </ul>
    </section>

    <!-- Thành tựu nổi bật -->
    <div class="milestones" data-aos="fade-up">
        <div class="milestone-item">
            <div class="milestone-number">10K+</div>
            <div class="milestone-text">Khách hàng hài lòng</div>
        </div>
        <div class="milestone-item">
            <div class="milestone-number">50+</div>
            <div class="milestone-text">Thương hiệu đối tác</div>
        </div>
        <div class="milestone-item">
            <div class="milestone-number">5</div>
            <div class="milestone-text">Cửa hàng trên toàn quốc</div>
        </div>
        <div class="milestone-item">
            <div class="milestone-number">100%</div>
            <div class="milestone-text">Cam kết chất lượng</div>
        </div>
    </div>

    <!-- Đội ngũ sáng lập -->
    <section class="team-section" data-aos="fade-up">
        <h2>Đội ngũ sáng lập</h2>
        <div class="row">
            <div class="col-md-4 team-member">
                <img src="{{ asset('storage/avatars/founder.jpg') }}"
                     alt="Nguyễn Minh Triều"
                     class="team-member-img">
                <h5>Nguyễn Minh Triều</h5>
                <p>Người sáng lập & CEO</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                </div>
            </div>
            <div class="col-md-4 team-member">
                <img src="{{ asset('storage/avatars/designer1.jpg') }}"
                     alt="Tạ Đình Trí"
                     class="team-member-img">
                <h5>Tạ Đình Trí</h5>
                <p>Nhà thiết kế chính</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-dribbble"></i></a>
                </div>
            </div>
            <div class="col-md-4 team-member">
                <img src="{{ asset('storage/avatars/designer2.jpg') }}"
                     alt="Nguyễn Tuấn Kiệt"
                     class="team-member-img">
                <h5>Nguyễn Tuấn Kiệt</h5>
                <p>Nhà thiết kế sáng tạo</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-behance"></i></a>
                    <a href="#"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Thành tựu & Hướng phát triển -->
    <section class="about-section" data-aos="fade-up">
        <h2>Thành tựu & Hướng phát triển</h2>
        <p>Trong 2 năm đầu tiên, ShoeSport đã đạt được những mốc quan trọng:</p>
        <ul>
            <li>Phục vụ hơn 10.000 khách hàng trực tiếp tại cửa hàng.</li>
            <li>Triển khai hệ thống bán hàng online với hơn 50.000 đơn hàng thành công.</li>
            <li>Hợp tác cùng các vận động viên, influencer nổi tiếng để lan tỏa phong cách thể thao.</li>
        </ul>
        <p>
            Trong tương lai, chúng tôi sẽ tiếp tục mở rộng thị trường, nâng cao trải nghiệm
            khách hàng và đầu tư vào công nghệ thông minh cho mua sắm trực tuyến.
        </p>
    </section>

    <!-- Liên hệ -->
    <section class="contact-section" data-aos="fade-up">
        <h2>Liên hệ với chúng tôi</h2>
        <p>Nếu bạn có bất kỳ thắc mắc hay góp ý, vui lòng liên hệ:</p>
        <ul>
            <li>
                <i class="bi bi-envelope-fill"></i>
                <a href="mailto:ShoeSport@gmail.vn">ShoeSport@gmail.vn</a>
            </li>
            <li>
                <i class="bi bi-telephone-fill"></i>
                <a href="tel:+0996-386-683">0996-386-683</a>
            </li>
            <li>
                <i class="bi bi-geo-alt-fill"></i>
                Số 256, đường Nguyễn Văn Cừ, phường An Hòa, quận Ninh Kiều, TP Cần Thơ
            </li>
        </ul>
    </section>
</div>
@endsection
