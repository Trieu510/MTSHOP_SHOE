@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    /* Custom CSS để cải tiến giao diện */
    .custom-alert {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 16px 20px;
        font-size: 0.95rem;
        transition: opacity 0.3s ease, transform 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f8f9fc);
        border: none;
    }

    .alert-success {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(145deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .custom-btn-close {
        border-radius: 50%;
        padding: 8px;
        background: rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease, transform 0.3s ease;
        opacity: 0.8;
    }

    .custom-btn-close:hover {
        background: rgba(0, 0, 0, 0.2);
        transform: scale(1.1);
        opacity: 1;
    }

    .alert-dismissible .custom-btn-close {
        top: 50%;
        transform: translateY(-50%);
        right: 12px;
    }

    /* Animation khi hiển thị */
    .fade.show {
        animation: alertFadeIn 0.4s ease-out;
    }

    @keyframes alertFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .custom-alert {
            font-size: 0.9rem;
            padding: 12px 16px;
        }

        .custom-btn-close {
            padding: 6px;
        }
    }
</style>
