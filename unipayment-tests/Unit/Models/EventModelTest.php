<?php

namespace UniPaymentTests\Unit\Models;

use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UniPaymentTests\TestCase;

class EventModelTest extends TestCase
{
    use RefreshDatabase;

    protected $event;
    protected $speaker1;
    protected $speaker2;
    protected $speaker3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->event = Event::factory()->create();
        $this->speaker1 = Speaker::factory()->create(['name' => 'John Doe']);
        $this->speaker2 = Speaker::factory()->create(['name' => 'Jane Smith']);
        $this->speaker3 = Speaker::factory()->create(['name' => 'Bob Johnson']);
    }

    /** @test */
    public function it_has_many_to_many_relationship_with_speakers()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $speakers = $this->event->speakers;

        $this->assertCount(2, $speakers);
        $this->assertTrue($speakers->contains($this->speaker1));
        $this->assertTrue($speakers->contains($this->speaker2));
    }

    /** @test */
    public function it_can_get_host_speaker()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $hostSpeaker = $this->event->hostSpeaker();

        $this->assertNotNull($hostSpeaker);
        $this->assertEquals($this->speaker1->id, $hostSpeaker->id);
        $this->assertEquals('John Doe', $hostSpeaker->name);
    }

    /** @test */
    public function it_returns_null_when_no_host_speaker_exists()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => false],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $hostSpeaker = $this->event->hostSpeaker();

        $this->assertNull($hostSpeaker);
    }

    /** @test */
    public function it_can_get_regular_speakers()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
            $this->speaker3->id => ['is_host' => false],
        ]);

        $regularSpeakers = $this->event->regularSpeakers;

        $this->assertCount(2, $regularSpeakers);
        $this->assertTrue($regularSpeakers->contains($this->speaker2));
        $this->assertTrue($regularSpeakers->contains($this->speaker3));
        $this->assertFalse($regularSpeakers->contains($this->speaker1));
    }

    /** @test */
    public function it_returns_empty_collection_when_no_regular_speakers_exist()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
        ]);

        $regularSpeakers = $this->event->regularSpeakers;

        $this->assertCount(0, $regularSpeakers);
    }

    /** @test */
    public function it_includes_pivot_data_in_speaker_relationships()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $speakers = $this->event->speakers;

        foreach ($speakers as $speaker) {
            $this->assertNotNull($speaker->pivot);
            $this->assertNotNull($speaker->pivot->is_host);
        }

        $hostSpeaker = $speakers->where('id', $this->speaker1->id)->first();
        $regularSpeaker = $speakers->where('id', $this->speaker2->id)->first();

        // The pivot data comes as integers from database, but EventSpeaker model casts it
        $this->assertEquals(1, $hostSpeaker->pivot->is_host);
        $this->assertEquals(0, $regularSpeaker->pivot->is_host);
    }

    /** @test */
    public function it_can_sync_speakers_with_host_designation()
    {
        // Initial assignment
        $this->event->speakers()->sync([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $this->assertCount(2, $this->event->speakers);

        // Update assignment - change host and add new speaker
        $this->event->speakers()->sync([
            $this->speaker2->id => ['is_host' => true],
            $this->speaker3->id => ['is_host' => false],
        ]);

        $this->event->refresh();
        $speakers = $this->event->speakers;

        $this->assertCount(2, $speakers);
        $this->assertFalse($speakers->contains($this->speaker1));
        $this->assertTrue($speakers->contains($this->speaker2));
        $this->assertTrue($speakers->contains($this->speaker3));

        $hostSpeaker = $this->event->hostSpeaker();
        $this->assertEquals($this->speaker2->id, $hostSpeaker->id);
    }

    /** @test */
    public function it_can_detach_all_speakers()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        $this->assertCount(2, $this->event->speakers);

        $this->event->speakers()->detach();

        $this->event->refresh();
        $this->assertCount(0, $this->event->speakers);
        $this->assertNull($this->event->hostSpeaker());
    }

    /** @test */
    public function it_maintains_timestamps_in_pivot_table()
    {
        $this->event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
        ]);

        $pivotRecord = EventSpeaker::where('event_id', $this->event->id)
            ->where('speaker_id', $this->speaker1->id)
            ->first();

        $this->assertNotNull($pivotRecord->created_at);
        $this->assertNotNull($pivotRecord->updated_at);
    }
}
