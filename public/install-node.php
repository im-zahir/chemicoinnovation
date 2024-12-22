<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting Node.js installation...\n\n";

try {
    // Install NVM
    echo "Installing NVM...\n";
    $homeDir = '/home/chemqssp';
    $nvmDir = $homeDir . '/.nvm';
    
    // Create .nvm directory
    if (!is_dir($nvmDir)) {
        mkdir($nvmDir, 0755, true);
        echo "✓ Created .nvm directory\n";
    }
    
    // Download and install NVM
    $installCmd = 'curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash';
    exec($installCmd . ' 2>&1', $output, $returnVar);
    echo implode("\n", $output) . "\n";
    
    if ($returnVar === 0) {
        echo "✓ NVM installed successfully\n\n";
        
        // Add NVM to .bashrc if not already there
        $bashrc = $homeDir . '/.bashrc';
        $nvmInit = '
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
';
        
        if (!file_exists($bashrc) || strpos(file_get_contents($bashrc), 'NVM_DIR') === false) {
            file_put_contents($bashrc, $nvmInit, FILE_APPEND);
            echo "✓ Added NVM initialization to .bashrc\n";
        }
        
        echo "\nNode.js installation instructions:\n";
        echo "1. Log out and log back in, or run:\n";
        echo "   source ~/.bashrc\n\n";
        echo "2. Then run these commands:\n";
        echo "   nvm install 18\n";
        echo "   nvm use 18\n";
        echo "   cd " . dirname(dirname(__FILE__)) . "\n";
        echo "   npm install\n";
        echo "   npm run build\n";
    } else {
        echo "! Failed to install NVM\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
