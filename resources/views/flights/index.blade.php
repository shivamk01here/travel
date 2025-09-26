@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Flights from {{ $src->name }} to {{ $dest->name }}</h2>

    <div class="grid grid-cols-1 gap-6">
        @foreach($flights as $flight)
        <div class="bg-white rounded shadow p-4 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg">{{ $flight->airline }} ({{ $flight->flight_number }})</h3>
                <p class="text-gray-600">{{ $flight->source_name }} → {{ $flight->destination_name }}</p>
                <p class="text-sm">{{ date('H:i', strtotime($flight->departure_time)) }} → {{ date('H:i', strtotime($flight->arrival_time)) }} ({{ $flight->duration }})</p>
                <p class="text-sm">Stops: {{ $flight->stops }}</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold text-blue-600">${{ $flight->price }}</p>
                <a href="{{ route('flights.show', $flight->id) }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">View</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
