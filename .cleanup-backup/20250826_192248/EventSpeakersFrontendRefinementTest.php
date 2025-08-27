<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\EventSpeaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventSpeakersFrontendRefinementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function speakers_section_displays_correctly_with_single_speaker()
    {
        $event = Event::factory()->create([
            'slug' => 'single-speaker-event',
            'status' => 'published'
        ]);
        $speaker = Speaker::factory()->create([
            'name' => 'Solo Speaker',
            'position' => 'CEO',
            'company' => 'Tech Corp',
            'bio' => 'This is a solo speaker bio.'
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speaker->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Event Speakers');
        $response->assertSee('Solo Speaker');
        $response->assertSee('CEO, Tech Corp');
        $response->assertDontSee('HOST SPEAKER');
        $response->assertDontSee('Additional Speakers');
    }

    /** @test */
    public function speakers_section_displays_correctly_with_two_speakers()
    {
        $event = Event::factory()->create([
            'slug' => 'two-speakers-event',
            'status' => 'published'
        ]);

        $speaker1 = Speaker::factory()->create(['name' => 'First Speaker']);
        $speaker2 = Speaker::factory()->create(['name' => 'Second Speaker']);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speaker1->id,
            'is_host' => false
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speaker2->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Event Speakers');
        $response->assertSee('First Speaker');
        $response->assertSee('Second Speaker');
        $response->assertSee('regular-speakers-grid');
        $response->assertDontSee('HOST SPEAKER');
    }

    /** @test */
    public function speakers_section_displays_correctly_with_multiple_speakers_and_host()
    {
        $event = Event::factory()->create([
            'slug' => 'multiple-speakers-event',
            'status' => 'published'
        ]);

        $hostSpeaker = Speaker::factory()->create([
            'name' => 'Host Speaker',
            'position' => 'CEO',
            'company' => 'Leadership Corp',
            'bio' => 'This is the host speaker with a detailed bio that should be prominently displayed.'
        ]);

        $regularSpeakers = Speaker::factory()->count(5)->create();

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $hostSpeaker->id,
            'is_host' => true
        ]);

        foreach ($regularSpeakers as $speaker) {
            EventSpeaker::create([
                'event_id' => $event->id,
                'speaker_id' => $speaker->id,
                'is_host' => false
            ]);
        }

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Event Speakers');
        $response->assertSee('HOST SPEAKER');
        $response->assertSee('Host Speaker');
        $response->assertSee('Additional Speakers');
        $response->assertSee('regular-speakers-grid');

        foreach ($regularSpeakers as $speaker) {
            $response->assertSee($speaker->name);
        }
    }

    /** @test */
    public function speakers_section_displays_correctly_with_many_speakers()
    {
        $event = Event::factory()->create([
            'slug' => 'many-speakers-event',
            'status' => 'published'
        ]);

        $hostSpeaker = Speaker::factory()->create(['name' => 'Main Host']);
        $regularSpeakers = Speaker::factory()->count(12)->create();

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $hostSpeaker->id,
            'is_host' => true
        ]);

        foreach ($regularSpeakers as $speaker) {
            EventSpeaker::create([
                'event_id' => $event->id,
                'speaker_id' => $speaker->id,
                'is_host' => false
            ]);
        }

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Event Speakers');
        $response->assertSee('HOST SPEAKER');
        $response->assertSee('Main Host');
        $response->assertSee('Additional Speakers');

        // Verify all regular speakers are displayed
        foreach ($regularSpeakers as $speaker) {
            $response->assertSee($speaker->name);
        }
    }

    /** @test */
    public function host_speaker_prominence_and_styling_is_correct()
    {
        $event = Event::factory()->create([
            'slug' => 'host-prominence-test',
            'status' => 'published'
        ]);

        $hostSpeaker = Speaker::factory()->create([
            'name' => 'Prominent Host',
            'position' => 'Chief Executive Officer',
            'company' => 'Global Leadership Institute',
            'bio' => 'This is a detailed bio for the host speaker that demonstrates the prominence and styling.'
        ]);

        $regularSpeaker = Speaker::factory()->create(['name' => 'Regular Speaker']);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $hostSpeaker->id,
            'is_host' => true
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $regularSpeaker->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check host speaker prominence elements
        $response->assertSee('host-speaker-container');
        $response->assertSee('host-speaker-card');
        $response->assertSee('host-speaker-badge');
        $response->assertSee('HOST SPEAKER');
        $response->assertSee('host-speaker-avatar');
        $response->assertSee('host-speaker-name');
        $response->assertSee('host-speaker-title');
        $response->assertSee('host-speaker-bio');

        // Verify host speaker content
        $response->assertSee('Prominent Host');
        $response->assertSee('Chief Executive Officer, Global Leadership Institute');
        $response->assertSee('This is a detailed bio for the host speaker');

        // Check regular speaker elements
        $response->assertSee('regular-speakers-section');
        $response->assertSee('regular-speakers-grid');
        $response->assertSee('regular-speaker-card');
        $response->assertSee('Regular Speaker');
    }

    /** @test */
    public function speakers_section_contains_proper_responsive_structure()
    {
        $event = Event::factory()->create([
            'slug' => 'responsive-test',
            'status' => 'published'
        ]);

        $hostSpeaker = Speaker::factory()->create(['name' => 'Responsive Host']);
        $regularSpeakers = Speaker::factory()->count(3)->create();

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $hostSpeaker->id,
            'is_host' => true
        ]);

        foreach ($regularSpeakers as $speaker) {
            EventSpeaker::create([
                'event_id' => $event->id,
                'speaker_id' => $speaker->id,
                'is_host' => false
            ]);
        }

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check for Bootstrap responsive classes
        $response->assertSee('col-md-4');
        $response->assertSee('col-md-8');
        $response->assertSee('align-items-center');
        $response->assertSee('text-center');

        // Check for custom responsive classes
        $response->assertSee('event-speakers-section');
        $response->assertSee('host-speaker-container');
        $response->assertSee('regular-speakers-grid');
    }

    /** @test */
    public function speakers_section_integrates_properly_with_event_page_layout()
    {
        $event = Event::factory()->create([
            'slug' => 'layout-integration-test',
            'title' => 'Layout Integration Event',
            'description' => 'Testing layout integration',
            'status' => 'published'
        ]);

        $speaker = Speaker::factory()->create(['name' => 'Integration Speaker']);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speaker->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Verify both Quick Registration and Event Speakers sections are present
        $response->assertSee('Quick Register - No Account Required');
        $response->assertSee('Event Speakers');

        // Check that speakers section has proper container structure
        $response->assertSee('<section class="event-speakers-section">', false);
        $response->assertSee('<div class="container">', false);
        $response->assertSee('Integration Speaker');
    }

    /** @test */
    public function speakers_section_handles_speaker_images_correctly()
    {
        $event = Event::factory()->create([
            'slug' => 'image-test',
            'status' => 'published'
        ]);

        $speakerWithImage = Speaker::factory()->create([
            'name' => 'Speaker With Image',
            'photo' => 'speakers/speaker-photo.jpg'
        ]);

        $speakerWithoutImage = Speaker::factory()->make([
            'name' => 'Speaker Without Image',
            'photo' => null
        ]);
        $speakerWithoutImage->save();

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speakerWithImage->id,
            'is_host' => true
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $speakerWithoutImage->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check for image handling
        $response->assertSee('storage/speakers/speaker-photo.jpg');
        $response->assertSee('speaker-placeholder');
        $response->assertSee('fas fa-user');
    }

    /** @test */
    public function speakers_section_displays_speaker_information_correctly()
    {
        $event = Event::factory()->create([
            'slug' => 'info-display-test',
            'status' => 'published'
        ]);

        $detailedSpeaker = Speaker::factory()->create([
            'name' => 'Dr. Detailed Speaker',
            'position' => 'Chief Technology Officer',
            'company' => 'Innovation Technologies Inc.',
            'bio' => 'Dr. Detailed Speaker has over 15 years of experience in technology leadership and innovation management.'
        ]);

        $minimalSpeaker = Speaker::factory()->create([
            'name' => 'Minimal Speaker',
            'position' => null,
            'company' => null,
            'bio' => null
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $detailedSpeaker->id,
            'is_host' => true
        ]);

        EventSpeaker::create([
            'event_id' => $event->id,
            'speaker_id' => $minimalSpeaker->id,
            'is_host' => false
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check detailed speaker information
        $response->assertSee('Dr. Detailed Speaker');
        $response->assertSee('Chief Technology Officer, Innovation Technologies Inc.');
        $response->assertSee('Dr. Detailed Speaker has over 15 years');

        // Check minimal speaker information
        $response->assertSee('Minimal Speaker');

        // Verify the speaker information is properly structured
        $response->assertSee('host-speaker-name');
        $response->assertSee('host-speaker-title');
        $response->assertSee('host-speaker-bio');
        $response->assertSee('regular-speaker-name');
    }

    /** @test */
    public function speakers_section_maintains_consistent_styling()
    {
        $event = Event::factory()->create([
            'slug' => 'styling-consistency-test',
            'status' => 'published'
        ]);

        $speakers = Speaker::factory()->count(6)->create();

        foreach ($speakers as $index => $speaker) {
            EventSpeaker::create([
                'event_id' => $event->id,
                'speaker_id' => $speaker->id,
                'is_host' => $index === 0 // First speaker is host
            ]);
        }

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Check for consistent CSS classes across all speaker cards
        $response->assertSee('event-speakers-section');
        $response->assertSee('section-title');
        $response->assertSee('host-speaker-card');
        $response->assertSee('regular-speaker-card');

        // Verify styling consistency elements
        $response->assertSee('host-speaker-avatar');
        $response->assertSee('regular-speaker-avatar');
    }
}
