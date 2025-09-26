@extends('layouts.profile')

@section('title','My Orders')

@section('profile-content')
<div class="ftco-animate">
    <div class="heading-section mb-5">
        <h2 class="mb-4">My Orders</h2>
        <p>Track and manage all your travel bookings</p>
    </div>

    @if(count($orders) === 0)
    <div class="text-center p-5">
        <div class="icon mb-4">
            <span class="flaticon-route" style="font-size: 72px; opacity: 0.3;"></span>
        </div>
        <h3 class="mb-4">No Orders Found</h3>
        <p class="mb-4 text-muted">You haven't placed any orders yet. Start planning your perfect trip!</p>
        <a href="{{ route('home') }}" class="btn btn-primary px-4 py-3">
            <i class="fa fa-search"></i> Explore Destinations
        </a>
    </div>
    @else
    <div class="orders-section">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-primary">
                    <tr class="text-center">
                        <th><i class="fa fa-hashtag"></i> Order ID</th>
                        <th><i class="fa fa-calendar"></i> Date</th>
                        <th><i class="fa fa-rupee"></i> Total</th>
                        <th><i class="fa fa-info-circle"></i> Status</th>
                        <th><i class="fa fa-eye"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="text-center">
                        <td class="align-middle">
                            <strong class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                        </td>
                        <td class="align-middle">
                            <div class="order-date">
                                <div class="date">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</small>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="price font-weight-bold">₹{{ number_format($order->final_total,2) }}</span>
                        </td>
                        <td class="align-middle">
                            @php
                                $statusClass = '';
                                $statusIcon = '';
                                switch(strtolower($order->status)) {
                                    case 'pending':
                                        $statusClass = 'badge-warning';
                                        $statusIcon = 'fa-clock-o';
                                        break;
                                    case 'confirmed':
                                        $statusClass = 'badge-success';
                                        $statusIcon = 'fa-check-circle';
                                        break;
                                    case 'cancelled':
                                        $statusClass = 'badge-danger';
                                        $statusIcon = 'fa-times-circle';
                                        break;
                                    case 'completed':
                                        $statusClass = 'badge-info';
                                        $statusIcon = 'fa-flag-checkered';
                                        break;
                                    default:
                                        $statusClass = 'badge-secondary';
                                        $statusIcon = 'fa-info';
                                }
                            @endphp
                            <span class="badge {{ $statusClass }} p-2">
                                <i class="fa {{ $statusIcon }}"></i> {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('profile.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Quick Actions -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Need Help with Your Orders?</h5>
                        <p class="card-text text-muted">Our customer support team is here to assist you with any questions about your bookings.</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-outline-primary mr-2">
                                <i class="fa fa-phone"></i> Contact Support
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Book New Trip
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.orders-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.heading-section h2 {
    color: #333;
    border-bottom: 3px solid #007bff;
    padding-bottom: 10px;
    display: inline-block;
}
.table th {
    background: #007bff;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
    border: none;
}
.table td {
    vertical-align: middle;
    padding: 15px 8px;
}
.order-id {
    color: #007bff;
    font-family: 'Courier New', monospace;
}
.order-date .date {
    font-weight: 600;
    color: #333;
}
.price {
    font-size: 16px;
    color: #28a745;
}
.badge {
    font-size: 11px;
    padding: 8px 12px;
    border-radius: 20px;
}
.badge-warning {
    background-color: #ffc107;
    color: #000;
}
.badge-success {
    background-color: #28a745;
}
.badge-danger {
    background-color: #dc3545;
}
.badge-info {
    background-color: #17a2b8;
}
.badge-secondary {
    background-color: #6c757d;
}
.btn-sm {
    padding: 8px 16px;
    font-size: 12px;
}
.card {
    border: 2px solid #f8f9fa;
    border-radius: 10px;
}
.card-body {
    padding: 30px;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
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

@push('scripts')
<script>
$(document).ready(function() {
    // Add hover effect to order rows
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Tooltip for status badges
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
