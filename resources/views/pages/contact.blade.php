@extends('layouts.app1')
@section('title', 'Contact Us')

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
                    <span style="color: #fff;">Contact Us <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Contact US</h1>
            </div>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="ftco-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-3" style="color:#2563eb;">We'd Love to Hear From You</h2>
                <p class="lead text-muted">
                    Have a question, suggestion or special request?<br>
                    Drop us a message or use any of the options below.
                </p>
            </div>
        </div>
        <div class="row g-5">
            <!-- Contact Details -->
            <div class="col-md-5">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <div class="mb-3">
                        <i class="fa fa-map-marker-alt text-danger mr-2"></i>
                        <strong> Address: </strong>
                        14th Floor, Pacific Towers, New Delhi NCR, 110001
                    </div>
                    <div class="mb-3">
                        <i class="fa fa-envelope text-primary mr-2"></i>
                        <strong> Email: </strong>
                        <a href="mailto:support@travelesy.com">support@travelesy.com</a>
                    </div>
                    <div class="mb-3">
                        <i class="fa fa-phone-alt text-success mr-2"></i>
                        <strong>Phone:</strong> +91-9876543210
                    </div>
                    <div class="mt-4">
                        <strong>Follow us:</strong>
                        <a href="#" class="mx-2 text-primary"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="mx-2 text-danger"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="mx-2 text-info"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="mx-2 text-success"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <!-- Contact Form -->
            <div class="col-md-7">
                <div class="bg-white p-4 rounded shadow-sm">
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="font-weight-bold">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Full Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject" class="font-weight-bold">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required placeholder="Subject" value="{{ old('subject') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="font-weight-bold">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="5" required placeholder="Type your message here...">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold" style="border-radius:7px;">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                        @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
