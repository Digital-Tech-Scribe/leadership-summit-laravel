<?php $__env->startSection('title', ($event->title ?? 'Event Details') . ' - Leadership Summit 2025'); ?>
<?php $__env->startSection('meta_description', Str::limit(strip_tags($event->description ?? 'Event details for the Leadership Summit 2025'), 160)); ?>



<?php $__env->startPush('styles'); ?>
<style>
    .event-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e3a8a 100%);
        color: white;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .event-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        <?php if(isset($event) && $event->featured_image): ?> background: url("<?php echo e(asset('storage/' . $event->featured_image)); ?>") center/cover;

        <?php elseif(isset($event) && $event->selected_icon): ?> background: linear-gradient(135deg, {
                {
                $event->featured ? '#ffc107, #ffb300' : 'var(--primary-color), var(--secondary-color)'
            }
        });
    <?php else: ?> background: url("<?php echo e(asset('images/default-event-bg.jpg')); ?>") center/cover;
    <?php endif; ?> opacity: 0.2;
    z-index: 1;
    }

    .event-hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-icon-display {
        text-align: center;
        margin-bottom: 2rem;
    }

    .hero-icon-display i {
        font-size: 6rem;
        color: white;
        opacity: 0.9;
    }

    .featured-badge {
        background: #ffc107 !important;
        color: #000 !important;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
    }

    .event-badge {
        display: inline-block;
        background: var(--secondary-color);
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .event-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .event-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .event-meta-item i {
        font-size: 1.2rem;
        color: var(--secondary-color);
    }

    .event-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .event-content {
        padding: 4rem 0;
    }

    .event-sidebar {
        background: #f8fafc;
        border-radius: 1rem;
        padding: 2rem;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .ticket-option {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .ticket-option:hover,
    .ticket-option.selected {
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(10, 36, 99, 0.1);
    }

    .ticket-name {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .ticket-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .ticket-price.free {
        color: #10b981;
    }

    .ticket-description {
        font-size: 0.9rem;
        color: var(--dark-gray);
        margin-bottom: 1rem;
    }

    .ticket-availability {
        font-size: 0.9rem;
        color: var(--dark-gray);
    }

    .ticket-availability.low {
        color: #f59e0b;
    }

    .ticket-availability.sold-out {
        color: #ef4444;
    }

    .event-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-color);
    }

    .event-description h2,
    .event-description h3,
    .event-description h4 {
        color: var(--primary-color);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .event-description ul,
    .event-description ol {
        margin-bottom: 1.5rem;
    }

    .event-description li {
        margin-bottom: 0.5rem;
    }

    /* Event Speakers Section - Now handled by SCSS */

    /* Legacy speakers section (from sessions) */
    .speakers-section {
        background: #f8fafc;
        padding: 4rem 0;
        margin-top: 3rem;
    }

    .speakers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .speaker-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .speaker-card:hover {
        transform: translateY(-5px);
    }

    .speaker-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 2rem;
    }

    .speaker-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .speaker-title {
        color: var(--dark-gray);
        margin-bottom: 1rem;
    }

    .speaker-bio {
        color: var(--text-color);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        text-align: left;
    }

    .related-events {
        padding: 4rem 0;
        background: white;
    }

    .related-events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .related-event-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .related-event-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(10, 36, 99, 0.1);
    }

    .registration-highlight {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .registration-highlight h4 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .registration-highlight p {
        margin-bottom: 0;
        opacity: 0.9;
    }

    .quick-registration-badge {
        display: inline-block;
        background: #10b981;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    @media (max-width: 768px) {
        .event-title {
            font-size: 2.5rem;
        }

        .event-meta {
            flex-direction: column;
            gap: 1rem;
        }

        .event-actions {
            justify-content: center;
        }

        .event-sidebar {
            position: static;
            margin-top: 2rem;
        }

        /* Event Speakers Mobile Styles - Now handled by SCSS */

        /* Legacy speakers grid */
        .speakers-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    /* Small mobile styles - Now handled by SCSS */
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Event Hero -->
<section class="event-hero">
    <div class="container">
        <div class="event-hero-content">
            <?php if(isset($event) && !$event->featured_image && $event->selected_icon): ?>
            <div class="hero-icon-display">
                <i class="<?php echo e($event->selected_icon); ?>" aria-hidden="true"></i>
            </div>
            <?php endif; ?>

            <?php if(isset($event) && $event->featured): ?>
            <span class="event-badge featured-badge">FEATURED</span>
            <?php endif; ?>

            <h1 class="event-title"><?php echo e($event->title); ?></h1>

            <div class="event-meta">
                <div class="event-meta-item">
                    <i class="fas fa-calendar" aria-hidden="true"></i>
                    <span>
                        <?php if(isset($event)): ?>
                        <?php echo e($event->start_date->format('F d, Y')); ?>

                        <?php if($event->end_date && $event->end_date != $event->start_date): ?>
                        - <?php echo e($event->end_date->format('F d, Y')); ?>

                        <?php endif; ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="event-meta-item">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                    <span>
                        <?php if(isset($event)): ?>
                        <?php echo e($event->start_date->format('g:i A')); ?>

                        <?php if($event->end_date && $event->end_date->format('Y-m-d') == $event->start_date->format('Y-m-d')): ?>
                        - <?php echo e($event->end_date->format('g:i A')); ?>

                        <?php endif; ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="event-meta-item">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    <span><?php echo e($event->location); ?></span>
                </div>
            </div>

            <div class="event-actions">
                <a href="<?php echo e(route('events.register', $event)); ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-bolt me-2" aria-hidden="true"></i>Quick Register - No Account Required
                </a>
                <a href="#tickets" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-info-circle me-2" aria-hidden="true"></i>View Ticket Options
                </a>
                <button class="btn btn-outline-light btn-lg" id="share-event-btn" data-title="<?php echo e($event->title ?? 'Leadership Summit Event'); ?>" data-url="<?php echo e(url()->current()); ?>">
                    <i class="fas fa-share-alt me-2" aria-hidden="true"></i>Share Event
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Event Content -->
<section class="event-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Event Speakers Section (moved above description) -->
                <?php if(isset($event) && $event->speakers && $event->speakers->count() > 0): ?>
                <div class="event-speakers-inline mb-5">
                    <h2 class="section-title mb-4">Event Speakers</h2>

                    <?php
                    $hostSpeaker = $event->hostSpeaker();
                    $regularSpeakers = $event->regularSpeakers()->get();
                    ?>

                    <!-- Host Speaker (if designated) -->
                    <?php if($hostSpeaker): ?>
                    <div class="host-speaker-container mb-4">
                        <div class="host-speaker-card">
                            <div class="host-speaker-badge">
                                <i class="fas fa-star me-2"></i>HOST SPEAKER
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center">
                                    <div class="host-speaker-avatar">
                                        <?php if($hostSpeaker->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $hostSpeaker->photo)); ?>" alt="<?php echo e($hostSpeaker->name); ?>" class="img-fluid rounded-circle">
                                        <?php else: ?>
                                        <div class="speaker-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="host-speaker-name"><?php echo e($hostSpeaker->name); ?></h3>
                                    <?php if($hostSpeaker->position || $hostSpeaker->company): ?>
                                    <p class="host-speaker-title"><?php echo e($hostSpeaker->position); ?><?php if($hostSpeaker->position && $hostSpeaker->company): ?>, <?php endif; ?><?php echo e($hostSpeaker->company); ?></p>
                                    <?php endif; ?>
                                    <?php if($hostSpeaker->bio): ?>
                                    <p class="host-speaker-bio"><?php echo e(Str::limit($hostSpeaker->bio, 200)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Regular Speakers Grid -->
                    <?php if($regularSpeakers && $regularSpeakers->count() > 0): ?>
                    <div class="regular-speakers-section">
                        <?php if($hostSpeaker): ?>
                        <h3 class="mb-4">Guest Speakers</h3>
                        <?php endif; ?>
                        <div class="regular-speakers-grid">
                            <?php $__currentLoopData = $regularSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="regular-speaker-card">
                                <div class="regular-speaker-avatar">
                                    <?php if($speaker->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $speaker->photo)); ?>" alt="<?php echo e($speaker->name); ?>" class="img-fluid rounded-circle">
                                    <?php else: ?>
                                    <div class="speaker-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="regular-speaker-name"><?php echo e($speaker->name); ?></h4>
                                <?php if($speaker->position || $speaker->company): ?>
                                <p class="regular-speaker-title"><?php echo e($speaker->position); ?><?php if($speaker->position && $speaker->company): ?>, <?php endif; ?><?php echo e($speaker->company); ?></p>
                                <?php endif; ?>
                                <?php if($speaker->bio): ?>
                                <p class="regular-speaker-bio"><?php echo e(Str::limit($speaker->bio, 120)); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="event-description">
                    <?php if(isset($event) && $event->description): ?>
                    <?php echo nl2br(e($event->description)); ?>

                    <?php else: ?>
                    <h2>About This Event</h2>
                    <p>Join us for the flagship event of the International Global Leadership Academy Summit 2025. This comprehensive three-day experience brings together the world's most influential leaders, innovators, and visionaries to explore the future of leadership in an ever-changing global landscape.</p>

                    <h3>What You'll Experience</h3>
                    <ul>
                        <li><strong>Inspiring Keynote Presentations</strong> - Learn from industry titans and thought leaders who are shaping the future of business and society</li>
                        <li><strong>Interactive Workshops</strong> - Participate in hands-on sessions designed to develop practical leadership skills</li>
                        <li><strong>Panel Discussions</strong> - Engage with diverse perspectives on critical leadership challenges</li>
                        <li><strong>Networking Opportunities</strong> - Connect with peers, mentors, and potential collaborators from around the world</li>
                        <li><strong>Innovation Showcases</strong> - Discover cutting-edge technologies and methodologies transforming leadership</li>
                    </ul>

                    <h3>Who Should Attend</h3>
                    <p>This summit is designed for current and aspiring leaders across all industries and sectors, including:</p>
                    <ul>
                        <li>C-suite executives and senior managers</li>
                        <li>Entrepreneurs and business owners</li>
                        <li>Non-profit and community leaders</li>
                        <li>Government and public sector officials</li>
                        <li>Emerging leaders and high-potential professionals</li>
                    </ul>

                    <h3>Key Topics</h3>
                    <ul>
                        <li>Digital transformation and technology leadership</li>
                        <li>Sustainable business practices and ESG leadership</li>
                        <li>Diversity, equity, and inclusion in leadership</li>
                        <li>Crisis management and resilient leadership</li>
                        <li>Global perspectives on leadership challenges</li>
                        <li>The future of work and remote team leadership</li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="event-sidebar" id="tickets">
                    <div class="registration-highlight">
                        <h4><i class="fas fa-bolt me-2"></i>Quick Registration</h4>
                        <p>Register in minutes - no account creation required!</p>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Registration Options</h3>

                        <?php if(isset($event) && $event->tickets && $event->tickets->count() > 0): ?>
                        <?php $__currentLoopData = $event->tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ticket-option" data-ticket-id="<?php echo e($ticket->id); ?>">
                            <div class="ticket-name"><?php echo e($ticket->name); ?></div>
                            <div class="ticket-price <?php echo e($ticket->price == 0 ? 'free' : ''); ?>">
                                <?php if($ticket->price == 0): ?>
                                Free
                                <?php else: ?>
                                $<?php echo e(number_format($ticket->price, 2)); ?>

                                <?php endif; ?>
                            </div>
                            <?php if($ticket->description): ?>
                            <div class="ticket-description"><?php echo e($ticket->description); ?></div>
                            <?php endif; ?>
                            <div class="ticket-availability <?php echo e($ticket->available <= 10 ? 'low' : ''); ?> <?php echo e($ticket->available == 0 ? 'sold-out' : ''); ?>">
                                <?php if($ticket->available == 0): ?>
                                Sold Out
                                <?php elseif($ticket->available <= 10): ?>
                                    Only <?php echo e($ticket->available); ?> left
                                    <?php else: ?>
                                    <?php echo e($ticket->available); ?> available
                                    <?php endif; ?>
                                    </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">No tickets available for this event.</p>
                            </div>
                            <?php endif; ?>

                            <a href="<?php echo e(route('events.register', $event)); ?>" class="btn btn-secondary w-100 mt-3" id="registerBtn" style="opacity: 0.5; pointer-events: none; cursor: not-allowed;">
                                <i class="fas fa-ticket-alt me-2" aria-hidden="true"></i>Start Registration
                            </a>
                            <p class="text-center mt-2 mb-0 small text-muted" id="selectionHint">
                                <i class="fas fa-arrow-up me-1"></i>
                                Please select a ticket option above
                            </p>
                            <p class="text-center mt-2 mb-0 small text-muted">
                                <i class="fas fa-check-circle me-1 text-success"></i>
                                No account creation required
                            </p>
                        </div>

                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Event Details</h3>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-users me-2 text-primary" aria-hidden="true"></i>
                                <span>Expected Attendance: 500+</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-language me-2 text-primary" aria-hidden="true"></i>
                                <span>Language: English</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-certificate me-2 text-primary" aria-hidden="true"></i>
                                <span>CPE Credits Available</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-wifi me-2 text-primary" aria-hidden="true"></i>
                                <span>Free WiFi Included</span>
                            </div>
                        </div>

                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Contact</h3>
                            <p class="mb-2">
                                <i class="fas fa-envelope me-2 text-primary" aria-hidden="true"></i>
                                <a href="mailto:events@leadershipacademy.org">events@leadershipacademy.org</a>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-phone me-2 text-primary" aria-hidden="true"></i>
                                <a href="tel:+15551234567">+1 (555) 123-4567</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>



<!-- Legacy Speakers Section (from sessions) -->
<?php if(isset($event) && $event->sessions && $event->sessions->count() > 0 && (!$event->speakers || $event->speakers->count() == 0)): ?>
<section class="speakers-section">
    <div class="container">
        <h2 class="section-title text-center mb-4">Featured Speakers</h2>
        <div class="speakers-grid">
            <?php $__currentLoopData = $event->sessions->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $session->speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="speaker-card">
                <div class="speaker-avatar">
                    <?php if($speaker->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $speaker->photo)); ?>" alt="<?php echo e($speaker->name); ?>" class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                    <?php else: ?>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <?php endif; ?>
                </div>
                <h3 class="speaker-name"><?php echo e($speaker->name); ?></h3>
                <p class="speaker-title"><?php echo e($speaker->position); ?><?php if($speaker->company): ?>, <?php echo e($speaker->company); ?><?php endif; ?></p>
                <?php if($speaker->bio): ?>
                <p class="speaker-bio"><?php echo e(Str::limit($speaker->bio, 100)); ?></p>
                <?php endif; ?>
                <a href="<?php echo e(url('/speakers/' . $speaker->id)); ?>" class="btn btn-outline-primary btn-sm">
                    View Profile
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ticket selection functionality
        const ticketOptions = document.querySelectorAll('.ticket-option');
        const registerBtn = document.getElementById('registerBtn');
        let selectedTicketId = null;

        ticketOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove previous selection
                ticketOptions.forEach(opt => opt.classList.remove('selected'));

                // Add selection to clicked option
                this.classList.add('selected');

                // Store selected ticket ID
                selectedTicketId = this.dataset.ticketId;

                // Update register button text to show selection
                const ticketName = this.querySelector('.ticket-name').textContent;
                registerBtn.innerHTML = `<i class="fas fa-ticket-alt me-2" aria-hidden="true"></i>Start Registration`;

                // Enable the button and change to primary color
                registerBtn.classList.remove('btn-secondary');
                registerBtn.classList.add('btn-primary');
                registerBtn.style.opacity = '1';
                registerBtn.style.pointerEvents = 'auto';
                registerBtn.style.cursor = 'pointer';

                // Hide the selection hint
                const selectionHint = document.getElementById('selectionHint');
                if (selectionHint) {
                    selectionHint.style.display = 'none';
                }
            });
        });

        // Handle register button click
        registerBtn.addEventListener('click', function(e) {
            if (selectedTicketId) {
                // Add selected ticket as URL parameter
                const currentHref = this.getAttribute('href');
                const separator = currentHref.includes('?') ? '&' : '?';
                this.setAttribute('href', currentHref + separator + 'ticket=' + selectedTicketId);
            }
        });

        // Share event button click
        const shareBtn = document.getElementById('share-event-btn');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const title = this.dataset.title;
                const url = this.dataset.url;
                shareEvent(title, url);
            });
        }
    });

    // Share event function
    function shareEvent(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).catch(console.error);
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(url).then(() => {
                alert('Event link copied to clipboard!');
            }).catch(() => {
                // Final fallback: show URL in prompt
                prompt('Copy this link to share:', url);
            });
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/Apple/Desktop/dev_folder/Dev_project/test.kiro2/leadership-summit-laravel/resources/views/events/show.blade.php ENDPATH**/ ?>