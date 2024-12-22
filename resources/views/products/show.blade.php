@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
            <li><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">Products</a></li>
            <li><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        <!-- Product Image -->
        <div class="animate-fade-in-left">
            <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100 rounded-3xl shadow-2xl border border-gray-100">
                @if($product->image && Storage::exists('public/' . $product->image))
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                @else
                    <div class="flex items-center justify-center h-full bg-gray-100">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="animate-fade-in-right">
            <h1 class="text-3xl md:text-4xl font-bold mb-6">{{ $product->name }}</h1>
            
            @if($product->category)
                <a href="{{ route('categories.show', $product->category) }}" class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium hover:bg-primary/20 transition-colors mb-8">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    {{ $product->category->name }}
                </a>
            @endif

            @if($product->description)
                <div class="mb-12">
                    <h2 class="text-xl font-bold mb-4">Product Details</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                </div>
            @endif

            @if(!empty($product->features) && is_array($product->features))
                <div class="mb-12">
                    <h2 class="text-xl font-bold mb-4">Key Features</h2>
                    <ul class="space-y-4">
                        @foreach($product->features as $feature)
                            @if(!empty($feature))
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-primary flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-gray-600">{{ $feature }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($product->specifications) && is_array($product->specifications))
                <div>
                    <h2 class="text-xl font-bold mb-4">Specifications</h2>
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="divide-y divide-gray-100">
                            @foreach($product->specifications as $spec)
                                @if(is_array($spec) && isset($spec['name'], $spec['value']) && !empty($spec['name']) && !empty($spec['value']))
                                    <div class="flex">
                                        <div class="w-1/3 px-6 py-4 bg-gray-50 text-sm font-medium text-gray-500">{{ $spec['name'] }}</div>
                                        <div class="w-2/3 px-6 py-4 bg-white text-sm text-gray-900">{{ $spec['value'] }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
