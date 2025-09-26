@extends('layouts.profile')

@section('title','My Orders')

@section('profile-content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Order #{{ $order->id }}</h1>

    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y H:i') }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    @if($order->coupon)
        <p><strong>Coupon:</strong> {{ $order->coupon }}</p>
    @endif

    <h2 class="text-xl font-semibold mt-6 mb-2">Items</h2>
    <table class="w-full border-collapse border mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Item</th>
                <th class="border p-2">Details</th>
                <th class="border p-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @php $meta = $item->meta; @endphp
                <tr>
                    <td class="border p-2">{{ $item->name }}</td>
                    <td class="border p-2">
                        @foreach($meta as $key=>$val)
                            <div>{{ ucfirst(str_replace('_',' ',$key)) }}: {{ $val }}</div>
                        @endforeach
                    </td>
                    <td class="border p-2">₹{{ number_format($item->total_price,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right font-bold">
        <div>Total: ₹{{ number_format($order->total,2) }}</div>
        <div>Discount: ₹{{ number_format($order->discount,2) }}</div>
        <div>Final Amount: ₹{{ number_format($order->final_total,2) }}</div>
    </div>

    <a href="{{ route('profile.orders') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 inline-block">Back to Orders</a>
</div>
@endsection
