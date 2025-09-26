@extends('layouts.app1')

@section('content')
<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($tours as $tour)
            <div class="col mb-4">
                <div class="card h-100 shadow-sm rounded-3" style="border-radius: 12px; overflow: hidden;">

                    <!-- Tour Image with fallback -->
                    <img 
                        src="{{ $tour->main_image ?: 'https://placehold.co/600x400?text=No+Image' }}" 
                        class="card-img-top" 
                        alt="{{ $tour->name }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=No+Image';"
                        style="height: 220px; object-fit: cover;"
                    >

                    <!-- Card Body -->
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title mb-2">{{ $tour->name }}</h5>

                        <p class="text-muted mb-1">
                            <i class="fa fa-map-marker"></i> {{ $location->name }}
                        </p>

                        <p class="small mb-2">
                            {{ $tour->duration_days }} Days / {{ $tour->duration_nights }} Nights
                        </p>

                        <p class="flex-grow-1 small text-secondary">
                            {{ Str::limit($tour->full_description, 100) }}
                        </p>

                        <!-- Price + Rating + Details Button -->
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            
                            <!-- Star Rating -->
                            <div class="star-rating">
                                @php
                                    $rating = round($tour->rating ?? 0); // round to nearest whole number
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="fa fa-star text-warning"></i>
                                    @else
                                        <i class="fa fa-star text-secondary"></i>
                                    @endif
                                @endfor
                            </div>

                            <div class="text-end">
                                <p class="h6 text-primary mb-1">
                                    ${{ number_format($tour->price, 2) }}
                                </p>
                                <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
