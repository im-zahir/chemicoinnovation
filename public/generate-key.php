<?php
$key = 'base64:'.base64_encode(random_bytes(32));
$envFile = __DIR__.'/../laravel/.env';

if (file_exists($envFile)) {
    $env = file_get_contents($envFile);
    $env = preg_replace('/APP_KEY=.*/', 'APP_KEY='.$key, $env);
    file_put_contents($envFile, $env);
    echo "Application key set successfully: " . $key;
} else {
    echo "Error: .env file not found at: " . $envFile;
}
?>
