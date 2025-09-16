<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Danh sách liên hệ
    public function index(Request $request)
{
    $query = Contact::query();

    // Lọc theo Họ tên
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Lọc theo Email
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Sắp xếp và phân trang
    $contacts = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    return view('admin.contacts.index', compact('contacts'));
}


    // Xem chi tiết một liên hệ, kèm form reply
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    // Xử lý gửi phản hồi
    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'reply' => 'required|string|max:2000'
        ]);

        $contact->update([
            'reply'      => $request->reply,
            'replied_at' => now(),
        ]);

        // Nếu bạn muốn gửi email cho khách thì gọi Mailable ở đây

        return back()->with('success', 'Đã gửi phản hồi cho liên hệ #' . $contact->id);
    }
}
