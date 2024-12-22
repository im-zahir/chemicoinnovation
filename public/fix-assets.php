<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting asset fix...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    
    // Update blade template
    $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        if ($content !== false) {
            // Replace Vite with direct asset includes
            $content = str_replace(
                '@vite([\'resources/css/app.css\', \'resources/js/app.js\'])',
                '<link href="{{ asset(\'css/app.css\') }}" rel="stylesheet">' . "\n" .
                '    <script src="{{ asset(\'js/app.js\') }}" defer></script>',
                $content
            );
            
            if (file_put_contents($bladePath, $content)) {
                echo "✓ Updated blade template\n";
            }
        }
    }
    
    // Copy CSS file
    $cssSource = $repoPath . '/resources/css/app.css';
    $cssTarget = $repoPath . '/public/css/app.css';
    if (!is_dir(dirname($cssTarget))) {
        mkdir(dirname($cssTarget), 0755, true);
    }
    if (file_exists($cssSource)) {
        if (copy($cssSource, $cssTarget)) {
            echo "✓ Copied CSS file\n";
        }
    }
    
    // Copy JS file
    $jsSource = $repoPath . '/resources/js/app.js';
    $jsTarget = $repoPath . '/public/js/app.js';
    if (!is_dir(dirname($jsTarget))) {
        mkdir(dirname($jsTarget), 0755, true);
    }
    if (file_exists($jsSource)) {
        if (copy($jsSource, $jsTarget)) {
            echo "✓ Copied JS file\n";
        }
    }
    
    // Clear view cache
    exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
    if ($cacheReturn === 0) {
        echo "✓ Cleared view cache\n";
    }
    
    echo "\nAsset fix completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
