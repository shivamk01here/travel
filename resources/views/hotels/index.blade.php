@extends('layouts.app1')
@section('title', 'Hotels in '.($cityInfo->name ?? ''))

@section('content')
<!-- Hero Section -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('images/bg_1.jpg') }}'); min-height: 140px; height: 180px; background-size: cover; background-position: center; position: relative;">
    <div class="overlay" style="background: rgba(34, 42, 61, 0.25); position: absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
    <div class="container h-100" style="position:relative; z-index:2;">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-md-10 ftco-animate">
                <p class="breadcrumbs mb-2" style="color:#fff; font-size:15px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color:#fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span class="mr-2">
                        <a href="#" style="color:#fff;">Hotels <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color:#ffd700;">{{ $cityInfo->name ?? 'All Cities' }}</span>
                </p>
                <h1 class="bread mb-0" style="color:#fff; font-weight:700; font-size:2rem; text-shadow:0 3px 10px #2a3447a0;">Hotels in {{ $cityInfo->name ?? 'All Cities' }}</h1>
            </div>
        </div>
    </div>
</section>


<!-- Hotels Listing Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 ftco-animate">
                <div class="sidebar-box">
                    <h3 class="heading-sidebar"><i class="fa fa-filter"></i> Filter Hotels</h3>
                    <form method="GET" action="{{ route('hotels.index') }}">
                        <input type="hidden" name="city" value="{{ $cityInfo->slug ?? '' }}"/>

                        <!-- Rating Filter -->
                        <div class="form-group mb-4">
                            <label class="form-label"><i class="fa fa-star text-warning"></i> Min Rating</label>
                            <input type="number" step="0.1" min="0" max="5" name="rating_min" class="form-control form-control-sm" value="{{ request('rating_min') }}" placeholder="0.0">
                        </div>

                        <!-- Price Range -->
                        <div class="form-group mb-4">
                            <label class="form-label"><i class="fa fa-rupee text-success"></i> Price Range</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="price_min" class="form-control form-control-sm" value="{{ request('price_min') }}" placeholder="Min Price">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="price_max" class="form-control form-control-sm" value="{{ request('price_max') }}" placeholder="Max Price">
                                </div>
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="form-group mb-4">
                            <label class="form-label"><i class="fa fa-sort text-secondary"></i> Sort By</label>
                            <div class="select-wrap">
                                <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                <select name="sort" class="form-control form-control-sm">
                                    <option value="rating_desc" {{ request('sort')=='rating_desc'?'selected':'' }}>Rating (High → Low)</option>
                                    <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price (Low → High)</option>
                                    <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price (High → Low)</option>
                                    <option value="rating_asc" {{ request('sort')=='rating_asc'?'selected':'' }}>Rating (Low → High)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Apply Button -->
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-search"></i> Apply Filters
                        </button>
                        
                        <!-- Clear Filters -->
                        <a href="{{ route('hotels.index', ['city' => $cityInfo->slug ?? '']) }}" class="btn btn-outline-secondary btn-block mt-2">
                            <i class="fa fa-times"></i> Clear Filters
                        </a>
                    </form>
                </div>

                <!-- Quick Info -->
                <div class="sidebar-box">
                    <h3 class="heading-sidebar">Quick Info</h3>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Hotels:</span>
                        <span class="font-weight-bold">6</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>City:</span>
                        <span class="font-weight-bold">{{ $cityInfo->name ?? 'All' }}</span>
                    </div>
                </div>
            </div>

            <!-- Hotels Results -->
            <div class="col-lg-9 col-md-8 ftco-animate">
                <div class="hotels-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Available Hotels</h3>
                        <span class="text-muted">5 hotels found</span>
                    </div>
                </div>

                <div class="hotels-list">
                    @forelse($hotels as $h)
                    <div class="hotel-item mb-4">
                        <div class="project-wrap">
                            <a href="{{ route('hotels.show', $h->slug) }}" class="hotel-card d-flex card shadow-sm">
                                <div class="hotel-image">
                                    <img src="/hotel/{{ $h->primary_image ?? 'https://placehold.co/300x200?text=Hotel' }}" class="img-fluid" alt="{{ $h->name }}" style="width: 250px; height: 200px; object-fit: cover;">
                                    <div class="price-overlay">₹{{ number_format($h->min_price,0) }}</div>
                                </div>
                                <div class="card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h4 class="hotel-name mb-1">{{ $h->name }}</h4>
                                        <div class="rating-badge">
                                            <span class="badge badge-warning">
                                                <i class="fa fa-star"></i> {{ $h->avg_rating }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="location mb-2">
                                        <i class="fa fa-map-marker text-primary"></i> {{ $h->address }}
                                    </p>
                                    <div class="hotel-features mb-3">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item"><span class="flaticon-shower"></span> {{ rand(1,3) }}</li>
                                            <li class="list-inline-item"><span class="flaticon-king-size"></span> {{ rand(2,4) }}</li>
                                            <li class="list-inline-item"><span class="fa fa-wifi"></span> Free WiFi</li>
                                        </ul>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price-info">
                                            <span class="price-label">From </span>
                                            <span class="price">₹{{ number_format($h->min_price,0) }}</span>
                                            <span class="price-unit">/night</span>
                                        </div>
                                        <div class="hotel-actions">
                                            <span class="btn btn-primary btn-sm">View Details</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="no-results text-center py-5">
                        <div class="icon mb-4">
                            <span class="flaticon-route" style="font-size: 72px; opacity: 0.3;"></span>
                        </div>
                        <h4 class="mb-3">No Hotels Found</h4>
                        <p class="text-muted mb-4">No hotels match your current filter criteria. Try adjusting your filters or search for a different location.</p>
                        <a href="{{ route('hotels.index', ['city' => $cityInfo->slug ?? '']) }}" class="btn btn-primary">
                            <i class="fa fa-refresh"></i> Reset Filters
                        </a>
                    </div>
                    @endforelse
                </div>

                
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.sidebar-box {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
    margin-bottom: 30px;
}
.heading-sidebar {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 8px;
}
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}
.amenities-scroll {
    background: white;
}
.form-check {
    margin-bottom: 8px;
}
.form-check-input {
    margin-top: 3px;
}
.form-check-label {
    font-size: 13px;
    color: #666;
}
.select-wrap {
    position: relative;
}
.select-wrap .icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    z-index: 10;
}
.select-wrap select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}
.hotel-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}
.hotel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}
.hotel-image {
    position: relative;
    flex-shrink: 0;
}
.price-overlay {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #007bff;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}
.hotel-name {
    color: #333;
    font-size: 18px;
    font-weight: 600;
}
.rating-badge .badge {
    font-size: 12px;
    padding: 6px 10px;
}
.location {
    color: #666;
    font-size: 14px;
}
.hotel-features ul li {
    margin-right: 15px;
    font-size: 13px;
    color: #666;
}
.hotel-features span {
    margin-right: 5px;
}
.price-info .price {
    font-size: 20px;
    font-weight: 700;
    color: #28a745;
}
.price-label, .price-unit {
    font-size: 14px;
    color: #666;
}
.hotels-header h3 {
    color: #333;
    font-weight: 600;
    border-bottom: 3px solid #007bff;
    padding-bottom: 10px;
    display: inline-block;
}
.no-results {
    background: #f8f9fa;
    border-radius: 10px;
    margin: 20px 0;
}
@media (max-width: 768px) {
    .hotel-card {
        flex-direction: column;
    }
    .hotel-image img {
        width: 100% !important;
        height: 200px !important;
    }
    .sidebar-box {
        margin-bottom: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Filter form enhancements
    $('.form-check-input').change(function() {
        // You can add real-time filtering here if needed
    });

    // Smooth scroll to results on mobile after filter
    $('form').submit(function() {
        if ($(window).width() < 768) {
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('.hotels-header').offset().top - 100
                }, 500);
            }, 100);
        }
    });
});
</script>
@endpush
