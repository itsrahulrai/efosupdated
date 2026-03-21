@extends('frontend.layout.layout')
@section('title', 'Thank You | EFOS Edumarketers Pvt Ltd')
@section('meta_description', 'Thank you for your purchase. Your bundle has been activated successfully.')
@section('meta_keywords', 'Bundle purchase, thank you, efos edumarketers')
@section('meta_robots', 'noindex, nofollow')
@section('canonical', url()->current())

@section('og_title', 'Thank You | EFOS Edumarketers Pvt Ltd')
@section('og_description', 'Your bundle purchase has been completed successfully.')

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
                                Your bundle purchase has been confirmed.
                            </p>
                        </div>

                        <div class="p-5">

                            <div class="row g-5">

                                <!-- Bundle Info -->
                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-4">Bundle Details</h5>

                                    <div class="d-flex mb-3">
                                        <img src="{{ static_asset($courseBuy->bundle->thumbnail) }}" width="90"
                                            class="rounded me-3" alt="Bundle Image">
                                        <div>
                                            <h6 class="fw-semibold mb-1">
                                                {{ $courseBuy->bundle->title }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $courseBuy->bundle->courses->count() }} Courses Included
                                            </small>
                                        </div>
                                    </div>

                                    <p class="mb-3">
                                        <strong>Purchase Date:</strong>
                                        {{ optional($courseBuy->purchased_at)->format('d M Y, h:i A') }}
                                    </p>

                                    <!-- Course List -->
                                    <div class="bg-light p-3 rounded">
                                        <strong class="d-block mb-2">Included Courses:</strong>

                                        @foreach($courseBuy->bundle->courses->take(5) as $course)
                                            <div class="small text-dark">
                                                <i class="fa-solid fa-play text-danger me-1"></i>
                                                {{ $course->title }}
                                            </div>
                                        @endforeach

                                        @if($courseBuy->bundle->courses->count() > 5)
                                            <small class="text-muted">
                                                +{{ $courseBuy->bundle->courses->count() - 5 }} more courses
                                            </small>
                                        @endif
                                    </div>

                                </div>

                                <!-- Payment Info -->
                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-4">Payment Summary</h5>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Bundle Price</span>
                                        <span>₹ {{ number_format($courseBuy->bundle->price, 2) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Discount</span>
                                        <span class="text-success">
                                            - ₹ {{ number_format($courseBuy->bundle->price - $courseBuy->amount, 2) }}
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