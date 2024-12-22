<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting image fixes...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Update blade template to use correct image paths
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Update image paths to use storage URLs
            $content = str_replace(
                'images/hero-bg.jpg',
                'storage/images/hero/Y45bZZCsbW352cFy7Pqt7DbxHLUKOZSNLy0Pluq1.jpg',
                $content
            );
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template with correct image paths\n";
            }
        }
    }

    // Create storage link if it doesn't exist
    if (!is_link($repoPath . '/public/storage')) {
        exec("cd {$repoPath} && php artisan storage:link 2>&1", $linkOutput, $linkReturn);
        if ($linkReturn === 0) {
            echo "✓ Created storage symlink\n";
        } else {
            echo "! Failed to create storage symlink: " . implode("\n", $linkOutput) . "\n";
        }
    } else {
        echo "✓ Storage symlink already exists\n";
    }

    // Clear view cache
    exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
    if ($cacheReturn === 0) {
        echo "✓ Cleared view cache\n";
    }

    echo "\nImage fixes completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";

// Remove this script
unlink(__FILE__);
