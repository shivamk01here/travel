@extends('layouts.app1')
@section('title', 'All Flights')

@section('content')
<div class="w-100" style="background:#f7fafc;">
    <!-- Breadcrumb above Banner -->
    <section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color: #fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color: #fff;">Flights <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Travel Stories</h1>
            </div>
        </div>
    </div>
</section>
    <!-- Flights Table/Card Grid -->
    <div class="container pb-5">
        @if(count($flights))
            <div class="row">
            @foreach($flights as $flight)
                <div class="col-lg-6 col-md-12 mb-4 d-flex">
                    <div class="card shadow-sm border-0 flex-fill w-100" style="border-radius:16px;">
                        <div class="card-body d-flex flex-wrap align-items-center">
                            <div class="flex-grow-1 pr-4">
                                <h5 class="mb-2 font-weight-bold" style="color:#2563eb;">
                                    <i class="fa fa-plane mr-1"></i>
                                    {{ $flight->airline ?? 'Airline' }}
                                    <span class="badge badge-info ml-2" style="font-size:.97rem;">
                                        {{ $flight->flight_number ?? '--' }}
                                    </span>
                                </h5>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="mr-3"><i class="fa fa-circle text-success" style="font-size:10px;"></i> <b>{{ $flight->source_name }}</b></span>
                                    <i class="fa fa-long-arrow-right mx-2"></i>
                                    <span class="mr-3"><i class="fa fa-map-marker text-danger"></i> <b>{{ $flight->destination_name }}</b></span>
                                    <span class="mx-2 d-none d-md-inline"><i class="fa fa-clock text-info mr-1"></i> Departs: {{ substr($flight->departure_time,0,5) }}</span>
                                    <span class="mx-2 d-none d-md-inline"><i class="fa fa-clock-o text-warning mr-1"></i> Arrives: {{ substr($flight->arrival_time,0,5) }}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge" style="background:#fff3bf;color:#b89217;font-weight:500;">{{ $flight->stops ?? 'Non-Stop' }}</span>
                                </div>
                            </div>
                            <div class="text-right" style="min-width:160px;">
                                <div class="mb-2" style="font-size:1.25rem;color:#14bb7a;font-weight:700;">
                                    ₹{{ number_format($flight->price, 0) }}
                                </div>
                                <a href="{{ route('flights.show', $flight->id) }}" 
                                   class="btn btn-primary font-weight-bold btn-sm"
                                   style="background:linear-gradient(90deg,#2563eb,#2c79ff 85%);border:none;border-radius:7px;">
                                    <i class="fa fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @else
        <div class="text-center my-5">
            <img src="{{ asset('images/no_data.svg') }}" alt="No Flights" style="height:100px;">
            <h4 class="mt-3 font-weight-bold">No Flights Found</h4>
            <p class="text-muted">No flights are available. Please check later.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.card:hover { transform: translateY(-3px) scale(1.01); box-shadow:0 7px 18px #2563eb24;}
.badge-info {
  background:linear-gradient(90deg,#46b2f0 0,#537ce7 90%);
  color:#fff;
}
</style>
@endpush
