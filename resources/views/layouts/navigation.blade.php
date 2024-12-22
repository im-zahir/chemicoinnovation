@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;
@endphp

<nav x-data="{ open: false }" 
     x-init="$watch('open', value => {
        if (value && window.innerWidth < 1024) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    })"
     class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img class="h-8 w-auto" 
                         src="{{ Setting::get('site_logo') ? Storage::disk('public')->url(Setting::get('site_logo')) : asset('images/logo.svg') }}" 
                         alt="{{ config('app.name') }}">
                </a>
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" 
                        type="button" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-50"
                        :aria-expanded="open">
                    <span class="sr-only" x-text="open ? 'Close menu' : 'Open menu'">Open menu</span>
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ route('home') }}" 
                   class="nav-link {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-gray-600' }}">
                    Home
                </a>
                <a href="{{ route('products.index') }}" 
                   class="nav-link {{ request()->routeIs('products.*') ? 'text-primary font-semibold' : 'text-gray-600' }}">
                    Products
                </a>
                <a href="{{ route('about') }}" 
                   class="nav-link {{ request()->routeIs('about') ? 'text-primary font-semibold' : 'text-gray-600' }}">
                    About
                </a>
                <a href="{{ route('contact') }}" 
                   class="nav-link {{ request()->routeIs('contact') ? 'text-primary font-semibold' : 'text-gray-600' }}">
                    Contact
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-cloak
         x-show="open"
         x-transition:enter="transform transition-transform duration-300"
         x-transition:enter-start="-translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transform transition-transform duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="-translate-y-full"
         class="fixed inset-0 z-40 lg:hidden">
        <!-- Background overlay -->
        <div x-show="open" 
             x-transition:enter="transition-opacity duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-black bg-opacity-25"
             @click="open = false">
        </div>

        <!-- Menu content -->
        <div class="relative bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" 
                   @click="open = false"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    Home
                </a>
                <a href="{{ route('products.index') }}" 
                   @click="open = false"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products.*') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    Products
                </a>
                <a href="{{ route('about') }}" 
                   @click="open = false"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    About
                </a>
                <a href="{{ route('contact') }}" 
                   @click="open = false"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    Contact
                </a>
            </div>
        </div>
    </div>
</nav>
