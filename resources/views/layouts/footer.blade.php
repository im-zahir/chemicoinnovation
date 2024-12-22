<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>About Us</h5>
                <p>{{ \App\Models\Setting::get('company_tagline') }}</p>
                <div class="social-links mt-3">
                    <a href="{{ \App\Models\Setting::get('social_facebook') }}" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ \App\Models\Setting::get('social_twitter') }}" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="{{ \App\Models\Setting::get('social_linkedin') }}" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-light text-decoration-none">Products</a></li>
                    <li><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ \App\Models\Setting::get('contact_address') }}</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> {{ \App\Models\Setting::get('contact_phone') }}</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> {{ \App\Models\Setting::get('contact_email') }}</li>
                    <li><i class="fas fa-clock me-2"></i> {{ \App\Models\Setting::get('contact_hours') }}</li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4">
        
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('company_name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
