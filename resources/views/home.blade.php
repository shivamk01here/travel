@extends('layouts.app')

@section('title','Find your next stay')

@section('content')
    @include('partials.hero-section')
    @include('partials.search-section', ['allLocations' => $allLocations])
    @include('partials.popular-cities', ['cities' => $cities])
    @include('partials.top-hotels', ['hotels' => $hotels])
    @include('partials.services-section')
    @include('partials.featured-tours', ['topTours' => $topTours])
    @include('partials.testimonials')
    @include('partials.blog-section', ['latestBlogs' => $latestBlogs])
    @include('partials.cta-section')
@endsection

@push('styles')
<style>
.autocomplete-suggestions {
    position: absolute;
    z-index: 1000;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
    display: none;
    width: 100%;
    margin-top: 2px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.autocomplete-suggestions div {
    padding: 12px 15px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}
.autocomplete-suggestions div:hover {
    background-color: #f8f9fa;
}
.autocomplete-suggestions div:last-child {
    border-bottom: none;
}
.autocomplete-suggestions div.active {
    background-color: #007bff;
    color: white;
}
.form-field {
    position: relative;
}
/* Enhanced Autocomplete Styles */
.autocomplete-suggestions {
    position: absolute;
    z-index: 1000;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
    display: none;
    width: 100%;
    margin-top: 2px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.autocomplete-suggestions div.suggestion-item {
    padding: 12px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.2s ease;
    font-size: 14px;
}

.autocomplete-suggestions div.suggestion-item:hover,
.autocomplete-suggestions div.suggestion-item.active {
    background-color: #007bff;
    color: white;
}

.autocomplete-suggestions div.suggestion-item:last-child {
    border-bottom: none;
}

.autocomplete-suggestions div.suggestion-item strong {
    font-weight: 600;
}

.form-field {
    position: relative;
}

/* Loading state */
.autocomplete-loading {
    padding: 12px 15px;
    text-align: center;
    color: #666;
    font-style: italic;
}

/* No results state */
.autocomplete-no-results {
    padding: 12px 15px;
    text-align: center;
    color: #999;
    font-style: italic;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .autocomplete-suggestions {
        max-height: 200px;
    }
    
    .autocomplete-suggestions div.suggestion-item {
        padding: 10px 12px;
        font-size: 13px;
    }
}
</style>
@endpush
@push('scripts')
<script src="{{ asset('js/autocomplete.js') }}"></script>
<script>
$(document).ready(function() {
    // Pass locations data to JavaScript
    window.allLocations = @json($allLocations);
    
    // Tab functionality
    $('.tab-btn').click(function(e) {
        e.preventDefault();
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('show active');
        $($(this).attr('href')).addClass('show active');
    });

    // Initialize autocomplete for each search input
    const hotelAutocomplete = new LocationAutocomplete('#hotel-city', '#hotel-suggest', {
        onSelect: function(name, slug) {
            console.log('Hotel destination selected:', name, slug);
        }
    });

    const tourAutocomplete = new LocationAutocomplete('#tourSearch', '#tourSuggestions', {
        onSelect: function(name, slug) {
            console.log('Tour destination selected:', name, slug);
        }
    });

    const flightFromAutocomplete = new LocationAutocomplete('#flightFrom', '#fromSuggestions', {
        onSelect: function(name, slug) {
            console.log('Flight from selected:', name, slug);
        }
    });

    const flightToAutocomplete = new LocationAutocomplete('#flightTo', '#toSuggestions', {
        onSelect: function(name, slug) {
            console.log('Flight to selected:', name, slug);
        }
    });

    // Flight search functionality
    $('#searchFlightBtn').on('click', function(){
        const fromData = flightFromAutocomplete.getSelectedData();
        const toData = flightToAutocomplete.getSelectedData();
        
        if(fromData.name && toData.name){
            window.location.href = `/flights/${encodeURIComponent(fromData.slug)}/${encodeURIComponent(toData.slug)}`;
        } else {
            alert('Please select both departure and destination cities from the suggestions');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        const cityInput = $(this).find('input[name="city"]');
        if (cityInput.length) {
            const selectedData = cityInput.data('selected-name');
            if (!selectedData && cityInput.val().trim()) {
                e.preventDefault();
                alert('Please select a destination from the suggestions');
                cityInput.focus();
                return false;
            }
        }
    });

    // Clear validation state when input changes
    $('input[name="city"]').on('input', function() {
        $(this).removeData('selected-name selected-slug');
    });
});
</script>
@endpush