@extends('layouts.admin')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Danh sách bài viết</h4>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Thêm bài viết
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Bộ lọc --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm theo tiêu đề...">
        </div>
        <div class="col-md-4">
            <select name="post_category_id" class="form-select">
                <option value="">-- Tất cả danh mục --</option>
                @foreach($postCategories as $category)
                    <option value="{{ $category->id }}" {{ request('post_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-funnel"></i> Lọc
            </button>
        </div>
    </form>

    {{-- Danh sách bài viết --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Ảnh</th>
                    <th>Danh mục</th>
                    <th>Nổi bật</th>
                    <th>Hiển thị</th>
                    <th>Ngày tạo</th>
                    <th width="130">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail_url }}" width="60" height="40" style="object-fit:cover;">
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>{{ $post->postCategory?->name ?? '-' }}</td>
                        <td>
                            @if($post->is_featured)
                                <span class="badge bg-success">✔</span>
                            @else
                                <span class="text-muted">✘</span>
                            @endif
                        </td>
                        <td>
                            @if($post->is_visible)
                                <span class="badge bg-primary">Hiện</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Không có bài viết nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection
