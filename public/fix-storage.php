<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting storage link fix...\n\n";

try {
    $publicStorage = '/home/chemqssp/public_html/storage';
    $targetStorage = '/home/chemqssp/laravel/storage/app/public';
    
    echo "Configuration:\n";
    echo "Public storage path: {$publicStorage}\n";
    echo "Target storage path: {$targetStorage}\n\n";
    
    // Check if target directory exists
    if (!is_dir($targetStorage)) {
        echo "Creating target storage directory...\n";
        mkdir($targetStorage, 0755, true);
        echo "✓ Target directory created\n\n";
    } else {
        echo "✓ Target directory exists\n\n";
    }
    
    // Remove existing storage if it exists
    if (is_link($publicStorage)) {
        echo "Removing existing symlink...\n";
        unlink($publicStorage);
        echo "✓ Existing symlink removed\n\n";
    } elseif (is_dir($publicStorage)) {
        echo "Removing existing storage directory...\n";
        exec("rm -rf " . escapeshellarg($publicStorage));
        echo "✓ Existing directory removed\n\n";
    }
    
    // Create new symlink
    echo "Creating new symlink...\n";
    if (symlink($targetStorage, $publicStorage)) {
        echo "✓ Storage link created successfully\n";
    } else {
        echo "! Failed to create symlink\n";
        echo "Error: " . error_get_last()['message'] . "\n";
    }
    
    // Verify the link
    if (is_link($publicStorage)) {
        echo "\nVerifying symlink:\n";
        echo "Link exists: Yes\n";
        echo "Points to: " . readlink($publicStorage) . "\n";
        echo "Real path: " . realpath($publicStorage) . "\n";
    }
    
    // Set permissions
    chmod($targetStorage, 0755);
    echo "\nPermissions set on target directory\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nStorage fix completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
?>
