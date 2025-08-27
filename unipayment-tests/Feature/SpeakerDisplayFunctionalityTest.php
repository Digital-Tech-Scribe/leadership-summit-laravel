<?php

namespace UniPaymentTests\Feature;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UniPaymentTests\TestCase;

class SpeakerDisplayFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function event_page_loads_successfully()
    {
        // Create an event
        $event = Event::factory()->create([
            'status' => 'published',
            'slug' => 'test-event'
        ]);

        // Visit the event page
        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
    }

    /** @test */
    public function event_page_displays_speakers_section_when_speakers_are_assigned()
    {
        // Create an event
        $event = Event::factory()->create([
            'status' => 'published',
            'slug' => 'test-event-with-speakers'
        ]);

        // Create speakers
        $hostSpeaker = Speaker::factory()->create([
            'name' => 'John Host Speaker',
            'position' => 'CEO',
            'company' => 'Tech Corp',
            'bio' => 'This is the host speaker bio.'
        ]);

        $regularSpeaker = Speaker::factory()->create([
            'name' => 'Jane Regular Speaker',
            'position' => 'CTO',
            'company' => 'Innovation Inc'
        ]);

        // Assign speakers to event
        $event->speakers()->attach($hostSpeaker->id, ['is_host' => true]);
        $event->speakers()->attach($regularSpeaker->id, ['is_host' => false]);

        // Visit the event page
        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check that speakers section is displayed
        $response->assertSee('Event Speakers');
        $response->assertSee('HOST SPEAKER');
        $response->assertSee('John Host Speaker');
        $response->assertSee('CEO, Tech Corp');
        $response->assertSee('This is the host speaker bio');

        // Check regular speaker
        $response->assertSee('Additional Speakers');
        $response->assertSee('Jane Regular Speaker');
        $response->assertSee('CTO, Innovation Inc');
    }

    /** @test */
    public function event_page_does_not_display_speakers_section_when_no_speakers_assigned()
    {
        // Create an event without speakers
        $event = Event::factory()->create([
            'status' => 'published',
            'slug' => 'test-event-no-speakers'
        ]);

        // Visit the event page
        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check that speakers section is not displayed
        $response->assertDontSee('<section class="event-speakers-section">', false);
        $response->assertDontSee('HOST SPEAKER');
    }

    /** @test */
    public function event_page_displays_speaker_bio_information()
    {
        // Create an event
        $event = Event::factory()->create([
            'status' => 'published',
            'slug' => 'test-event-with-bio'
        ]);

        // Create speakers with bio information
        $hostSpeaker = Speaker::factory()->create([
            'name' => 'Host Speaker',
            'position' => 'CEO',
            'company' => 'Tech Corp',
            'bio' => 'This is a detailed bio for the host speaker that should be displayed prominently on the event page.'
        ]);

        $regularSpeaker = Speaker::factory()->create([
            'name' => 'Regular Speaker',
            'position' => 'CTO',
            'company' => 'Innovation Inc',
            'bio' => 'This is a bio for the regular speaker that should be displayed in the speaker card.'
        ]);

        // Assign speakers to event
        $event->speakers()->attach($hostSpeaker->id, ['is_host' => true]);
        $event->speakers()->attach($regularSpeaker->id, ['is_host' => false]);

        // Visit the event page
        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check that bio information is displayed
        $response->assertSee('This is a detailed bio for the host speaker');
        $response->assertSee('This is a bio for the regular speaker');
    }

    /** @test */
    public function event_page_displays_only_regular_speakers_when_no_host_designated()
    {
        // Create an event
        $event = Event::factory()->create([
            'status' => 'published',
            'slug' => 'test-event-no-host'
        ]);

        // Create speakers (all regular, no host)
        $speaker1 = Speaker::factory()->create(['name' => 'Speaker One']);
        $speaker2 = Speaker::factory()->create(['name' => 'Speaker Two']);

        // Assign speakers to event (all as regular speakers)
        $event->speakers()->attach($speaker1->id, ['is_host' => false]);
        $event->speakers()->attach($speaker2->id, ['is_host' => false]);

        // Visit the event page
        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check that speakers section is displayed
        $response->assertSee('Event Speakers');
        $response->assertDontSee('HOST SPEAKER');
        $response->assertDontSee('Additional Speakers');
        $response->assertSee('Speaker One');
        $response->assertSee('Speaker Two');
    }
}
