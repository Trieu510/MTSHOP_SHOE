<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách khách hàng.
     */
    public function index(Request $request)
{
    $query = User::where('is_admin', false);

    // Lọc theo từ khóa tên, email, sđt
    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%$keyword%")
              ->orWhere('email', 'like', "%$keyword%")
              ->orWhere('phone', 'like', "%$keyword%");
        });
    }

    // Lọc theo trạng thái
    if ($request->filled('status') && in_array($request->status, ['active', 'locked'])) {
        $query->where('status', $request->status);
    }

    $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

    return view('admin.users.index', compact('users'));
}

    /**
     * Hiển thị form chỉnh sửa trạng thái.
     */
    public function edit(User $user)
    {
        // Chỉ xử lý với customer (is_admin = 0)
        if ($user->is_admin) {
            abort(403, 'Không thể sửa admin.');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật trạng thái khóa/mở tài khoản.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,locked',
        ]);

        $user->update(['status' => $request->status]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Cập nhật trạng thái người dùng thành công.');
    }

    /**
     * Xóa người dùng.
     */
    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không thể xóa tài khoản Admin.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công.');
    }
}
