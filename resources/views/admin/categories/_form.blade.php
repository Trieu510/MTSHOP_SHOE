<div class="mb-4">
    <label for="name" class="form-label fw-semibold text-dark">Tên danh mục</label>
    <input type="text"
           id="name"
           name="name"
           class="form-control form-control-custom @error('name') is-invalid @enderror"
           value="{{ old('name', isset($category) ? $category->name : '') }}"
           required
           autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<style>
    /* Custom CSS để cải tiến giao diện */
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control-custom:focus {
        border-color: #0066CC;
        box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    }

    .form-label {
        font-size: 0.95rem;
        color: #1a1a1a;
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: #dc3545;
        transition: opacity 0.3s ease;
    }

    .is-invalid.form-control-custom {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    @media (max-width: 768px) {
        .form-control-custom {
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .invalid-feedback {
            font-size: 0.8rem;
        }
    }
</style>
