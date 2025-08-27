<?php $__env->startSection('title', $speaker->name . ' - Speaker Profile'); ?>
<?php $__env->startSection('meta_description', 'Learn more about ' . $speaker->name . ', ' . ($speaker->position ?: 'speaker') . ' at the International Global Leadership Academy Summit 2025.'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('speakers.index')); ?>">Speakers</a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e($speaker->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .speaker-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e3a8a 100%);
        color: white;
        padding: 4rem 0;
    }

    .speaker-avatar {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.2);
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        background: rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .speaker-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .speaker-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    .speaker-meta {
        text-align: center;
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .speaker-social {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .social-link:hover {
        background: var(--secondary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .speaker-content {
        padding: 4rem 0;
    }

    .bio-section {
        background: white;
        border-radius: 1rem;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 3rem;
    }

    .bio-section h2 {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }

    .bio-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--dark-gray);
        text-align: justify;
    }

    .sessions-section {
        background: white;
        border-radius: 1rem;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 3rem;
    }

    .sessions-section h2 {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }

    .session-card {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .session-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .session-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .session-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        color: var(--dark-gray);
    }

    .session-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .session-meta-item i {
        color: var(--secondary-color);
        width: 16px;
    }

    .session-description {
        color: var(--dark-gray);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .event-badge {
        display: inline-block;
        background: var(--secondary-color);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }

    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-top: 4px solid var(--primary-color);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        display: block;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--dark-gray);
        font-weight: 500;
    }

    .back-to-speakers {
        background: var(--primary-color);
        color: white;
        padding: 2rem 0;
        text-align: center;
    }

    .back-to-speakers a {
        color: white;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .back-to-speakers a:hover {
        color: var(--secondary-color);
        transform: translateX(-5px);
    }

    @media (max-width: 768px) {
        .speaker-hero {
            padding: 2rem 0;
        }

        .speaker-hero h1 {
            font-size: 2rem;
        }

        .speaker-avatar {
            width: 150px;
            height: 150px;
            font-size: 3rem;
        }

        .bio-section,
        .sessions-section {
            padding: 2rem;
        }

        .session-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Speaker Hero -->
<section class="speaker-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="speaker-avatar">
                    <?php if($speaker->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $speaker->photo)); ?>" alt="<?php echo e($speaker->name); ?>">
                    <?php else: ?>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <?php endif; ?>
                </div>

                <h1><?php echo e($speaker->name); ?></h1>

                <div class="speaker-meta">
                    <?php if($speaker->position): ?>
                    <div><?php echo e($speaker->position); ?></div>
                    <?php endif; ?>
                    <?php if($speaker->company): ?>
                    <div class="mt-1"><?php echo e($speaker->company); ?></div>
                    <?php endif; ?>
                </div>

                <div class="speaker-social">
                    <?php if($speaker->linkedin ?? false): ?>
                    <a href="<?php echo e($speaker->linkedin); ?>" class="social-link" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($speaker->twitter ?? false): ?>
                    <a href="<?php echo e($speaker->twitter); ?>" class="social-link" target="_blank" aria-label="Twitter">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($speaker->website ?? false): ?>
                    <a href="<?php echo e($speaker->website); ?>" class="social-link" target="_blank" aria-label="Website">
                        <i class="fas fa-globe" aria-hidden="true"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Speaker Stats -->
<section class="speaker-content">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number"><?php echo e($speaker->sessions->count()); ?></span>
                <span class="stat-label">Sessions</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo e($speaker->sessions->pluck('event_id')->unique()->count()); ?></span>
                <span class="stat-label">Events</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo e($speaker->sessions->where('start_time', '>=', now())->count()); ?></span>
                <span class="stat-label">Upcoming</span>
            </div>
        </div>
    </div>
</section>

<!-- Biography -->
<section class="speaker-content">
    <div class="container">
        <div class="bio-section">
            <h2>About <?php echo e($speaker->name); ?></h2>
            <div class="bio-text">
                <?php echo nl2br(e($speaker->bio)); ?>

            </div>
        </div>
    </div>
</section>

<!-- Sessions -->
<?php if($speaker->sessions->count() > 0): ?>
<section class="speaker-content">
    <div class="container">
        <div class="sessions-section">
            <h2>Sessions & Presentations</h2>

            <?php $__currentLoopData = $speaker->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="session-card">
                <h3 class="session-title"><?php echo e($session->title); ?></h3>

                <div class="session-meta">
                    <?php if($session->event): ?>
                    <div class="session-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span><?php echo e($session->event->title); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if($session->start_time): ?>
                    <div class="session-meta-item">
                        <i class="fas fa-clock"></i>
                        <span>
                            <?php echo e($session->start_time->format('M j, Y')); ?> at <?php echo e($session->start_time->format('g:i A')); ?>

                            <?php if($session->end_time): ?>
                            - <?php echo e($session->end_time->format('g:i A')); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <?php if($session->location): ?>
                    <div class="session-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo e($session->location); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($session->description): ?>
                <div class="session-description">
                    <?php echo e($session->description); ?>

                </div>
                <?php endif; ?>

                <?php if($session->event): ?>
                <span class="event-badge"><?php echo e($session->event->title); ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Back to Speakers -->
<section class="back-to-speakers">
    <div class="container">
        <a href="<?php echo e(route('speakers.index')); ?>">
            <i class="fas fa-arrow-left"></i>
            Back to All Speakers
        </a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats on load
        const statNumbers = document.querySelectorAll('.stat-number');

        statNumbers.forEach(stat => {
            const finalValue = parseInt(stat.textContent);
            animateNumber(stat, 0, finalValue, 1500);
        });

        function animateNumber(element, start, end, duration) {
            const startTime = performance.now();

            function updateNumber(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.floor(start + (end - start) * progress);
                element.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(updateNumber);
                }
            }

            requestAnimationFrame(updateNumber);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/Apple/Desktop/dev_folder/Dev_project/test.kiro2/leadership-summit-laravel/resources/views/speakers/show.blade.php ENDPATH**/ ?>