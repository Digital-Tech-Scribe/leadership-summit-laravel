<?php
$navItems = [
['url' => '/', 'label' => 'Home', 'icon' => 'fas fa-home', 'pattern' => '/'],
['url' => '/about', 'label' => 'About', 'icon' => 'fas fa-info-circle', 'pattern' => 'about*'],
['url' => '/speakers', 'label' => 'Speakers', 'icon' => 'fas fa-users', 'pattern' => 'speakers*'],
['url' => '/events', 'label' => 'Events', 'icon' => 'fas fa-calendar-alt', 'pattern' => 'events*'],
['url' => '/agenda', 'label' => 'Agenda', 'icon' => 'fas fa-list-ul', 'pattern' => 'agenda*'],
['url' => '/contact', 'label' => 'Contact', 'icon' => 'fas fa-envelope', 'pattern' => 'contact*'],
];
?>

<ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-spaced">
    <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->is($item['pattern']) ? 'active' : ''); ?>"
            href="<?php echo e(url($item['url'])); ?>"
            <?php if(request()->is($item['pattern'])): ?> aria-current="page" <?php endif; ?>>
            <i class="<?php echo e($item['icon']); ?> d-lg-none me-2" aria-hidden="true"></i><?php echo e($item['label']); ?>

        </a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(auth()->guard()->check()): ?>
    <?php if(auth()->user()->role && auth()->user()->role->name === 'admin'): ?>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-shield d-lg-none me-2" aria-hidden="true"></i>
            <span class="d-none d-lg-inline">Admin User</span>
            <span class="d-lg-none">Admin</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <h6 class="dropdown-header text-primary">
                <i class="fas fa-crown me-1"></i><?php echo e(Auth::user()->name); ?>

            </h6>
            <div class="dropdown-divider"></div>

            <!-- Admin Dashboard Section -->
            <h6 class="dropdown-header text-muted small">ADMIN DASHBOARD</h6>
            <a class="dropdown-item" href="<?php echo e(url('/admin')); ?>">
                <i class="fas fa-tachometer-alt me-2 text-primary" aria-hidden="true"></i>Dashboard
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.events.create')); ?>">
                <i class="fas fa-plus-circle me-2 text-success" aria-hidden="true"></i>Add Event
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.speakers.create')); ?>">
                <i class="fas fa-user-plus me-2 text-info" aria-hidden="true"></i>Add Speaker
            </a>
            <div class="dropdown-divider"></div>

            <!-- Admin Management Section -->
            <h6 class="dropdown-header text-muted small">MANAGEMENT</h6>
            <a class="dropdown-item" href="<?php echo e(route('admin.events.index')); ?>">
                <i class="fas fa-calendar-alt me-2" aria-hidden="true"></i>All Events
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.speakers.index')); ?>">
                <i class="fas fa-users me-2" aria-hidden="true"></i>All Speakers
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.registrations.index')); ?>">
                <i class="fas fa-ticket-alt me-2" aria-hidden="true"></i>Registrations
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.payments.pending')); ?>">
                <i class="fas fa-credit-card me-2" aria-hidden="true"></i>Payments
            </a>
            <a class="dropdown-item" href="<?php echo e(route('admin.users.index')); ?>">
                <i class="fas fa-users-cog me-2" aria-hidden="true"></i>Users
            </a>
            <div class="dropdown-divider"></div>



            <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i>Logout
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </li>
    <?php endif; ?>
    <?php endif; ?>
</ul><?php /**PATH /Users/Apple/Desktop/dev_folder/Dev_project/test.kiro2/leadership-summit-laravel/resources/views/components/navigation.blade.php ENDPATH**/ ?>