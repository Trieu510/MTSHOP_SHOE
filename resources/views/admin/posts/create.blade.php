{{-- resources/views/admin/posts/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Thêm bài viết mới')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Thêm bài viết mới</h4>
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

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.posts._form')
    </form>
</div>
@endsection
