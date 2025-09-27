@extends('frontend.master')
@section('title', 'Register | E-Visa')
@section('content')
<!-- Contact Section -->
@php
$countries = App\Models\Country::select('id', 'name')->orderBy('name', 'asc')->get();
@endphp
<section class="contact section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 g-lg-5 d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="fw-bold">Create your e-Visa account</h3>
                    <form action="{{ route('register') }}" method="post" data-aos="fade-up" data-aos-delay="300">
                        @csrf
                        <div class="row gy-4">
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
                            <h6 class="fw-bold">Personal Information</h6>
                            <div class="col-lg-6">
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Your First Name" required="">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Your Last Name" required="">
                            </div>
                            <div class="col-lg-12">
                                <label for="nationality" class="form-label required-field">Select Nationality</label>
                                <select id="nationality" name="nationality" class="select2 form-control" required="">
                                    <option value="">--Choose One--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('nationality') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h6 class="fw-bold">Login Information</h6>
                            <div class="col-lg-12">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Your Email" required="">
                            </div>

                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="">
                            </div>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat Password" required="">
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <strong>Already have an account?</strong> <a href="{{ route('login') }}">Login Now</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn">Register</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Contact Section -->
@endsection
