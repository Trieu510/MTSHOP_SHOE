<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Redirect to Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Tìm user theo email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Nếu chưa có thì tạo mới
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'password'  => bcrypt(Str::random(16)), // password tạm
                'google_id' => $googleUser->getId(),
            ]);
        }

        // Kiểm tra tài khoản bị khóa
        if ($user->status === 'locked') {
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.',
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại!');
    }
}

}
