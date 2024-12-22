<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting final fixes...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Update blade template
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Add Tailwind CSS CDN and Bootstrap
            $content = preg_replace(
                '/<script src="https:\/\/cdn\.tailwindcss\.com"><\/script>/',
                '<script src="https://cdn.tailwindcss.com"></script>' . "\n" .
                '    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">' . "\n" .
                '    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>',
                $content
            );
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template with Bootstrap\n";
            }
        }
    }
    
    // Create a simpler JS file without imports
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

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
});
JS;

    // Write JS file
    $jsDir = $repoPath . '/public/js';
    if (!is_dir($jsDir)) {
        mkdir($jsDir, 0755, true);
    }
    if (file_put_contents($jsDir . '/app.js', $jsContent)) {
        echo "✓ Created simplified JS file\n";
    }

    // Copy missing images
    $sourceImages = [
        $repoPath . '/resources/images/hero-bg.jpg',
        $repoPath . '/resources/images/1734891621_22-2jpg.jpg',
        $repoPath . '/resources/images/1734891544.jpg'
    ];
    
    $publicImagesDir = $repoPath . '/public/images';
    if (!is_dir($publicImagesDir)) {
        mkdir($publicImagesDir, 0755, true);
        echo "✓ Created public images directory\n";
    }
    
    foreach ($sourceImages as $image) {
        if (file_exists($image)) {
            $filename = basename($image);
            if (copy($image, $publicImagesDir . '/' . $filename)) {
                echo "✓ Copied image: {$filename}\n";
            }
        } else {
            echo "! Image not found: {$filename}\n";
        }
    }

    // Clear view cache
    exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
    if ($cacheReturn === 0) {
        echo "✓ Cleared view cache\n";
    }

    echo "\nFinal fixes completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";

// Remove this script
unlink(__FILE__);
