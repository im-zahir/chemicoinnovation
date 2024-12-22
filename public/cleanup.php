<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting cleanup...\n\n";

$files_to_remove = [
    __DIR__ . '/check-db.php',
    __DIR__ . '/test-db.php',
    __DIR__ . '/fix-storage.php',
    __DIR__ . '/cleanup.php'  // This script will remove itself too
];

foreach ($files_to_remove as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✓ Removed: " . basename($file) . "\n";
        } else {
            echo "! Failed to remove: " . basename($file) . "\n";
        }
    } else {
        echo "- File not found: " . basename($file) . "\n";
    }
}

echo "\nCleanup completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
