@extends('layouts.admin')

@section('title', 'Create Event')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
<li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@push('styles')
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
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Create New Event</h1>
    <div class="page-actions">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to Events
        </a>
    </div>
</div>

<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Basic Information -->
    <div class="form-section">
        <h3>Basic Information</h3>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="">Select Status</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror"
                id="location" name="location" value="{{ old('location') }}"
                placeholder="e.g., Conference Center, Online, TBD">
            @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Date & Time -->
    <div class="form-section">
        <h3>Date & Time</h3>

        <div class="datetime-inputs">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date & Time <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                    id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date & Time</label>
                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                    id="end_date" name="end_date" value="{{ old('end_date') }}">
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                    <select class="form-select @error('speakers') is-invalid @enderror"
                        id="speakers" name="speakers[]" multiple size="6">
                        @forelse($speakers as $speaker)
                        <option value="{{ $speaker->id }}"
                            {{ in_array($speaker->id, old('speakers', [])) ? 'selected' : '' }}>
                            {{ $speaker->name }}
                            @if($speaker->position && $speaker->company)
                            - {{ $speaker->position }} at {{ $speaker->company }}
                            @elseif($speaker->position)
                            - {{ $speaker->position }}
                            @elseif($speaker->company)
                            - {{ $speaker->company }}
                            @endif
                        </option>
                        @empty
                        <option disabled>No speakers available - Create speakers first</option>
                        @endforelse
                    </select>
                    @error('speakers')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Hold Ctrl (Cmd on Mac) to select multiple speakers</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="host_speaker" class="form-label">Host Speaker</label>
                    <select class="form-select @error('host_speaker') is-invalid @enderror"
                        id="host_speaker" name="host_speaker">
                        <option value="">Select host speaker</option>
                        <!-- Options will be populated dynamically based on selected speakers -->
                    </select>
                    @error('host_speaker')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                id="featured_image" name="featured_image" accept="image/*">
            @error('featured_image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                @php
                $iconsByCategory = App\Helpers\EventIcons::getIconsByCategory();
                @endphp

                @foreach($iconsByCategory as $category => $icons)
                <div class="icon-category mb-4">
                    <h6 class="category-title">{{ $category }}</h6>
                    <div class="icon-grid">
                        @foreach($icons as $iconClass => $iconData)
                        <div class="icon-option" data-icon="{{ $iconClass }}" title="{{ $iconData['name'] }} - {{ $iconData['description'] }}">
                            <i class="{{ $iconClass }}"></i>
                            <span class="icon-name">{{ $iconData['name'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <input type="hidden" name="selected_icon" id="selectedIcon" value="{{ old('selected_icon') }}">
            @error('selected_icon')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                Mark as Featured Event
            </label>
            <small class="form-text text-muted d-block">Featured events will display with a special "FEATURED" badge</small>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-section">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
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
@endsection

@push('scripts')
<!-- Speaker Selection JavaScript -->
<script src="{{ asset('js/admin-speaker-selection.js') }}"></script>

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
@endpush