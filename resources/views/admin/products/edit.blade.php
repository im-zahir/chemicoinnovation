@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Product</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label required">Name</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label required">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5" 
                              required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label required">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="features" class="form-label">Key Features</label>
                    <div id="features-container">
                        @if(old('features', $product->features))
                            @foreach(old('features', $product->features ?? []) as $index => $feature)
                                <div class="input-group mb-2 feature-item">
                                    <input type="text" 
                                           class="form-control @error('features.'.$index) is-invalid @enderror"
                                           name="features[]" 
                                           value="{{ $feature }}"
                                           placeholder="Enter a key feature">
                                    <button type="button" class="btn btn-danger remove-feature">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @error('features.'.$index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" id="add-feature">
                        <i class="fas fa-plus"></i> Add Feature
                    </button>
                </div>

                <div class="mb-3">
                    <label for="specifications" class="form-label">Specifications</label>
                    <div id="specifications-container">
                        @if(old('specifications', $product->specifications))
                            @foreach(old('specifications', $product->specifications ?? []) as $index => $spec)
                                <div class="input-group mb-2 specification-item">
                                    <input type="text" 
                                           class="form-control @error('specifications.'.$index.'.name') is-invalid @enderror"
                                           name="specifications[{{ $index }}][name]" 
                                           value="{{ $spec['name'] ?? '' }}"
                                           placeholder="Specification name">
                                    <input type="text" 
                                           class="form-control @error('specifications.'.$index.'.value') is-invalid @enderror"
                                           name="specifications[{{ $index }}][value]" 
                                           value="{{ $spec['value'] ?? '' }}"
                                           placeholder="Specification value">
                                    <button type="button" class="btn btn-danger remove-specification">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @error('specifications.'.$index.'.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('specifications.'.$index.'.value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" id="add-specification">
                        <i class="fas fa-plus"></i> Add Specification
                    </button>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-thumbnail" 
                                 style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image"
                           accept="image/*">
                    <div class="form-text">Supported formats: JPEG, PNG, GIF. Max size: 2MB</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $product->sort_order) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" 
                                   class="form-check-input @error('is_featured') is-invalid @enderror" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Product
                            </label>
                            @error('is_featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   class="form-check-input @error('is_active') is-invalid @enderror" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Features
    const featuresContainer = document.getElementById('features-container');
    const addFeatureBtn = document.getElementById('add-feature');

    addFeatureBtn.addEventListener('click', function() {
        const featureItem = document.createElement('div');
        featureItem.className = 'input-group mb-2 feature-item';
        featureItem.innerHTML = `
            <input type="text" 
                   class="form-control"
                   name="features[]" 
                   placeholder="Enter a key feature">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="fas fa-times"></i>
            </button>
        `;
        featuresContainer.appendChild(featureItem);
    });

    featuresContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });

    // Specifications
    const specificationsContainer = document.getElementById('specifications-container');
    const addSpecificationBtn = document.getElementById('add-specification');
    let specIndex = {{ count(old('specifications', $product->specifications ?? [])) }};

    addSpecificationBtn.addEventListener('click', function() {
        const specItem = document.createElement('div');
        specItem.className = 'input-group mb-2 specification-item';
        specItem.innerHTML = `
            <input type="text" 
                   class="form-control"
                   name="specifications[${specIndex}][name]" 
                   placeholder="Specification name">
            <input type="text" 
                   class="form-control"
                   name="specifications[${specIndex}][value]" 
                   placeholder="Specification value">
            <button type="button" class="btn btn-danger remove-specification">
                <i class="fas fa-times"></i>
            </button>
        `;
        specificationsContainer.appendChild(specItem);
        specIndex++;
    });

    specificationsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-specification')) {
            e.target.closest('.specification-item').remove();
        }
    });
});
</script>
@endpush
@endsection
