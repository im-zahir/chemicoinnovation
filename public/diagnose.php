<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting Laravel Diagnostics...\n\n";

try {
    $laravelPath = '/home/chemqssp/laravel';
    
    // Check Laravel directory
    echo "Checking Laravel installation:\n";
    echo "Laravel path: {$laravelPath}\n";
    echo "Directory exists: " . (is_dir($laravelPath) ? "Yes" : "No") . "\n";
    echo "Directory permissions: " . substr(sprintf('%o', fileperms($laravelPath)), -4) . "\n\n";
    
    // Check critical files
    $criticalFiles = [
        '/home/chemqssp/laravel/.env' => 'Environment file',
        '/home/chemqssp/laravel/bootstrap/cache' => 'Bootstrap cache directory',
        '/home/chemqssp/laravel/storage' => 'Storage directory',
        '/home/chemqssp/laravel/storage/logs' => 'Logs directory',
        '/home/chemqssp/laravel/storage/framework/sessions' => 'Sessions directory',
        '/home/chemqssp/laravel/storage/framework/views' => 'Views directory',
        '/home/chemqssp/laravel/storage/framework/cache' => 'Cache directory',
    ];
    
    echo "Checking critical files and directories:\n";
    foreach ($criticalFiles as $path => $description) {
        echo "{$description}:\n";
        echo "Path: {$path}\n";
        echo "Exists: " . (file_exists($path) ? "Yes" : "No") . "\n";
        echo "Permissions: " . (file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : "N/A") . "\n";
        if (is_file($path)) {
            echo "Size: " . filesize($path) . " bytes\n";
        }
        echo "\n";
    }
    
    // Check storage symlink
    $publicStorage = '/home/chemqssp/public_html/storage';
    echo "Checking storage symlink:\n";
    echo "Symlink path: {$publicStorage}\n";
    echo "Is symlink: " . (is_link($publicStorage) ? "Yes" : "No") . "\n";
    if (is_link($publicStorage)) {
        echo "Points to: " . readlink($publicStorage) . "\n";
    }
    echo "\n";
    
    // Check PHP version and extensions
    echo "PHP Environment:\n";
    echo "PHP Version: " . phpversion() . "\n";
    echo "Required extensions:\n";
    $requiredExtensions = ['pdo', 'pdo_sqlite', 'openssl', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
    foreach ($requiredExtensions as $ext) {
        echo "{$ext}: " . (extension_loaded($ext) ? "Loaded" : "Not loaded") . "\n";
    }
    echo "\n";
    
    // Check error log
    $errorLog = '/home/chemqssp/laravel/storage/logs/laravel.log';
    echo "Checking Laravel error log:\n";
    if (file_exists($errorLog)) {
        echo "Log file exists\n";
        echo "Last 10 lines of error log:\n";
        $log = file($errorLog);
        $lastLines = array_slice($log, -10);
        foreach ($lastLines as $line) {
            echo $line;
        }
    } else {
        echo "Log file not found at: {$errorLog}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nDiagnostics completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
