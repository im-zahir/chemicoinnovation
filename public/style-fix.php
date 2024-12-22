<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting style fixes...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Create CSS directory if it doesn't exist
    $cssDir = $repoPath . '/public/css';
    if (!is_dir($cssDir)) {
        mkdir($cssDir, 0755, true);
        echo "✓ Created CSS directory\n";
    }

    // Create base CSS file
    $cssContent = <<<'CSS'
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
}

/* Buttons */
.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--primary-light);
    border-color: var(--primary-light);
}

/* Navigation */
.navbar {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Custom utilities */
.bg-primary {
    background-color: var(--primary) !important;
}

.text-primary {
    color: var(--primary) !important;
}

/* Mobile menu */
.mobile-menu {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.mobile-menu.hidden {
    display: none;
}

/* Alert styles */
.alert {
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 0.375rem;
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
CSS;

    if (file_put_contents($cssDir . '/app.css', $cssContent)) {
        echo "✓ Created CSS file\n";
    }

    // Update blade template
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Replace existing styles section with new one
            $newStyles = <<<'HTML'
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
HTML;
            
            // Replace everything between <!-- Styles --> and the next section
            $content = preg_replace(
                '/<!-- Styles -->.*?(?=<\/head>)/s',
                $newStyles,
                $content
            );
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template\n";
            }
        }
    }

    // Clear view cache
    exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
    if ($cacheReturn === 0) {
        echo "✓ Cleared view cache\n";
    }

    // Clear route cache
    exec("cd {$repoPath} && php artisan route:clear 2>&1", $routeOutput, $routeReturn);
    if ($routeReturn === 0) {
        echo "✓ Cleared route cache\n";
    }

    // Clear config cache
    exec("cd {$repoPath} && php artisan config:clear 2>&1", $configOutput, $configReturn);
    if ($configReturn === 0) {
        echo "✓ Cleared config cache\n";
    }

    echo "\nStyle fixes completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";

// Remove this script
unlink(__FILE__);
