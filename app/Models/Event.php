<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReusableId;

class Event extends Model
{
    use HasFactory, ReusableId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'featured_image',
        'icon',
        'status',
        'is_default',
        'featured',
        'selected_icon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_default' => 'boolean',
        'featured' => 'boolean',
    ];

    /**
     * Get the tickets for the event.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the sessions for the event.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the speakers for the event (many-to-many relationship).
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speakers')
            ->withPivot('is_host')
            ->withTimestamps();
    }

    /**
     * Get the designated host speaker for this event.
     */
    public function hostSpeaker()
    {
        return $this->belongsToMany(Speaker::class, 'event_speakers')
            ->wherePivot('is_host', true)
            ->withPivot('is_host')
            ->withTimestamps()
            ->first();
    }

    /**
     * Get non-host speakers for this event.
     */
    public function regularSpeakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speakers')
            ->wherePivot('is_host', false)
            ->withPivot('is_host')
            ->withTimestamps();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the default event.
     */
    public static function getDefaultEvent()
    {
        return self::where('is_default', true)->first() ?? self::first();
    }

    /**
     * Set this event as the default event.
     */
    public function setAsDefault()
    {
        // Remove default status from all other events
        self::where('is_default', true)->update(['is_default' => false]);

        // Set this event as default and featured
        $this->update([
            'is_default' => true,
            'featured' => true
        ]);
    }

    /**
     * Get featured events (max 4).
     */
    public static function getFeaturedEvents()
    {
        return self::where('featured', true)
            ->where('status', 'published')
            ->orderByRaw('is_default DESC') // Default event first
            ->orderBy('start_date', 'asc')
            ->limit(4)
            ->get();
    }

    /**
     * Set this event as featured.
     */
    public function setAsFeatured()
    {
        // Check if we already have 4 featured events
        $featuredCount = self::where('featured', true)->count();

        if ($featuredCount >= 4 && !$this->featured) {
            throw new \Exception('Maximum of 4 events can be featured at once.');
        }

        $this->update(['featured' => true]);
    }

    /**
     * Remove featured status from this event.
     */
    public function removeFeatured()
    {
        // Don't allow removing featured status from default event
        if ($this->is_default) {
            throw new \Exception('Cannot remove featured status from the default event.');
        }

        $this->update(['featured' => false]);
    }
}
