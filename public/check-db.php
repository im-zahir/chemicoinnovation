<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting database check...\n\n";

try {
    require '/home/chemqssp/laravel/vendor/autoload.php';
    echo "✓ Autoloader loaded\n";
    
    $app = require_once '/home/chemqssp/laravel/bootstrap/app.php';
    echo "✓ Bootstrap loaded\n";
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    echo "✓ Kernel initialized\n";
    
    // Get database configuration
    $database_path = '/home/chemqssp/laravel/database/database.sqlite';
    echo "\nDatabase Configuration:\n";
    echo "Path: " . $database_path . "\n";
    
    // Check if database file exists
    if (file_exists($database_path)) {
        echo "✓ Database file exists\n";
        echo "File permissions: " . substr(sprintf('%o', fileperms($database_path)), -4) . "\n";
        echo "File size: " . filesize($database_path) . " bytes\n";
    } else {
        echo "! Database file does not exist\n";
        echo "Attempting to create database file...\n";
        try {
            touch($database_path);
            chmod($database_path, 0666);
            echo "✓ Database file created with permissions 666\n";
        } catch (Exception $e) {
            echo "! Failed to create database: " . $e->getMessage() . "\n";
        }
    }
    
    // Check directory permissions
    $db_dir = dirname($database_path);
    echo "\nDatabase directory permissions: " . substr(sprintf('%o', fileperms($db_dir)), -4) . "\n";
    
    // Test database connection
    try {
        $pdo = DB::connection()->getPdo();
        echo "\n✓ Database connection successful!\n";
        echo "SQLite version: " . $pdo->query('SELECT sqlite_version()')->fetchColumn() . "\n";
        
        // Test table access
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        echo "\nAvailable tables:\n";
        foreach ($tables as $table) {
            echo "- " . $table->name . "\n";
        }
    } catch (PDOException $e) {
        echo "\n! Database connection failed: " . $e->getMessage() . "\n";
        echo "PDO error code: " . $e->getCode() . "\n";
        echo "PDO error info: " . json_encode($e->errorInfo, JSON_PRETTY_PRINT) . "\n";
        
        // Check Laravel database config
        echo "\nChecking Laravel database configuration:\n";
        $config = config('database.connections.sqlite');
        echo "Database driver: " . config('database.default') . "\n";
        echo "Database config: " . json_encode($config, JSON_PRETTY_PRINT) . "\n";
    } catch (Exception $e) {
        echo "\n! Error: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
    
} catch (Exception $e) {
    echo "\n! Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCheck completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";