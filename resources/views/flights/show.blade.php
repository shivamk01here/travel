@extends('layouts.app1')

@section('content')
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">{{ $flight->airline }} ({{ $flight->flight_number }})</h2>

    <p class="mb-2">{{ $flight->source_name }} → {{ $flight->destination_name }}</p>
    <p class="mb-2">Departure: {{ date('d M Y, H:i', strtotime($flight->departure_time)) }}</p>
    <p class="mb-2">Arrival: {{ date('d M Y, H:i', strtotime($flight->arrival_time)) }}</p>
    <p class="mb-2">Duration: {{ $flight->duration }}</p>
    <p class="mb-2">Stops: {{ $flight->stops }}</p>
    <p class="text-xl font-bold text-blue-600 mb-4">Price: ${{ $flight->price }}</p>

    @if($details)
    <div class="mb-6">
        <h3 class="text-lg font-semibold">Flight Details</h3>
        <p>Baggage Policy: {{ $details->baggage_policy }}</p>
        <p>Cabin Class: {{ $details->cabin_class }}</p>
        <p>Fare Rules: {{ $details->fare_rules }}</p>
    </div>
    @endif

    {{-- Add to Cart Form --}}
    <form action="{{ route('cart.addFlight') }}" method="POST" class="bg-gray-100 p-4 rounded">
        @csrf
        <input type="hidden" name="flight_id" value="{{ $flight->id }}">

        <div class="mb-2">
            <label class="block font-semibold">Adults <span class="text-red-500">*</span></label>
            <input type="number" name="adults" value="1" min="1" class="border p-2 rounded w-24">
        </div>

        <div class="mb-2">
            <label class="block font-semibold">Children</label>
            <input type="number" name="children" value="0" min="0" class="border p-2 rounded w-24">
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded mt-2 hover:bg-green-700">
            Add to Cart
        </button>
    </form>
</div>
@endsection
