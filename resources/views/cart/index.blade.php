@extends('layouts.app')

@section('title','Your Cart')

@section('content')
<!-- Hero Section (same as Blog) -->
<section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2">
                        <a href="{{ route('home') }}" style="color: #fff;">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span style="color: #fff;">Cart <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Travel Stories</h1>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="ftco-section">
    <div class="container">
        @if($cartItems->count() == 0)
            <div class="text-center p-5 bg-light rounded shadow-sm">
                <h3 class="mb-3">Your cart is empty 🛒</h3>
                <p>Looks like you haven’t added anything yet.</p>
                <a href="{{ route('home') }}" class="btn btn-orange px-4 py-2 mt-3">Start Exploring</a>
            </div>
        @else
            <div class="table-responsive shadow-sm rounded mb-4">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Services</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                        <tr>
                            <td>{{ ucfirst($item->item_type) }}</td>
                            <td>{{ $item->item_id }}</td>
                            <td>{{ $item->adult_count }}</td>
                            <td>{{ $item->child_count }}</td>
                            <td>{{ implode(', ', json_decode($item->services, true) ?? []) }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>
                                <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-sm btn-danger">Remove</a>
                            </td>
                        </tr>
                        @php $total += $item->price; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <h2 class="font-weight-bold">Total: ₹{{ number_format($total, 2) }}</h2>
                <a href="{{ route('checkout') }}" class="btn btn-orange px-4 py-2">Proceed to Checkout →</a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Navbar overrides */
    .ftco-navbar-light {
        background: #fff !important;
        transition: none !important;
    }
    .ftco-navbar-light .navbar-nav > .nav-item > .nav-link {
        color: #000 !important;
    }
    .ftco-navbar-light .navbar-brand,
    .ftco-navbar-light .navbar-brand span {
        color: #000 !important;
    }
    .ftco-navbar-light .nav-item.active > a.nav-link {
        color: #ff6600 !important;
    }

    /* Hero adjustment */
    .hero-wrap-2 {
        margin-top: 75px; /* adjust for navbar */
    }

    /* Buttons */
    .btn-orange {
        background-color: #ff6600;
        color: #fff !important;
        border-radius: 6px;
        transition: 0.3s ease;
    }
    .btn-orange:hover {
        background-color: #e65c00;
        color: #fff !important;
    }

    /* Table responsiveness */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .table-dark th {
        background-color: #343a40 !important;
        color: #fff !important;
    }

    /* Empty Cart box */
    .bg-light {
        background: #f9f9f9 !important;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border: none;
        }
        .hero-wrap-2 h1 {
            font-size: 24px;
        }
        .btn-orange {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush
