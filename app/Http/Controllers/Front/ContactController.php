<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;

class ContactController extends Controller
{
    /**
     * Hiển thị form liên hệ.
     */
    public function create()
    {
        return view('front.contact.create');
    }

    /**
     * Xử lý lưu liên hệ.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Nếu user đã đăng nhập, gán user_id
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $contact = Contact::create($data);

        // Gửi email thông báo cho admin
        Mail::to(config('mail.admin_address'))
            ->send(new ContactNotification($contact));

        return back()->with('success', 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất.');
    }

    /**
     * Danh sách liên hệ của chính khách hàng đang đăng nhập.
     */
    public function index()
    {
        $contacts = auth()->user()
                          ->contacts()
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('front.contact.index', compact('contacts'));
    }

    /**
     * Xem chi tiết một liên hệ và phản hồi (nếu có).
     */
    public function show(Contact $contact)
    {
        // Chỉ cho phép chủ liên hệ xem
        if (auth()->id() !== $contact->user_id) {
            abort(403);
        }

        return view('front.contact.show', compact('contact'));
    }
}
