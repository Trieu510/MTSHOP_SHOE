<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Hiển thị form edit
    public function edit()
{
    $user = Auth::user();
    $defaultAddress = $user->defaultAddress; // hàm đã thêm trong model User

    return view('front.profile.edit', [
        'user' => $user,
        'defaultAddress' => $defaultAddress,
    ]);
}


    // Cập nhật thông tin cơ bản
    public function update(ProfileUpdateRequest $request)
    {
        Auth::user()->update($request->validated());
        return Redirect::route('front.profile.edit')->with('success','Cập nhật thành công.');
    }

    // Đổi mật khẩu
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = $request->validated()['password'];
        $user->save();
        return Redirect::route('front.profile.edit')->with('success','Đổi mật khẩu thành công.');
    }

    // Xóa tài khoản
    public function destroy(Request $request)
    {
        $request->validate(['password'=>'required|current_password']);
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return Redirect::route('home')->with('success','Tài khoản đã bị xóa.');
    }
}
