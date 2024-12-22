<?php
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

// If we get here, password was correct
header('Content-Type: text/plain');

// Include the autoloader
require __DIR__.'/../laravel/vendor/autoload.php';

// Create the application
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
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
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
