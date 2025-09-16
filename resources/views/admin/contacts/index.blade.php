@extends('layouts.admin')

@section('title','Quản lý Liên hệ')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Liên hệ từ khách</h1>
  <!-- Form lọc -->
<form method="GET" class="row g-2 align-items-center mb-3">
    <div class="col-md-4">
        <input type="text" name="name" class="form-control"
               placeholder="Tìm theo họ tên..." value="{{ request('name') }}">
    </div>
    <div class="col-md-4">
        <input type="text" name="email" class="form-control"
               placeholder="Tìm theo email..." value="{{ request('email') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-search"></i> Lọc
        </button>
    </div>
    @if(request('name') || request('email'))
    <div class="col-md-2">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">
            Xoá lọc
        </a>
    </div>
    @endif
</form>

  <table class="table table-hover mt-3">
    <thead>
      <tr>
        <th>#</th><th>Họ tên</th><th>Email</th><th>Ngày gửi</th>
        <th>Nội dung</th><th>Phản hồi</th><th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($contacts as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->email }}</td>
        <td>{{ $c->created_at->format('d/m H:i') }}</td>
        <td style="max-width:200px; white-space: pre-wrap; overflow:hidden;">
          {{ Str::limit($c->message, 100) }}
        </td>
        <td style="min-width:250px;">
          @if($c->reply)
            <div class="alert alert-success p-2 mb-0">
              {{ Str::limit($c->reply, 80) }}<br>
              <small class="text-muted">{{ $c->replied_at->format('d/m H:i') }}</small>
            </div>
          @else
            <form action="{{ route('admin.contacts.reply', $c) }}" method="POST" class="d-flex">
              @csrf
              <input name="reply" class="form-control form-control-sm me-2" placeholder="Soạn phản hồi..." required>
              <button class="btn btn-sm btn-primary">Gửi</button>
            </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $contacts->links('pagination::bootstrap-5') }}
</div>
@endsection
