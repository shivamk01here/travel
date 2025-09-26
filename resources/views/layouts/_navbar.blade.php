    <style>
        /* White background with shadow */
    #ftco-navbar {
        background-color: #fff !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Brand styling */
    .navbar-brand {
        font-weight: 700;
        color: #000 !important;
        font-size: 22px;
    }
    .navbar-brand span {
        display: block;
        font-size: 12px;
        color: #f85a40 !important; /* orange accent */
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Nav links */
    .navbar-nav .nav-link {
        color: #000 !important;
        font-size: 16px;
        font-weight: 500;
        padding: 10px 15px;
    }
    .navbar-nav .nav-item.active .nav-link {
        color: #f85a40 !important; /* orange when active */
    }

    /* Dropdown menu */
    .dropdown-menu {
        border-radius: 0;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Push content down (avoid hiding under navbar) */
    main {
        padding-top: 80px;
    }

    /* Mobile styles */
    @media (max-width: 991px) {
        .navbar-nav {
            background: #ffffff;
            border-top: 1px solid #eee;
            padding: 10px;
        }
    }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light scrolled awake" id="ftco-navbar">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                TravelEsy<span>Travel Agency</span>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
            <ul class="navbar-nav ml-auto">
    <!-- Services Dropdown -->
    <li class="nav-item dropdown
        {{ Request::routeIs('hotels.*') || Request::routeIs('tours.*') || Request::routeIs('flights.*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Services
        </a>
        <div class="dropdown-menu" aria-labelledby="servicesDropdown">
            <a class="dropdown-item" href="{{ route('hotels.all') }}">Hotels</a>
            <a class="dropdown-item" href="{{ route('tours.all') }}">Tours</a>
            <a class="dropdown-item" href="{{ route('flights.all') }}">Flights</a>
        </div>
    </li>
    <!-- Blog -->
    <li class="nav-item {{ Request::is('blogs*') ? 'active' : '' }}">
        <a href="{{ url('/blogs') }}" class="nav-link">Blog</a>
    </li>
    <!-- Pages Dropdown -->
    <li class="nav-item dropdown
        {{ Request::routeIs('about') || Request::routeIs('contact') || Request::routeIs('terms') || Request::routeIs('privacy') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pages
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ route('about') }}">About</a>
            <a class="dropdown-item" href="{{ route('contact') }}">Contact</a>
            <a class="dropdown-item" href="{{ route('terms') }}">Terms</a>
            <a class="dropdown-item" href="{{ route('privacy') }}">Privacy</a>
        </div>
    </li>
    <!-- Cart -->
    <li class="nav-item {{ Request::routeIs('cart.show') ? 'active' : '' }}">
        <a href="{{ route('cart.show') }}" class="nav-link">Cart</a>
    </li>
    <!-- User Dropdown / Auth Controls -->
    @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                <a class="dropdown-item" href="{{ url('/profile/orders') }}">My Orders</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
            </div>
        </li>
    @endauth
    @guest
        <li class="nav-item">
            <a href="{{ url('/login') }}" class="nav-link">Log in</a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/register') }}" class="nav-link">Register</a>
        </li>
    @endguest
</ul>


            </div>
        </div>
    </nav>
