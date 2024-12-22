<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";

try {
    $laravelPath = '/home/chemqssp/laravel';
    
    // Check Laravel path
    if (!is_dir($laravelPath)) {
        throw new Exception("Laravel directory not found at: {$laravelPath}");
    }
    echo "✓ Laravel directory found\n";
    
    // Load composer autoloader
    $autoloader = $laravelPath . '/vendor/autoload.php';
    if (!file_exists($autoloader)) {
        throw new Exception("Autoloader not found at: {$autoloader}");
    }
    require $autoloader;
    echo "✓ Autoloader loaded\n";
    
    // Bootstrap Laravel
    $app = require $laravelPath . '/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class);
    echo "✓ Laravel bootstrapped\n";
    
    // Create storage directory if it doesn't exist
    $publicStorage = '/home/chemqssp/public_html/storage';
    if (!is_dir($publicStorage)) {
        if (mkdir($publicStorage, 0755, true)) {
            echo "✓ Created public storage directory\n";
        }
    }
    
    // Create storage symlink manually
    $target = $laravelPath . '/storage/app/public';
    if (!is_dir($target)) {
        mkdir($target, 0755, true);
        echo "✓ Created storage target directory\n";
    }
    
    // Create symlink if it doesn't exist
    if (!file_exists($publicStorage) || !is_link($publicStorage)) {
        if (symlink($target, $publicStorage)) {
            echo "✓ Created storage symlink\n";
        } else {
            echo "! Failed to create symlink\n";
            echo "Target: {$target}\n";
            echo "Link: {$publicStorage}\n";
        }
    } else {
        echo "Storage symlink already exists\n";
    }
    
    // Clear Laravel caches manually
    $cachePaths = [
        $laravelPath . '/bootstrap/cache/*.php',
        $laravelPath . '/storage/framework/cache/*',
        $laravelPath . '/storage/framework/views/*.php',
        $laravelPath . '/storage/framework/sessions/*',
    ];
    
    foreach ($cachePaths as $path) {
        array_map('unlink', glob($path) ?: []);
    }
    echo "✓ Cleared Laravel caches\n";
    
    // Set directory permissions
    $permissions = [
        $laravelPath . '/storage' => 0755,
        $laravelPath . '/storage/app' => 0755,
        $laravelPath . '/storage/app/public' => 0755,
        $laravelPath . '/storage/framework' => 0755,
        $laravelPath . '/storage/framework/cache' => 0755,
        $laravelPath . '/storage/framework/sessions' => 0755,
        $laravelPath . '/storage/framework/views' => 0755,
        $laravelPath . '/storage/logs' => 0755,
        $laravelPath . '/bootstrap/cache' => 0755,
    ];
    
    foreach ($permissions as $path => $perm) {
        if (!is_dir($path)) {
            mkdir($path, $perm, true);
            echo "Created directory: {$path}\n";
        }
        chmod($path, $perm);
        echo "✓ Set permissions for: " . basename($path) . "\n";
    }
    
    echo "\nSetup completed successfully!\n";
    echo "You can now try accessing your website.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
