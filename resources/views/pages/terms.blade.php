@extends('layouts.app1')
@section('title', 'Terms & Conditions')

@section('content')
<section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color: #fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color: #fff;">Terms & Conditions <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Terms & Conditions</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="bg-white p-5 rounded shadow-sm">
            <h4 class="mb-3" style="color:#2563eb;">1. Booking & Payments</h4>
            <ul>
                <li>All bookings are subject to availability and confirmation.</li>
                <li>Full or partial payment is required to secure your reservation.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">2. Cancellation & Refunds</h4>
            <ul>
                <li>Cancellations must be made as per the policy displayed during booking.</li>
                <li>Refunds (if eligible) will be processed to the original payment method.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">3. User Responsibilities</h4>
            <ul>
                <li>Ensure all provided information is accurate and up-to-date.</li>
                <li>Respect laws, rules, and conduct of all destinations and service providers.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">4. Liability</h4>
            <ul>
                <li>TravelEsy is not liable for any loss, injury, or damage during travel, except where required by law.</li>
                <li>Force majeure events may impact travel arrangements and services.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">5. Policy Updates</h4>
            <ul>
                <li>These terms may change over time. Please review regularly for updates.</li>
            </ul>
        </div>
    </div>
</section>
@endsection
