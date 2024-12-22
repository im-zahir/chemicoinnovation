<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "Starting CSS compilation...\n\n";

try {
    $repoPath = '/home/chemqssp/laravel';
    $cssDir = $repoPath . '/public/css';
    
    // Create a temporary tailwind.config.js
    $tailwindConfig = <<<'CONFIG'
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: 'var(--primary)',
                'primary-light': 'var(--primary-light)',
                'primary-dark': 'var(--primary-dark)',
                accent: 'var(--accent)',
            },
        },
    },
    plugins: [],
}
CONFIG;

    if (file_put_contents($repoPath . '/tailwind.config.js', $tailwindConfig)) {
        echo "✓ Created Tailwind config\n";
    }

    // Create a temporary package.json if it doesn't exist
    $packageJson = <<<'JSON'
{
    "private": true,
    "type": "module",
    "scripts": {
        "build:css": "tailwindcss -i ./public/css/app.css -o ./public/css/app.min.css --minify"
    },
    "devDependencies": {
        "tailwindcss": "^3.4.0"
    }
}
JSON;

    if (file_put_contents($repoPath . '/package.json', $packageJson)) {
        echo "✓ Created package.json\n";
    }

    // Install dependencies
    echo "\nInstalling dependencies...\n";
    exec("cd {$repoPath} && npm install 2>&1", $npmOutput, $npmReturn);
    echo implode("\n", $npmOutput) . "\n";

    if ($npmReturn === 0) {
        echo "✓ Installed dependencies\n";

        // Build CSS
        echo "\nBuilding CSS...\n";
        exec("cd {$repoPath} && ./node_modules/.bin/tailwindcss -i ./public/css/app.css -o ./public/css/app.min.css --minify 2>&1", $buildOutput, $buildReturn);
        echo implode("\n", $buildOutput) . "\n";

        if ($buildReturn === 0) {
            echo "✓ Built CSS successfully\n";

            // Update blade template to use minified CSS
            $bladePath = $repoPath . '/resources/views/layouts/app.blade.php';
            if (file_exists($bladePath)) {
                $content = file_get_contents($bladePath);
                if ($content !== false) {
                    $content = str_replace(
                        'css/app.css',
                        'css/app.min.css',
                        $content
                    );
                    
                    if (file_put_contents($bladePath, $content)) {
                        echo "✓ Updated blade template to use minified CSS\n";
                    }
                }
            }

            // Clear view cache
            exec("cd {$repoPath} && php artisan view:clear 2>&1", $cacheOutput, $cacheReturn);
            if ($cacheReturn === 0) {
                echo "✓ Cleared view cache\n";
            }
        } else {
            echo "! Failed to build CSS\n";
        }
    } else {
        echo "! Failed to install dependencies\n";
    }

    echo "\nCSS compilation completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nCompleted at: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";
