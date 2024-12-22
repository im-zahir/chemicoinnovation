<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting final style fixes...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Update blade template
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Replace everything between <head> and </head>
            $newHead = <<<'HTML'
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary)',
                        'primary-light': 'var(--primary-light)',
                        'primary-dark': 'var(--primary-dark)',
                        accent: 'var(--accent)'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
HTML;
            
            // Replace the entire head section
            $content = preg_replace('/<head>.*?<\/head>/s', $newHead, $content);
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template with proper head section\n";
            }
        }
    }

    // Update CSS file
    $cssContent = <<<'CSS'
/* Base styles */
:root {
    --primary: #000435;
    --primary-light: #1a1e4d;
    --primary-dark: #00021f;
    --accent: #3b82f6;
}

body {
    font-family: 'Inter', sans-serif;
    color: #1f2937;
    background-color: white;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1rem;
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.75rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

/* Buttons */
.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary:hover {
    background-color: var(--primary-light);
    border-color: var(--primary-light);
}

/* Navigation */
.navbar {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 1rem;
}

.nav-link {
    color: var(--primary);
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: color 0.2s;
}

.nav-link:hover {
    color: var(--accent);
}

/* Mobile menu */
.mobile-menu {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    padding: 1rem;
    margin-top: 0.5rem;
}

.mobile-menu.hidden {
    display: none;
}

/* Alert styles */
.alert {
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid transparent;
}

.alert-success {
    background-color: #d1fae5;
    border-color: #34d399;
    color: #065f46;
}

.alert-danger {
    background-color: #fee2e2;
    border-color: #f87171;
    color: #991b1b;
}

/* Custom utilities */
.bg-primary { background-color: var(--primary) !important; }
.text-primary { color: var(--primary) !important; }
.bg-accent { background-color: var(--accent) !important; }
.text-accent { color: var(--accent) !important; }
CSS;

    $cssPath = $repoPath . '/public/css/app.css';
    if (file_put_contents($cssPath, $cssContent)) {
        echo "✓ Updated CSS file with enhanced styles\n";
    }

    // Clear all caches
    $commands = [
        'view:clear',
        'route:clear',
        'config:clear',
        'cache:clear'
    ];

    foreach ($commands as $command) {
        exec("cd {$repoPath} && php artisan {$command} 2>&1", $output, $return);
        if ($return === 0) {
            echo "✓ Cleared {$command} cache\n";
        }
    }

    echo "\nFinal style fixes completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";

// Remove this script and other fix scripts
$scriptsToRemove = [
    __FILE__,
    __DIR__ . '/style-fix.php'
];

foreach ($scriptsToRemove as $script) {
    if (file_exists($script)) {
        unlink($script);
    }
}
