<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('speaker_id')->constrained('speakers')->onDelete('cascade');
            $table->boolean('is_host')->default(false);
            $table->timestamps();

            // Add unique constraint to prevent duplicate event-speaker assignments
            $table->unique(['event_id', 'speaker_id']);

            // Add indexes for better query performance
            $table->index('event_id');
            $table->index('speaker_id');
            $table->index('is_host');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_speakers');
    }
};
