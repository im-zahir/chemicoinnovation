<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";

try {
    $db_path = __DIR__ . '/../database/database.sqlite';
    echo "Database path: " . $db_path . "\n";
    
    if (file_exists($db_path)) {
        echo "Database file exists\n";
        echo "Permissions: " . substr(sprintf('%o', fileperms($db_path)), -4) . "\n";
        
        $pdo = new PDO("sqlite:" . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "Connected successfully\n";
        
        $result = $pdo->query("SELECT COUNT(*) FROM sqlite_master")->fetchColumn();
        echo "Number of tables: " . $result . "\n";
    } else {
        echo "Database file does not exist!\n";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
