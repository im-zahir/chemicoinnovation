<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting assets fix...\n\n";

try {
    // Create build directory if it doesn't exist
    $buildDir = '/home/chemqssp/laravel/public/build';
    if (!is_dir($buildDir)) {
        mkdir($buildDir, 0755, true);
        echo "✓ Created build directory\n";
    }
    
    // Create a basic Vite manifest
    $manifest = [
        "resources/css/app.css" => [
            "file" => "assets/app-4ed993c7.js",
            "isEntry" => true,
            "src" => "resources/css/app.css"
        ],
        "resources/js/app.js" => [
            "file" => "assets/app-4ed993c7.js",
            "isEntry" => true,
            "src" => "resources/js/app.js"
        ]
    ];
    
    // Write manifest
    $manifestPath = $buildDir . '/manifest.json';
    if (file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT))) {
        echo "✓ Created Vite manifest\n";
    } else {
        echo "! Failed to create manifest\n";
    }
    
    // Create assets directory
    $assetsDir = $buildDir . '/assets';
    if (!is_dir($assetsDir)) {
        mkdir($assetsDir, 0755, true);
        echo "✓ Created assets directory\n";
    }
    
    // Create empty asset files
    $assetFile = $assetsDir . '/app-4ed993c7.js';
    if (file_put_contents($assetFile, '')) {
        echo "✓ Created asset file\n";
    }
    
    // Update app.blade.php to not use Vite
    $bladePath = '/home/chemqssp/laravel/resources/views/layouts/app.blade.php';
    if (file_exists($bladePath)) {
        $content = file_get_contents($bladePath);
        
        // Replace Vite directives with regular asset includes
        $content = str_replace(
            '@vite([\'resources/css/app.css\', \'resources/js/app.js\'])',
            '<link rel="stylesheet" href="{{ asset(\'css/app.css\') }}">' . "\n" .
            '<script src="{{ asset(\'js/app.js\') }}" defer></script>',
            $content
        );
        
        if (file_put_contents($bladePath, $content)) {
            echo "✓ Updated app.blade.php\n";
        }
    }
    
    echo "\nAssets fix completed!\n";
    echo "Note: You may need to run 'npm install && npm run build' locally and upload the built assets.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
