@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>About Page Settings
                        </h5>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hero Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Hero Section</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="title">Title</label>
                                        <input type="text" 
                                               class="form-control @error('title') is-invalid @enderror" 
                                               name="title" 
                                               id="title"
                                               value="{{ old('title', $settings->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="subtitle">Subtitle</label>
                                        <input type="text" 
                                               class="form-control @error('subtitle') is-invalid @enderror" 
                                               name="subtitle" 
                                               id="subtitle"
                                               value="{{ old('subtitle', $settings->subtitle) }}">
                                        @error('subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  name="description" 
                                                  id="description" 
                                                  rows="4">{{ old('description', $settings->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="image">Hero Image</label>
                                        @if($settings->image)
                                            <div class="mb-3">
                                                <img src="{{ Storage::url($settings->image) }}" 
                                                     alt="Current Hero Image" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 200px;">
                                            </div>
                                        @endif
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               name="image" 
                                               id="image"
                                               accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mission, Vision & Values -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Mission, Vision & Values</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="mission">Our Mission</label>
                                        <textarea class="form-control @error('mission') is-invalid @enderror" 
                                                  name="mission" 
                                                  id="mission" 
                                                  rows="4">{{ old('mission', $settings->mission) }}</textarea>
                                        @error('mission')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="vision">Our Vision</label>
                                        <textarea class="form-control @error('vision') is-invalid @enderror" 
                                                  name="vision" 
                                                  id="vision" 
                                                  rows="4">{{ old('vision', $settings->vision) }}</textarea>
                                        @error('vision')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Our Values</label>
                                        <div id="values-container">
                                            @foreach(old('values', $settings->values ?? []) as $index => $value)
                                                <div class="input-group mb-3 value-row">
                                                    <input type="text" 
                                                           class="form-control @error('values.'.$index) is-invalid @enderror" 
                                                           name="values[]" 
                                                           value="{{ $value }}"
                                                           placeholder="Enter a value">
                                                    <button type="button" class="btn btn-danger remove-value">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @error('values.'.$index)
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary" id="add-value">
                                            <i class="fas fa-plus me-2"></i>Add Value
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Team Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Team Section</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="team_title">Team Section Title</label>
                                        <input type="text" 
                                               class="form-control @error('team_title') is-invalid @enderror" 
                                               name="team_title" 
                                               id="team_title"
                                               value="{{ old('team_title', $settings->team_title) }}">
                                        @error('team_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="team_description">Team Section Description</label>
                                        <textarea class="form-control @error('team_description') is-invalid @enderror" 
                                                  name="team_description" 
                                                  id="team_description" 
                                                  rows="4">{{ old('team_description', $settings->team_description) }}</textarea>
                                        @error('team_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- History Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">History Section</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="history_title">History Section Title</label>
                                        <input type="text" 
                                               class="form-control @error('history_title') is-invalid @enderror" 
                                               name="history_title" 
                                               id="history_title"
                                               value="{{ old('history_title', $settings->history_title) }}">
                                        @error('history_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="history_description">History Section Description</label>
                                        <textarea class="form-control @error('history_description') is-invalid @enderror" 
                                                  name="history_description" 
                                                  id="history_description" 
                                                  rows="4">{{ old('history_description', $settings->history_description) }}</textarea>
                                        @error('history_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('values-container');
    const addButton = document.getElementById('add-value');

    // Add new value
    addButton.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'input-group mb-3 value-row';
        div.innerHTML = `
            <input type="text" 
                   class="form-control" 
                   name="values[]" 
                   placeholder="Enter a value">
            <button type="button" class="btn btn-danger remove-value">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    });

    // Remove value
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-value')) {
            e.target.closest('.value-row').remove();
        }
    });
});
</script>
@endpush
