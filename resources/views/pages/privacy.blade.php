@extends('layouts.app1')
@section('title', 'Privacy Policy')

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
                    <span style="color: #fff;">Privacy Policies <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Privacy Policies</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="bg-white p-5 rounded shadow-sm">
            <h4 class="mb-3" style="color:#2563eb;">1. Information We Collect</h4>
            <ul>
                <li>Personal details such as name, contact info, and payment data.</li>
                <li>Usage, booking, and preference data for better service.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">2. How We Use Your Data</h4>
            <ul>
                <li>For booking and customer service.</li>
                <li>To improve our offerings and personalize your experience.</li>
                <li>For legal, fraud prevention, and regulatory compliance purposes.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">3. Sharing & Security</h4>
            <ul>
                <li>Your data is shared only with necessary, trusted service providers.</li>
                <li>We employ strict security measures to protect your data.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">4. Cookies</h4>
            <ul>
                <li>We use cookies to enhance usability. You may disable these in your browser settings.</li>
            </ul>
            <h4 class="mt-4 mb-3" style="color:#2563eb;">5. Policy Changes</h4>
            <ul>
                <li>Policy updates will appear here with date of revision. Continued use means acceptance of new policy.</li>
            </ul>
            <p class="mt-4 text-muted small">For privacy questions, contact <a href="mailto:support@travelesy.com">support@travelesy.com</a></p>
        </div>
    </div>
</section>
@endsection
