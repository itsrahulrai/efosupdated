@extends('frontend.layout.layout')
@section('title', 'Thank You | EFOS Edumarketers Pvt Ltd')
@section('meta_description', 'Thank you for contacting EFOS Edumarketers. We will get back to you shortly.')
@section('meta_keywords', 'thank you, contact submitted, efos edumarketers')
@section('meta_robots', 'noindex, nofollow')
@section('canonical', url()->current())

@section('og_title', 'Thank You | EFOS Edumarketers Pvt Ltd')
@section('og_description', 'Your message has been sent successfully. Our team will contact you soon.')

@section('content')

    <main>

        <!-- Banner -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content text-center">
                    <h1>Thank You</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Thank You</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Thank You Content -->
        <section class="pt-80 pb-100">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                            <!-- Success Header -->
                            <div class="text-center p-5 bg-light">
                                <i class="fa-solid fa-circle-check text-success mb-3" style="font-size:70px;"></i>
                                <h2 class="fw-bold mb-2">Payment Successful</h2>
                                <p class="text-muted mb-0">
                                    Your course purchase has been confirmed.
                                </p>
                            </div>

                            <div class="p-5">

                                <div class="row g-5">

                                    <!-- Course Info -->
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-4">Course Details</h5>

                                        <div class="d-flex mb-3">
                                            <img src="{{ static_asset($courseBuy->course->thumbnail) }}" width="90"
                                                class="rounded me-3" alt="Course Image">
                                            <div>
                                                <h6 class="fw-semibold mb-1">
                                                    {{ $courseBuy->course->title }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $courseBuy->course->language }} • {{ $courseBuy->course->duration }}
                                                </small>
                                            </div>
                                        </div>

                                        <p class="mb-0">
                                            <strong>Purchase Date:</strong>
                                            {{ $courseBuy->purchased_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>

                                    <!-- Payment Info -->
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-4">Payment Summary</h5>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Course Price</span>
                                            <span>₹ {{ number_format($courseBuy->course->price, 2) }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Discount</span>
                                            <span class="text-success">
                                                - ₹ {{ number_format($courseBuy->discount_amount, 2) }}
                                            </span>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between mb-3">
                                            <strong>Total Paid</strong>
                                            <strong class="text-success fs-5">
                                                ₹ {{ number_format($courseBuy->amount, 2) }}
                                            </strong>
                                        </div>

                                        <div class="bg-light p-3 rounded">
                                            <small>
                                                <strong>Transaction ID:</strong>
                                                {{ $courseBuy->transaction_id }}
                                            </small><br>
                                            <small>
                                                <strong>Payment Method:</strong>
                                                {{ ucfirst($courseBuy->payment_gateway) }}
                                            </small>
                                        </div>

                                    </div>

                                </div>

                                <!-- Buttons -->
                                <div class="text-center mt-5">
                                    <a href="{{ route('student.dashboard') }}" class="btn-one me-2">
                                        Go to Dashboard
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

@endsection
