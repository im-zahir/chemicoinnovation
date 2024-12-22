<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set execution time to 5 minutes
set_time_limit(300);

// Correct Laravel path
$laravelPath = '/home/chemqssp/laravel';

// The command to run (passed via GET parameter)
$allowedCommands = [
    'storage:link',
    'cache:clear',
    'config:clear',
    'view:clear',
    'route:clear',
    'config:cache',
    'route:cache',
    'view:cache',
    'optimize:clear',
    'optimize'
];

$command = isset($_GET['cmd']) ? $_GET['cmd'] : '';

if (!in_array($command, $allowedCommands)) {
    die("Invalid command. Allowed commands are: " . implode(', ', $allowedCommands));
}

// Output as plain text
header('Content-Type: text/plain');

echo "Laravel Path: {$laravelPath}\n";
echo "Running command: php artisan {$command}\n\n";

// Change to Laravel root directory
if (!chdir($laravelPath)) {
    die("Failed to change to Laravel directory: {$laravelPath}");
}

echo "Current working directory: " . getcwd() . "\n\n";

// Execute the command
$output = [];
$return_var = 0;
$command = escapeshellcmd("php artisan {$command}");
exec($command . " 2>&1", $output, $return_var);

// Output results
echo "Return code: {$return_var}\n\n";
echo "Output:\n";
echo implode("\n", $output);
?>