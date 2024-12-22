<?php
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    // Get database path
    $database_path = database_path('database.sqlite');
    
    echo "Checking database configuration...\n";
    echo "Database path: " . $database_path . "\n";
    
    // Check if database file exists
    if (!file_exists($database_path)) {
        echo "Database file does not exist. Creating...\n";
        touch($database_path);
        chmod($database_path, 0666);
        echo "Database file created.\n";
    } else {
        echo "Database file exists.\n";
    }
    
    // Test database connection
    try {
        DB::connection()->getPdo();
        echo "Database connection successful!\n";
    } catch (\Exception $e) {
        echo "Database connection failed: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
