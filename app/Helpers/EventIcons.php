<?php

namespace App\Helpers;

class EventIcons
{
    /**
     * Get all available event icons
     */
    public static function getAvailableIcons()
    {
        return [
            // Speaking & Presentation
            'fas fa-microphone' => [
                'name' => 'Microphone',
                'category' => 'Speaking',
                'description' => 'Perfect for keynotes, speeches, and presentations'
            ],
            'fas fa-microphone-alt' => [
                'name' => 'Microphone Alt',
                'category' => 'Speaking',
                'description' => 'Alternative microphone icon for speaking events'
            ],
            'fas fa-bullhorn' => [
                'name' => 'Bullhorn',
                'category' => 'Speaking',
                'description' => 'Great for announcements and public speaking'
            ],

            // People & Networking
            'fas fa-users' => [
                'name' => 'Users',
                'category' => 'Networking',
                'description' => 'Ideal for team events, networking, and group activities'
            ],
            'fas fa-user-friends' => [
                'name' => 'User Friends',
                'category' => 'Networking',
                'description' => 'Perfect for community and friendship events'
            ],
            'fas fa-handshake' => [
                'name' => 'Handshake',
                'category' => 'Networking',
                'description' => 'Great for business meetings and partnerships'
            ],
            'fas fa-people-arrows' => [
                'name' => 'People Arrows',
                'category' => 'Networking',
                'description' => 'Excellent for collaboration and teamwork events'
            ],

            // Communication & Discussion
            'fas fa-comments' => [
                'name' => 'Comments',
                'category' => 'Discussion',
                'description' => 'Perfect for panels, discussions, and Q&A sessions'
            ],
            'fas fa-comment-dots' => [
                'name' => 'Comment Dots',
                'category' => 'Discussion',
                'description' => 'Great for interactive sessions and conversations'
            ],
            'fas fa-chalkboard-teacher' => [
                'name' => 'Chalkboard Teacher',
                'category' => 'Education',
                'description' => 'Ideal for workshops, training, and educational events'
            ],

            // Business & Leadership
            'fas fa-briefcase' => [
                'name' => 'Briefcase',
                'category' => 'Business',
                'description' => 'Perfect for business conferences and professional events'
            ],
            'fas fa-chart-line' => [
                'name' => 'Chart Line',
                'category' => 'Business',
                'description' => 'Great for growth, analytics, and business strategy events'
            ],
            'fas fa-crown' => [
                'name' => 'Crown',
                'category' => 'Leadership',
                'description' => 'Excellent for leadership summits and executive events'
            ],
            'fas fa-trophy' => [
                'name' => 'Trophy',
                'category' => 'Achievement',
                'description' => 'Perfect for awards ceremonies and recognition events'
            ],

            // Technology & Innovation
            'fas fa-laptop-code' => [
                'name' => 'Laptop Code',
                'category' => 'Technology',
                'description' => 'Ideal for tech conferences and coding workshops'
            ],
            'fas fa-rocket' => [
                'name' => 'Rocket',
                'category' => 'Innovation',
                'description' => 'Great for startup events and innovation summits'
            ],
            'fas fa-lightbulb' => [
                'name' => 'Lightbulb',
                'category' => 'Innovation',
                'description' => 'Perfect for creative workshops and idea sessions'
            ],
            'fas fa-cogs' => [
                'name' => 'Cogs',
                'category' => 'Technology',
                'description' => 'Excellent for technical workshops and process events'
            ],

            // Events & Calendar
            'fas fa-calendar-alt' => [
                'name' => 'Calendar',
                'category' => 'General',
                'description' => 'Classic event icon, suitable for any type of event'
            ],
            'fas fa-calendar-check' => [
                'name' => 'Calendar Check',
                'category' => 'General',
                'description' => 'Great for scheduled events and confirmations'
            ],
            'fas fa-star' => [
                'name' => 'Star',
                'category' => 'Featured',
                'description' => 'Perfect for featured or premium events'
            ],
            'fas fa-fire' => [
                'name' => 'Fire',
                'category' => 'Popular',
                'description' => 'Ideal for hot topics and trending events'
            ],

            // Specialized Events
            'fas fa-graduation-cap' => [
                'name' => 'Graduation Cap',
                'category' => 'Education',
                'description' => 'Perfect for educational events and certifications'
            ],
            'fas fa-medal' => [
                'name' => 'Medal',
                'category' => 'Achievement',
                'description' => 'Great for competitions and achievement events'
            ],
            'fas fa-globe' => [
                'name' => 'Globe',
                'category' => 'Global',
                'description' => 'Excellent for international and global events'
            ],
            'fas fa-heart' => [
                'name' => 'Heart',
                'category' => 'Community',
                'description' => 'Perfect for charity events and community gatherings'
            ]
        ];
    }

    /**
     * Get icons grouped by category
     */
    public static function getIconsByCategory()
    {
        $icons = self::getAvailableIcons();
        $grouped = [];

        foreach ($icons as $iconClass => $iconData) {
            $category = $iconData['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][$iconClass] = $iconData;
        }

        return $grouped;
    }

    /**
     * Get default icon
     */
    public static function getDefaultIcon()
    {
        return 'fas fa-calendar-alt';
    }

    /**
     * Check if an icon exists in our available icons
     */
    public static function isValidIcon($icon)
    {
        return array_key_exists($icon, self::getAvailableIcons());
    }

    /**
     * Get icon data by class name
     */
    public static function getIconData($iconClass)
    {
        $icons = self::getAvailableIcons();
        return $icons[$iconClass] ?? null;
    }
}
