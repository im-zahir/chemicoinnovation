<?php
// Check if this is run from web server
if (php_sapi_name() !== 'cli') {
    // Web execution
    header('Content-Type: text/plain');
}

// Include the autoloader
require __DIR__.'/../vendor/autoload.php';

// Create the application
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    // Generate application key
    $kernel->call('key:generate');
    echo "✓ Application key generated\n";

    // Create storage link
    $kernel->call('storage:link');
    echo "✓ Storage link created\n";

    // Clear caches
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('view:clear');
    echo "✓ Caches cleared\n";

    // Run migrations
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Migrations completed\n";

    echo "\nSetup completed successfully! Please delete this file for security.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
