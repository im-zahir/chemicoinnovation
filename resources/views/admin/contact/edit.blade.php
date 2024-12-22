@extends('admin.layouts.app')

@section('title', 'Edit Contact Information')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Contact Information</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Contact Information</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-address-card me-1"></i>
            Edit Contact Information
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.contact.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <!-- Address -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $settings->address) }}" 
                                   required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $settings->phone) }}" 
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $settings->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="working_hours" class="form-label">Working Hours</label>
                            <input type="text" 
                                   class="form-control @error('working_hours') is-invalid @enderror" 
                                   id="working_hours" 
                                   name="working_hours" 
                                   value="{{ old('working_hours', $settings->working_hours) }}" 
                                   required>
                            @error('working_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Social Media Links -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" 
                                   class="form-control @error('facebook_url') is-invalid @enderror" 
                                   id="facebook_url" 
                                   name="facebook_url" 
                                   value="{{ old('facebook_url', $settings->facebook_url) }}">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter URL</label>
                            <input type="url" 
                                   class="form-control @error('twitter_url') is-invalid @enderror" 
                                   id="twitter_url" 
                                   name="twitter_url" 
                                   value="{{ old('twitter_url', $settings->twitter_url) }}">
                            @error('twitter_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                            <input type="url" 
                                   class="form-control @error('linkedin_url') is-invalid @enderror" 
                                   id="linkedin_url" 
                                   name="linkedin_url" 
                                   value="{{ old('linkedin_url', $settings->linkedin_url) }}">
                            @error('linkedin_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Google Maps URL -->
                <div class="mb-4">
                    <label for="map_url" class="form-label">Google Maps Embed URL</label>
                    <input type="url" 
                           class="form-control @error('map_url') is-invalid @enderror" 
                           id="map_url" 
                           name="map_url" 
                           value="{{ old('map_url', $settings->map_url) }}">
                    <div class="form-text">Enter the Google Maps embed URL for your location</div>
                    @error('map_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
