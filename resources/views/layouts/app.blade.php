@php
    use Illuminate\Support\Facades\Storage;
    use App\Models\Setting;
    use Illuminate\Support\Facades\Cache;

    // Cache favicon URL for 24 hours
    $faviconUrl = Cache::remember('site_favicon_url', 86400, function () {
        $favicon = Setting::get('site_favicon');
        if ($favicon && Storage::disk('public')->exists($favicon)) {
            return Storage::disk('public')->url($favicon);
        }
        return null;
    });
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chemico Innovation') }} - @yield('title')</title>
    <meta name="description" content="@yield('meta_description', 'Leading chemical innovation company providing cutting-edge solutions')">
    <meta name="keywords" content="@yield('meta_keywords', 'chemical, innovation, solutions, Bangladesh')">

    <!-- Favicon -->
    @if($faviconUrl)
        <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
        <link rel="shortcut icon" type="image/png" href="{{ $faviconUrl }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @endif

    <!-- Preload critical assets -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style">
    <link rel="preload" href="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" as="script">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Defer non-critical CSS -->
    <link rel="stylesheet" href="{{ asset('css/non-critical.css') }}" media="print" onload="this.media='all'">
    @stack('styles')
</head>
<body class="antialiased min-h-screen flex flex-col">
    <div id="app" class="flex-grow">
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
