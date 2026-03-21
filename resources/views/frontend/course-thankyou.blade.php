@extends('frontend.layout.layout')
@section('title', ' Payment Successful | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@push('style')
@endpush
@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Payment Successful
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Payment Successful</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Discount area start here -->
        <section class="py-5">
            <div class="container text-center">

                <div style="background:#fff;border-radius:20px;padding:50px;box-shadow:0 10px 40px rgba(0,0,0,0.08);">

                    <div style="font-size:70px;color:#10b981;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <h2 class="fw-bold mt-3">Payment Successful 🎉</h2>

                    <p class="text-muted mt-3">
                        Thank you for purchasing
                        <strong>{{ $course->title }}</strong>
                    </p>

                    <p class="text-muted">
                        You now have full lifetime access to this course.
                    </p>

                    <a href="{{ route('student.dashboard') }}" class="btn btn-success mt-4 px-4 py-2">
                        Go to Dashboard
                    </a>

                </div>

            </div>
        </section>

    </main>

@endsection

@push('script')
@endpush
