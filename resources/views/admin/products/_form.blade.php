<div class="mb-4">
    <label for="name" class="form-label fw-semibold text-dark">Tên sản phẩm</label>
    <input
        type="text"
        id="name"
        name="name"
        class="form-control form-control-custom @error('name') is-invalid @enderror"
        value="{{ old('name', $product->name ?? '') }}"
        required
        autofocus
    >
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-4">
            <label for="category_id" class="form-label fw-semibold text-dark">Danh mục</label>
            <select
                id="category_id"
                name="category_id"
                class="form-select form-control-custom @error('category_id') is-invalid @enderror"
                required
            >
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option
                        value="{{ $cat->id }}"
                        {{ (old('category_id', $product->category_id ?? '') == $cat->id) ? 'selected' : '' }}
                    >
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="form-label fw-semibold text-dark">Giá (₫)</label>
            <input
                type="number"
                id="price"
                name="price"
                class="form-control form-control-custom @error('price') is-invalid @enderror"
                value="{{ old('price', $product->price ?? '') }}"
                min="0"
                required
            >
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="sku" class="form-label fw-semibold text-dark">Mã SKU</label>
            <input
                type="text"
                id="sku"
                name="sku"
                class="form-control form-control-custom @error('sku') is-invalid @enderror"
                value="{{ old('sku', $product->sku ?? '') }}"
            >
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="brand" class="form-label fw-semibold text-dark">Thương hiệu</label>

            <input
                type="text"
                id="brand"
                name="brand"
                class="form-control form-control-custom @error('brand') is-invalid @enderror"
                value="{{ old('brand', $product->brand ?? '') }}"
            >
            @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
    <label for="gender" class="form-label fw-semibold text-dark">Giới tính</label>
    <select
        id="gender"
        name="gender"
        class="form-select form-control-custom @error('gender') is-invalid @enderror"
        required
    >
        <option value="">-- Chọn giới tính --</option>
        <option value="male" {{ old('gender', $product->gender ?? '') == 'male' ? 'selected' : '' }}>Nam</option>
        <option value="female" {{ old('gender', $product->gender ?? '') == 'female' ? 'selected' : '' }}>Nữ</option>
        <option value="unisex" {{ old('gender', $product->gender ?? '') == 'unisex' ? 'selected' : '' }}>Unisex</option>
    </select>
    @error('gender')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    </div>

    <div class="col-md-6">
        <div class="mb-4">
            <label for="description" class="form-label fw-semibold text-dark">Mô tả</label>
            <textarea
                id="description"
                name="description"
                class="form-control form-control-custom"
                rows="4"
            >{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="material" class="form-label fw-semibold text-dark">Chất liệu</label>
            <input
                type="text"
                id="material"
                name="material"
                class="form-control form-control-custom @error('material') is-invalid @enderror"
                value="{{ old('material', $product->material ?? '') }}"
            >
            @error('material')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="care_instructions" class="form-label fw-semibold text-dark">Hướng dẫn bảo quản</label>
            <textarea
                id="care_instructions"
                name="care_instructions"
                class="form-control form-control-custom"
                rows="3"
            >{{ old('care_instructions', $product->care_instructions ?? '') }}</textarea>
            @error('care_instructions')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
    <label for="youtube_id" class="form-label fw-semibold text-dark">Video YouTube (Tùy chọn)</label>
    <input
        type="text"
        id="youtube_id"
        name="youtube_id"
        class="form-control form-control-custom @error('youtube_id') is-invalid @enderror"
        value="{{ old('youtube_id', $product->youtube_id ?? '') }}"
        placeholder="Nhập ID hoặc link YouTube, ví dụ: https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        oninput="updateYoutubeIframe(this.value)"
    >
    @error('youtube_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <div id="youtube-iframe-preview" class="mt-3">
        @if (!empty($product->youtube_id))
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.youtube.com/embed/{{ $product->youtube_id }}"
                    frameborder="0"
                    allowfullscreen
                ></iframe>
            </div>
        @endif
    </div>
</div>
    </div>
</div>

<hr class="my-4">
<h5 class="mb-4 fw-bold text-dark">Biến thể (Size & Kho)</h5>
<div id="variants-wrapper" class="p-3 rounded-3 bg-gradient-light">
    @php
        $oldSizes = old('sizes', isset($product) ? $product->variants->pluck('size')->toArray() : []);
    @endphp

    @foreach($oldSizes as $i => $sz)
    <div class="row mb-3 variant-item align-items-center">
        <div class="col-md-10">
            <input
                type="text"
                name="sizes[]"
                class="form-control form-control-custom"
                placeholder="Size"
                value="{{ $sz }}"
                required
            >
        </div>
        <div class="col-md-2 text-center">
            <button type="button" class="btn btn-danger btn-sm remove-variant btn-icon">
                <i class="bi bi-dash-circle"></i>
            </button>
        </div>
    </div>
@endforeach

</div>
<button type="button" class="btn btn-outline-primary btn-sm mb-4 btn-add-variant" id="add-variant">
    <i class="bi bi-plus-circle me-1"></i> Thêm biến thể
</button>

<hr class="my-4">
<h5 class="mb-4 fw-bold text-dark">Ảnh sản phẩm</h5>
<div class="mb-4">
    <label class="form-label fw-semibold text-dark">Tải lên ảnh</label>
    <input
        type="file"
        name="images[]"
        class="form-control form-control-custom mb-3 @error('images.*') is-invalid @enderror"
        multiple
        accept="image/*"
    >
    <div class="image-preview mt-3 d-flex flex-wrap gap-2"></div>

    @error('images.*')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($product) && $product->images->count())
        <div class="row mt-3 g-3">
            @foreach($product->images as $img)
                <div class="col-auto">
                    <div class="image-wrapper position-relative">
                        <img
                            src="{{ asset('storage/'.$img->path) }}"
                            class="img-thumbnail rounded-3"
                            style="width: 100px; height: 100px; object-fit: cover;"
                        >
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.getElementById('add-variant').addEventListener('click', function() {
        const wrapper = document.getElementById('variants-wrapper');
        const item = document.createElement('div');
        item.classList.add('row', 'mb-3', 'variant-item', 'align-items-center');
        item.innerHTML = `
    <div class="col-md-10">
        <input type="text" name="sizes[]" class="form-control form-control-custom" placeholder="Size" required>
    </div>
    <div class="col-md-2 text-center">
        <button type="button" class="btn btn-danger btn-sm remove-variant btn-icon"><i class="bi bi-dash-circle"></i></button>
    </div>
`;

        wrapper.appendChild(item);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-variant')) {
            e.target.closest('.variant-item').remove();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('input[name="images[]"]');
        const previewContainer = document.querySelector('.image-preview');

        input.addEventListener('change', function (event) {
            previewContainer.innerHTML = ''; // Xóa ảnh cũ khi chọn ảnh mới

            Array.from(event.target.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded border';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.boxShadow = '0 2px 6px rgba(0,0,0,0.1)';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>
<script>
function extractYoutubeId(url) {
    // Trích ID từ đường link YouTube hoặc chuỗi ID
    const match = url.trim().match(/(?:v=|\/|embed\/|be\/)([0-9A-Za-z_-]{11})/);
    return match ? match[1] : null;
}

function updateYoutubeIframe(inputVal) {
    const id = extractYoutubeId(inputVal);
    const iframePreview = document.getElementById('youtube-iframe-preview');

    if (!id) {
        iframePreview.innerHTML = '';
        return;
    }

    iframePreview.innerHTML = `
        <div class="ratio ratio-16x9">
            <iframe
                src="https://www.youtube.com/embed/${id}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>
    `;
}
</script>

@endpush
