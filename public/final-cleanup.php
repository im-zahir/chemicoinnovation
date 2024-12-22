<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting final cleanup...\n\n";

$files_to_remove = [
    'check-env.php',
    'finalize.php',
    'generate-key.php',
    'install-deps.php',
    'run-artisan.php',
    'run-command.php',
    'secure-setup.php',
    'setup-core.php',
    'setup-db.php',
    'setup.php',
    'test-setup.php',
    'artisan.php',
    'final-cleanup.php'  // This script will remove itself last
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
