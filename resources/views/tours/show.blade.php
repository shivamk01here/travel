@extends('layouts.app1')
@section('title', $tour->name ?? 'Tour Details')

@section('content')
<div class="tour-page bg-light">

    <!-- HERO SECTION -->
    <div class="tour-hero position-relative">
        <img src="{{ $tour->main_image ?? 'https://placehold.co/1200x500?text=No+Image' }}"
             alt="{{ $tour->name }}"
             class="img-fluid w-100 hero-image">
        <div class="hero-overlay d-flex align-items-end">
            <div class="container text-white pb-4">
                <h1 class="display-4 font-weight-bold">{{ $tour->name }}</h1>

                <!-- Meeting Point -->
                @php $meetingPoint = json_decode($tour->meeting_point, true) ?? []; @endphp
                @if(count($meetingPoint) > 0)
                    @foreach($meetingPoint as $location => $desc)
                        <p class="lead mb-1">
                            <i class="fa fa-map-marker-alt text-warning mr-2"></i>
                            <strong>{{ $location }}</strong> — {{ $desc }}
                        </p>
                    @endforeach
                @else
                    <p class="lead mb-1 text-light">
                        <i class="fa fa-map-marker-alt mr-2"></i>
                        Meeting point not specified
                    </p>
                @endif

                <!-- Rating + Price -->
                <span class="badge badge-warning mr-2">{{ $tour->rating }} ★</span>
                <span class="h3 text-warning font-weight-bold">₹{{ number_format($tour->price, 0) }}</span>
                <small class="text-light">/ Per Adult</small>
            </div>
        </div>
    </div>

    <div class="container mt-5">

        <!-- GALLERY -->
        @if(isset($images) && count($images) > 0)
        <div class="mb-5">
            <h3 class="mb-3 font-weight-bold">Tour Gallery</h3>
            <div class="d-flex flex-wrap">
                @foreach($images as $img)
                    <img src="{{ $img->url }}" alt="Tour image"
                         class="rounded shadow-sm mr-2 mb-2"
                         style="width:220px;height:150px;object-fit:cover;">
                @endforeach
            </div>
        </div>
        @endif

        <!-- DESCRIPTION & BOOKING -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h4 class="font-weight-bold">About this Tour</h4>
                <p class="text-muted">{{ $tour->full_description ?? 'No description available.' }}</p>

                <!-- HIGHLIGHTS -->
                @php $highlights = json_decode($tour->highlights, true) ?? []; @endphp
                @if(count($highlights) > 0)
                <div class="mb-4">
                    <h5 class="font-weight-bold">Highlights</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($highlights as $key => $value)
                            <li class="list-group-item">
                                <i class="fa fa-star text-warning mr-2"></i>
                                <strong>{{ $key }}:</strong> {{ $value }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- INCLUSIONS -->
                @php $inclusions = json_decode($tour->inclusions, true) ?? []; @endphp
                @if(count($inclusions) > 0)
                <div class="mb-4">
                    <h5 class="font-weight-bold">Inclusions</h5>
                    <div class="d-flex flex-wrap">
                        @foreach($inclusions as $item => $icon)
                            <div class="badge badge-success m-1 p-2">
                                <i class="fa {{ $icon }} mr-1"></i> {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- EXCLUSIONS -->
                @php $exclusions = json_decode($tour->exclusions, true) ?? []; @endphp
                @if(count($exclusions) > 0)
                <div class="mb-4">
                    <h5 class="font-weight-bold">Exclusions</h5>
                    <div class="d-flex flex-wrap">
                        @foreach($exclusions as $item => $icon)
                            <div class="badge badge-danger m-1 p-2">
                                <i class="fa {{ $icon }} mr-1"></i> {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- ITINERARY -->
                @php $itinerary = json_decode($tour->tour_itinerary, true) ?? []; @endphp
                @if(count($itinerary) > 0)
                <div class="mb-4">
                    <h5 class="font-weight-bold">Itinerary</h5>
                    <div class="timeline-container">
                        @foreach($itinerary as $day => $plan)
                        <div class="timeline-item mb-3">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content p-3 border rounded bg-white shadow-sm">
                                <h6 class="font-weight-bold">{{ $day }}</h6>
                                <p class="mb-0">{{ $plan }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- IMPORTANT INFO -->
                @php $info = json_decode($tour->important_information, true) ?? []; @endphp
                @if(count($info) > 0)
                <div class="mb-4">
                    <h5 class="font-weight-bold">Important Information</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($info as $key => $val)
                            <li class="list-group-item"><strong>{{ $key }}:</strong> {{ $val }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- BOOKING CARD -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top:80px;">
                    <div class="card-body">
                        <h3 class="font-weight-bold text-warning mb-3">₹{{ number_format($tour->price, 0) }}</h3>
                        <p class="text-muted">Per Adult, excluding taxes</p>
                        <form action="{{ route('cart.addTour') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <div class="form-group">
                                <label>Adults</label>
                                <input type="number" name="adults" class="form-control" value="1" min="1">
                            </div>
                            <div class="form-group">
                                <label>Children</label>
                                <input type="number" name="children" class="form-control" value="0" min="0">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Book Now</button>
                        </form>
                        <hr>
                        <p class="small text-muted mb-0"><i class="fa fa-tag mr-2"></i> No cost EMI available</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.tour-hero {
    height: 450px;
    overflow: hidden;
}
.tour-hero .hero-image {
    height: 100%;
    object-fit: cover;
}
.tour-hero .hero-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
}
.timeline-container {
    position: relative;
    margin-left: 20px;
}
.timeline-container::before {
    content: '';
    position: absolute;
    top: 0; bottom: 0; left: -10px;
    width: 2px;
    background: #007bff;
}
.timeline-item {
    position: relative;
}
.timeline-dot {
    position: absolute;
    left: -15px;
    top: 5px;
    width: 12px; height: 12px;
    background: #007bff;
    border-radius: 50%;
}
</style>
@endsection
