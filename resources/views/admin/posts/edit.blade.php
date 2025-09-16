{{-- resources/views/admin/posts/edit.blade.php --}}

@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Chỉnh sửa bài viết</h4>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Quay lại
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.posts._form')
    </form>
</div>
@endsection
