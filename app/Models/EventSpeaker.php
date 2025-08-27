<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSpeaker extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'event_speakers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'event_id',
        'speaker_id',
        'is_host'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_host' => 'boolean'
    ];

    /**
     * Boot method to ensure only one host speaker per event.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_host) {
                // Remove host status from other speakers for this event
                static::where('event_id', $model->event_id)
                    ->where('speaker_id', '!=', $model->speaker_id)
                    ->update(['is_host' => false]);
            }
        });
    }

    /**
     * Get the event that owns the EventSpeaker.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the speaker that owns the EventSpeaker.
     */
    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }
}
