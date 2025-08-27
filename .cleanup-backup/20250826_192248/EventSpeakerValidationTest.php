<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventSpeakerValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role and user for testing
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $this->user = User::factory()->create();
        $this->user->roles()->attach($adminRole);
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_validates_host_speaker_must_be_in_speakers_array()
    {
        $speaker1 = Speaker::factory()->create();
        $speaker2 = Speaker::factory()->create();

        $response = $this->post(route('admin.events.store'), [
            'title' => 'Test Event',
            'description' => 'Test Description',
            'start_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'status' => 'draft',
            'speakers' => [$speaker1->id],
            'host_speaker' => $speaker2->id, // Host speaker not in speakers array
        ]);

        $response->assertSessionHasErrors('host_speaker');
    }
}
