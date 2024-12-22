<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP Test Script</h1>";

// Test basic file system access
echo "<h2>File System Test:</h2>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Parent directory exists: " . (is_dir(__DIR__ . '/../') ? 'Yes' : 'No') . "<br>";
echo "Laravel directory exists: " . (is_dir(__DIR__ . '/../laravel') ? 'Yes' : 'No') . "<br>";

// List contents of parent directory
echo "<h2>Directory Contents:</h2>";
echo "<pre>";
$parentDir = __DIR__ . '/../';
if (is_dir($parentDir)) {
    $files = scandir($parentDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo $file . "\n";
        }
    }
}
echo "</pre>";

// Check PHP version and loaded extensions
echo "<h2>PHP Information:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Loaded Extensions:<br><pre>";
print_r(get_loaded_extensions());
echo "</pre>";

?>
