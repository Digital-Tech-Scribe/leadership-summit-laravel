<?php

/**
 * Netlify Setup Script
 * This script runs during deployment to set up the database and initial data
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🗄️ Setting up database for Netlify...\n";

try {
    // Create SQLite database file
    $dbPath = '/tmp/database.sqlite';
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0666);
        echo "✅ Created SQLite database at {$dbPath}\n";
    }

    // Run migrations
    echo "🔄 Running database migrations...\n";
    $kernel->call('migrate', ['--force' => true]);
    echo "✅ Migrations completed\n";

    // Seed the database
    echo "🌱 Seeding database...\n";
    $kernel->call('db:seed', ['--force' => true]);
    echo "✅ Database seeded\n";

    echo "🎉 Netlify setup completed successfully!\n";
} catch (Exception $e) {
    echo "❌ Error during setup: " . $e->getMessage() . "\n";
    exit(1);
}
