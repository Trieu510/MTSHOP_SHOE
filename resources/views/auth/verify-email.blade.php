<x-guest-layout>
    <div class="email-verification-container">
        <div class="email-verification-card">
            <!-- Header -->
            <div class="email-verification-header">
                <svg class="email-verification-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                </svg>
                <h2 class="email-verification-title">Xác thực email của bạn</h2>
                <p class="email-verification-message">
                    {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực địa chỉ email của bạn bằng cách nhấp vào liên kết chúng tôi vừa gửi qua email. Nếu bạn không nhận được email, chúng tôi sẽ gửi lại cho bạn.') }}
                </p>
            </div>

            <!-- Status Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="email-verification-alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ __('Một liên kết xác thực mới đã được gửi đến địa chỉ email bạn cung cấp khi đăng ký.') }}</span>
                </div>
            @endif

            <!-- Actions -->
            <div class="email-verification-actions">
                <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
                    @csrf
                    <button type="submit" class="resend-button">
                        <i class="bi bi-envelope-arrow-up me-2"></i>Gửi lại email xác thực
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .email-verification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            background-color: #f8fafc;
        }

        .email-verification-card {
            width: 100%;
            max-width: 32rem;
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .email-verification-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .email-verification-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .email-verification-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 1rem;
            color: #4f46e5;
        }

        .email-verification-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .email-verification-message {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .email-verification-alert {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background-color: #f0fdf4;
            color: #166534;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .email-verification-alert svg {
            width: 1.25rem;
            height: 1.25rem;
            color: #22c55e;
        }

        .email-verification-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .resend-form, .logout-form {
            width: 100%;
        }

        .resend-button {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .resend-button:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }

        .logout-button {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background-color: #f8fafc;
            color: #4f46e5;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-button:hover {
            background-color: #f1f5f9;
            border-color: #c7d2fe;
        }

        @media (min-width: 640px) {
            .email-verification-actions {
                flex-direction: row;
            }

            .logout-button {
                width: auto;
            }
        }

        @media (max-width: 640px) {
            .email-verification-card {
                padding: 1.5rem;
            }
        }
    </style>
</x-guest-layout>
