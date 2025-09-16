@extends('layouts.front')

@section('title', $post->title)

@push('styles')
<style>
    .post-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .post-meta {
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .post-thumbnail {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #374151;
    }

    .related-posts h5 {
        font-weight: 700;
        margin-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 0.5rem;
    }

    .related-posts .item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .related-posts .item img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 1rem;
    }

    .related-posts .item-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row">
        {{-- Nội dung bài viết --}}
        <div class="col-lg-8">
            <div class="post-title">{{ $post->title }}</div>
            <div class="post-meta">
                Đăng ngày {{ $post->created_at->format('d/m/Y') }}
            </div>

            @if($post->thumbnail)
                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="post-thumbnail" alt="{{ $post->title }}">
            @else
                <img src="{{ asset('images/default-thumbnail.jpg') }}" class="post-thumbnail" alt="Không có ảnh">
            @endif

            <div class="post-content">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Bài viết liên quan --}}
        <div class="col-lg-4">
            <div class="related-posts">
                <h5>Bài viết liên quan</h5>
                @if(isset($relatedPosts) && $relatedPosts->count())
                    @foreach($relatedPosts as $related)
                        <div class="item">
                            <a href="{{ route('posts.show', $related->slug) }}">
                                <img src="{{ $related->thumbnail ? asset('storage/' . $related->thumbnail) : asset('images/default-thumbnail.jpg') }}" alt="{{ $related->title }}">
                            </a>
                            <div>
                                <a href="{{ route('posts.show', $related->slug) }}" class="item-title">
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Không có bài viết liên quan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
