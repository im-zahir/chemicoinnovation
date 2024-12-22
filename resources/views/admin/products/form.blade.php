<div class="mb-3">
    <label for="name" class="form-label">Product Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" name="description" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Product Image</label>
    <input type="file" class="form-control @error('image') is-invalid @enderror" 
           id="image" name="image" accept="image/*" {{ isset($product) ? '' : 'required' }}>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($product) && $product->image)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="img-thumbnail" 
                 style="max-width: 200px;">
        </div>
    @endif
</div>

<div class="mb-3">
    <label for="sort_order" class="form-label">Sort Order</label>
    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
           id="sort_order" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
    @error('sort_order')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <div class="form-check">
        <input type="hidden" name="is_featured" value="0">
        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
               value="1" {{ old('is_featured', $product->is_featured ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">Featured Product</label>
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
               value="1" {{ old('is_active', $product->is_active ?? 1) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active Product</label>
    </div>
</div>
