<?php
try {
    // Create database file if it doesn't exist
    $databasePath = __DIR__.'/../laravel/database/database.sqlite';
    $databaseDir = dirname($databasePath);
    
    echo "<pre>\n";
    
    // Create database directory if it doesn't exist
    if (!is_dir($databaseDir)) {
        if (mkdir($databaseDir, 0755, true)) {
            echo "✓ Created database directory\n";
        } else {
            throw new Exception("Failed to create database directory");
        }
    }
    
    // Create empty database file if it doesn't exist
    if (!file_exists($databasePath)) {
        if (touch($databasePath)) {
            chmod($databasePath, 0644);
            echo "✓ Created database file\n";
        } else {
            throw new Exception("Failed to create database file");
        }
    }
    
    // Include the autoloader
    require __DIR__.'/../laravel/vendor/autoload.php';
    
    // Create the application
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Run migrations
    $kernel->call('migrate:fresh', ['--force' => true]);
    echo "✓ Database migrations completed\n";
    
    // Clear caches
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('view:clear');
    echo "✓ Cache cleared\n";
    
    echo "\nDatabase setup completed successfully!\n";
    echo "Please delete this file for security.\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "</pre>";
}
?>
