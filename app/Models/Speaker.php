<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReusableId;

class Speaker extends Model
{
    use HasFactory, ReusableId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'photo',
        'position',
        'company',
    ];

    /**
     * Get the sessions for the speaker.
     */
    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_speakers');
    }

    /**
     * Many-to-many relationship with events.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_speakers')
            ->withPivot('is_host')
            ->withTimestamps();
    }

    /**
     * Get events where this speaker is the host.
     */
    public function hostedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_speakers')
            ->wherePivot('is_host', true)
            ->withPivot('is_host')
            ->withTimestamps();
    }
}
