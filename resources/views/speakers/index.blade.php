@extends('layouts.app')

@section('title', 'Speakers - Leadership Summit')

@section('content')
<section class="speakers-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Our Speakers</h1>
                <p class="lead text-muted">Meet the industry leaders and visionaries who will share their insights and expertise at the Leadership Summit.</p>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="search-container">
                    <div class="input-group mb-4">
                        <input type="text"
                            class="form-control form-control-lg"
                            id="speakerSearchInput"
                            placeholder="Search speakers by name, company, or expertise..."
                            aria-label="Search speakers">
                        <button class="btn btn-outline-secondary"
                            type="button"
                            id="clearSpeakerBtn"
                            style="display: none;"
                            aria-label="Clear search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Category Filter Buttons -->
                    <div class="category-filters text-center">
                        <button class="btn btn-outline-primary category-btn active me-2 mb-2" data-category="all">
                            All Speakers
                        </button>
                        <button class="btn btn-outline-primary category-btn me-2 mb-2" data-category="ceo">
                            CEOs & Executives
                        </button>
                        <button class="btn btn-outline-primary category-btn me-2 mb-2" data-category="entrepreneur">
                            Entrepreneurs
                        </button>
                        <button class="btn btn-outline-primary category-btn me-2 mb-2" data-category="academic">
                            Academics
                        </button>
                        <button class="btn btn-outline-primary category-btn mb-2" data-category="consultant">
                            Consultants
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Speakers Grid -->
        @if($speakers && $speakers->count() > 0)
        <div class="speakers-grid">
            @foreach($speakers as $speaker)
            <article class="speaker-card">
                <div class="speaker-image">
                    @if($speaker->image)
                    <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ $speaker->name }}" class="img-fluid">
                    @else
                    <i class="fas fa-user" aria-hidden="true"></i>
                    @endif
                    @if($speaker->is_featured)
                    <span class="speaker-badge">Featured</span>
                    @endif
                </div>
                <div class="speaker-content">
                    <h2 class="speaker-name">{{ $speaker->name }}</h2>
                    <p class="speaker-title">{{ $speaker->title }}</p>
                    <p class="speaker-company">{{ $speaker->company }}</p>
                    <p class="speaker-bio">{{ Str::limit($speaker->bio, 150) }}</p>

                    @if($speaker->expertise)
                    <div class="speaker-topics">
                        @foreach(explode(',', $speaker->expertise) as $topic)
                        <span class="topic-tag">{{ trim($topic) }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="speaker-social">
                        @if($speaker->linkedin)
                        <a href="{{ $speaker->linkedin }}" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn profile for {{ $speaker->name }}">
                            <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                        </a>
                        @endif
                        @if($speaker->twitter)
                        <a href="{{ $speaker->twitter }}" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Twitter profile for {{ $speaker->name }}">
                            <i class="fab fa-twitter" aria-hidden="true"></i>
                        </a>
                        @endif
                        @if($speaker->website)
                        <a href="{{ $speaker->website }}" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Website for {{ $speaker->name }}">
                            <i class="fas fa-globe" aria-hidden="true"></i>
                        </a>
                        @endif
                    </div>

                    <a href="{{ route('speakers.show', $speaker) }}" class="btn btn-primary">View Full Profile</a>
                </div>
            </article>
            @endforeach
        </div>

        @if(method_exists($speakers, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $speakers->links() }}
        </div>
        @endif
        @else
        <!-- No speakers available message -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No Speakers Available</h3>
                <p class="text-muted">Speakers will be announced soon. Please check back later.</p>
            </div>
            @auth
            @if(auth()->user()->role && auth()->user()->role->name === 'admin')
            <div class="mt-4">
                <a href="{{ route('admin.speakers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Speaker
                </a>
            </div>
            @endif
            @endauth
        </div>
        @endif

        <!-- Search Results Container (Hidden by default) -->
        <div id="speakerSearchResults" style="display: none;">
            <div id="searchSpeakersGrid" class="speakers-grid">
                <!-- Search results will be populated here -->
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .speakers-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .search-container {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .category-filters .category-btn {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }

    .category-filters .category-btn.active {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }

    .speakers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .speaker-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .speaker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .speaker-image {
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .speaker-image i {
        font-size: 4rem;
        color: #6c757d;
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .speaker-image img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f8f9fa;
    }

    .speaker-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(45deg, #ffd700, #ffed4e);
        color: #333;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .speaker-name {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .speaker-title {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.25rem;
        text-align: center;
    }

    .speaker-company {
        color: var(--bs-primary);
        font-weight: 500;
        margin-bottom: 1rem;
        text-align: center;
    }

    .speaker-bio {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .speaker-topics {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .topic-tag {
        background: #e9ecef;
        color: #495057;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .speaker-social {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        color: #6c757d;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--bs-primary);
        color: white;
        transform: translateY(-2px);
    }

    .speaker-card .btn {
        width: 100%;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .speakers-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .search-container {
            padding: 1.5rem;
        }

        .category-filters .category-btn {
            font-size: 0.875rem;
            padding: 0.4rem 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Simple search functionality for speakers page
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('speakerSearchInput');
        const clearBtn = document.getElementById('clearSpeakerBtn');

        if (searchInput) {
            // Add search functionality when speakers are loaded from database
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();

                if (searchTerm.length > 0) {
                    if (clearBtn) clearBtn.style.display = 'inline-block';
                    // Search functionality will be implemented when speakers are loaded from database
                } else {
                    if (clearBtn) clearBtn.style.display = 'none';
                }
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.focus();
                }
                this.style.display = 'none';
            });
        }

        // Category filter buttons
        const categoryButtons = document.querySelectorAll('.category-btn');
        categoryButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all buttons
                categoryButtons.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Filter functionality will be implemented when speakers are loaded from database
                const category = this.dataset.category || 'all';
                console.log('Filter by category:', category);
            });
        });
    });
</script>
@endpush