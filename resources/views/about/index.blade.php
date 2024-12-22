@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<section class="relative h-[60vh] overflow-hidden bg-primary">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark/90 to-primary/90"></div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-10"></div>
    </div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up">About Us</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto animate-fade-in-up-delay leading-relaxed">
                {{ \App\Models\Setting::get('company_tagline') }}
            </p>
            <div class="mt-8">
                <div class="inline-flex items-center space-x-2 text-white/80 text-sm animate-fade-in-up-delay-2">
                    <span class="w-8 h-px bg-white/40"></span>
                    <span>Innovating Since {{ \App\Models\Setting::get('company_founded', '1990') }}</span>
                    <span class="w-8 h-px bg-white/40"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-white" viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h1440V0C1440 0 1140 48 720 48S0 0 0 0v48z"/>
        </svg>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="group">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-primary to-primary-light">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-white/10 backdrop-blur-lg rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 animate-fade-in-up">Our Mission</h2>
                        <p class="text-lg text-gray-600 leading-relaxed animate-fade-in-up">
                            {{ $aboutSettings->mission }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="group">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-primary to-primary-light">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-white/10 backdrop-blur-lg rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 animate-fade-in-up">Our Vision</h2>
                        <p class="text-lg text-gray-600 leading-relaxed animate-fade-in-up">
                            {{ $aboutSettings->vision }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="py-24 bg-gray-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-5"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $aboutSettings->history_title ?: 'Our Journey' }}</h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
            <div class="prose prose-lg max-w-none">
                {{ $aboutSettings->history_description }}
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
@if($aboutSettings->values && count($aboutSettings->values) > 0)
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Values</h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($aboutSettings->values as $value)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors">{{ $value }}</h3>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Values Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($aboutContent['values']) && $aboutContent['values'])
                @foreach(json_decode($aboutContent['values'], true) ?? [] as $value)
                    <div class="group">
                        <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full"></div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 relative">{{ $value['title'] }}</h3>
                            <p class="text-gray-600 relative">{{ $value['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-24 bg-gray-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-5"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $aboutSettings->team_title ?: 'Our Team' }}</h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
            @if($aboutSettings->team_description)
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $aboutSettings->team_description }}</p>
            @endif
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($team as $member)
                <div class="group">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:-translate-y-2">
                        <!-- Member Image -->
                        <div class="relative aspect-[4/5] overflow-hidden">
                            @if($member->image)
                                <img src="{{ Storage::url($member->image) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Social Links Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-4">
                                <div class="flex space-x-4">
                                    @if($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}" target="_blank" class="text-white hover:text-primary-light transition-colors">
                                            <i class="fab fa-facebook-f fa-lg"></i>
                                        </a>
                                    @endif
                                    
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}" target="_blank" class="text-white hover:text-primary-light transition-colors">
                                            <i class="fab fa-twitter fa-lg"></i>
                                        </a>
                                    @endif
                                    
                                    @if($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}" target="_blank" class="text-white hover:text-primary-light transition-colors">
                                            <i class="fab fa-linkedin-in fa-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Member Info -->
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $member->name }}</h3>
                            <p class="text-primary font-medium mb-3">{{ $member->position }}</p>
                            @if($member->description)
                                <p class="text-gray-600 text-sm line-clamp-3">{{ $member->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No team members found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <div class="group">
                    <div class="bg-white rounded-2xl shadow-xl p-8 relative transform transition-all duration-300 hover:-translate-y-2">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full -mr-12 -mt-12"></div>
                        
                        <!-- Quote Icon -->
                        <div class="absolute -top-4 left-8">
                            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.956.76-3.022.66-1.065 1.515-1.867 2.558-2.403L9.373 5c-.8.396-1.56.898-2.26 1.505-.71.607-1.34 1.305-1.9 2.094s-.98 1.68-1.25 2.69-.346 2.04-.217 3.1c.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003zm9.124 0c0-.88-.23-1.618-.69-2.217-.326-.42-.77-.692-1.327-.817-.56-.124-1.074-.13-1.54-.022-.16-.94.09-1.95.75-3.02.66-1.06 1.514-1.86 2.557-2.4L18.49 5c-.8.396-1.555.898-2.26 1.505-.708.607-1.34 1.305-1.894 2.094-.556.79-.97 1.68-1.24 2.69-.273 1-.345 2.04-.217 3.1.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <div class="mb-6">
                                <p class="text-gray-600 italic">{{ $testimonial->content }}</p>
                            </div>
                            
                            <div class="flex items-center">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                         alt="{{ $testimonial->name }}" 
                                         class="w-12 h-12 rounded-xl object-cover mr-4">
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $testimonial->position }}</p>
                                </div>
                            </div>
                            
                            <div class="flex text-yellow-400 mt-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
    
    .animate-fade-in-up-delay {
        animation: fade-in-up 0.6s ease-out 0.2s forwards;
        opacity: 0;
    }
    
    .animate-fade-in-up-delay-2 {
        animation: fade-in-up 0.6s ease-out 0.4s forwards;
        opacity: 0;
    }
</style>
@endsection
