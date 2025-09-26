@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span>My Account <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">My Account</h1>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="text-center">
                    <h2 class="mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-muted">Manage your profile and view your travel bookings</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 ftco-animate">
                <div class="sidebar-box">
                    <div class="user-info text-center mb-4">
                        <div class="user-avatar mb-3">
                            <div class="avatar-circle">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="categories">
                        <h3 class="heading-sidebar">Account Menu</h3>
                        <ul class="list-unstyled">
                            <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                                <a href="{{ route('profile') }}" class="d-flex align-items-center py-2">
                                    <i class="fa fa-user-cog mr-3"></i>
                                    <span>Profile Settings</span>
                                    @if(request()->routeIs('profile'))
                                        <i class="fa fa-chevron-right ml-auto"></i>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('profile.orders*') ? 'active' : '' }}">
                                <a href="{{ route('profile.orders') }}" class="d-flex align-items-center py-2">
                                    <i class="fa fa-history mr-3"></i>
                                    <span>Order History</span>
                                    @if(request()->routeIs('profile.orders*'))
                                        <i class="fa fa-chevron-right ml-auto"></i>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="categories mt-4">
                        <h3 class="heading-sidebar">Quick Actions</h3>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('cart.show') }}" class="d-flex align-items-center py-2">
                                    <i class="fa fa-shopping-cart mr-3"></i>
                                    <span>View Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}" class="d-flex align-items-center py-2">
                                    <i class="fa fa-search mr-3"></i>
                                    <span>Book New Trip</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-block" onclick="return confirm('Are you sure you want to sign out?')">
                                <i class="fa fa-sign-out-alt mr-2"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8 ftco-animate">
                <div class="main-content">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Help Section -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-5">
                    <h3>Need Help?</h3>
                    <p class="text-muted">Our customer support team is here to assist you</p>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-phone" style="font-size: 48px; color: #007bff;"></span>
                        </div>
                        <h5>Call Us</h5>
                        <p>+1 234 567 890</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-envelope" style="font-size: 48px; color: #28a745;"></span>
                        </div>
                        <h5>Email Support</h5>
                        <p>support@travelesy.com</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-comments" style="font-size: 48px; color: #ffc107;"></span>
                        </div>
                        <h5>Live Chat</h5>
                        <p>Available 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.sidebar-box {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}
.user-info .avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 32px;
}
.heading-sidebar {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 8px;
}
.categories ul li {
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}
.categories ul li:last-child {
    border-bottom: none;
}
.categories ul li a {
    color: #666;
    text-decoration: none;
    padding: 12px 0;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}
.categories ul li:hover,
.categories ul li.active {
    background: rgba(0,123,255,0.1);
    border-radius: 5px;
    margin: 2px 0;
}
.categories ul li:hover a,
.categories ul li.active a {
    color: #007bff;
    font-weight: 600;
    padding-left: 10px;
}
.categories ul li a i {
    width: 20px;
    text-align: center;
}
.main-content {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
}
.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
    font-weight: 600;
}
.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
    color: white;
}
@media (max-width: 768px) {
    .sidebar-box {
        margin-bottom: 30px;
    }
    .main-content {
        margin-top: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add smooth hover effects
    $('.categories ul li').hover(
        function() {
            $(this).find('i.fa-chevron-right').addClass('text-primary');
        },
        function() {
            if (!$(this).hasClass('active')) {
                $(this).find('i.fa-chevron-right').removeClass('text-primary');
            }
        }
    );

    // Mobile menu toggle for responsive design
    if ($(window).width() < 768) {
        $('.sidebar-box').addClass('mb-4');
    }
});
</script>
@endpush
