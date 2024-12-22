<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "PHP Version: " . PHP_VERSION . "\n\n";

echo "Current Directory: " . getcwd() . "\n";
echo "Script Location: " . __DIR__ . "\n\n";

echo "Laravel Directory Check:\n";
$laravelPath = __DIR__ . '/../laravel';
echo "Laravel Path: " . $laravelPath . "\n";
echo "Exists: " . (is_dir($laravelPath) ? 'Yes' : 'No') . "\n";
if (is_dir($laravelPath)) {
    echo "Readable: " . (is_readable($laravelPath) ? 'Yes' : 'No') . "\n";
    echo "Writable: " . (is_writable($laravelPath) ? 'Yes' : 'No') . "\n";
    echo "Contents:\n";
    $files = scandir($laravelPath);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "- $file\n";
        }
    }
}

echo "\nArtisan File Check:\n";
$artisanPath = $laravelPath . '/artisan';
echo "Artisan Path: " . $artisanPath . "\n";
echo "Exists: " . (file_exists($artisanPath) ? 'Yes' : 'No') . "\n";
if (file_exists($artisanPath)) {
    echo "Readable: " . (is_readable($artisanPath) ? 'Yes' : 'No') . "\n";
    echo "Executable: " . (is_executable($artisanPath) ? 'Yes' : 'No') . "\n";
    echo "File Permissions: " . substr(sprintf('%o', fileperms($artisanPath)), -4) . "\n";
}

echo "\nPHP Binary:\n";
$output = [];
exec('which php 2>&1', $output);
echo "PHP Path: " . implode("\n", $output) . "\n";

echo "\nEnvironment Variables:\n";
foreach ($_ENV as $key => $value) {
    echo "$key: $value\n";
}

echo "\nServer Variables:\n";
foreach ($_SERVER as $key => $value) {
    if (!is_array($value)) {
        echo "$key: $value\n";
    }
}

echo "</pre>";
?>
