<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Xác định xem user có quyền gửi request này không.
     * Chúng ta chỉ cho phép user đã đăng nhập.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Định nghĩa các luật validate cho request.
     */
    public function rules(): array
    {
        return [
            // Label (tùy chọn): tối đa 50 ký tự
            'label'          => 'nullable|string|max:50',

            // Tên người nhận: bắt buộc, chuỗi, tối đa 100 ký tự
            'recipient_name' => 'required|string|max:100',

            // Số điện thoại: bắt buộc, định dạng 0xxxxxxxxx hoặc 01xxxxxxxxx
            'phone'          => ['required', 'regex:/^0\d{9,10}$/'],

            // Tỉnh/Thành: bắt buộc, chuỗi
            'province'       => 'required|string',

            // Quận/Huyện: bắt buộc, chuỗi
            'district'       => 'required|string',

            // Phường/Xã: bắt buộc, chuỗi
            'ward'           => 'required|string',

            // Địa chỉ chi tiết: bắt buộc, chuỗi, tối đa 255 ký tự
            'detail'         => 'required|string|max:255',

            // Đánh dấu mặc định: tùy chọn, boolean
            'is_default'     => 'nullable|boolean',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (nếu cần).
     */
    public function messages(): array
    {
        return [
            'recipient_name.required' => 'Vui lòng nhập tên người nhận.',
            'phone.required'          => 'Vui lòng nhập số điện thoại.',
            'phone.regex'             => 'Số điện thoại không đúng định dạng.',
            'province.required'       => 'Vui lòng chọn tỉnh/thành.',
            'district.required'       => 'Vui lòng chọn quận/huyện.',
            'ward.required'           => 'Vui lòng chọn phường/xã.',
            'detail.required'         => 'Vui lòng nhập địa chỉ chi tiết.',
            'detail.max'              => 'Địa chỉ chi tiết không vượt quá 255 ký tự.',
        ];
    }
}
