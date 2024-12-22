@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative h-[80vh] overflow-hidden bg-gradient-to-br from-primary via-primary-dark to-primary">
    @php
        $heroImage = Setting::get('hero_image');
        $heroImageUrl = $heroImage ? Storage::disk('public')->url($heroImage) : asset('images/hero-bg.jpg');
    @endphp
    
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ $heroImageUrl }}');">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Animated particles -->
    <div class="particles absolute inset-0"></div>

    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 rounded-full bg-white/10 text-white/90 backdrop-blur-lg text-sm font-medium mb-6 animate-fade-in-up">
                Welcome to {{ Setting::get('company_name', 'Chemico Innovation') }}
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-8 animate-fade-in-up leading-tight">
                {!! nl2br(e(Setting::get('hero_title', 'Innovative Chemical Solutions'))) !!}
            </h1>
            <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto animate-fade-in-up-delay leading-relaxed font-light mb-12">
                {!! nl2br(e(Setting::get('hero_subtitle', 'Leading chemical innovation company providing cutting-edge solutions'))) !!}
            </p>
            <div class="flex flex-wrap justify-center gap-6 animate-fade-in-up" style="animation-delay: 0.4s">
                <a href="{{ route('products.index') }}" class="btn-white group">
                    {{ Setting::get('hero_cta_primary_text', 'Explore Our Products') }}
                    <svg class="ml-2 -mr-1 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="btn-outline-white">
                    {{ Setting::get('hero_cta_secondary_text', 'Contact Us') }}
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-white" viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h1440V0C1440 0 1140 48 720 48S0 0 0 0v48z"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6 animate-fade-in-up">
                Why Choose Us
            </span>
            <h2 class="text-3xl md:text-4xl font-bold mb-6 animate-fade-in-up">Experience Excellence in Chemical Innovation</h2>
            <p class="text-lg text-gray-600 animate-fade-in-up">Discover why leading industries trust us for their chemical solutions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Innovation -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                 style="animation-delay: 0.1s">
                <div class="p-8">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 group-hover:text-primary transition-colors">Innovation First</h3>
                    <p class="text-gray-600 leading-relaxed">Pioneering chemical solutions that drive industry progress and set new standards in quality and performance.</p>
                </div>
            </div>

            <!-- Quality -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                 style="animation-delay: 0.2s">
                <div class="p-8">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 group-hover:text-primary transition-colors">Quality Assured</h3>
                    <p class="text-gray-600 leading-relaxed">Rigorous testing and quality control processes ensure excellence in every product we deliver.</p>
                </div>
            </div>

            <!-- Sustainability -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                 style="animation-delay: 0.3s">
                <div class="p-8">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 group-hover:text-primary transition-colors">Eco-Friendly</h3>
                    <p class="text-gray-600 leading-relaxed">Committed to sustainable practices and environmentally conscious solutions for a better future.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6 animate-fade-in-up">
                Featured Products
            </span>
            <h2 class="text-3xl md:text-4xl font-bold mb-6 animate-fade-in-up">Discover Our Solutions</h2>
            <p class="text-lg text-gray-600 animate-fade-in-up">Innovative chemical solutions designed to meet your industry needs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
            @if($featuredProducts->isEmpty())
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">No featured products available at the moment.</p>
                </div>
            @else
                @foreach($featuredProducts as $product)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-6 line-clamp-2">{{ $product->description }}</p>
                        <a href="{{ route('products.show', $product) }}" class="inline-flex items-center text-primary hover:text-primary-dark transition-colors group">
                            Learn More
                            <svg class="w-5 h-5 ml-2 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6 animate-fade-in-up">
                Our Categories
            </span>
            <h2 class="text-3xl md:text-4xl font-bold mb-6 animate-fade-in-up">Browse By Category</h2>
            <p class="text-lg text-gray-600 animate-fade-in-up">Explore our comprehensive range of chemical products and solutions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" 
                   class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                   style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 relative overflow-hidden">
                        @if($category->image && Storage::exists('public/' . $category->image))
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 loading="lazy">
                        @else
                            <div class="flex items-center justify-center h-full bg-primary/5">
                                <svg class="w-16 h-16 text-primary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors duration-300">
                            {{ $category->name }}
                        </h3>
                        <p class="text-gray-600 mb-6 line-clamp-2">{{ $category->description }}</p>
                        <div class="flex items-center text-primary font-semibold">
                            <span>View Products</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition duration-300 group">
                View All Categories
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6 animate-fade-in-up">
                Testimonials
            </span>
            <h2 class="text-3xl md:text-4xl font-bold mb-6 animate-fade-in-up">What Our Clients Say</h2>
            <p class="text-lg text-gray-600 animate-fade-in-up">Trusted by industry leaders worldwide</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-3xl shadow-xl p-8 group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <div class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $testimonial->client_name }}</div>
                        <div class="text-gray-600">{{ $testimonial->company }}</div>
                    </div>
                </div>
                <p class="text-gray-600 italic leading-relaxed">"{{ $testimonial->content }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative py-32 bg-gradient-to-br from-primary via-primary-dark to-primary overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-30 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-black/30"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-3xl mx-auto text-center">
            <span class="inline-block px-4 py-2 rounded-full bg-white/10 text-white/90 backdrop-blur-lg text-sm font-medium mb-6 animate-fade-in-up">
                Get Started Today
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-8 animate-fade-in-up">Ready to Transform Your Chemical Solutions?</h2>
            <p class="text-lg text-white/90 mb-12 animate-fade-in-up">Partner with us to discover innovative chemical solutions tailored to your needs</p>
            <div class="flex flex-wrap justify-center gap-6 animate-fade-in-up">
                <a href="{{ route('contact') }}" class="btn-white group">
                    Get Started
                    <svg class="ml-2 -mr-1 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="{{ route('products.index') }}" class="btn-outline-white">
                    View All Products
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
