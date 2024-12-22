<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Laravel Error Log Viewer\n\n";

try {
    $logFile = '/home/chemqssp/laravel/storage/logs/laravel.log';
    
    if (file_exists($logFile)) {
        echo "Reading last error from log file...\n\n";
        
        // Read the file content
        $content = file_get_contents($logFile);
        
        // Split into individual log entries (usually separated by stack traces)
        $entries = preg_split('/\[[\d\-\s\:]+\]\s+production\.ERROR/m', $content);
        
        // Get the last entry
        $lastEntry = end($entries);
        
        if ($lastEntry) {
            echo "Most recent error:\n";
            echo $lastEntry . "\n";
        } else {
            echo "No error entries found in log.\n";
        }
        
        // Also check for any SQL-related errors
        if (stripos($content, 'sql') !== false || stripos($content, 'database') !== false) {
            echo "\nFound SQL/Database related errors:\n";
            $lines = explode("\n", $content);
            foreach ($lines as $line) {
                if (stripos($line, 'sql') !== false || stripos($line, 'database') !== false) {
                    echo $line . "\n";
                }
            }
        }
    } else {
        echo "Error log file not found at: {$logFile}\n";
    }
    
} catch (Exception $e) {
    echo "Error reading log file: " . $e->getMessage() . "\n";
}

echo "\nViewer completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
