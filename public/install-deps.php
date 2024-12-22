<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300); // 5 minutes

echo "<pre>\n";

try {
    $laravelPath = '/home/chemqssp/laravel';
    
    // Check Laravel path
    if (!is_dir($laravelPath)) {
        throw new Exception("Laravel directory not found at: {$laravelPath}");
    }
    echo "✓ Laravel directory found\n";
    
    // Change to Laravel directory
    if (!chdir($laravelPath)) {
        throw new Exception("Could not change to Laravel directory");
    }
    echo "✓ Changed to Laravel directory: " . getcwd() . "\n";
    
    // Check if composer.json exists
    if (!file_exists('composer.json')) {
        throw new Exception("composer.json not found");
    }
    echo "✓ Found composer.json\n";
    
    // Run composer install
    echo "\nRunning composer install...\n";
    $output = [];
    exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $return_var);
    
    echo "Return code: " . $return_var . "\n\n";
    echo "Output:\n";
    echo implode("\n", $output) . "\n";
    
    if ($return_var !== 0) {
        throw new Exception("Composer install failed");
    }
    
    echo "\n✓ Dependencies installed successfully!\n";
    echo "Now you can run setup-core.php to complete the setup.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
