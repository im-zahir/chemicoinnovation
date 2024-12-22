@extends('layouts.app')

@section('title', 'Products')

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
                Discover Our Range
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up">Our Products</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto animate-fade-in-up-delay leading-relaxed">
                Innovative products engineered to meet your specific requirements with uncompromising quality
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-white" viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h1440V0C1440 0 1140 48 720 48S0 0 0 0v48z"/>
        </svg>
    </div>
</section>

<!-- Products Section -->
<section class="py-20 bg-white relative">
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
                               class="flex items-center justify-between px-8 py-5 hover:bg-gray-50 transition-all duration-300 group
                                      {{ request()->route('category')?->id === $category->id 
                                         ? 'bg-primary/10 text-primary font-semibold border-l-4 border-primary' 
                                         : 'text-gray-700 border-l-4 border-transparent' }}">
                                <span class="text-lg">{{ $category->name }}</span>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
                    @forelse($products as $product)
                        <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-1 border border-gray-100" 
                        style="animation-delay: {{ min($loop->index * 0.1, 1) . 's' }}">

                            <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100">
                                @if($product->image && Storage::exists('public/' . $product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         loading="lazy"
                                    >
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
                                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors duration-300 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 mb-8 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($product->description, 120) }}
                                </p>

                                <a href="{{ route('products.show', $product->slug) }}" class="text-primary font-semibold">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>No products available.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-20">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
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

    /* Particle animation */
    .particles {
        background-image: 
            radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px),
            radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
        animation: particleMove 60s linear infinite;
    }

    @keyframes particleMove {
        from {
            background-position: 0 0, 20px 20px;
        }
        to {
            background-position: 1000px 1000px, 1020px 1020px;
        }
    }
</style>
@endsection
