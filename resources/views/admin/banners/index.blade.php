@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 text-dark fw-bold">Quản lý Banner</h3>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-lg shadow-sm">
      <i class="bi bi-plus-circle me-2"></i> Thêm Banner Mới
    </a>
  </div>

  @include('admin.partials.alerts')

  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4">#</th>
              <th>Ảnh</th>
              <th>Tiêu đề</th>
              <th>Link</th>
              <th>Ưu tiên</th>
              <th class="text-center">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($banners as $b)
            <tr class="align-middle">
              <td class="ps-4">{{ $b->id }}</td>
              <td>
                <img src="{{ asset('storage/'.$b->image_path) }}"
                     class="rounded shadow-sm"
                     style="height: 50px; width: 100px; object-fit: cover;">
              </td>
              <td>{{ $b->title }}</td>
              <td>{{ $b->link_url ?: '—' }}</td>
              <td>{{ $b->priority }}</td>
              <td class="text-center">
                <a href="{{ route('admin.banners.edit', $b) }}"
                   class="btn btn-sm btn-warning me-2 rounded-pill px-3"
                   title="Chỉnh sửa">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.banners.destroy', $b) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Bạn có chắc muốn xóa banner này?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger rounded-pill px-3"
                          title="Xóa">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">
                <i class="bi bi-image me-2"></i> Chưa có banner nào.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-light border-0 py-3">
      {{ $banners->withQueryString()->links() }}
    </div>
  </div>
</div>

<style>
.table th, .table td {
  vertical-align: middle;
}
.table-hover tbody tr:hover {
  background-color: #f8f9fa;
}
.card {
  transition: transform 0.2s;
}
.card:hover {
  transform: translateY(-2px);
}
.btn {
  transition: all 0.2s;
}
.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endsection
