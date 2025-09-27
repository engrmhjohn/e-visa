@extends('frontend.master')
@section('title', 'E-Visa | Home')
@section('content')
<!-- Hero Section -->
<section id="hero" class="hero section">

    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-delay="100">
                <div class="content-wrapper">
                    <h1 class="hero-title">Why e-Visa?</h1>
                    <p class="lead">We process your e-Visa application with efficency and accurancy The visitors receive complete access to e-visa service and grants them 24/7 access.</p>
                </div>
                <ul>
                    <li>Instant approval for all countries (see below)</li>
                    <li>Secure and efficent application submission</li>
                    <li>24/7 fast online application & simplified forms</li>
                    <li>Visas for tourism, business, study & transit</li>
                    <li> User friendly and eco friendly (paper less)</li>
                </ul>
            </div>

            <div class="col-lg-6 hero-image" data-aos="fade-left" data-aos-delay="200">
                <div class="image-container">
                    <div class="floating-elements">
                        <div class="floating-card card-1" data-aos="zoom-in" data-aos-delay="300">
                            <span>Apply Now</span>
                        </div>
                        <div class="floating-card card-2" data-aos="zoom-in" data-aos-delay="400">
                            <span>See Result</span>
                        </div>
                        <div class="floating-card card-3" data-aos="zoom-in" data-aos-delay="500">
                            <span>Make Payment</span>
                        </div>
                    </div>
                    <img src="{{ asset('frontendAssets') }}/img/passport2.png" alt="Portfolio Hero" class="img-fluid hero-main-image">
                    <div class="image-overlay"></div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-3 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold">Step 01</h6>
                    </div>
                    <div class="card-body">
                    <img src="{{ asset('frontendAssets') }}/img/apply.png" alt="Apply Now" style="max-width: 100px" height="auto">
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary btn-sm" href="">Apply Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold">Step 02</h6>
                    </div>
                    <div class="card-body">
                    <img src="{{ asset('frontendAssets') }}/img/payment.png" alt="Make Payment" style="max-width: 100px" height="auto">
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary btn-sm" href="">Make Payment</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card text-center">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold">Step 03</h6>
                    </div>
                    <div class="card-body">
                    <img src="{{ asset('frontendAssets') }}/img/result.png" alt="See Result" style="max-width: 100px" height="auto">
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary btn-sm" href="">See Result</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section><!-- /Hero Section -->
@endsection
