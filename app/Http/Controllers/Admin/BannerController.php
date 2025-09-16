<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Hiển thị danh sách banner.
     */
    public function index()
    {
        $banners = Banner::orderBy('priority', 'desc')
                         ->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Hiển thị form tạo banner mới.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Lưu banner mới.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:150',
            'subtitle'   => 'nullable|string|max:255',
            'link_url'   => 'nullable|url|max:255',
            'priority'   => 'required|integer|min:0',
            'image'      => 'required|image|max:2048',
        ]);

        // Upload ảnh
        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title'       => $data['title'],
            'subtitle'    => $data['subtitle'] ?? null,
            'link_url'    => $data['link_url'] ?? null,
            'priority'    => $data['priority'],
            'image_path'  => $path,
        ]);

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Thêm banner thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Cập nhật banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:150',
            'subtitle'   => 'nullable|string|max:255',
            'link_url'   => 'nullable|url|max:255',
            'priority'   => 'required|integer|min:0',
            'image'      => 'nullable|image|max:2048',
        ]);

        // Nếu có upload ảnh mới thì xóa cũ, lưu mới
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image_path);
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'title'      => $data['title'],
            'subtitle'   => $data['subtitle'] ?? null,
            'link_url'   => $data['link_url'] ?? null,
            'priority'   => $data['priority'],
            'image_path' => $data['image_path'] ?? $banner->image_path,
        ]);

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Cập nhật banner thành công.');
    }

    /**
     * Xóa banner.
     */
    public function destroy(Banner $banner)
    {
        // Xóa file ảnh
        Storage::disk('public')->delete($banner->image_path);

        $banner->delete();

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Xóa banner thành công.');
    }
}
