<?php
try {
    echo "<pre>\n";
    
    // Include the autoloader
    require __DIR__.'/../laravel/vendor/autoload.php';
    
    // Create the application
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Create storage link
    $kernel->call('storage:link');
    echo "✓ Storage link created\n";
    
    // Clear all caches
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    echo "✓ All caches cleared\n";
    
    // Cache configurations for better performance
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    $kernel->call('view:cache');
    echo "✓ Configurations cached\n";
    
    // Set directory permissions
    $dirs = [
        __DIR__.'/../laravel/storage',
        __DIR__.'/../laravel/storage/app',
        __DIR__.'/../laravel/storage/framework',
        __DIR__.'/../laravel/storage/logs',
        __DIR__.'/../laravel/bootstrap/cache'
    ];
    
    foreach ($dirs as $dir) {
        if (is_dir($dir)) {
            chmod($dir, 0755);
            echo "✓ Set permissions for: " . basename($dir) . "\n";
        }
    }
    
    echo "\nFinalization completed successfully!\n";
    echo "Your website should now be working. Please delete all setup files (generate-key.php, setup-db.php, and this file) for security.\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "</pre>";
}
?>
