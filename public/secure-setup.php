<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set a secure password
$setup_password = 'chemico2024setup'; // You'll use this password to access the setup page

// Check if password is provided and correct
if (!isset($_POST['password']) || $_POST['password'] !== $setup_password) {
    // Show login form if password is not provided or incorrect
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Chemico Setup</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .container { max-width: 500px; margin: 0 auto; }
            .form-group { margin-bottom: 15px; }
            input[type="password"] { width: 100%; padding: 8px; margin: 5px 0; }
            button { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
            .error { color: red; margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Chemico Setup</h2>
            <?php if (isset($_POST['password'])) { ?>
                <div class="error">Incorrect password</div>
            <?php } ?>
            <form method="POST">
                <div class="form-group">
                    <label>Setup Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Access Setup</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

try {
    // First, check if we can find the Laravel installation
    $laravelPath = __DIR__.'/../laravel';
    if (!is_dir($laravelPath)) {
        throw new Exception("Laravel directory not found at: $laravelPath");
    }

    // Include the autoloader
    $autoloaderPath = $laravelPath.'/vendor/autoload.php';
    if (!file_exists($autoloaderPath)) {
        throw new Exception("Autoloader not found at: $autoloaderPath");
    }
    require $autoloaderPath;

    // Load the application
    $bootstrapPath = $laravelPath.'/bootstrap/app.php';
    if (!file_exists($bootstrapPath)) {
        throw new Exception("Bootstrap file not found at: $bootstrapPath");
    }
    $app = require_once $bootstrapPath;

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // Start output buffering
    ob_start();

    echo "<pre>\n";
    
    // Generate application key
    $kernel->call('key:generate');
    echo "✓ Application key generated\n";

    // Create storage link
    $kernel->call('storage:link');
    echo "✓ Storage link created\n";

    // Clear caches
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('view:clear');
    echo "✓ Caches cleared\n";

    // Run migrations
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Migrations completed\n";

    echo "\nSetup completed successfully!\n";
    echo "IMPORTANT: Delete this file (secure-setup.php) immediately for security!\n";
    echo "</pre>";

    // Flush the output buffer
    ob_end_flush();

} catch (Exception $e) {
    // If there was an error, display it in a formatted way
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Setup Error</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .container { max-width: 800px; margin: 0 auto; }
            .error { color: red; background: #ffebee; padding: 15px; border-radius: 4px; }
            .details { margin-top: 20px; background: #f5f5f5; padding: 15px; border-radius: 4px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Setup Error</h2>
            <div class="error">
                <?php echo htmlspecialchars($e->getMessage()); ?>
            </div>
            <div class="details">
                <strong>Error Details:</strong><br>
                <?php echo nl2br(htmlspecialchars($e->getTraceAsString())); ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
