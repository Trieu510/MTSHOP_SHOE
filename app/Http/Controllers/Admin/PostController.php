<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('postCategory');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('post_category_id')) {
            $query->where('post_category_id', $request->post_category_id);
        }

        $posts = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends(request()->query());

        $postCategories = PostCategory::all();

        return view('admin.posts.index', compact('posts', 'postCategories'));
    }

    public function create()
    {
        $postCategories = PostCategory::all();
        return view('admin.posts.create', compact('postCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'excerpt'          => 'nullable|string',
            'content'          => 'required|string',
            'post_category_id' => 'required|exists:post_categories,id',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Thêm bài viết thành công.');
    }

    public function edit(Post $post)
    {
        $postCategories = PostCategory::all();
        return view('admin.posts.edit', compact('post', 'postCategories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'excerpt'          => 'nullable|string',
            'content'          => 'required|string',
            'post_category_id' => 'required|exists:post_categories,id',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->where('id', '!=', $post->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Xoá bài viết thành công.');
    }
}
