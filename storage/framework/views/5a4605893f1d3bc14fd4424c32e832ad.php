<?php $__env->startSection('title', 'Create Event'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.events.index')); ?>">Events</a></li>
<li class="breadcrumb-item active" aria-current="page">Create</li>
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
    <h1 class="page-title">Create New Event</h1>
    <div class="page-actions">
        <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to Events
        </a>
    </div>
</div>

<form action="<?php echo e(route('admin.events.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

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
                        id="title" name="title" value="<?php echo e(old('title')); ?>" required>
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
                        <option value="draft" <?php echo e(old('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="featured" <?php echo e(old('status') == 'featured' ? 'selected' : ''); ?>>Featured</option>
                        <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
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
                id="description" name="description" rows="6" required><?php echo e(old('description')); ?></textarea>
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
                id="location" name="location" value="<?php echo e(old('location')); ?>"
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
                    id="start_date" name="start_date" value="<?php echo e(old('start_date')); ?>" required>
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
                    id="end_date" name="end_date" value="<?php echo e(old('end_date')); ?>">
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
                            <?php echo e(in_array($speaker->id, old('speakers', [])) ? 'selected' : ''); ?>>
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

        <div class="mb-3">
            <label for="featured_image" class="form-label">Upload Image</label>
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
            <img id="previewImg" class="image-preview" alt="Image preview">
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
                        <div class="icon-option" data-icon="<?php echo e($iconClass); ?>" title="<?php echo e($iconData['name']); ?> - <?php echo e($iconData['description']); ?>">
                            <i class="<?php echo e($iconClass); ?>"></i>
                            <span class="icon-name"><?php echo e($iconData['name']); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <input type="hidden" name="selected_icon" id="selectedIcon" value="<?php echo e(old('selected_icon')); ?>">
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
                <input type="checkbox" name="featured" value="1" <?php echo e(old('featured') ? 'checked' : ''); ?>>
                Mark as Featured Event
            </label>
            <small class="form-text text-muted d-block">Featured events will display with a special "FEATURED" badge</small>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-section">
        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2" aria-hidden="true"></i>Cancel
            </a>
            <div>
                <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                    <i class="fas fa-save me-2" aria-hidden="true"></i>Save as Draft
                </button>
                <button type="submit" name="action" value="publish" class="btn btn-primary">
                    <i class="fas fa-check me-2" aria-hidden="true"></i>Create Event
                </button>
            </div>
        </div>
    </div>
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

        // Form submission handling for draft/publish actions
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const actionButton = e.submitter;
            if (actionButton && actionButton.name === 'action') {
                const statusSelect = document.getElementById('status');
                if (actionButton.value === 'draft') {
                    statusSelect.value = 'draft';
                } else if (actionButton.value === 'publish') {
                    if (!statusSelect.value || statusSelect.value === 'draft') {
                        statusSelect.value = 'published';
                    }
                }
            }
        });

        // Auto-set end date when start date changes (if end date is empty)
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            if (!endDateInput.value && this.value) {
                // Set end date to same day, 2 hours later
                const startDate = new Date(this.value);
                startDate.setHours(startDate.getHours() + 2);
                endDateInput.value = startDate.toISOString().slice(0, 16);
            }
        });

        // Enhanced form validation with user feedback
        form.addEventListener('submit', function(e) {
            // Show loading state on form submission
            const submitButtons = form.querySelectorAll('button[type="submit"]');
            submitButtons.forEach(button => {
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                button.disabled = true;

                // Re-enable if form submission is prevented
                setTimeout(() => {
                    if (e.defaultPrevented) {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                }, 100);
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/Apple/Desktop/dev_folder/Dev_project/test.kiro2/leadership-summit-laravel/resources/views/admin/events/create.blade.php ENDPATH**/ ?>