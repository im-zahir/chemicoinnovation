@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white">
    <div class="container py-12">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-500">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                </li>
                <li class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">Products</a>
                </li>
                <li class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">{{ $category->name }}</span>
                </li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl font-bold mb-4">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-lg text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar with Categories -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                    <div class="bg-primary px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">Categories</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($categories as $cat)
                            <a href="{{ route('categories.show', $cat) }}" 
                               class="block px-6 py-4 hover:bg-gray-50 transition-colors duration-200
                                      {{ $cat->id === $category->id 
                                         ? 'bg-primary/5 text-primary font-medium' 
                                         : 'text-gray-700' }}">
                                <div class="flex items-center justify-between">
                                    <span>{{ $cat->name }}</span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <div class="product-card group">
                            <div class="relative overflow-hidden rounded-t-xl">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="w-full h-64 object-cover object-center transform transition-transform duration-500 group-hover:scale-110"
                                         alt="{{ $product->name }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @endif
                            </div>
                            <div class="p-6 bg-white rounded-b-xl">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 120) }}
                                </p>

                                <a href="{{ route('products.show', $product) }}" 
                                   class="inline-flex items-center text-primary font-semibold hover:text-primary-light transition-colors">
                                    View Details
                                    <svg class="w-5 h-5 ml-2 transform transition-transform group-hover:translate-x-1" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="lg:col-span-3">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            No products found in this category.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
