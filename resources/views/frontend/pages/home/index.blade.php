@extends('frontend.app')
@section('content')
    <div class="main-content">
        <!-- hero section -->
        <div class="hero-wrapper">
            <div class="container-fluid">
                <div class="heroContainer d-flex gap-4 align-items-center">
                    <div class="content">
                        <h1 class="fw-700 font-56">Everything You Need in One App.</h1>
                        <h6 class="font-18 fw-600 mt-4">
                            Access all your favorite features and tools in one easy app,
                            making
                            life
                            simpler and more efficient.
                        </h6>
                        <div class="app-download d-flex gap-3 ">
                            <a href="#">
                                <img src="{{ asset('frontend/assets/images/google.svg') }}" alt="" class="w-auto">
                            </a>
                            <a href="#">
                                <img src="{{ asset('frontend/assets/images/apple.svg') }}" alt="" class="w-auto">
                            </a>
                        </div>
                    </div>
                    <div class="image d-flex justify-content-center align-items-center">
                        <img src="{{ asset('frontend/assets/images/hero_bannar.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section -->

        <!-- services section -->
        <div class="service-wrapper mt-80">
            <div class="container-fluid">
                <div class="serviceContainer">
                    <div class="section-header d-flex flex-column align-items-center gap-2">
                        <h1 class="section-title fw-600">Our Services</h1>
                        <p class="section-subtitle font-16">
                            Manage all your needs effortlessly with one seamless
                            platform.
                        </p>
                    </div>
                    <div class="section-content mt-5">
                        <div class="servicess">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Shop</h6>
                                            <p class="font-16">Shop easily and get fast, secure delivery.</p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_shop.svg') }}" alt=""
                                                class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Courier</h6>
                                            <p class="font-16">Fast and reliable deliveries for your business needs.
                                            </p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_courier.svg') }}"
                                                alt="" class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Parcel</h6>
                                            <p class="font-16">Send packages across the city,
                                                fast and secure.</p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_parcel.svg') }}"
                                                alt="" class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Ride</h6>
                                            <p class="font-16">Quick rides at your fingertips, anytime you need.</p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_ride.svg') }}" alt=""
                                                class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Food</h6>
                                            <p class="font-16">Enjoy hot and fresh meals delivered to your door.</p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_food.svg') }}" alt=""
                                                class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service d-flex align-items-center gap-3">
                                        <div class="content d-flex flex-column gap-2">
                                            <h6 class="fw-600 font-18">Rental</h6>
                                            <p class="font-16">Affordable rentals for any occasion, quick and easy.
                                            </p>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/icon/sr_rent.svg') }}" alt=""
                                                class="w-auto h-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- services section -->

        <!-- About Us section -->
        <div class="about-wrapper mt-120">
            <div class="container-fluid">
                <div class="aboutContainer">
                    <div class="section-content">
                        <div class="about-us d-flex gap-5 align-items-center">
                            <div class="content d-flex flex-column ">
                                <div class="section-header d-flex flex-column  gap-4">
                                    <h1 class="section-title fw-600">About Us</h1>
                                    <p class="section-subtitle font-16">At Packly, we offer a range of on-demand
                                        services,
                                        from rides to food delivery, parcel handling, and more. Our mission is to
                                        provide fast,
                                        reliable solutions that make your life simpler and more convenient.
                                    </p>
                                </div>
                                <a href="#" style="width: fit-content;"
                                    class="btn btn-primary btn-ex-sm mt-4 d-flex align-items-center justify-content-center">
                                    Read More
                                </a>
                            </div>
                            <div class="image">
                                <img src="{{ asset('frontend/assets/images/about_img.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About Us section -->

        <!-- Social Impact section -->
        <div class="socail-wrapper mt-120">
            <div class="container-fluid">
                <div class="socialContainer">
                    <div class="section-content">
                        <div class="social-impact ">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <div class="image d-flex flex-column">
                                        <div class="grid-one d-flex gap-4">
                                            <div class="social-img-one">
                                                <img src="{{ asset('frontend/assets/images/scl_img_1.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="social-img-two">
                                                <img src="{{ asset('frontend/assets/images/scl_img_2.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="grid-two d-flex">
                                            <div
                                                class="social-live-impact d-flex align-items-center justify-content-center flex-column gap-2 ">
                                                <h1 class="fw-700 text-white">10k+</h1>
                                                <h5 class="fw-700 text-white text-center">Lives impacted</h5>
                                            </div>
                                            <div class="shap">
                                                <img src="{{ asset('frontend/assets/images/shape_1.svg') }}"
                                                    class="w-auto h-auto" alt="">
                                            </div>
                                            <div class="social-img-three">
                                                <img src="{{ asset('frontend/assets/images/scl_img_3.svg') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="content d-flex flex-column ">
                                        <div class="section-header d-flex flex-column  gap-4">
                                            <h1 class="section-title fw-600">Our Social Impact</h1>
                                            <p class="section-subtitle font-16">We are committed to driving
                                                positive social and
                                                economic change in the region. Through our platform, we connect
                                                customers with
                                                communities in need, helping to create opportunities and foster
                                                growth where it
                                                matters
                                                most.
                                            </p>

                                        </div>
                                        <a href="#" style="width: fit-content;"
                                            class="btn btn-primary btn-ex-sm mt-4 d-flex align-items-center justify-content-center">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Social Impact section -->

        <!-- Social Impact section -->
        <div class="bannar-wrapper mt-120">
            <div class="container-fluid">
                <div class="bannerContainer">
                    <div class="section-content d-flex align-items-center">
                        <div class="content d-flex flex-column gap-3 ">
                            <div class="section-header d-flex flex-column  gap-4">
                                <h1 class="section-title fw-600 font-48">Download Our App</h1>
                                <p class="section-subtitle font-16">
                                    Get started today! Download our app for easy access to
                                    all our services, right at your fingertips.
                                </p>
                            </div>
                            <div class="app-download d-flex gap-3 mt-4 ">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/google.svg') }}" alt=""
                                        class="w-auto">
                                </a>
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/apple.svg') }}" alt=""
                                        class="w-auto">
                                </a>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/banar_img.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Social Impact section -->
    @endsection
