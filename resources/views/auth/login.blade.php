@extends('layouts.app1')

@section('title', 'Login')

@section('content')


<!-- Login Form Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap ftco-animate">
                    <div class="login-form">
                        <div class="text-center mb-4">
                            <h3 class="mb-3">Welcome Back!</h3>
                            <p class="text-muted">Sign in to your account to continue</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="signin-form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fa fa-envelope text-primary"></i> Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter your email"
                                    required
                                    autocomplete="email"
                                >
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fa fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fa fa-lock text-primary"></i> Password
                                </label>
                                <div class="input-group">
                                    <input 
                                        type="password" 
                                        id="password"
                                        name="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Enter your password"
                                        required
                                        autocomplete="current-password"
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        <i class="fa fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-primary">Forgot Password?</a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fa fa-sign-in-alt"></i> Login to Account
                                </button>
                            </div>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center mt-4">
                            <p class="mb-0">
                                Don't have an account? 
                                <a href="{{ route('register.form') }}" class="text-primary font-weight-bold">
                                    Create Account
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-5">
                    <h3>Why Choose TravelEsy?</h3>
                    <p class="text-muted">Join thousands of happy travelers</p>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="flaticon-route" style="font-size: 48px; color: #007bff;"></span>
                        </div>
                        <h5>Best Prices</h5>
                        <p>Get exclusive deals and instant confirmation for all bookings</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-shield" style="font-size: 48px; color: #28a745;"></span>
                        </div>
                        <h5>Secure Booking</h5>
                        <p>Your personal and payment information is always protected</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <span class="fa fa-headphones" style="font-size: 48px; color: #ffc107;"></span>
                        </div>
                        <h5>24/7 Support</h5>
                        <p>Round the clock customer service for all your travel needs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.login-wrap {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
}
.signin-form .form-group {
    margin-bottom: 25px;
}
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
}
.form-control {
    height: 50px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}
.form-control.is-invalid {
    border-color: #dc3545;
}
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}
.btn-lg {
    height: 50px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-1px);
}
.custom-control-label {
    font-size: 14px;
    color: #666;
}
.divider {
    position: relative;
    text-align: center;
    margin: 20px 0;
}
.divider:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9ecef;
}
.divider span {
    background: white;
    padding: 0 20px;
    color: #999;
    font-size: 14px;
}
.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
}
.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
}
.btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
}
.btn-outline-primary:hover {
    background: #007bff;
    border-color: #007bff;
}
.input-group-text {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-left: none;
}
@media (max-width: 768px) {
    .login-wrap {
        padding: 30px 20px;
        margin: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Password toggle functionality
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const passwordFieldType = passwordField.attr('type');
        const icon = $(this).find('i');
        
        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Form validation feedback
    $('.form-control').on('blur', function() {
        if ($(this).val().trim() === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    // Social login placeholders (you can implement actual functionality)
    $('.btn-outline-danger, .btn-outline-primary').click(function(e) {
        e.preventDefault();
        alert('Social login functionality would be implemented here');
    });
});
</script>
@endpush
