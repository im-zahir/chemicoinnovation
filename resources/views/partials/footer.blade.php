@php
    use App\Models\Setting;
    use App\Models\ContactSetting;
    $contactSettings = ContactSetting::first();
@endphp

<footer class="footer bg-white relative">
    <div class="absolute inset-0 bg-grid-slate-100/[0.02]"></div>
    
    <!-- Decorative elements -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    
    <div class="container relative mx-auto px-4 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Company Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-primary">
                        {{ Setting::get('company_name', 'Chemico') }}
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        {{ Setting::get('footer_about', 'Pioneering chemical innovations for a sustainable future. Leading the industry with cutting-edge solutions and unwavering commitment to quality.') }}
                    </p>
                </div>
                
                <!-- Social Links -->
                <div class="flex space-x-4">
                    @if(Setting::get('social_facebook'))
                    <a href="{{ Setting::get('social_facebook') }}" target="_blank" rel="noopener noreferrer" class="footer-social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if(Setting::get('social_twitter'))
                    <a href="{{ Setting::get('social_twitter') }}" target="_blank" rel="noopener noreferrer" class="footer-social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if(Setting::get('social_linkedin'))
                    <a href="{{ Setting::get('social_linkedin') }}" target="_blank" rel="noopener noreferrer" class="footer-social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if(Setting::get('social_instagram'))
                    <a href="{{ Setting::get('social_instagram') }}" target="_blank" rel="noopener noreferrer" class="footer-social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="{{ route('home') }}" class="footer-link">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="footer-link">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="footer-link">
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="footer-link">
                            Contact
                        </a>
                    </li>
                    @php
                        $footerLinks = Setting::get('footer_links');
                        $links = is_string($footerLinks) ? json_decode($footerLinks, true) : $footerLinks;
                        $links = is_array($links) ? $links : [];
                    @endphp
                    @foreach($links as $link)
                        @if(!empty($link['title']) && !empty($link['url']))
                            <li>
                                <a href="{{ $link['url'] }}" class="footer-link" target="_blank" rel="noopener noreferrer">
                                    {{ $link['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Products -->
            <div>
                <h3 class="footer-title">Our Solutions</h3>
                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="{{ route('solutions.industrial-chemicals') }}" class="footer-link">
                            Industrial Chemicals
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solutions.laboratory-solutions') }}" class="footer-link">
                            Laboratory Solutions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solutions.custom-formulations') }}" class="footer-link">
                            Custom Formulations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solutions.safety-equipment') }}" class="footer-link">
                            Safety Equipment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solutions.quality-control') }}" class="footer-link">
                            Quality Control
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solutions.rd-services') }}" class="footer-link">
                            R&D Services
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="footer-title">Get in Touch</h3>
                <ul class="mt-6 space-y-4">
                    <li class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-primary mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-600">
                            {!! nl2br(e($contactSettings->address ?? '123 Innovation Street<br>Dhaka, Bangladesh')) !!}
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-envelope w-6 h-6 text-primary mt-1"></i>
                        <span class="text-gray-600">
                            {{ $contactSettings->email ?? 'info@chemico.com' }}
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-primary mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-gray-600">
                            {{ $contactSettings->phone ?? '+880 123-456-7890' }}
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-primary mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-600">
                            {{ $contactSettings->working_hours ?? 'Mon - Fri: 9:00 AM - 6:00 PM' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="mt-16 pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-600">
                    &copy; {{ date('Y') }} Chemico. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
