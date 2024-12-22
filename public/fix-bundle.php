<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting bundle fix...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Create a bundled JS file without imports
    $jsContent = <<<'JS'
// Initialize Bootstrap components
window.bootstrap = require('bootstrap');

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
            
            const icon = mobileMenuButton.querySelector('svg');
            if (mobileMenu.classList.contains('hidden')) {
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                `;
            } else {
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                `;
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
});

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
});
JS;

    // Create public/js directory if it doesn't exist
    $jsDir = $repoPath . '/public/js';
    if (!is_dir($jsDir)) {
        mkdir($jsDir, 0755, true);
        echo "✓ Created JS directory\n";
    }

    // Write bundled JS
    if (file_put_contents($jsDir . '/app.js', $jsContent)) {
        echo "✓ Created bundled JS file\n";
    }

    // Create a simpler CSS file
    $cssContent = <<<'CSS'
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Modern Design System */
:root {
    --primary: #000435;
    --primary-light: #1a1e4d;
    --primary-dark: #00021f;
    --accent: #3b82f6;
    --text-dark: #1f2937;
    --text-light: #6b7280;
}

body {
    color: #1f2937;
    background-color: white;
    font-family: ui-sans-serif, system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
    scroll-behavior: smooth;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    letter-spacing: -0.025em;
    color: #111827;
}

/* Add more styles as needed */
CSS;

    // Create public/css directory if it doesn't exist
    $cssDir = $repoPath . '/public/css';
    if (!is_dir($cssDir)) {
        mkdir($cssDir, 0755, true);
        echo "✓ Created CSS directory\n";
    }

    // Write CSS file
    if (file_put_contents($cssDir . '/app.css', $cssContent)) {
        echo "✓ Created CSS file\n";
    }

    // Update blade template
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Remove Vite and non-critical CSS
            $content = preg_replace(
                '/@vite\(\[[^\]]+\]\)/',
                '<link href="{{ asset(\'css/app.css\') }}" rel="stylesheet">' . "\n" .
                '    <script src="{{ asset(\'js/app.js\') }}" defer></script>',
                $content
            );
            
            // Remove non-critical CSS
            $content = preg_replace(
                '/\s*<link[^>]+non-critical.css[^>]+>\s*/',
                "\n",
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

    echo "\nBundle fix completed!\n";
    echo "Note: You may need to run 'npm install' and compile Tailwind CSS.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
