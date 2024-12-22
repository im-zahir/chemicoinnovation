<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting Node.js installation...\n\n";

try {
    $homeDir = '/home/chemqssp';
    $nodeDir = $homeDir . '/node';
    
    // Create node directory
    if (!is_dir($nodeDir)) {
        mkdir($nodeDir, 0755, true);
        echo "✓ Created node directory\n";
    }
    
    // Download Node.js binary
    echo "Downloading Node.js...\n";
    $nodeVersion = '18.19.0';
    $nodeUrl = "https://nodejs.org/dist/v{$nodeVersion}/node-v{$nodeVersion}-linux-x64.tar.gz";
    $targetFile = $nodeDir . '/node.tar.gz';
    
    $ch = curl_init($nodeUrl);
    $fp = fopen($targetFile, 'w+');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    if (curl_exec($ch)) {
        echo "✓ Downloaded Node.js\n";
        
        // Extract the archive
        echo "Extracting Node.js...\n";
        $extractCmd = "cd {$nodeDir} && tar xzf node.tar.gz";
        exec($extractCmd . ' 2>&1', $output, $returnVar);
        
        if ($returnVar === 0) {
            echo "✓ Extracted Node.js\n";
            
            // Add Node.js to PATH in .bashrc
            $nodeBinPath = $nodeDir . "/node-v{$nodeVersion}-linux-x64/bin";
            $pathUpdate = "\nexport PATH=\"{$nodeBinPath}:\$PATH\"\n";
            
            $bashrc = $homeDir . '/.bashrc';
            if (!file_exists($bashrc) || strpos(file_get_contents($bashrc), $nodeBinPath) === false) {
                file_put_contents($bashrc, $pathUpdate, FILE_APPEND);
                echo "✓ Added Node.js to PATH in .bashrc\n";
            }
            
            // Create symlinks
            $binDir = $homeDir . '/bin';
            if (!is_dir($binDir)) {
                mkdir($binDir, 0755, true);
            }
            
            symlink($nodeBinPath . '/node', $binDir . '/node');
            symlink($nodeBinPath . '/npm', $binDir . '/npm');
            symlink($nodeBinPath . '/npx', $binDir . '/npx');
            echo "✓ Created symlinks in ~/bin\n";
            
            echo "\nNode.js installation instructions:\n";
            echo "1. Log out and log back in, or run:\n";
            echo "   source ~/.bashrc\n\n";
            echo "2. Then run these commands:\n";
            echo "   cd " . dirname(dirname(__FILE__)) . "\n";
            echo "   npm install\n";
            echo "   npm run build\n";
        } else {
            echo "! Failed to extract Node.js\n";
            echo implode("\n", $output) . "\n";
        }
    } else {
        echo "! Failed to download Node.js\n";
        echo curl_error($ch) . "\n";
    }
    
    curl_close($ch);
    fclose($fp);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
