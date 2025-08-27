<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::withCount(['registrations', 'tickets'])
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $speakers = Speaker::orderBy('name')->get();
        return view('admin.events.create', compact('speakers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,cancelled',
            'is_default' => 'boolean',
            'featured' => 'boolean',
            'selected_icon' => 'nullable|string',
            'speakers' => 'nullable|array',
            'speakers.*' => 'exists:speakers,id',
            'host_speaker' => 'nullable|exists:speakers,id',
        ]);

        // Custom validation: ensure host speaker is in speakers array
        if ($request->filled('host_speaker') && $request->filled('speakers')) {
            if (!in_array($request->host_speaker, $request->speakers)) {
                return back()->withErrors([
                    'host_speaker' => 'Host speaker must be selected from the assigned speakers.'
                ])->withInput();
            }
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }

        $event = Event::create($data);

        // Handle speaker assignments
        $this->handleSpeakerAssignments($event, $request);

        // Set as default if requested
        if ($request->is_default) {
            $event->setAsDefault();
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['registrations', 'tickets']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $speakers = Speaker::orderBy('name')->get();
        $event->load('speakers');
        return view('admin.events.edit', compact('event', 'speakers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,cancelled',
            'is_default' => 'boolean',
            'featured' => 'boolean',
            'selected_icon' => 'nullable|string',
            'speakers' => 'nullable|array',
            'speakers.*' => 'exists:speakers,id',
            'host_speaker' => 'nullable|exists:speakers,id',
        ]);

        // Custom validation: ensure host speaker is in speakers array
        if ($request->filled('host_speaker') && $request->filled('speakers')) {
            if (!in_array($request->host_speaker, $request->speakers)) {
                return back()->withErrors([
                    'host_speaker' => 'Host speaker must be selected from the assigned speakers.'
                ])->withInput();
            }
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($event->featured_image) {
                Storage::disk('public')->delete($event->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }

        $event->update($data);

        // Handle speaker assignments
        $this->handleSpeakerAssignments($event, $request);

        // Set as default if requested
        if ($request->is_default) {
            $event->setAsDefault();
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Check if event has registrations
        if ($event->registrations()->count() > 0) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Cannot delete event with existing registrations.');
        }

        // Delete featured image
        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Set event as default
     */
    public function setDefault(Event $event)
    {
        $event->setAsDefault();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event set as default successfully.');
    }

    /**
     * Handle speaker assignments for an event.
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    private function handleSpeakerAssignments(Event $event, Request $request)
    {
        // Check if speakers field is present in the request
        if ($request->has('speakers')) {
            if ($request->filled('speakers')) {
                // Assign speakers with host designation
                $speakerData = [];
                foreach ($request->speakers as $speakerId) {
                    $speakerData[$speakerId] = [
                        'is_host' => $request->filled('host_speaker') && $request->host_speaker == $speakerId
                    ];
                }
                $event->speakers()->sync($speakerData);
            } else {
                // Clear all speaker assignments if speakers array is empty
                $event->speakers()->detach();
            }
        } elseif ($request->filled('speakers')) {
            // Handle case where speakers is filled but not an array (edge case)
            $speakerData = [];
            $speakers = is_array($request->speakers) ? $request->speakers : [$request->speakers];

            foreach ($speakers as $speakerId) {
                $speakerData[$speakerId] = [
                    'is_host' => $request->filled('host_speaker') && $request->host_speaker == $speakerId
                ];
            }
            $event->speakers()->sync($speakerData);
        }
    }
}
