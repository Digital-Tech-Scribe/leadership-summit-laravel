<?php $__env->startSection('title', 'Edit Event'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.events.index')); ?>">Events</a></li>
<li class="breadcrumb-item active" aria-current="page">Edit: <?php echo e($event->title); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-section {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .form-section h3 {
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .image-preview {
        max-width: 300px;
        max-height: 200px;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }

    .current-image {
        max-width: 300px;
        max-height: 200px;
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
    }

    /* Icon Selection Styles */
    .icon-selection-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        background-color: #f8f9fa;
    }

    .icon-category {
        margin-bottom: 20px;
    }

    .category-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid #dee2e6;
    }

    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }

    .icon-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px 10px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .icon-option:hover {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }

    .icon-option.selected {
        border-color: #0d6efd;
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .icon-option.selected:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .icon-option i {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .icon-name {
        font-size: 11px;
        font-weight: 500;
        line-height: 1.2;
    }

    .datetime-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .datetime-inputs {
            grid-template-columns: 1fr;
        }
    }

    .speaker-selection select[multiple] {
        min-height: 150px;
    }

    .speaker-selection .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }

    #host_speaker:disabled {
        background-color: #f8f9fa;
        opacity: 0.65;
    }

    .speaker-selection .form-text.text-warning {
        color: #f0ad4e !important;
        font-weight: 500;
    }

    .speaker-selection .form-text.text-info {
        color: #5bc0de !important;
    }

    .speaker-selection .invalid-feedback {
        display: block;
    }

    .loading-overlay {
        position: relative;
    }

    .loading-overlay::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        z-index: 10;
    }

    .loading-overlay.loading::after {
        display: block;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Edit Event</h1>
    <div class="page-actions">
        <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="btn btn-outline-info me-2">
            <i class="fas fa-eye me-2" aria-hidden="true"></i>View Event
        </a>
        <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to Events
        </a>
    </div>
</div>

<form action="<?php echo e(route('admin.events.update', $event)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Basic Information -->
    <div class="form-section">
        <h3>Basic Information</h3>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="title" name="title" value="<?php echo e(old('title', $event->title)); ?>" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                        <option value="">Select Status</option>
                        <option value="draft" <?php echo e(old('status', $event->status) == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="published" <?php echo e(old('status', $event->status) == 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="featured" <?php echo e(old('status', $event->status) == 'featured' ? 'selected' : ''); ?>>Featured</option>
                        <option value="cancelled" <?php echo e(old('status', $event->status) == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                id="description" name="description" rows="6" required><?php echo e(old('description', $event->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                id="location" name="location" value="<?php echo e(old('location', $event->location)); ?>"
                placeholder="e.g., Conference Center, Online, TBD">
            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <!-- Date & Time -->
    <div class="form-section">
        <h3>Date & Time</h3>

        <div class="datetime-inputs">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date & Time <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    id="start_date" name="start_date"
                    value="<?php echo e(old('start_date', $event->start_date->format('Y-m-d\TH:i'))); ?>" required>
                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date & Time</label>
                <input type="datetime-local" class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    id="end_date" name="end_date"
                    value="<?php echo e(old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '')); ?>">
                <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="form-text">Leave empty if it's a single-day event</div>
            </div>
        </div>
    </div>

    <!-- Speaker Assignment -->
    <div class="form-section speaker-selection">
        <h3>Speaker Assignment</h3>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="speakers" class="form-label">Select Speakers</label>
                    <select class="form-select <?php $__errorArgs = ['speakers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="speakers" name="speakers[]" multiple size="6">
                        <?php $__empty_1 = true; $__currentLoopData = $speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <option value="<?php echo e($speaker->id); ?>"
                            <?php echo e(in_array($speaker->id, old('speakers', $event->speakers->pluck('id')->toArray())) ? 'selected' : ''); ?>>
                            <?php echo e($speaker->name); ?>

                            <?php if($speaker->position && $speaker->company): ?>
                            - <?php echo e($speaker->position); ?> at <?php echo e($speaker->company); ?>

                            <?php elseif($speaker->position): ?>
                            - <?php echo e($speaker->position); ?>

                            <?php elseif($speaker->company): ?>
                            - <?php echo e($speaker->company); ?>

                            <?php endif; ?>
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <option disabled>No speakers available - Create speakers first</option>
                        <?php endif; ?>
                    </select>
                    <?php $__errorArgs = ['speakers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-text">Hold Ctrl (Cmd on Mac) to select multiple speakers</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="host_speaker" class="form-label">Host Speaker</label>
                    <select class="form-select <?php $__errorArgs = ['host_speaker'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="host_speaker" name="host_speaker">
                        <option value="">Select host speaker</option>
                        <!-- Options will be populated dynamically based on selected speakers -->
                    </select>
                    <?php $__errorArgs = ['host_speaker'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-text" id="host-speaker-help">Select speakers first to choose a host speaker</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    <div class="form-section">
        <h3>Featured Image</h3>

        <?php if($event->featured_image): ?>
        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div>
                <img src="<?php echo e(asset('storage/' . $event->featured_image)); ?>"
                    alt="<?php echo e($event->title); ?>" class="current-image">
            </div>
        </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="featured_image" class="form-label">
                <?php echo e($event->featured_image ? 'Replace Image' : 'Upload Image'); ?>

            </label>
            <input type="file" class="form-control <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                id="featured_image" name="featured_image" accept="image/*">
            <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="form-text">Recommended size: 1200x600px. Max file size: 2MB. Formats: JPEG, PNG, JPG, GIF</div>
        </div>

        <div id="imagePreview" style="display: none;">
            <label class="form-label">New Image Preview</label>
            <div>
                <img id="previewImg" class="image-preview" alt="Image preview">
            </div>
        </div>
    </div>

    <!-- Icon Selection -->
    <div class="form-section">
        <h3>Event Icon</h3>
        <p class="text-muted">Select an icon to display when no image is uploaded</p>

        <div class="mb-3">
            <label class="form-label">Choose Icon</label>
            <div class="icon-selection-container">
                <?php
                $iconsByCategory = App\Helpers\EventIcons::getIconsByCategory();
                ?>

                <?php $__currentLoopData = $iconsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $icons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="icon-category mb-4">
                    <h6 class="category-title"><?php echo e($category); ?></h6>
                    <div class="icon-grid">
                        <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iconClass => $iconData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="icon-option <?php echo e(old('selected_icon', $event->selected_icon) == $iconClass ? 'selected' : ''); ?>"
                            data-icon="<?php echo e($iconClass); ?>"
                            title="<?php echo e($iconData['name']); ?> - <?php echo e($iconData['description']); ?>">
                            <i class="<?php echo e($iconClass); ?>"></i>
                            <span class="icon-name"><?php echo e($iconData['name']); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <input type="hidden" name="selected_icon" id="selectedIcon" value="<?php echo e(old('selected_icon', $event->selected_icon)); ?>">
            <?php $__errorArgs = ['selected_icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label class="form-label">
                <input type="checkbox" name="featured" value="1" <?php echo e(old('featured', $event->featured) ? 'checked' : ''); ?>>
                Mark as Featured Event
            </label>
            <small class="form-text text-muted d-block">Featured events will display with a special "FEATURED" badge</small>
        </div>
    </div>

    <!-- Event Statistics -->
    <div class="form-section">
        <h3>Event Statistics</h3>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($event->registrations->count()); ?></h5>
                        <p class="card-text text-muted">Registrations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($event->tickets->count()); ?></h5>
                        <p class="card-text text-muted">Ticket Types</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($event->sessions->count()); ?></h5>
                        <p class="card-text text-muted">Sessions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($event->created_at->diffForHumans()); ?></h5>
                        <p class="card-text text-muted">Created</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-section">
        <div class="d-flex justify-content-between">
            <div>
                <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times me-2" aria-hidden="true"></i>Cancel
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2" aria-hidden="true"></i>Delete Event
                </button>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2" aria-hidden="true"></i>Update Event
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Delete Form (hidden) -->
<form id="deleteForm" action="<?php echo e(route('admin.events.destroy', $event)); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Speaker Selection JavaScript -->
<script src="<?php echo e(asset('js/admin-speaker-selection.js')); ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('featured_image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // Icon selection functionality
        const iconOptions = document.querySelectorAll('.icon-option');
        const selectedIconInput = document.getElementById('selectedIcon');

        iconOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                iconOptions.forEach(opt => opt.classList.remove('selected'));

                // Add selected class to clicked option
                this.classList.add('selected');

                // Update hidden input value
                const iconValue = this.getAttribute('data-icon');
                selectedIconInput.value = iconValue;

                // Visual feedback
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Initialize selection if there's a pre-selected value
        const currentIcon = selectedIconInput.value;
        if (currentIcon) {
            const currentOption = document.querySelector(`[data-icon="${currentIcon}"]`);
            if (currentOption) {
                currentOption.classList.add('selected');
            }
        }

        // Speaker selection functionality
        const speakersSelect = document.getElementById('speakers');
        const hostSpeakerSelect = document.getElementById('host_speaker');
        const hostSpeakerHelp = document.getElementById('host-speaker-help');

        function updateHostSpeakerOptions() {
            const selectedSpeakers = Array.from(speakersSelect.selectedOptions);
            const currentHostSpeaker = hostSpeakerSelect.value;

            // Clear existing options except the first one
            hostSpeakerSelect.innerHTML = '<option value="">Select host speaker</option>';

            if (selectedSpeakers.length === 0) {
                hostSpeakerSelect.disabled = true;
                hostSpeakerHelp.textContent = 'Select speakers first to choose a host speaker';
                return;
            }

            hostSpeakerSelect.disabled = false;
            hostSpeakerHelp.textContent = 'Choose one speaker to be the host speaker';

            // Add options for selected speakers
            selectedSpeakers.forEach(option => {
                const hostOption = document.createElement('option');
                hostOption.value = option.value;
                hostOption.textContent = option.textContent;

                // Restore previous selection if it's still valid
                if (option.value === currentHostSpeaker) {
                    hostOption.selected = true;
                }

                hostSpeakerSelect.appendChild(hostOption);
            });
        }

        // Initialize host speaker dropdown state
        updateHostSpeakerOptions();

        // Set current host speaker if one exists
        const currentHostSpeaker = '<?php echo e($event->host_speaker ?? ""); ?>';
        if (currentHostSpeaker) {
            hostSpeakerSelect.value = currentHostSpeaker;
        }

        // Restore host speaker selection if there's an old value
        const oldHostSpeaker = '<?php echo e(old("host_speaker")); ?>';
        if (oldHostSpeaker) {
            hostSpeakerSelect.value = oldHostSpeaker;
        }

        // Update host speaker options when speakers selection changes
        speakersSelect.addEventListener('change', updateHostSpeakerOptions);

        // Initialize speaker selection with current data after the component loads
        setTimeout(() => {
            if (window.adminSpeakerSelection) {
                // Set current host speaker if one exists
                const currentHostSpeaker = '<?php echo e($event->host_speaker ?? ""); ?>';
                if (currentHostSpeaker) {
                    window.adminSpeakerSelection.setHostSpeaker(currentHostSpeaker);
                }

                // Restore host speaker selection if there's an old value (validation errors)
                const oldHostSpeaker = '<?php echo e(old("host_speaker")); ?>';
                if (oldHostSpeaker) {
                    window.adminSpeakerSelection.setHostSpeaker(oldHostSpeaker);
                }

                // Refresh the component to ensure proper state
                window.adminSpeakerSelection.refresh();
            }
        }, 100);

        // Enhanced form validation with user feedback
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // Show loading state on form submission
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitButton.disabled = true;

                // Re-enable if form submission is prevented
                setTimeout(() => {
                    if (e.defaultPrevented) {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                }, 100);
            }
        });

        // Delete confirmation with enhanced UX
        window.confirmDelete = function() {
            const deleteButton = document.querySelector('button[onclick="confirmDelete()"]');

            if (confirm('Are you sure you want to delete this event? This action cannot be undone and will also delete all associated registrations and tickets.')) {
                if (deleteButton) {
                    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';
                    deleteButton.disabled = true;
                }
                document.getElementById('deleteForm').submit();
            }
        };
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/Apple/Desktop/dev_folder/Dev_project/test.kiro2/leadership-summit-laravel/resources/views/admin/events/edit.blade.php ENDPATH**/ ?>