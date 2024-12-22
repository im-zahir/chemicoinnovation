<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";

try {
    $db_path = '/home/chemqssp/laravel/database/database.sqlite';
    echo "Database path: " . $db_path . "\n";
    
    if (file_exists($db_path)) {
        echo "Database file exists\n";
        echo "Permissions: " . substr(sprintf('%o', fileperms($db_path)), -4) . "\n";
        echo "File size: " . filesize($db_path) . " bytes\n";
        
        $pdo = new PDO("sqlite:" . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "\nConnected successfully\n";
        
        $result = $pdo->query("SELECT COUNT(*) FROM sqlite_master")->fetchColumn();
        echo "Number of tables: " . $result . "\n";
        
        // List all tables
        $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
        echo "\nTables in database:\n";
        foreach ($tables as $table) {
            echo "- " . $table . "\n";
        }
    } else {
        echo "Database file does not exist!\n";
        echo "Parent directory: " . dirname($db_path) . "\n";
        echo "Parent directory exists: " . (is_dir(dirname($db_path)) ? "Yes" : "No") . "\n";
        echo "Parent directory permissions: " . substr(sprintf('%o', fileperms(dirname($db_path))), -4) . "\n";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
    echo "Error info: " . json_encode($e->errorInfo, JSON_PRETTY_PRINT) . "\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nScript completed at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
?>
