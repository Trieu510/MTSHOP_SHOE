<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Nếu user chưa đăng nhập hoặc không phải admin thì redirect về trang home hoặc abort 403.
     */
    public function handle(Request $request, Closure $next)
    {
        // Nếu chưa đăng nhập, chuyển về trang login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Nếu đã đăng nhập nhưng không phải admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        // Đủ quyền → cho phép tiếp tục
        return $next($request);
    }
}
