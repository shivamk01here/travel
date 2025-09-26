@extends('layouts.app')

@section('title', 'TravelEsy Blog')

@section('content')
<!-- Hero Section with Centered Breadcrumbs & Title -->
<section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color: #fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color: #fff;">Blog <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Travel Stories</h1>
            </div>
        </div>
    </div>
</section>



<!-- Blog Posts Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row d-flex">
            @forelse($blogs as $blog)
            <div class="col-md-4 d-flex ftco-animate">
                <div class="blog-entry justify-content-end">
                    <a href="{{ route('blogs.show', $blog->id) }}" class="block-20" 
                       style="background-image: url('{{ $blog->image_url ?? 'https://placehold.co/400x300?text=Blog' }}');">
                    </a>
                    <div class="text">
                        <div class="d-flex align-items-center mb-4 topp">
                            <div class="one">
                                <span class="day">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('d') }}</span>
                            </div>
                            <div class="two">
                                <span class="yr">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('Y') }}</span>
                                <span class="mos">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('F') }}</span>
                            </div>
                        </div>
                        <h3 class="heading">
                            <a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a>
                        </h3>
                        @if($blog->author)
                        <p class="mb-2"><small class="text-muted">By {{ $blog->author }}</small></p>
                        @endif
                        <p>{{ Str::limit($blog->content, 150) }}</p>
                        <p>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-primary">Read more</a>
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12 d-flex ftco-animate">
                <div class="blog-entry justify-content-center text-center p-5" style="width: 100%;">
                    <div class="text">
                        <h3 class="heading mb-4">No Blog Posts Found</h3>
                        <p>We're working on bringing you amazing travel stories. Check back soon!</p>
                        <p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Explore Destinations</a>
                        </p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="ftco-intro ftco-section ftco-no-pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div class="img" style="background-image: url({{ asset('images/bg_2.jpg') }}); position: relative;">
                    <div class="overlay"></div>
                    <h2>Ready for Your Next Adventure?</h2>
                    <p>Discover amazing destinations and create unforgettable memories with TravelEsy</p>
                    <p class="mb-0">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 py-3">Start Planning →</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Make navbar white immediately */
    .ftco-navbar-light {
        background: #fff !important;
        transition: none !important;
    }

    /* Make nav links black */
    .ftco-navbar-light .navbar-nav > .nav-item > .nav-link {
        color: #000 !important;
    }

    /* Make brand text black */
    .ftco-navbar-light .navbar-brand,
    .ftco-navbar-light .navbar-brand span {
        color: #000 !important;
    }

    /* Highlight active menu item */
    .ftco-navbar-light .nav-item.active > a.nav-link {
        color: #ff6600 !important;
    }

    /* Adjust for fixed navbar */
    .hero-wrap-2 {
        margin-top: 75px; /* adjust this to match your navbar height */
    }

    /* Blog content styles */
    .blog-entry .text {
        padding: 20px;
    }

    .blog-entry .text .heading a {
        color: #333;
        text-decoration: none;
    }

    .blog-entry .text .heading a:hover {
        color: #007bff;
    }

    .block-27 ul li.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .block-27 ul li.disabled span {
        color: #6c757d;
        cursor: not-allowed;
    }
</style>
@endpush
