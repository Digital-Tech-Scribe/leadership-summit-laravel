<?php

/**
 * Cleanup Hardcoded Data Script
 * 
 * This script removes hardcoded speakers and other test data from the production database.
 * 
 * Usage:
 * 1. Upload to server: scp cleanup-hardcoded-data.php globalea@server:/home/globalea/leadership-summit-laravel/
 * 2. Run via CLI: /usr/local/php83/bin/php cleanup-hardcoded-data.php
 * 3. Or run via web: https://globaleadershipacademy.com/cleanup-hardcoded-data.php
 */

// Bootstrap Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h2>🧹 Cleanup Hardcoded Data</h2>\n";
echo "<pre>\n";

try {
    echo "1. Identifying hardcoded speakers to remove...\n";

    // List of hardcoded speaker names to remove
    $hardcodedSpeakers = [
        'Dr. Sarah Johnson',
        'Michael Chen',
        'Dr. Amanda Rodriguez',
        'James Thompson',
        'Lisa Park',
        'Speaker 1',
        'Speaker 2',
        'Speaker 3',
        'Speaker 4',
        'Speaker 5',
        'Speaker 6',
        'John Speaker',
        'Jane Expert'
    ];

    $removedCount = 0;

    foreach ($hardcodedSpeakers as $speakerName) {
        $speakers = \App\Models\Speaker::where('name', 'like', '%' . $speakerName . '%')->get();

        foreach ($speakers as $speaker) {
            echo "   🗑️  Removing speaker: {$speaker->name} (ID: {$speaker->id})\n";

            // Remove speaker photo if exists
            if ($speaker->photo) {
                \Storage::disk('public')->delete($speaker->photo);
                echo "      📷 Deleted photo: {$speaker->photo}\n";
            }

            // Remove speaker from sessions
            $speaker->sessions()->detach();
            echo "      🔗 Detached from sessions\n";

            // Delete the speaker
            $speaker->delete();
            $removedCount++;
        }
    }

    echo "   ✅ Removed {$removedCount} hardcoded speakers\n";

    echo "\n2. Cleaning up test events...\n";

    // Remove test events that might have been created by seeders
    $testEvents = \App\Models\Event::where('title', 'like', '%test%')
        ->orWhere('title', 'like', '%sample%')
        ->orWhere('title', 'like', '%demo%')
        ->get();

    $removedEventsCount = 0;
    foreach ($testEvents as $event) {
        echo "   🗑️  Removing test event: {$event->title} (ID: {$event->id})\n";

        // Remove event image if exists
        if ($event->featured_image) {
            \Storage::disk('public')->delete($event->featured_image);
            echo "      📷 Deleted image: {$event->featured_image}\n";
        }

        // Remove related data
        $event->registrations()->delete();
        $event->sessions()->delete();
        $event->tickets()->delete();
        $event->delete();
        $removedEventsCount++;
    }

    echo "   ✅ Removed {$removedEventsCount} test events\n";

    echo "\n3. Cleaning up test users...\n";

    // Remove test users (but keep admin)
    $testUsers = \App\Models\User::where('email', 'like', '%example.com%')
        ->orWhere('email', 'like', '%test%')
        ->orWhere('name', 'like', '%test%')
        ->where('email', '!=', 'admin@leadershipsummit.com')
        ->get();

    $removedUsersCount = 0;
    foreach ($testUsers as $user) {
        echo "   🗑️  Removing test user: {$user->name} ({$user->email}) (ID: {$user->id})\n";

        // Remove user registrations and orders
        $user->registrations()->delete();
        $user->orders()->delete();
        $user->delete();
        $removedUsersCount++;
    }

    echo "   ✅ Removed {$removedUsersCount} test users\n";

    echo "\n4. Resetting auto-increment values...\n";

    // Reset auto-increment for cleaned tables
    $tables = ['speakers', 'events', 'users', 'tickets', 'sessions', 'registrations'];

    foreach ($tables as $table) {
        $maxId = \DB::table($table)->max('id') ?? 0;
        $nextId = $maxId + 1;

        \DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = {$nextId}");
        echo "   ✅ Reset {$table} auto-increment to {$nextId}\n";
    }

    echo "\n5. Database statistics after cleanup...\n";

    $stats = [
        'Speakers' => \App\Models\Speaker::count(),
        'Events' => \App\Models\Event::count(),
        'Users' => \App\Models\User::count(),
        'Tickets' => \App\Models\Ticket::count(),
        'Sessions' => \App\Models\Session::count(),
        'Registrations' => \App\Models\Registration::count(),
    ];

    foreach ($stats as $model => $count) {
        echo "   📊 {$model}: {$count} records\n";
    }

    echo "\n🎉 CLEANUP COMPLETE!\n";
    echo "===================\n";
    echo "✅ Removed all hardcoded test data\n";
    echo "✅ Reset auto-increment values\n";
    echo "✅ Database is now clean and ready for real data\n\n";
    echo "You can now create speakers, events, and other content from scratch\n";
    echo "with proper ID sequencing starting from 1.\n";
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>\n";

// Auto-redirect to admin dashboard after 5 seconds if run via web
if (isset($_SERVER['HTTP_HOST'])) {
    echo "<script>
        setTimeout(function() {
            window.location.href = '/admin';
        }, 5000);
    </script>";
    echo "<p><a href='/admin'>Click here to go to admin dashboard</a> (auto-redirecting in 5 seconds)</p>";
}
