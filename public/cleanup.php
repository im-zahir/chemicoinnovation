<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting cleanup...\n\n";

$files_to_remove = [
    'install-node.php',
    'install-node-direct.php',
    'fix-assets.php',
    'cleanup.php'  // This script will remove itself too
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

echo "\nCleanup completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
