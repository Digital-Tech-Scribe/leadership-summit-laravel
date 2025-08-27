<?php

namespace UniPaymentTests\Unit\Models;

use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UniPaymentTests\TestCase;

class EventSpeakerRelationshipTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->event = Event::factory()->create();
        $this->speaker1 = Speaker::factory()->create();
        $this->speaker2 = Speaker::factory()->create();
        $this->speaker3 = Speaker::factory()->create();
    }

    /** @test */
    public function it_can_create_event_speaker_relationship()
    {
        $eventSpeaker = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertInstanceOf(EventSpeaker::class, $eventSpeaker);
    }

    /** @test */
    public function it_can_set_a_speaker_as_host()
    {
        $eventSpeaker = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        $this->assertTrue($eventSpeaker->is_host);
    }

    /** @test */
    public function it_ensures_only_one_host_speaker_per_event()
    {
        // Create first host speaker
        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        // Create second host speaker - should remove host status from first
        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => true
        ]);

        // Verify only speaker2 is host
        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => true
        ]);
    }

    /** @test */
    public function it_allows_multiple_non_host_speakers_per_event()
    {
        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => false
        ]);

        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker3->id,
            'is_host' => false
        ]);

        $this->assertDatabaseCount('event_speakers', 3);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => false
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker3->id,
            'is_host' => false
        ]);
    }

    /** @test */
    public function it_updates_existing_host_speaker_when_new_host_is_assigned()
    {
        // Create initial host speaker
        $hostSpeaker = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        // Create regular speaker
        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => false
        ]);

        // Update speaker2 to be host
        $regularSpeaker = EventSpeaker::where('event_id', $this->event->id)
            ->where('speaker_id', $this->speaker2->id)
            ->first();

        $regularSpeaker->update(['is_host' => true]);

        // Verify speaker1 is no longer host and speaker2 is now host
        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => true
        ]);
    }

    /** @test */
    public function it_does_not_affect_host_speakers_of_different_events()
    {
        $event2 = Event::factory()->create();

        // Create host speaker for first event
        EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        // Create host speaker for second event
        EventSpeaker::create([
            'event_id' => $event2->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => true
        ]);

        // Both should remain as hosts for their respective events
        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => true
        ]);

        $this->assertDatabaseHas('event_speakers', [
            'event_id' => $event2->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => true
        ]);
    }

    /** @test */
    public function it_has_proper_relationships()
    {
        $eventSpeaker = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => false
        ]);

        $this->assertInstanceOf(Event::class, $eventSpeaker->event);
        $this->assertInstanceOf(Speaker::class, $eventSpeaker->speaker);
        $this->assertEquals($this->event->id, $eventSpeaker->event->id);
        $this->assertEquals($this->speaker1->id, $eventSpeaker->speaker->id);
    }

    /** @test */
    public function it_casts_is_host_to_boolean()
    {
        $eventSpeaker = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker1->id,
            'is_host' => 1
        ]);

        $this->assertIsBool($eventSpeaker->is_host);
        $this->assertTrue($eventSpeaker->is_host);

        $eventSpeaker2 = EventSpeaker::create([
            'event_id' => $this->event->id,
            'speaker_id' => $this->speaker2->id,
            'is_host' => 0
        ]);

        $this->assertIsBool($eventSpeaker2->is_host);
        $this->assertFalse($eventSpeaker2->is_host);
    }
}
