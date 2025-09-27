@extends('frontend.master')
@section('title', 'Login | E-Visa')
@section('content')
<!-- Contact Section -->
<section id="contact" class="contact section light-background mb-3">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 g-lg-5 d-flex justify-content-center">
            <div class="col-lg-5">
                <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="fw-bold">Reset your password</h3>
                    <form action="{{ route('password.update') }}" method="post" data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
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


                            <div class="col-md-12 mb-3">
                                <input type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat Password" required>
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <strong>Back to</strong> <a href="{{ route('/') }}">Home</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section><!-- /Contact Section -->
@endsection
