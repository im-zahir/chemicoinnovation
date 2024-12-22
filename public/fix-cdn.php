<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting CDN fix...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Update blade template to use CDN
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Add Tailwind CSS CDN and remove old CSS references
            $content = preg_replace(
                '/<link href="\{\{ asset\(\'css\/app[^"]*\'\) \}\}" rel="stylesheet">/i',
                '<script src="https://cdn.tailwindcss.com"></script>' . "\n" .
                '    <script>' . "\n" .
                '        tailwind.config = {' . "\n" .
                '            theme: {' . "\n" .
                '                extend: {' . "\n" .
                '                    colors: {' . "\n" .
                '                        primary: "var(--primary)",' . "\n" .
                '                        "primary-light": "var(--primary-light)",' . "\n" .
                '                        "primary-dark": "var(--primary-dark)",' . "\n" .
                '                        accent: "var(--accent)"' . "\n" .
                '                    }' . "\n" .
                '                }' . "\n" .
                '            }' . "\n" .
                '        }' . "\n" .
                '    </script>' . "\n" .
                '    <style>' . "\n" .
                '        :root {' . "\n" .
                '            --primary: #000435;' . "\n" .
                '            --primary-light: #1a1e4d;' . "\n" .
                '            --primary-dark: #00021f;' . "\n" .
                '            --accent: #3b82f6;' . "\n" .
                '        }' . "\n" .
                '    </style>',
                $content
            );
            
            // Remove non-critical CSS
            $content = preg_replace(
                '/\s*<link[^>]+non-critical.css[^>]+>\s*/',
                "\n",
                $content
            );
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template with CDN and custom styles\n";
            }
        }
    }
    
    // Update JS to not use imports
    $jsContent = <<<'JS'
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

    // Write JS file
    if (file_put_contents($jsDir . '/app.js', $jsContent)) {
        echo "✓ Created JS file\n";
    }

    // Clear view cache
    exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
    if ($cacheReturn === 0) {
        echo "✓ Cleared view cache\n";
    }

    echo "\nCDN fix completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
