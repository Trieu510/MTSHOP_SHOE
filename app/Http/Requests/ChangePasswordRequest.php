<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Cho phép user đã đăng nhập.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Luật validate cho đổi mật khẩu.
     */
    public function rules(): array
    {
        return [
            // Mật khẩu hiện tại: bắt buộc và phải đúng với password hiện tại của user
            'current_password'      => ['required', 'current_password'],

            // Mật khẩu mới: bắt buộc, ít nhất 8 ký tự, và phải trùng khớp confirmation
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Thông báo lỗi tuỳ chỉnh.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.current_password' => 'Mật khẩu hiện tại không đúng.',
            'password.required'        => 'Vui lòng nhập mật khẩu mới.',
            'password.min'             => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'password.confirmed'       => 'Xác nhận mật khẩu không khớp.',
        ];
    }
}
