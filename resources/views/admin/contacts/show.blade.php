@extends('layouts.admin')
@section('title','Chi tiết liên hệ #'.$contact->id)
@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Liên hệ #{{ $contact->id }}</h1>
  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Khách:</strong> {{ $contact->name }} ({{ $contact->email }})</p>
      <p><strong>Điện thoại:</strong> {{ $contact->phone ?? '—' }}</p>
      <p><strong>Gửi lúc:</strong> {{ $contact->created_at }}</p>
      <hr>
      <p><strong>Nội dung:</strong><br>{{ $contact->message }}</p>
    </div>
  </div>

  {{-- Form phản hồi --}}
  <div class="card">
    <div class="card-header">Gửi phản hồi</div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
        @csrf
        <div class="mb-3">
          <textarea name="reply" class="form-control" rows="5" placeholder="Viết phản hồi...">{{ old('reply',$contact->reply) }}</textarea>
          @error('reply')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Gửi</button>
      </form>
    </div>
  </div>
</div>
@endsection
