@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[60vh] overflow-hidden bg-gradient-to-br from-primary via-primary-dark to-primary">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-30 mix-blend-overlay"></div>
        <!-- Animated particles -->
        <div class="particles absolute inset-0"></div>
    </div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 rounded-full bg-white/10 text-white/90 backdrop-blur-lg text-sm font-medium mb-6 animate-fade-in-up">
                Welcome to Chemico Innovation
            </span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-8 animate-fade-in-up leading-tight">
                Innovative Solutions <br class="hidden md:block"> for Every Industry
            </h1>
            <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto animate-fade-in-up-delay leading-relaxed font-light">
                Leading manufacturer and supplier of high-quality chemical products engineered to meet your specific requirements
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-white" viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h1440V0C1440 0 1140 48 720 48S0 0 0 0v48z"/>
        </svg>
    </div>
</section>

<!-- Featured Products -->
<section class="py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <!-- Sidebar with Categories -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden sticky top-24 animate-fade-in-left border border-gray-100">
                    <div class="bg-gradient-to-r from-primary to-primary-dark p-8">
                        <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <span>Categories</span>
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="flex items-center justify-between px-8 py-5 hover:bg-gray-50 transition-all duration-300 group text-gray-700 border-l-4 border-transparent">
                                <span class="text-lg">{{ $category->name }}</span>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Featured Products Grid -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                             style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100">
                                @if($product->image && Storage::exists('public/' . $product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         loading="lazy">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($product->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-white/90 backdrop-blur-sm text-primary shadow-lg">
                                            {{ $product->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors duration-300 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 mb-8 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                                <a href="{{ route('products.show', $product) }}" class="text-primary font-semibold">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-32 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary backdrop-blur-lg text-sm font-medium mb-6 animate-fade-in-up">
                Client Testimonials
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 animate-fade-in-up">
                What Our Clients Say
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto animate-fade-in-up-delay">
                Hear from our satisfied customers about their experience with us
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($testimonials as $testimonial)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-primary">{{ substr($testimonial->client_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->client_name }}</h4>
                                <p class="text-gray-600">{{ $testimonial->client_company }}</p>
                            </div>
                        </div>
                        <div class="relative">
                            <svg class="absolute top-0 left-0 w-8 h-8 text-primary/20 transform -translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                            </svg>
                            <p class="text-gray-600 italic leading-relaxed line-clamp-4">{{ $testimonial->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="relative py-32 bg-gradient-to-br from-primary via-primary-dark to-primary overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-30 mix-blend-overlay"></div>
        <div class="particles absolute inset-0"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 rounded-full bg-white/10 text-white/90 backdrop-blur-lg text-sm font-medium mb-6 animate-fade-in-up">
            Get Started Today
        </span>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up">
            Ready to Transform Your Business?
        </h2>
        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto animate-fade-in-up-delay">
            Contact us today to discuss your chemical requirements and how we can help your business grow
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-xl hover:bg-gray-50 transition duration-300">
                Browse Products
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition duration-300">
                Contact Us
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
    /* Animations */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-left {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-fade-in-up {
        opacity: 0;
        animation: fade-in-up 0.8s ease-out forwards;
    }
    
    .animate-fade-in-up-delay {
        opacity: 0;
        animation: fade-in-up 0.8s ease-out 0.3s forwards;
    }
    
    .animate-fade-in-left {
        opacity: 0;
        animation: fade-in-left 0.8s ease-out forwards;
    }

    /* Aspect Ratio */
    .aspect-w-4 {
        position: relative;
        padding-bottom: calc(var(--tw-aspect-h) / var(--tw-aspect-w) * 100%);
        --tw-aspect-w: 4;
    }
    .aspect-h-3 {
        --tw-aspect-h: 3;
    }
    .aspect-w-4 > * {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    /* Line Clamp */
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
    
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .line-clamp-4 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
    }

    /* Particle animation */
    .particles {
        background-image: 
            radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px),
            radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
    }
</style>
@endsection
