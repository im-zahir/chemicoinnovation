@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>Site Settings
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

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Logo Settings -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-image me-2"></i>Logo Settings
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="site_logo">
                                            Site Logo
                                        </label>
                                        <div class="mb-3">
                                            @if($logo = \App\Models\Setting::get('site_logo'))
                                                <div class="bg-light p-3 rounded d-inline-block mb-3">
                                                    <img src="{{ Storage::disk('public')->url($logo) }}" 
                                                         alt="Current Logo" 
                                                         class="img-fluid" 
                                                         style="max-height: 100px;">
                                                </div>
                                            @else
                                                <div class="bg-light p-3 rounded d-inline-block">
                                                    <img src="{{ asset('images/logo.svg') }}" 
                                                         alt="Default Logo" 
                                                         class="img-fluid opacity-50" style="max-height: 48px;">
                                                    <p class="text-muted small mt-1 mb-0">Using default logo</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" 
                                               class="form-control @error('site_logo') is-invalid @enderror" 
                                               name="site_logo" 
                                               id="site_logo"
                                               accept="image/*">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recommended: SVG or PNG with transparent background. Max size: 1MB
                                        </div>
                                        @error('site_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="site_favicon">
                                            Site Favicon
                                        </label>
                                        <div class="mb-3">
                                            @if($favicon = \App\Models\Setting::get('site_favicon'))
                                                <div class="bg-light p-3 rounded d-inline-block mb-3">
                                                    <img src="{{ Storage::disk('public')->url($favicon) }}" 
                                                         alt="Current Favicon" 
                                                         class="img-fluid" 
                                                         style="max-height: 32px;">
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" 
                                               class="form-control @error('site_favicon') is-invalid @enderror" 
                                               name="site_favicon" 
                                               id="site_favicon"
                                               accept="image/x-icon,image/png">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Upload .ico or .png file (32x32 pixels recommended)
                                        </div>
                                        @error('site_favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="company_name">
                                            Company Name
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('company_name') is-invalid @enderror"
                                               name="company_name" 
                                               id="company_name"
                                               value="{{ old('company_name', \App\Models\Setting::get('company_name') ?? config('app.name')) }}">
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hero Section Settings -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-home me-2"></i>Hero Section
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="hero_title">
                                            Hero Title
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('hero_title') is-invalid @enderror"
                                               name="hero_title" 
                                               id="hero_title"
                                               value="{{ old('hero_title', \App\Models\Setting::get('hero_title')) }}">
                                        @error('hero_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="hero_subtitle">
                                            Hero Subtitle
                                        </label>
                                        <textarea class="form-control @error('hero_subtitle') is-invalid @enderror"
                                                  name="hero_subtitle" 
                                                  id="hero_subtitle"
                                                  rows="3">{{ old('hero_subtitle', \App\Models\Setting::get('hero_subtitle')) }}</textarea>
                                        @error('hero_subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="hero_image">
                                            Hero Background Image
                                        </label>
                                        @if($heroImage = \App\Models\Setting::get('hero_image'))
                                            <div class="mb-3">
                                                <div class="bg-light p-3 rounded d-inline-block">
                                                    <img src="{{ Storage::disk('public')->url($heroImage) }}" 
                                                         alt="Current Hero Image" 
                                                         class="img-fluid" 
                                                         style="max-height: 200px;">
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" 
                                               class="form-control @error('hero_image') is-invalid @enderror"
                                               name="hero_image" 
                                               id="hero_image"
                                               accept="image/*">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recommended: High-resolution image (1920x1080 or larger). Max size: 2MB
                                        </div>
                                        @error('hero_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="hero_cta_primary_text">
                                            Primary Button Text
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('hero_cta_primary_text') is-invalid @enderror"
                                               name="hero_cta_primary_text" 
                                               id="hero_cta_primary_text"
                                               value="{{ old('hero_cta_primary_text', \App\Models\Setting::get('hero_cta_primary_text')) }}">
                                        @error('hero_cta_primary_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="hero_cta_secondary_text">
                                            Secondary Button Text
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('hero_cta_secondary_text') is-invalid @enderror"
                                               name="hero_cta_secondary_text" 
                                               id="hero_cta_secondary_text"
                                               value="{{ old('hero_cta_secondary_text', \App\Models\Setting::get('hero_cta_secondary_text')) }}">
                                        @error('hero_cta_secondary_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Settings -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-list me-2"></i>Footer Settings
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label" for="footer_about">
                                            Footer About Text
                                        </label>
                                        <textarea class="form-control @error('footer_about') is-invalid @enderror"
                                                  name="footer_about" 
                                                  id="footer_about"
                                                  rows="3">{{ old('footer_about', \App\Models\Setting::get('footer_about')) }}</textarea>
                                        @error('footer_about')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Quick Links</label>
                                        <div id="footer-links-container">
                                            @php
                                                $footerLinks = old('footer_links', \App\Models\Setting::get('footer_links') ?? []);
                                                if (!is_array($footerLinks)) {
                                                    $footerLinks = json_decode($footerLinks, true) ?: [];
                                                }
                                            @endphp
                                            @foreach($footerLinks as $index => $link)
                                                <div class="row g-3 mb-3 footer-link-row">
                                                    <div class="col-md-5">
                                                        <input type="text" 
                                                               class="form-control @error('footer_links.'.$index.'.title') is-invalid @enderror" 
                                                               name="footer_links[{{ $index }}][title]" 
                                                               placeholder="Link Title"
                                                               value="{{ $link['title'] ?? '' }}">
                                                        @error('footer_links.'.$index.'.title')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="url" 
                                                               class="form-control @error('footer_links.'.$index.'.url') is-invalid @enderror" 
                                                               name="footer_links[{{ $index }}][url]" 
                                                               placeholder="Link URL"
                                                               value="{{ $link['url'] ?? '' }}">
                                                        @error('footer_links.'.$index.'.url')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger remove-footer-link">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary mt-3" id="add-footer-link">
                                            <i class="fas fa-plus me-2"></i>Add Link
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Settings -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-share-alt me-2"></i>Social Media Links
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label" for="social_facebook">
                                            <i class="fab fa-facebook-f me-2"></i>Facebook URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('social_facebook') is-invalid @enderror" 
                                               name="social_facebook" 
                                               id="social_facebook"
                                               value="{{ old('social_facebook', \App\Models\Setting::get('social_facebook')) }}"
                                               placeholder="https://facebook.com/your-page">
                                        @error('social_facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="social_twitter">
                                            <i class="fab fa-twitter me-2"></i>Twitter URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('social_twitter') is-invalid @enderror" 
                                               name="social_twitter" 
                                               id="social_twitter"
                                               value="{{ old('social_twitter', \App\Models\Setting::get('social_twitter')) }}"
                                               placeholder="https://twitter.com/your-handle">
                                        @error('social_twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="social_linkedin">
                                            <i class="fab fa-linkedin-in me-2"></i>LinkedIn URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('social_linkedin') is-invalid @enderror" 
                                               name="social_linkedin" 
                                               id="social_linkedin"
                                               value="{{ old('social_linkedin', \App\Models\Setting::get('social_linkedin')) }}"
                                               placeholder="https://linkedin.com/company/your-company">
                                        @error('social_linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="social_instagram">
                                            <i class="fab fa-instagram me-2"></i>Instagram URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('social_instagram') is-invalid @enderror" 
                                               name="social_instagram" 
                                               id="social_instagram"
                                               value="{{ old('social_instagram', \App\Models\Setting::get('social_instagram')) }}"
                                               placeholder="https://instagram.com/your-handle">
                                        @error('social_instagram')
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
        const footerLinksContainer = document.getElementById('footer-links-container');
        const addFooterLinkBtn = document.getElementById('add-footer-link');
        let linkIndex = footerLinksContainer.querySelectorAll('.footer-link-row').length;

        // Add new footer link
        addFooterLinkBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'row g-3 mb-3 footer-link-row';
            row.innerHTML = `
                <div class="col-md-5">
                    <input type="text" 
                           class="form-control" 
                           name="footer_links[${linkIndex}][title]" 
                           placeholder="Link Title">
                </div>
                <div class="col-md-5">
                    <input type="url" 
                           class="form-control" 
                           name="footer_links[${linkIndex}][url]" 
                           placeholder="Link URL">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-footer-link">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            footerLinksContainer.appendChild(row);
            linkIndex++;
        });

        // Remove footer link
        footerLinksContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-footer-link') || e.target.closest('.remove-footer-link')) {
                const row = e.target.closest('.footer-link-row');
                row.remove();
            }
        });
    });
</script>
@endpush
