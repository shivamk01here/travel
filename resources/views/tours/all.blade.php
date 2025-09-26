@extends('layouts.app1')
@section('title', 'All Tours')

@section('content')

<!-- Banner/Hero -->
<div class="w-100 mb-4" style="height:150px;overflow:hidden;position:relative;">
    <img src="{{ asset('images/bg_1.jpg') }}" class="img-fluid w-100 h-100" style="object-fit:cover;opacity:.75;">
    <div class="position-absolute w-100 h-100" style="top:0;left:0;background:rgba(34, 42, 61, .15);"></div>
    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="z-index:5;">
        <h1 class="text-white font-weight-bold" style="font-size:1.9rem;text-shadow:0 4px 18px #232b3d;">
            <i class="fa fa-ticket-alt mr-2"></i> All Tours
        </h1>
    </div>
</div>

<div class="container pb-5">
    @if(count($tours))
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($tours as $tour)
        <div class="col d-flex">
            <div class="card h-100 shadow-sm rounded-3 flex-fill">

                <!-- Tour Image -->
                <img 
                    src="{{ $tour->main_image ?? 'https://placehold.co/400x260?text=No+Image' }}" 
                    class="card-img-top" 
                    alt="{{ $tour->name }}" 
                    onerror="this.onerror=null;this.src='https://placehold.co/400x260?text=No+Image';"
                    style="height:220px; object-fit:cover; border-radius:16px 16px 0 0;"
                >

                <div class="card-body d-flex flex-column p-3">
                    <h5 class="card-title mb-2 font-weight-bold">{{ $tour->name }}</h5>

                    <p class="text-muted mb-2" style="font-size:14px;">
                        {{ Str::limit($tour->full_description, 70, '...') }}
                    </p>

                    <!-- Duration (small, neat) -->
                    <p class="small text-secondary mb-2">
                        <i class="fa fa-clock mr-1"></i> {{ $tour->duration ?? '2-4 Days' }}
                    </p>

                    <!-- Star Rating -->
                    <div class="mb-3">
                        @php
                            $rating = round($tour->rating ?? 0);
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating)
                                <i class="fa fa-star text-warning"></i>
                            @else
                                <i class="fa fa-star text-secondary"></i>
                            @endif
                        @endfor
                    </div>

                    <!-- Price + View Details -->
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="h6 text-success mb-0">₹{{ $tour->price ?? 'N/A' }}</span>
                        <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View Details
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center my-5">
        <img src="{{ asset('images/no_data.svg') }}" alt="No Tours" style="height:100px;">
        <h4 class="mt-3 font-weight-bold">No Tours Listed</h4>
        <p class="text-muted">Please check back soon!</p>
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
.card:hover { 
    transform: translateY(-5px) scale(1.02); 
    box-shadow: 0 10px 28px rgba(35, 48, 90, 0.2);
}
.badge-danger { background:linear-gradient(135deg,#e84118 0,#c0392b 90%); color:#fff; }
.badge-success { background:linear-gradient(135deg,#54e884 0,#13be4c 90%); color:#fff; }
.badge-info { background:linear-gradient(135deg,#09a7ee,#504fed); color:#fff; }
.fa-star { font-size:16px; margin-right:2px; }
.row.g-4 > .col { display:flex; }
</style>
@endpush
