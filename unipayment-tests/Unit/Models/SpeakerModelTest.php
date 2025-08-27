<?php

namespace UniPaymentTests\Unit\Models;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UniPaymentTests\TestCase;

class SpeakerModelTest extends TestCase
{
    use RefreshDatabase;

    protected $speaker;
    protected $event1;
    protected $event2;
    protected $event3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->speaker = Speaker::factory()->create(['name' => 'John Doe']);
        $this->event1 = Event::factory()->create(['title' => 'Event 1']);
        $this->event2 = Event::factory()->create(['title' => 'Event 2']);
        $this->event3 = Event::factory()->create(['title' => 'Event 3']);
    }

    /** @test */
    public function it_has_many_to_many_relationship_with_events()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
        ]);

        $events = $this->speaker->events;

        $this->assertCount(2, $events);
        $this->assertTrue($events->contains($this->event1));
        $this->assertTrue($events->contains($this->event2));
    }

    /** @test */
    public function it_can_get_hosted_events()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
            $this->event3->id => ['is_host' => true],
        ]);

        $hostedEvents = $this->speaker->hostedEvents;

        $this->assertCount(2, $hostedEvents);
        $this->assertTrue($hostedEvents->contains($this->event1));
        $this->assertTrue($hostedEvents->contains($this->event3));
        $this->assertFalse($hostedEvents->contains($this->event2));
    }

    /** @test */
    public function it_returns_empty_collection_when_no_hosted_events_exist()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => false],
            $this->event2->id => ['is_host' => false],
        ]);

        $hostedEvents = $this->speaker->hostedEvents;

        $this->assertCount(0, $hostedEvents);
    }

    /** @test */
    public function it_includes_pivot_data_in_event_relationships()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
        ]);

        $events = $this->speaker->events;

        foreach ($events as $event) {
            $this->assertNotNull($event->pivot);
            $this->assertNotNull($event->pivot->is_host);
        }

        $hostedEvent = $events->where('id', $this->event1->id)->first();
        $regularEvent = $events->where('id', $this->event2->id)->first();

        // The pivot data comes as integers from database, but EventSpeaker model casts it
        $this->assertEquals(1, $hostedEvent->pivot->is_host);
        $this->assertEquals(0, $regularEvent->pivot->is_host);
    }

    /** @test */
    public function it_can_be_assigned_to_multiple_events()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
            $this->event3->id => ['is_host' => true],
        ]);

        $events = $this->speaker->events;

        $this->assertCount(3, $events);
        $this->assertTrue($events->contains($this->event1));
        $this->assertTrue($events->contains($this->event2));
        $this->assertTrue($events->contains($this->event3));
    }

    /** @test */
    public function it_can_host_multiple_events()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => true],
            $this->event3->id => ['is_host' => false],
        ]);

        $hostedEvents = $this->speaker->hostedEvents;

        $this->assertCount(2, $hostedEvents);
        $this->assertTrue($hostedEvents->contains($this->event1));
        $this->assertTrue($hostedEvents->contains($this->event2));
        $this->assertFalse($hostedEvents->contains($this->event3));
    }

    /** @test */
    public function it_can_sync_events_with_host_designation()
    {
        // Initial assignment
        $this->speaker->events()->sync([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
        ]);

        $this->assertCount(2, $this->speaker->events);

        // Update assignment
        $this->speaker->events()->sync([
            $this->event2->id => ['is_host' => true],
            $this->event3->id => ['is_host' => false],
        ]);

        $this->speaker->refresh();
        $events = $this->speaker->events;

        $this->assertCount(2, $events);
        $this->assertFalse($events->contains($this->event1));
        $this->assertTrue($events->contains($this->event2));
        $this->assertTrue($events->contains($this->event3));

        $hostedEvents = $this->speaker->hostedEvents;
        $this->assertCount(1, $hostedEvents);
        $this->assertTrue($hostedEvents->contains($this->event2));
    }

    /** @test */
    public function it_can_detach_from_all_events()
    {
        $this->speaker->events()->attach([
            $this->event1->id => ['is_host' => true],
            $this->event2->id => ['is_host' => false],
        ]);

        $this->assertCount(2, $this->speaker->events);

        $this->speaker->events()->detach();

        $this->speaker->refresh();
        $this->assertCount(0, $this->speaker->events);
        $this->assertCount(0, $this->speaker->hostedEvents);
    }
}
