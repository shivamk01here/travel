@extends('layouts.app1')

@section('title','Checkout')

@section('content')

<section class="hero-wrap hero-wrap-2" style="height: 220px; background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center center; position: relative;">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    
    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row h-100 justify-content-center align-items-center text-center">
            <div class="col-md-9">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                <span class="mr-2">
                        <a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span class="mr-2">
                        <a href="{{ route('cart.show') }}">Cart <i class="fa fa-chevron-right"></i></a>
                    </span> 
                    <span>Checkout <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Checkout</h1>       
            </div>
        </div>
    </div>
</section>

<!-- Checkout Content -->
<section class="ftco-section">
    <div class="container">
        @if(count($items) === 0)
        <div class="row">
            <div class="col-md-12 text-center ftco-animate">
                <div class="p-5">
                    <div class="icon mb-4">
                        <span class="flaticon-route" style="font-size: 72px; opacity: 0.3;"></span>
                    </div>
                    <h3 class="mb-4">Your cart is empty</h3>
                    <p class="mb-4">Please add items to your cart before checkout.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-3">Start Booking</a>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <!-- LEFT: Cart Summary -->
            <div class="col-lg-7 ftco-animate">
                <div class="cart-list">
                    <h3 class="billing-heading mb-4">Cart Summary</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Item</th>
                                    <th>Details</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    @php $meta = $item->meta; @endphp
                                    <tr>
                                        <td class="align-middle">
                                            <div class="product-name">
                                                <h3>{{ $item->display_name ?? $item->name }}</h3>
                                                <span class="badge badge-primary">{{ ucfirst($item->item_type) }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="product-details">
                                                @foreach($meta as $key=>$val)
                                                    @if(!empty($val))
                                                    <div class="detail-item">
                                                        <strong>{{ ucfirst(str_replace('_',' ',$key)) }}:</strong> {{ $val }}
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="price font-weight-bold">₹{{ number_format($item->total_price,2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="2" class="text-right align-middle">
                                        <h4 class="mb-0">Grand Total:</h4>
                                    </td>
                                    <td class="text-center align-middle">
                                        <h3 class="mb-0 text-primary">₹{{ number_format($grandTotal,2) }}</h3>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Coupon Section -->
                    <div class="coupon-section mt-4 p-4 bg-light rounded">
                        <h5 class="mb-3"><i class="fa fa-tag"></i> Have a Coupon Code?</h5>
                        <form method="POST" class="row">
                            @csrf
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="coupon" class="form-control" placeholder="Enter coupon code">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-check"></i> Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Checkout Form -->
            <div class="col-lg-5 ftco-animate">
                <div class="cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Billing Details</h3>
                        <form method="POST" action="{{ route('checkout.process') }}" class="billing-form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                        <div class="select-wrap">
                                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                            <select id="payment_method" name="payment_method" class="form-control" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="cod">Cash on Delivery</option>
                                                <option value="online">Online Payment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary Box -->
                            <div class="order-summary mt-4 p-3 bg-primary text-white rounded">
                                <h5 class="mb-3"><i class="fa fa-shopping-cart"></i> Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Items ({{ count($items) }})</span>
                                    <span>₹{{ number_format($grandTotal,2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Service Fee</span>
                                    <span>₹0.00</span>
                                </div>
                                <hr class="bg-white">
                                <div class="d-flex justify-content-between">
                                    <strong>Total Amount</strong>
                                    <strong>₹{{ number_format($grandTotal,2) }}</strong>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success btn-lg btn-block py-3">
                                    <i class="fa fa-credit-card"></i> Place Order - ₹{{ number_format($grandTotal,2) }}
                                </button>
                            </div>

                            <!-- Security Info -->
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fa fa-lock"></i> Your personal data is secure and protected
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Security Section -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="flaticon-route" style="font-size: 48px; color: #007bff;"></span>
                        </div>
                        <h5>Secure Booking</h5>
                        <p>Your booking and payment information is protected with SSL encryption.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-shield" style="font-size: 48px; color: #28a745;"></span>
                        </div>
                        <h5>Trusted Service</h5>
                        <p>We are a trusted travel agency with thousands of satisfied customers.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-headphones" style="font-size: 48px; color: #ffc107;"></span>
                        </div>
                        <h5>24/7 Support</h5>
                        <p>Our customer support team is available round the clock to assist you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.billing-heading {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}
.product-name h3 {
    font-size: 16px;
    margin-bottom: 5px;
}
.product-details .detail-item {
    font-size: 13px;
    color: #666;
    margin-bottom: 3px;
}
.price {
    font-size: 18px;
    color: #007bff;
}
.coupon-section {
    border: 2px dashed #007bff;
}
.cart-wrap {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
}
.billing-form .form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}
.order-summary {
    background: linear-gradient(135deg, #007bff, #0056b3) !important;
}
.select-wrap {
    position: relative;
}
.select-wrap .icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    z-index: 10;
}
.select-wrap select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Payment method change handler
    $('#payment_method').change(function() {
        var method = $(this).val();
        if (method === 'online') {
            $('.btn-success').html('<i class="fa fa-credit-card"></i> Pay Online - ₹{{ number_format($grandTotal,2) }}');
        } else if (method === 'cod') {
            $('.btn-success').html('<i class="fa fa-money"></i> Place Order (COD) - ₹{{ number_format($grandTotal,2) }}');
        }
    });

    // Form validation
    $('.billing-form').on('submit', function(e) {
        var paymentMethod = $('#payment_method').val();
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            $('#payment_method').focus();
        }
    });
});
</script>
@endpush
