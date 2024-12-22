<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting final cleanup...\n\n";

$files_to_remove = [
    'fix-bundle.php',
    'fix-cdn.php',
    'compile-css.php',
    'cleanup-all.php'  // This script will remove itself too
];

foreach ($files_to_remove as $file) {
    $filepath = __DIR__ . '/' . $file;
    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            echo "✓ Removed: {$file}\n";
        } else {
            echo "! Failed to remove: {$file}\n";
        }
    } else {
        echo "- File not found: {$file}\n";
    }
}

// Clean up any leftover build files
$cleanup_dirs = [
    '/home/chemqssp/laravel/public/build',
    '/home/chemqssp/laravel/node_modules'
];

foreach ($cleanup_dirs as $dir) {
    if (is_dir($dir)) {
        exec("rm -rf " . escapeshellarg($dir) . " 2>&1", $output, $return);
        if ($return === 0) {
            echo "✓ Removed directory: " . basename($dir) . "\n";
        } else {
            echo "! Failed to remove directory: " . basename($dir) . "\n";
        }
    }
}

echo "\nCleanup completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
