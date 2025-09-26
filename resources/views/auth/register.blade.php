@extends('layouts.app1')

@section('title', 'Register')

@section('content')
<div class="d-flex align-items-center justify-content-center px-2" style="min-height:100vh; background:#f7fafc;">
    <div class="card shadow border-0 px-5 py-4 mx-auto" style="min-width:364px;max-width:540px;width:100%;border-radius:22px;">
        <h2 class="text-center mb-3" style="font-weight:800;font-size:2rem;letter-spacing:.5px;">
            Create Your Account
        </h2>
        <p class="text-center text-muted mb-4" style="font-size:16px;">
            Welcome! Please fill in your basic information below.
        </p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row mb-3">
                <div class="col pr-md-2">
                    <label for="name" class="mb-1" style="font-weight:500;">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Jane Smith"
                        required
                        autofocus
                        style="height:50px;"
                    >
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col pl-md-2">
                    <label for="email" class="mb-1" style="font-weight:500;">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="you@email.com"
                        required
                        style="height:50px;"
                    >
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="mb-1" style="font-weight:500;">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password"
                    required
                    autocomplete="new-password"
                    minlength="8"
                    style="height:50px;"
                >
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation" class="mb-1" style="font-weight:500;">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Retype password"
                    required
                    autocomplete="new-password"
                    minlength="8"
                    style="height:50px;"
                >
            </div>

            <button type="submit"
                class="btn btn-primary btn-block font-weight-bold"
                style="padding:14px 0; font-size:18px; border-radius:14px;">
                Register
            </button>
        </form>
        <div class="text-center mt-4" style="font-size:16px;">
            Already have an account?
            <a href="{{ route('login.form') }}" class="text-primary font-weight-bold">Login</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    background: #fff !important;
    border-radius: 22px !important;
    box-shadow: 0 6px 32px 0 #2223a50c;
}
.form-control, .btn {
    border-radius: 12px;
    font-size: 17px;
}
.form-control:focus {
    box-shadow: 0 0 0 2px #b8bffc22;
    border-color: #4a56e2;
}
.btn-primary {
    background: linear-gradient(135deg, #3748b7 0%, #3a465a 100%);
    border: none;
}
.btn-primary:hover, .btn-primary:focus {
    background: #222b44;
}
@media (max-width: 740px) {
    .card {
        max-width: 99vw !important;
        min-width: unset !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
    }
    .form-row {
        display: block;
    }
    .form-row .col, .form-row .col.pr-md-2, .form-row .col.pl-md-2 {
        width: 100% !important;
        padding-right: 0 !important;
        padding-left: 0 !important;
        margin-bottom: 1rem;
    }
}
</style>
@endpush
