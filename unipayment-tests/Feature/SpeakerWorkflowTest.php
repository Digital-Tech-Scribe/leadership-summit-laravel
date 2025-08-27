<?php

namespace UniPaymentTests\Feature;

use App\Models\Event;
use App\Models\Role;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UniPaymentTests\TestCase;

class SpeakerWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $speaker1;
    protected $speaker2;
    protected $speaker3;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role and user
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $this->adminUser = User::factory()->create(['role_id' => $adminRole->id]);

        // Create test speakers with detailed information
        $this->speaker1 = Speaker::factory()->create([
            'name' => 'John Doe',
            'bio' => 'Experienced technology leader with 15 years in the industry.',
            'position' => 'CTO',
            'company' => 'Tech Corp',
            'photo' => 'speakers/john-doe.jpg'
        ]);

        $this->speaker2 = Speaker::factory()->create([
            'name' => 'Jane Smith',
            'bio' => 'Marketing expert specializing in digital transformation.',
            'position' => 'VP Marketing',
            'company' => 'Marketing Inc',
            'photo' => 'speakers/jane-smith.jpg'
        ]);

        $this->speaker3 = Speaker::factory()->create([
            'name' => 'Bob Johnson',
            'bio' => 'Product management specialist with startup experience.',
            'position' => 'Product Manager',
            'company' => 'Startup LLC',
            'photo' => 'speakers/bob-johnson.jpg'
        ]);
    }

    /** @test */
    public function complete_workflow_create_event_with_speakers_and_display_on_frontend()
    {
        $this->actingAs($this->adminUser);

        // Step 1: Create event with speakers through admin panel
        $eventData = [
            'title' => 'Leadership Summit 2024',
            'description' => 'Annual leadership conference for industry professionals.',
            'start_date' => now()->addDays(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(31)->format('Y-m-d H:i:s'),
            'location' => 'Convention Center',
            'status' => 'published',
            'speakers' => [$this->speaker1->id, $this->speaker2->id, $this->speaker3->id],
            'host_speaker' => $this->speaker1->id,
        ];

        $response = $this->post(route('admin.events.store'), $eventData);
        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Leadership Summit 2024')->first();
        $this->assertNotNull($event);

        // Step 2: Verify speakers are correctly assigned in database
        $this->assertCount(3, $event->speakers);

        $hostSpeaker = $event->hostSpeaker();
        $this->assertEquals($this->speaker1->id, $hostSpeaker->id);

        $regularSpeakers = $event->regularSpeakers;
        $this->assertCount(2, $regularSpeakers);

        // Step 3: Visit event page as public user (logout admin)
        auth()->logout();

        $response = $this->get(route('events.show', $event->slug));
        $response->assertStatus(200);

        // Step 4: Verify speakers section is displayed
        $response->assertSee('John Doe'); // Host speaker
        $response->assertSee('Jane Smith'); // Regular speaker
        $response->assertSee('Bob Johnson'); // Regular speaker

        // Verify speaker details are shown
        $response->assertSee('CTO');
        $response->assertSee('Tech Corp');
        $response->assertSee('VP Marketing');
        $response->assertSee('Marketing Inc');
        $response->assertSee('Product Manager');
        $response->assertSee('Startup LLC');

        // Step 5: Verify host speaker prominence (should appear first/prominently)
        $content = $response->getContent();
        $johnDoePosition = strpos($content, 'John Doe');
        $janeSmithPosition = strpos($content, 'Jane Smith');

        // Host speaker should appear before regular speakers in the content
        $this->assertLessThan($janeSmithPosition, $johnDoePosition);
    }

    /** @test */
    public function workflow_update_speakers_and_verify_frontend_changes()
    {
        $this->actingAs($this->adminUser);

        // Step 1: Create initial event
        $event = Event::factory()->create([
            'title' => 'Tech Conference',
            'status' => 'published'
        ]);

        $event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        // Step 2: Verify initial state on frontend
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');
        $response->assertDontSee('Bob Johnson');

        // Step 3: Update speakers through admin panel
        $this->actingAs($this->adminUser);

        $updateData = [
            'title' => $event->title,
            'description' => $event->description,
            'start_date' => $event->start_date->format('Y-m-d H:i:s'),
            'end_date' => $event->end_date->format('Y-m-d H:i:s'),
            'location' => $event->location,
            'status' => $event->status,
            'speakers' => [$this->speaker2->id, $this->speaker3->id], // Remove speaker1, add speaker3
            'host_speaker' => $this->speaker3->id, // Change host to speaker3
        ];

        $response = $this->put(route('admin.events.update', $event), $updateData);
        $response->assertRedirect(route('admin.events.index'));

        // Step 4: Verify changes on frontend
        auth()->logout();
        $event->refresh(); // Refresh to get updated slug
        $response = $this->get(route('events.show', $event->slug));

        if ($response->getStatusCode() === 404) {
            // Debug: check if event exists and what its slug is
            $this->fail("Event not found. Event ID: {$event->id}, Slug: {$event->slug}, Title: {$event->title}");
        }

        $response->assertDontSee('John Doe'); // Removed speaker
        $response->assertSee('Jane Smith'); // Still assigned
        $response->assertSee('Bob Johnson'); // New host speaker

        // Verify new host speaker appears prominently
        $content = $response->getContent();
        $bobPosition = strpos($content, 'Bob Johnson');
        $janePosition = strpos($content, 'Jane Smith');
        $this->assertLessThan($janePosition, $bobPosition);
    }

    /** @test */
    public function workflow_remove_all_speakers_hides_speakers_section()
    {
        $this->actingAs($this->adminUser);

        // Step 1: Create event with speakers
        $event = Event::factory()->create([
            'title' => 'Workshop Event',
            'status' => 'published'
        ]);

        $event->speakers()->attach([
            $this->speaker1->id => ['is_host' => true],
            $this->speaker2->id => ['is_host' => false],
        ]);

        // Step 2: Verify speakers are shown initially
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');

        // Step 3: Remove all speakers through admin panel
        $this->actingAs($this->adminUser);

        $updateData = [
            'title' => $event->title,
            'description' => $event->description,
            'start_date' => $event->start_date->format('Y-m-d H:i:s'),
            'end_date' => $event->end_date->format('Y-m-d H:i:s'),
            'location' => $event->location,
            'status' => $event->status,
            'speakers' => [], // Remove all speakers
        ];

        $response = $this->put(route('admin.events.update', $event), $updateData);
        $response->assertRedirect(route('admin.events.index'));

        // Step 4: Verify speakers section is hidden on frontend
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));

        $response->assertDontSee('John Doe');
        $response->assertDontSee('Jane Smith');

        // The speakers section should not be rendered at all
        $response->assertDontSee('class="speakers-section"');
    }

    /** @test */
    public function workflow_handles_single_speaker_as_host()
    {
        $this->actingAs($this->adminUser);

        // Create event with single speaker as host
        $eventData = [
            'title' => 'Keynote Presentation',
            'description' => 'Special keynote by industry leader.',
            'start_date' => now()->addDays(15)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(15)->addHours(2)->format('Y-m-d H:i:s'),
            'location' => 'Main Auditorium',
            'status' => 'published',
            'speakers' => [$this->speaker1->id],
            'host_speaker' => $this->speaker1->id,
        ];

        $response = $this->post(route('admin.events.store'), $eventData);
        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Keynote Presentation')->first();

        // Verify single speaker setup
        $this->assertCount(1, $event->speakers);
        $this->assertEquals($this->speaker1->id, $event->hostSpeaker()->id);
        $this->assertCount(0, $event->regularSpeakers);

        // Verify frontend display
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));

        $response->assertSee('John Doe');
        $response->assertSee('CTO');
        $response->assertSee('Tech Corp');
        $response->assertDontSee('Jane Smith');
        $response->assertDontSee('Bob Johnson');
    }

    /** @test */
    public function workflow_handles_multiple_speakers_without_host()
    {
        $this->actingAs($this->adminUser);

        // Create event with multiple speakers but no designated host
        $eventData = [
            'title' => 'Panel Discussion',
            'description' => 'Industry experts panel discussion.',
            'start_date' => now()->addDays(20)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(20)->addHours(3)->format('Y-m-d H:i:s'),
            'location' => 'Conference Room A',
            'status' => 'published',
            'speakers' => [$this->speaker1->id, $this->speaker2->id, $this->speaker3->id],
            // No host_speaker specified
        ];

        $response = $this->post(route('admin.events.store'), $eventData);
        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Panel Discussion')->first();

        // Verify no host speaker
        $this->assertCount(3, $event->speakers);
        $this->assertNull($event->hostSpeaker());
        $this->assertCount(3, $event->regularSpeakers);

        // Verify frontend display shows all speakers equally
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));

        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');
        $response->assertSee('Bob Johnson');

        // All speakers should be displayed in regular speaker format
        $response->assertSee('CTO');
        $response->assertSee('VP Marketing');
        $response->assertSee('Product Manager');
    }

    /** @test */
    public function workflow_validates_business_rules_end_to_end()
    {
        $this->actingAs($this->adminUser);

        // Test 1: Try to create event with host speaker not in speakers array
        $invalidEventData = [
            'title' => 'Invalid Event',
            'description' => 'Test Description',
            'start_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'status' => 'draft',
            'speakers' => [$this->speaker1->id],
            'host_speaker' => $this->speaker2->id, // Not in speakers array
        ];

        $response = $this->post(route('admin.events.store'), $invalidEventData);
        $response->assertSessionHasErrors('host_speaker');

        // Verify event was not created
        $this->assertDatabaseMissing('events', ['title' => 'Invalid Event']);

        // Test 2: Create valid event
        $validEventData = [
            'title' => 'Valid Event',
            'description' => 'Test Description',
            'start_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'status' => 'published',
            'speakers' => [$this->speaker1->id, $this->speaker2->id],
            'host_speaker' => $this->speaker1->id,
        ];

        $response = $this->post(route('admin.events.store'), $validEventData);
        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Valid Event')->first();
        $this->assertNotNull($event);

        // Test 3: Verify only one host speaker per event (business rule)
        $this->assertCount(1, $event->speakers()->wherePivot('is_host', true)->get());

        // Test 4: Verify frontend displays correctly
        auth()->logout();
        $response = $this->get(route('events.show', $event->slug));
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');
    }
}
