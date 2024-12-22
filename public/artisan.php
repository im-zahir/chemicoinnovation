<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Generate application key
$kernel->call('key:generate');
echo "Application key generated\n";

// Create storage link
$kernel->call('storage:link');
echo "Storage link created\n";

// Clear caches
$kernel->call('config:clear');
$kernel->call('cache:clear');
$kernel->call('view:clear');
echo "Caches cleared\n";

// Run migrations
$kernel->call('migrate', ['--force' => true]);
echo "Migrations completed\n";

echo "All done! You can delete this file now.";
?>
