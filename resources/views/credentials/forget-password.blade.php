@extends('frontend.master')
@section('title', 'Login | E-Visa')
@section('content')
<!-- Contact Section -->
<section id="contact" class="contact section light-background mb-5">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 g-lg-5 d-flex justify-content-center">
            <div class="col-lg-5">
                <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="fw-bold">Forget Password?</h3>
                    <p>Enter your registered email address below and we'll send you a link to reset your password.</p>
                    <form action="{{ route('password.email') }}" method="post" data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                @if ($errors->any())
                                <div class="bg-warning p-3 mb-3 rounded">
                                    <div class="error-box">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                @session('status')
                                <div class="bg-success p-3 mb-3 rounded">
                                    <div class="text-white">
                                        {{ $value }}
                                    </div>
                                </div>
                                @endsession
                            </div>


                            <div class="col-md-12 mb-3">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Registered Email" required>
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <strong>Remember Password?</strong> <a href="{{ route('login') }}">Login Now</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section><!-- /Contact Section -->
@endsection
