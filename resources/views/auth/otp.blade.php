@extends('layouts.app')

@section('title', 'OTP Verification')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Enter OTP</h1>
        <p class="text-gray-600 mb-4">Please enter the static OTP (546142) to continue.</p>
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="otp" class="sr-only">OTP</label>
                <input type="text" name="otp" id="otp" placeholder="Enter OTP" required class="text-center mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition duration-300">Verify OTP</button>
        </form>
    </div>
</div>
@endsection