<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách bài viết (trang Blog).
     */
    public function index()
    {
        $posts = Post::where('is_visible', true)
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        $recentPosts = Post::where('is_visible', true)
                           ->latest()
                           ->take(5)
                           ->get();

        return view('front.posts.index', compact('posts', 'recentPosts'));
    }

    /**
     * Hiển thị chi tiết bài viết.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('is_visible', true)->firstOrFail();

        // Bài viết liên quan cùng danh mục (khác bài hiện tại)
        $relatedPosts = Post::where('post_category_id', $post->post_category_id)
                            ->where('id', '!=', $post->id)
                            ->where('is_visible', true)
                            ->latest()
                            ->take(5)
                            ->get();

        $recentPosts = Post::where('id', '!=', $post->id)
                           ->where('is_visible', true)
                           ->latest()
                           ->take(5)
                           ->get();

        return view('front.posts.show', compact('post', 'relatedPosts', 'recentPosts'));
    }
}
