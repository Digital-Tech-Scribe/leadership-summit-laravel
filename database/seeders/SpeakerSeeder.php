<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // No hardcoded speakers - admin will create speakers as needed
        // This seeder is kept for potential future use or can be removed entirely

        // Create sample sessions and assign speakers
        $events = \App\Models\Event::all();

        foreach ($events as $event) {
            $sessions = [
                [
                    'event_id' => $event->id,
                    'title' => 'Keynote: The Future of Leadership',
                    'description' => 'Opening keynote exploring emerging trends in leadership and organizational development.',
                    'start_time' => $event->start_date,
                    'end_time' => $event->start_date->addHour(),
                    'location' => 'Main Auditorium',
                ],
                [
                    'event_id' => $event->id,
                    'title' => 'Building High-Performance Teams',
                    'description' => 'Interactive workshop on creating and managing high-performance teams in modern organizations.',
                    'start_time' => $event->start_date->addHours(2),
                    'end_time' => $event->start_date->addHours(3),
                    'location' => 'Workshop Room A',
                ],
                [
                    'event_id' => $event->id,
                    'title' => 'Leadership in Digital Transformation',
                    'description' => 'Panel discussion on leading organizations through digital transformation initiatives.',
                    'start_time' => $event->start_date->addHours(4),
                    'end_time' => $event->start_date->addHours(5),
                    'location' => 'Conference Room B',
                ]
            ];

            foreach ($sessions as $sessionData) {
                $session = \App\Models\Session::create($sessionData);

                // Assign random speakers to sessions
                $randomSpeakers = \App\Models\Speaker::inRandomOrder()->take(rand(1, 2))->get();
                $session->speakers()->attach($randomSpeakers);
            }
        }
    }
}
