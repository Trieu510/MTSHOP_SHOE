{{-- resources/views/admin/posts/_form.blade.php --}}
@csrf

<div class="mb-3">
    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control" id="title"
           value="{{ old('title', $post->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" id="slug"
           value="{{ old('slug', $post->slug ?? '') }}">
    <small class="text-muted">Để trống sẽ tự tạo theo tiêu đề</small>
</div>

<div class="mb-3">
    <label for="excerpt" class="form-label">Tóm tắt</label>
    <textarea name="excerpt" id="excerpt" class="form-control" rows="3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
    <textarea name="content" id="content" class="form-control" rows="8" required>{{ old('content', $post->content ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="post_category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
    <select name="post_category_id" id="post_category_id" class="form-select" required>
        <option value="">-- Chọn danh mục --</option>
        @foreach($postCategories as $category)
            <option value="{{ $category->id }}"
                {{ old('post_category_id', $post->post_category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="thumbnail" class="form-label">Ảnh đại diện</label>
    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
    @if(!empty($post->thumbnail))
        <div class="mt-2">
            <img src="{{ $post->thumbnail_url }}" alt="thumbnail" width="150">
        </div>
    @endif
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
           {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_featured">Hiển thị nổi bật</label>
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible"
           {{ old('is_visible', $post->is_visible ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_visible">Hiển thị công khai</label>
</div>

<button type="submit" class="btn btn-primary">
    <i class="bi bi-save me-1"></i> Lưu bài viết
</button>
<a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endpush
