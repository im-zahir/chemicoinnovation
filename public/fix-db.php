<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting database fix...\n\n";

try {
    require '/home/chemqssp/laravel/vendor/autoload.php';
    $app = require '/home/chemqssp/laravel/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Clear all caches first
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    echo "✓ Cleared all caches\n\n";
    
    // Run migrations
    echo "Running migrations...\n";
    $kernel->call('migrate:fresh', ['--force' => true]);
    echo "✓ Migrations completed\n\n";
    
    // Run cache table creation
    echo "Creating cache tables...\n";
    $kernel->call('cache:table');
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Cache tables created\n\n";
    
    // Run session table creation
    echo "Creating session tables...\n";
    $kernel->call('session:table');
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Session tables created\n\n";
    
    // Run queue table creation
    echo "Creating queue tables...\n";
    $kernel->call('queue:table');
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Queue tables created\n\n";
    
    echo "Database fix completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
