<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";

try {
    $publicStorage = '/home/chemqssp/public_html/storage';
    $targetStorage = '/home/chemqssp/laravel/storage/app/public';
    
    // Remove existing storage link if it exists
    if (is_link($publicStorage)) {
        unlink($publicStorage);
        echo "✓ Removed existing symlink\n";
    } elseif (is_dir($publicStorage)) {
        // If it's a directory, remove it and its contents
        exec("rm -rf " . escapeshellarg($publicStorage));
        echo "✓ Removed existing storage directory\n";
    }
    
    // Create target directory if it doesn't exist
    if (!is_dir($targetStorage)) {
        mkdir($targetStorage, 0755, true);
        echo "✓ Created target storage directory\n";
    }
    
    // Create new symlink
    if (symlink($targetStorage, $publicStorage)) {
        echo "✓ Created new storage symlink\n";
        echo "Target: {$targetStorage}\n";
        echo "Link: {$publicStorage}\n";
    } else {
        echo "! Failed to create symlink\n";
        echo "Error: " . error_get_last()['message'] . "\n";
    }
    
    // Verify the link
    if (is_link($publicStorage)) {
        echo "✓ Storage link verified\n";
        echo "Real path: " . realpath($publicStorage) . "\n";
    }
    
    echo "\nStorage setup completed!\n";
    echo "Now try accessing your website at https://www.chemicobd.com\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
