<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * Hiển thị trang Giới thiệu.
     */
    public function index()
    {
        return view('front.about');
    }
}
