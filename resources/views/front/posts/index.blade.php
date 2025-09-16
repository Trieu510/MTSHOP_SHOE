@extends('layouts.front')

@section('title', 'Tin tức - Blog')

@push('styles')
<style>
    .blog-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        transition: 0.3s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.12);
    }

    .blog-card img {
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .blog-card .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-card h5 {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
        color: #1f2937;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-card .excerpt {
        font-size: 0.95rem;
        color: #6b7280;
        flex-grow: 1;
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .blog-card .read-more {
        font-weight: 600;
        font-size: 0.95rem;
        color: #1a73e8;
        text-decoration: none;
    }

    .blog-sidebar .recent-post {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .blog-sidebar .recent-post img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 1rem;
    }

    .blog-sidebar .recent-post-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.3;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <h2 class="section-title">TIN TỨC MỚI NHẤT</h2>

    <div class="row">
        {{-- Danh sách bài viết --}}
        <div class="col-lg-8">
            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-md-6">
                        <div class="card blog-card">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('images/default-thumbnail.jpg') }}"
                                     alt="{{ $post->title }}">
                            </a>
                            <div class="card-body">
                                <h5>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <div class="excerpt">
                                    {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 100) }}
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="read-more">Đọc tiếp →</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">Chưa có bài viết nào.</div>
                    </div>
                @endforelse
            </div>

            {{-- Phân trang --}}
            <div class="mt-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- Sidebar: Bài viết gần đây --}}
        <div class="col-lg-4 blog-sidebar">
            <h5 class="mb-3">Bài viết gần đây</h5>
            @if(!empty($recentPosts) && $recentPosts->count())
                @foreach($recentPosts as $recent)
                    <div class="recent-post">
                        <a href="{{ route('posts.show', $recent->slug) }}">
                            <img src="{{ $recent->thumbnail ? asset('storage/' . $recent->thumbnail) : asset('images/default-thumbnail.jpg') }}"
                                 alt="{{ $recent->title }}">
                        </a>
                        <div>
                            <a href="{{ route('posts.show', $recent->slug) }}" class="recent-post-title">
                                {{ Str::limit($recent->title, 50) }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Không có bài viết gần đây.</p>
            @endif
        </div>
    </div>
</div>
@endsection
