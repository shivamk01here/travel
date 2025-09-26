@extends('layouts.app1')
@section('title', 'About Us')

@section('content')
<!-- Banner with Breadcrumb -->
<section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color: #fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color: #fff;">About Us <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">About US</h1>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h2 class="mb-3" style="color:#2563eb;">Your Journey, Our Passion</h2>
                <p class="lead text-muted">
                    TravelEsy is dedicated to making travel planning simple, affordable, and delightful.<br>
                    With deep local expertise, responsive support, and a love for discovery, we've helped thousands explore the world their way.
                </p>
            </div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-4 text-center">
                <div class="p-4 bg-white shadow-sm rounded">
                    <i class="fa fa-globe-asia fa-2x mb-2 text-primary"></i>
                    <h5 class="font-weight-bold mb-2">Curated Destinations</h5>
                    <p class="mb-0 text-muted">Handpicked hotels, unique tours and seamless flight options for every kind of traveler.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-4 bg-white shadow-sm rounded">
                    <i class="fa fa-headset fa-2x mb-2 text-success"></i>
                    <h5 class="font-weight-bold mb-2">24/7 Support</h5>
                    <p class="mb-0 text-muted">Real people, real help—whenever and wherever you need us.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-4 bg-white shadow-sm rounded">
                    <i class="fa fa-check-circle fa-2x mb-2 text-warning"></i>
                    <h5 class="font-weight-bold mb-2">Trusted Service</h5>
                    <p class="mb-0 text-muted">Transparent pricing, real guest reviews, and secure bookings with zero hassle.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8 text-center">
                <p class="text-muted">
                    <b>Thank you for making us a part of your adventures.</b><br>
                    <span style="color:#2563eb">Ready to experience the world? <a href="{{ route('tours.all') }}">Discover our tours &rarr;</a></span>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
