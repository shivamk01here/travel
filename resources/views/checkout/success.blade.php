@extends('layouts.app')

@section('title','Order Success')

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
                    <span class="mr-2">
                        <a href="{{ route('cart.show') }}">Cart <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span>Order Success <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Order Confirmed</h1>
            </div>
        </div>
    </div>
</section>

<!-- Success Message -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center ftco-animate">
                <div class="success-message mb-5 p-5 bg-light rounded">
                    <div class="success-icon mb-4">
                        <span class="fa fa-check-circle" style="font-size: 80px; color: #28a745;"></span>
                    </div>
                    <h2 class="text-success mb-3">Order Placed Successfully!</h2>
                    <p class="lead text-muted">Thank you for your booking. Your order has been confirmed and you will receive a confirmation email shortly.</p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <h3 class="billing-heading mb-4 text-center">
                    <i class="fa fa-list-alt"></i> Order Summary
                </h3>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th><i class="fa fa-tag"></i> Item</th>
                                <th><i class="fa fa-info-circle"></i> Details</th>
                                <th><i class="fa fa-money"></i> Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                @php $meta = json_decode($item->meta, true) ?? []; @endphp
                                <tr>
                                    <td class="align-middle">
                                        <div class="product-name">
                                            <h4 class="mb-1">{{ $item->display_name ?? $item->name }}</h4>
                                            <span class="badge badge-primary">{{ ucfirst($item->item_type ?? 'Item') }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="product-details">
                                            @foreach($meta as $key=>$val)
                                                @if(!empty($val))
                                                <div class="detail-item mb-1">
                                                    <strong>{{ ucfirst(str_replace('_',' ',$key)) }}:</strong> 
                                                    <span class="text-muted">{{ $val }}</span>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="price h5 text-primary mb-0">₹{{ number_format($item->total_price,2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                
            </div>
        </div>

        <!-- Next Steps -->
        <div class="row mt-5">
            <div class="col-md-4 text-center ftco-animate">
                <div class="icon mb-3">
                    <span class="fa fa-envelope" style="font-size: 48px; color: #007bff;"></span>
                </div>
                <h5>Check Your Email</h5>
                <p>A confirmation email has been sent to your registered email address with all booking details.</p>
            </div>
            <div class="col-md-4 text-center ftco-animate">
                <div class="icon mb-3">
                    <span class="fa fa-clock-o" style="font-size: 48px; color: #28a745;"></span>
                </div>
                <h5>Processing Time</h5>
                <p>Your booking will be processed within 24 hours. You'll receive updates on your booking status.</p>
            </div>
            <div class="col-md-4 text-center ftco-animate">
                <div class="icon mb-3">
                    <span class="fa fa-phone" style="font-size: 48px; color: #ffc107;"></span>
                </div>
                <h5>Need Help?</h5>
                <p>Our support team is available 24/7 to assist you with any questions about your booking.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-5">
            <div class="col-md-12 text-center ftco-animate">
                <div class="action-buttons">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mr-3 px-4 py-3">
                        <i class="fa fa-home"></i> Continue Browsing
                    </a>
                    <a href="{{ url('/profile/orders') }}" class="btn btn-outline-primary btn-lg px-4 py-3">
                        <i class="fa fa-list"></i> View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="ftco-intro ftco-section ftco-no-pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div class="img" style="background-image: url({{ asset('images/bg_2.jpg') }});">
                    <div class="overlay"></div>
                    <h2>Have Questions About Your Booking?</h2>
                    <p>Our travel experts are here to help you with any queries or special requests</p>
                    <p class="mb-0">
                        <a href="#" class="btn btn-primary px-4 py-3">
                            <i class="fa fa-phone"></i> Contact Support
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.success-message {
    border: 3px solid #28a745;
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
}
.success-icon {
    animation: bounce 2s infinite;
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
.billing-heading {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    border-bottom: 3px solid #007bff;
    padding-bottom: 15px;
    margin-bottom: 30px;
    display: inline-block;
}
.product-name h4 {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}
.product-details .detail-item {
    font-size: 14px;
    border-bottom: 1px dashed #eee;
    padding: 3px 0;
}
.product-details .detail-item:last-child {
    border-bottom: none;
}
.price {
    font-size: 20px;
    font-weight: 700;
}
.cart-total {
    background: linear-gradient(135deg, #007bff, #0056b3) !important;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}
.action-buttons .btn {
    margin: 10px;
    min-width: 200px;
}
.icon {
    margin-bottom: 20px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add a subtle fade-in animation
    $('.ftco-animate').each(function(index) {
        $(this).delay(200 * index).animate({opacity: 1}, 500);
    });
    
    // Auto-scroll to success message
    $('html, body').animate({
        scrollTop: $('.success-message').offset().top - 100
    }, 1000);
});
</script>
@endpush
