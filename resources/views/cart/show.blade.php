@extends('layouts.app1')

@section('title','Your Cart')

@section('content')
<!-- Hero Section -->
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
                <h1 class="bread text-white font-weight-bold" style="font-size: 32px; line-height: 1.2;">Your Cart</h1>
            </div>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="ftco-section">
    <div class="container">
        @if(session('success'))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if(count($items) === 0)
        <div class="row">
            <div class="col-md-12 text-center ftco-animate">
                <div class="p-5">
                    <div class="icon mb-4">
                        <span class="flaticon-route" style="font-size: 72px; opacity: 0.3;"></span>
                    </div>
                    <h3 class="mb-4">Your cart is empty</h3>
                    <p class="mb-4">Start planning your perfect trip by adding hotels, tours, or flights to your cart.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-3">Start Booking</a>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-table">
                    <table class="table table-striped">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>Type</th>
                                <th>Details</th>
                                <th>Passengers</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($items as $item)
                                @php
                                    $meta = $item->meta ?? [];
                                    $details = $item->details ?? [];
                                    $grandTotal += $item->total_price;
                                    $totalPassengers = ($meta['adults'] ?? 0) + ($meta['children'] ?? 0);
                                @endphp
                                <tr class="text-center">
                                    <td class="align-middle">
                                        <span class="badge badge-primary p-2">{{ ucfirst($item->item_type) }}</span>
                                    </td>
                                    <td class="text-left align-middle">
                                        <div class="product-name">
                                            <h3><strong>{{ $item->display_name ?? $item->name }}</strong></h3>
                                            <div class="product-details mt-2">
                                                @if($item->item_type === 'hotel_room')
                                                    <p class="mb-1"><i class="fa fa-calendar"></i> Check-in: {{ $meta['check_in'] ?? '-' }} | Check-out: {{ $meta['check_out'] ?? '-' }}</p>
                                                    <p class="mb-1"><i class="fa fa-moon-o"></i> Nights: {{ $meta['nights'] ?? '-' }}</p>
                                                    <p class="mb-1"><i class="fa fa-users"></i> Adults: {{ $meta['adults'] ?? 0 }}, Children: {{ $meta['children'] ?? 0 }}</p>
                                                    @if(!empty($meta['breakfast'])) <p class="mb-1"><i class="fa fa-coffee"></i> Breakfast Included</p> @endif
                                                    @if(!empty($meta['refundable'])) <p class="mb-1"><i class="fa fa-shield"></i> Refundable</p> @endif
                                                    <p class="mb-0"><i class="fa fa-info-circle"></i> Service Fee: {{ $meta['service_fee_percent'] ?? 0 }}% + ₹{{ number_format($meta['service_fee_fixed'] ?? 0,2) }}</p>

                                                @elseif($item->item_type === 'flight')
                                                    <p class="mb-1"><i class="fa fa-plane"></i> {{ $meta['from'] ?? '-' }} → {{ $meta['to'] ?? '-' }}</p>
                                                    <p class="mb-1"><i class="fa fa-clock-o"></i> Departure: {{ $meta['departure'] ?? '-' }} | Arrival: {{ $meta['arrival'] ?? '-' }}</p>
                                                    <p class="mb-1"><i class="fa fa-info-circle"></i> {{ $meta['airline'] ?? '-' }} | Flight No: {{ $meta['flight_no'] ?? '-' }}</p>
                                                    <p class="mb-1"><i class="fa fa-star"></i> {{ $meta['cabin_class'] ?? 'Economy' }}</p>
                                                    <p class="mb-1"><i class="fa fa-users"></i> Adults: {{ $meta['adults'] ?? 0 }}, Children: {{ $meta['children'] ?? 0 }}</p>
                                                    <p class="mb-0"><i class="fa fa-info-circle"></i> Service Fee: {{ $meta['service_fee_percent'] ?? 0 }}% + ₹{{ number_format($meta['service_fee_fixed'] ?? 0,2) }}</p>

                                                @elseif($item->item_type === 'tour')
                                                    <p class="mb-1"><i class="fa fa-users"></i> Adults: {{ $meta['adults'] ?? 0 }}, Children: {{ $meta['children'] ?? 0 }}</p>
                                                    <p class="mb-1"><i class="fa fa-calendar"></i> Duration: {{ $meta['duration_days'] ?? '-' }} days, {{ $meta['duration_nights'] ?? '-' }} nights</p>
                                                    <p class="mb-0"><i class="fa fa-info-circle"></i> Service Fee: {{ $meta['service_fee_percent'] ?? 0 }}% + ₹{{ number_format($meta['service_fee_fixed'] ?? 0,2) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary">{{ $totalPassengers }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="price">₹{{ number_format($item->unit_price,2) }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="price font-weight-bold">₹{{ number_format($item->total_price,2) }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?')">
                                            <i class="fa fa-trash"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="4" class="text-right align-middle"><h4 class="mb-0">Grand Total:</h4></td>
                                <td colspan="2" class="text-center align-middle"><h3 class="mb-0 text-primary">₹{{ number_format($grandTotal,2) }}</h3></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('checkout.show') }}" class="btn btn-primary px-4 py-3">
                            <i class="fa fa-credit-card"></i> Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.cart-table .table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
}
.product-name h3 {
    font-size: 18px;
    margin-bottom: 5px;
}
.product-details p {
    font-size: 13px;
    color: #666;
}
.price {
    font-size: 16px;
    font-weight: 600;
}
.badge {
    font-size: 11px;
    padding: 5px 8px;
}
</style>
@endpush
