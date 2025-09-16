<div class="mb-4">
    <label for="title" class="form-label fw-semibold text-dark">Tiêu đề</label>
    <input
        type="text"
        id="title"
        name="title"
        class="form-control form-control-lg rounded-3 shadow-sm @error('title') is-invalid @enderror"
        value="{{ old('title', $banner->title ?? '') }}"
        required
    >
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="subtitle" class="form-label fw-semibold text-dark">Phụ đề (nếu có)</label>
    <input
        type="text"
        id="subtitle"
        name="subtitle"
        class="form-control form-control-lg rounded-3 shadow-sm @error('subtitle') is-invalid @enderror"
        value="{{ old('subtitle', $banner->subtitle ?? '') }}"
    >
    @error('subtitle')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="link_url" class="form-label fw-semibold text-dark">Liên kết (URL, nếu có)</label>
    <input
        type="url"
        id="link_url"
        name="link_url"
        class="form-control form-control-lg rounded-3 shadow-sm @error('link_url') is-invalid @enderror"
        value="{{ old('link_url', $banner->link_url ?? '') }}"
    >
    @error('link_url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="priority" class="form-label fw-semibold text-dark">Độ ưu tiên</label>
    <input
        type="number"
        id="priority"
        name="priority"
        class="form-control form-control-lg rounded-3 shadow-sm @error('priority') is-invalid @enderror"
        value="{{ old('priority', $banner->priority ?? 0) }}"
        min="0"
        required
    >
    @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="image" class="form-label fw-semibold text-dark">Ảnh banner</label>
    <input
        type="file"
        id="image"
        name="image"
        class="form-control form-control-lg rounded-3 shadow-sm @error('image') is-invalid @enderror"
        accept="image/*"
        @unless(isset($banner)) required @endunless
    >
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($banner) && $banner->image_path)
        <div class="mt-3">
            <p class="mb-2 text-muted">Ảnh hiện tại:</p>
            <img
                src="{{ asset('storage/'.$banner->image_path) }}"
                alt="banner"
                class="img-thumbnail rounded shadow-sm"
                style="max-width: 250px; height: auto;"
            >
        </div>
    @endif
</div>

<style>
.form-control, .form-control-lg {
    transition: all 0.2s;
}
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}
.form-label {
    margin-bottom: 0.5rem;
}
.img-thumbnail {
    transition: transform 0.2s;
}
.img-thumbnail:hover {
    transform: scale(1.05);
}
</style>
