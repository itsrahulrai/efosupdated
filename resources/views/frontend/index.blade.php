@extends('frontend.layout.layout')
@section('title', 'EFOS - Education Future One Stop | Education, Skills & Career Opportunities for Future-Ready India')
@section('meta_description',
    'EFOS offers expert career guidance, counselling, and skill development support to help
    students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support, hotel management course , diploma course')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@section('content')

    <main>

        <!-- Banner area start here -->
        <section class="banner-area pt-100 pb-100 sub-bg bg-image paralax__animation"
            data-background="{{ static_asset('assets/images/bg/banner-shadow.png') }}">
            <div class="banner__shape1">
                <img src="{{ static_asset('assets/images/shape/banner-shape-left.png') }}" alt="shape">
            </div>
            <div class="banner__shape2">
                <img class="animation__arryUpDown" src="{{ static_asset('assets/images/shape/banner-earth.png') }}"
                    alt="shape">
            </div>
            <div class="banner__shape3">
                <img class="slide-effect1" src="{{ static_asset('assets/images/shape/banner-circle.png') }}" alt="shape">
            </div>
            <div class="banner__shape4">
                <img class="sway__animationX" src="{{ static_asset('assets/images/shape/banner-line.png') }}"
                    alt="shape">
            </div>
            <div class="banner__shape5">
                <img src="{{ static_asset('assets/images/shape/banner-shape-right.png') }}" alt="shape">
            </div>
            <div class="container">
                <div class="banner__content">
                    <h5 class="mb-10 primary-color text-capitalize wow fadeInUp" data-wow-delay="00ms"
                        data-wow-duration="1500ms">Empowering India </h5>
                    <h1 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Trusted & Verified
                        <span class="primary-color">Opportunities FOR ALL</span>
                    </h1>
                    <p class="mt-20 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">Explore Opportunity as
                        per your Career Goal !</p>
                    <a href="{{ route('opportunity-highlights') }}" class="btn-one mt-50 wow fadeInUp"
                        data-wow-delay="600ms" data-wow-duration="1500ms">Explore Opportunities <i
                            class="fa-light fa-arrow-right-long"></i></a>
                            <p></p><a href="https://efos.in/efos-career-assessment-test" class="badge bg-success-subtle text-dark" >Career Assessment Test</a>
                            <p></p>
                            <a href="https://efos.in/efos-buddy" class="badge bg-success-subtle text-dark" >EFOS Buddy - Talk for Career Counselling</a>
                </div>
            </div>
            <div class="banner__hero">
                <div class="banner__info" data-depth="0.03">
                    <img src="{{ static_asset('assets/images/icon/banner-hero-icon.png') }}" alt="icon">
                    <div>
                        <h5 class="fs-28"><span class="count secondary-color">16,533</span>+</h5>
                        <span class="fs-14">SKILLS-BASED EDUCATION</span>
                    </div>
                </div>
                <div class="banner__info info2" data-depth="0.03">
                    <img src="{{ static_asset('assets/images/icon/banner-hero-icon2.png') }}" alt="icon">
                    <div>
                        <h5 class="fs-28"><span class="count secondary-color">100</span>k+</h5>
                        <span class="fs-14">Empowered Candidates </span>
                    </div>
                </div>
                <img src="{{ static_asset('assets/images/icon/download.png') }}" alt="image">
                <img class="hero-shape1" src="{{ static_asset('assets/images/shape/banner-hero-line.png') }}"
                    alt="shape">
                <img class="hero-shape2" src="{{ static_asset('assets/images/shape/banner-hero-shape.png') }}"
                    alt="shape">
                <img class="hero-shape3" src="{{ static_asset('assets/images/shape/banner-hero-circle.png') }}"
                    alt="shape">
                <img class="hero-shape4 sway_Y__animationY"
                    src="{{ static_asset('assets/images/shape/banner-hero-dots.png') }}" alt="shape">
            </div>
        </section>
        <!-- Banner area end here -->

        <!-- Brand area start here -->
        <div class="brand-area pt-60 pb-60 bor-bottom">
            <div class="container">
                <div class="swiper brand__slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/education" target="_blank"><img
                                    src="{{ static_asset('assets/images/icon/eduation.png') }}" width="90px"
                                    alt="Education"> </a>
                        </div>
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/skill-courses" target="_blank"><img
                                    src="{{ static_asset('assets/images/icon/skill-cources.png') }}" width="90px"
                                    alt="Skill Courses"> </a>
                        </div>
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/learn-earn" target="_blank"><img
                                    src="{{ static_asset('assets/images/icon/learn-earn.webp') }}" width="90px"
                                    alt="LearnEarn"> </a>
                        </div>
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/scholarships" target="_blank"><img
                                    src="{{ static_asset('assets/images/icon/schollership.png') }}" width="90px"
                                    alt="Scholarships"> </a>
                        </div>
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/international" target="_blank"><img
                                    src="{{ static_asset('assets/images/icon/international.png') }}" width="90px"
                                    alt="International"> </a>
                        </div>
                        <div class="swiper-slide text-center">
                            <a href="https://efos.in/opportunity-highlights/jobs" target="_blank"> <img
                                    src="{{ static_asset('assets/images/icon/job.png') }}" width="90px"
                                    alt="Jobs">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Brand area end here -->


        <!-- Event area start here -->
        <section class="event-area mb-5 mt-5">

            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-4 flex-wrap mb-60">
                    <div class="section-header">
                        <!--<h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">Conference on-->
                        <!--    Education</h5>-->
                        <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Opportunities <span>
                                Available
                            </span>
                        </h2>
                    </div>
                    <div class="d-flex align-items-center gap-3 wow fadeInUp" data-wow-delay="400ms"
                        data-wow-duration="1500ms"><button class="arry-prev event__arry-prev"><i
                                class="fa-light fa-arrow-left-long"></i></button>
                        <button class="arry-next event__arry-next active"><i
                                class="fa-light fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <div class="swiper event__slider">
                    <div class="swiper-wrapper">

                        @foreach ($jobs as $job)
                            <div class="swiper-slide">
                                <div class="event__item job-card">

                                    <!-- HEADER -->
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="{{ static_asset($job->company_logo ?? 'assets/images/favicon.png') }}"
                                            alt="{{ $job->company_name }}" class="rounded border"
                                            style="width:48px;height:48px;object-fit:contain">

                                        <div>
                                            <h5 class="mb-0 fw-semibold">
                                                <a href="{{ route('jobs.show', $job->slug) }}"
                                                    class="text-dark primary-hover">
                                                    {{ $job->title }}
                                                </a>
                                            </h5>

                                            <small class="text-muted">
                                                {{ $job->company_name ?? 'Opportunity Provider' }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- LOCATION + DATE -->
                                    <div class="d-flex justify-content-between align-items-center text-muted fs-14 mb-2">
                                        <div>
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $job->district }}, {{ $job->state }}
                                        </div>

                                        <div>
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ $job->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <!-- SALARY -->
                                    @if ($job->salary)
                                        <div class="fw-semibold text-success mb-2">
                                            {{ $job->salary }}
                                        </div>
                                    @endif

                                    <!-- BADGES -->
                                    <div class="d-flex flex-wrap gap-2 mb-3">

                                        @if ($job->job_type)
                                            <span class="badge bg-success-subtle text-dark">
                                                <i class="bi bi-briefcase me-1"></i>
                                                {{ $job->job_type }}
                                            </span>
                                        @endif

                                        @if ($job->work_mode)
                                            <span class="badge bg-primary-subtle text-dark">
                                                <i class="bi bi-building me-1"></i>
                                                {{ $job->work_mode }}
                                            </span>
                                        @endif

                                        @if ($job->experience)
                                            <span class="badge bg-warning-subtle text-dark">
                                                <i class="bi bi-person-check me-1"></i>
                                                {{ $job->experience }}
                                            </span>
                                        @endif

                                    </div>

                                    <!-- SHORT DESCRIPTION -->
                                    @if ($job->short_description)
                                        <p class="text-muted fs-14 mb-3">
                                            {{ Str::limit($job->short_description, 100) }}
                                        </p>
                                    @endif

                                    <!-- CTA -->
                                    <div class="d-flex justify-content-between align-items-center gap-3">

                                        <a href="{{ route('jobs.show', $job->slug) }}" class="btn-one">
                                            View Opportunities
                                            <i class="fa-light fa-arrow-right-long"></i>
                                        </a>

                                        @if ($job->is_featured)
                                            <span class="badge bg-warning text-dark">
                                                ⭐ Featured
                                            </span>
                                        @endif

                                    </div>


                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </section>
        <!-- Event area end here -->


        <!-- Courses area start here -->

        <section class="courses-area pt-120 pb-120 sub-bg">
            <div class="courses__line wow slideInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                <img src="{{ static_asset('assets/images/shape/courses-line.png') }}" alt="line-shape">
            </div>
            <div class="courses__shape">
                <img class="slide-up-down" src="{{ static_asset('assets/images/shape/courses-shape.png') }}"
                    alt="shape">
            </div>
            <div class="container">
                <div class="section-header mb-60 text-center">
                    <!--<h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">POPULAR Service </h5>-->
                    <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"> Services <span>
                            Offered
                            <img src="{{ static_asset('assets/images/shape/header-shape.png') }}" alt="shape"></span>
                    </h2>
                </div>
                <div class="row g-4">

                    @forelse ($courses as $course)
                        <div class="col-xl-4 col-md-6">
                            <div class="courses__item shadow">

                                <div class="courses__image image">
                                    <img src="{{ static_asset('uploads/courses/' . $course->image) }}"
                                        alt="{{ $course->title }}">
                                </div>

                                <div class="courses__content">
                                    <h3>
                                        <a href="" class="primary-hover">
                                            {{ $course->title }}
                                        </a>
                                    </h3>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit($course->short_description, 70) }}
                                    </p>

                                    <div class="bor-top d-flex align-items-center justify-content-between gap-3">
                                        <a href="{{ route('courses.details', $course->slug) }}" class="btn-one mt-20">
                                            Read More
                                            <i class="fa-light fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No courses available.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </section>
        <!-- Courses area end here -->




        <div class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title text-center">Partner Center Details</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="col-md-12 mb-4">
                            <div class="blog__item p-4 mb-30" style="border:1px solid #eee; border-radius:8px;">
                                <!-- Content -->
                                <div class="blog__content mt-3">

                                    <h3 class="fs-22 mb-3 fw-bold">Center Name</h3>

                                    <p class="mb-2">
                                        <strong>Address:</strong> XYZ Road, Delhi
                                    </p>

                                    <p class="mb-2">
                                        <strong>Phone:</strong> +91 9876543210
                                    </p>

                                    <p class="mb-3">
                                        <strong>Map:</strong>
                                        <a href="#" target="_blank">Open Location</a>
                                    </p>

                                    <a href="#0" class="btn-one d-inline-block mt-2">View Details</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Topic area start here -->


        <!-- Courses area start here -->
        <section class="courses-area pt-120 pb-120">
            <div class="container">
                <div class="section-header mb-60 text-center">
                    <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"> Our Blogs</h2>
                </div>
                <div class="courses__wrp">
                    <div class="swiper courses__slider">
                        <div class="swiper-wrapper">

                            @foreach ($blogs as $blog)
                                <div class="swiper-slide">
                                    <div class="courses__item" style="background-color: #f0f0f0; padding:15px;">

                                        <div class="courses__image image">
                                            <img src="{{ static_asset($blog->image) }}"
                                                alt="{{ $blog->alt ?? $blog->name }}">
                                        </div>
                                        <div class="p-2">

                                            <h3>
                                                <a href="{{ route('career-updates.details', $blog->slug) }}"
                                                    class="primary-hover">
                                                    {{ $blog->name }}
                                                </a>
                                            </h3>
                                            <p>
                                                {!! Str::limit($blog->short_content, 80) !!}
                                            </p>
                                        </div>

                                        <div class="bor-top d-flex align-items-center justify-content-between gap-3">
                                            <a href="{{ route('career-updates.details', $blog->slug) }}"
                                                class="btn-one mt-20">
                                                Read More
                                                <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- Slider Arrows --}}
                    <button class="arry-prev courses__arry-prev">
                        <i class="fa-light fa-arrow-left-long"></i>
                    </button>

                    <button class="arry-next courses__arry-next active">
                        <i class="fa-light fa-arrow-right-long"></i>
                    </button>
                </div>

            </div>
        </section>
        <!-- Courses area end here -->

        <!-- Banner video area start here -->
        <div class="banner-video-area">
            <div class="container">
                <div class="banner-video__wrp image">
                    <div class="banner-video__dots">
                        <img class="slide-effect2" src="{{ static_asset('assets/images/shape/video-shape.png') }}"
                            alt="shape">
                    </div>
                    <img src="{{ static_asset('assets/images/thumbnail/thumbvid.png') }}" alt="image">
                    <div class="banner-video__video-btn">
                        <div class="video-btn video-pulse">
                            <a class="video-popup" href="https://www.youtube.com/watch?v=9AjDAxAdQxQ"><i
                                    class="fa-solid fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner video area end here -->

        <!-- Team area start here -->
        <section class="team-area sub-bg pt-120 pb-120">
            <div class="team__line">
                <img class="sway_Y__animation" src="{{ static_asset('assets/images/shape/line.png') }}"
                    alt="line-shape">
            </div>

            <div class="team__earth">
                <img class="animation__arryUpDown" src="{{ static_asset('assets/images/shape/earth.png') }}"
                    alt="shape">
            </div>

            <div class="team__right-rectangle wow slideInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                <img src="{{ static_asset('assets/images/shape/right-rectangle.png') }}" alt="shape">
            </div>

            <div class="container">
                <div class="section-header mb-60 text-center">
                    <h5 class="wow fadeInUp">EFOS VIDEOS</h5>
                    <h2 class="wow fadeInUp" data-wow-delay="200ms">
                        EFOS <span>YouTube Videos
                            <img src="{{ static_asset('assets/images/shape/header-shape.png') }}" alt="shape">
                        </span>
                    </h2>
                </div>

                @if ($youtubeVideos->count())
                    <div class="courses__wrp">
                        <div class="swiper courses__slider">
                            <div class="swiper-wrapper">

                                @foreach ($youtubeVideos as $video)
                                    <div class="swiper-slide">
                                        <div class="courses__item">

                                            <div class="courses__image image">
                                                <iframe width="100%" height="240"
                                                    src="{{ youtube_embed($video->youtube_url) }}"
                                                    title="{{ $video->title }}" allowfullscreen>
                                                </iframe>
                                            </div>

                                            <div class="p-2 text-center">
                                                <h3 class="fs-6">
                                                    <a href="{{ $video->youtube_url }}" target="_blank">
                                                        {{ $video->title }}
                                                    </a>
                                                </h3>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <button class="arry-prev courses__arry-prev">
                                <i class="fa-light fa-arrow-left-long"></i>
                            </button>

                            <button class="arry-next courses__arry-next active">
                                <i class="fa-light fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Team area end here -->



        <!-- Contact area start here -->
        <section class="contact-area pt-70">
            <div class="container my-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-danger  py-3">
                        <h3 class="mb-0 text-center text-white">Registration / Enquiry Form</h3>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('student.store') }}" method="POST" id="leadForm" class="p-3">
                            @csrf
                            <div class="row g-4">

                                <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                                <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                                <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
                                <input type="hidden" name="utm_term" value="{{ request('utm_term') }}">
                                <input type="hidden" name="utm_content" value="{{ request('utm_content') }}">

                                <div class="col-md-4">
                                    <label for="name" class="form-label">Your Name*</label>
                                    <input id="name" name="name" type="text" class="form-control" required
                                        placeholder="Your Name" value="{{ old('name') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" required
                                        placeholder="Your Number" value="{{ old('phone') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Your Email*</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                        placeholder="Your Email" value="{{ old('email') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="age_group" class="form-label">Age Group*</label>
                                    <select id="age_group" name="age_group" class="form-select" required>
                                        <option value="">Select Age Group</option>
                                        <option value="16_18">16 - 18</option>
                                        <option value="19_21">19 - 21</option>
                                        <option value="22_25">22 - 25</option>
                                        <option value="26_30">26 - 30</option>
                                        <option value="30_40">30 - 40</option>
                                        <option value="40_50">40 - 50</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="qualification" class="form-label">Select Highest Qualification</label>
                                    <select name="qualification" id="qualification" class="form-select">
                                        <option value="">Select Highest Qualification</option>
                                        <option value="Below 10th">Below 10th</option>
                                        <option value="10th">10th</option>
                                        <option value="ITI/Diploma">ITI / Diploma</option>
                                        <option value="12th Pass">12th Pass</option>
                                        <option value="Undergraduate">Undergraduate</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="present_status" class="form-label">Present Status</label>
                                    <select name="present_status" id="present_status" class="form-select">
                                        <option value="">Select Present Status</option>
                                        <option value="Student">Student</option>
                                        <option value="Looking for Job">Looking for Job</option>
                                        <option value="Working">Working</option>
                                        <option value="Retired">Retired</option>
                                        <option value="Ex-armyperson">Ex-armyperson</option>
                                        <option value="Woman after break">Woman after break</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="state2" class="form-label">State*</label>
                                    <select id="state" name="state" class="form-select" data-state
                                        data-target="district2" required>
                                        <option value="">Select State</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="district2" class="form-label">District*</label>
                                    <select id="district" class="form-select" name="district" required>
                                        <option value="">Select District</option>
                                    </select>
                                </div>


                                <div class="col-md-4">
                                    <label for="looking_for" class="form-label">What Are You Looking For?</label>
                                    <select id="looking_for" name="looking_for" class="form-select" required>
                                        <option value="">Select an Option</option>
                                        <option value="education">Education</option>
                                        <option value="skill_course">Skill Course</option>
                                        <option value="job">Job</option>
                                        <option value="learn_earn">Learn & Earn Program</option>
                                        <option value="career_counselling">Career Counselling</option>
                                        <option value="international_options">International Options</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms"
                                        value="1" required>
                                    <label class="form-check-label" for="agree_terms">
                                        I agree to receive SMS/Calls/Whatsapp
                                        <strong> by EFOS.in</strong>
                                    </label>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" id="submitBtn" class="btn-one wow fadeInDown">
                                    Send Now →
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!-- Contact area end here -->

        <!-- Fanfact area start here -->
        <section class="fanfact-area extra-padding">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="fanfact__item">
                            <div class="">
                                <img src="{{ static_asset('assets/images/icon/fanfact-icon1.png') }}" width="80px"
                                    alt="icon">
                            </div>
                            <h2><span class="count">18</span>+</h2>
                            <span>Years of Experience</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="fanfact__item">
                            <div class="">
                                <img src="{{ static_asset('assets/images/icon/fanfact-icon2.png') }}" width="80px"
                                    alt="icon">
                            </div>
                            <h2><span class="count">200</span>k+</h2>
                            <span>Students Empowered</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="fanfact__item">
                            <div class="">
                                <img src="{{ static_asset('assets/images/icon/fanfact-icon3.png') }}" width="80px"
                                    alt="icon">
                            </div>
                            <h2><span class="count">100</span>+</h2>
                            <span>EFOS Partner Centers </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                        <div class="fanfact__item">
                            <div class="">
                                <img src="{{ static_asset('assets/images/favicon.png') }}" width="70px"
                                    alt="icon">
                            </div>
                            <h2><span class="count">100</span>+</h2>
                            <span> Opportunities</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fanfact area end here -->

        <!-- About area start here -->
        <section class="about-area  pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="text-center">
                            <div class="section-header">
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                                    The Serenity
                                    <span>Prayer <img src="{{ static_asset('assets/images/shape/header-shape.png') }}"
                                            alt="shape"></span>
                                </h2>
                                <p class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    “God, grant me the serenity to accept the things I cannot change, The courage to change
                                    the things I can, And the wisdom to know the difference.”
                                </p>
                                <p class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    We believe in the fact that Right Education and Career Opportunities can change anyone
                                    life irrespective of their current situations or circumstances and right education or
                                    career decision can change the present life and life of coming generations.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About area end here -->




        <!-- Discount area start here -->
        <section class="discout-three-area pt-120 pb-120 primary-bg">
            <div class="discout-two__shape-left">
                <img src="{{ static_asset('assets/images/shape/discout-two-shpe-left.png') }}" alt="shape">
            </div>
            <div class="discout-two__shape-right">
                <img src="{{ static_asset('assets/images/shape/discout-two-shpe-right.png') }}" alt="shape">
            </div>
            <div class="container">
                <div class="col-xl-7">
                    <div class="discout-three__item bg-white p-3 rounded">
                        <h2 class="text-dark wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                            Find EFOS Partner <br> Centers</h2>
                        <form id="searchForm">
                            <div class="search-bar mt-4">
                                <div class="row g-3 align-items-end">

                                    <div class="col-lg-4 col-md-4">
                                        <label for="state1" class="form-label">State *</label>
                                        <select class="form-select" id="state2">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <label for="district1" class="form-label">District *</label>
                                        <select class="form-select" id="district2">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4 d-grid">
                                        <button type="button" class="btn btn-primary" id="searchBtn">
                                            Search
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="discout-three__image">
                <img src="{{ static_asset('assets/images/offer/offer-hero2.png') }}" alt="image">
                <img class="shape" src="{{ static_asset('assets/images/shape/discout-three-item-line.png') }}"
                    alt="shape">
            </div>
        </section>
        <!-- Discount area end here -->


        <!-- Testimonial area start here -->
        <section class="testimonial-seven-area sub-bg-two pt-120 pb-120 bg-image"
            data-background="{{ static_asset('assets/images/bg/ellipse-bg.png') }}">
            <div class="container">
                <div class="section-header mb-60 text-center">
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">TESTIMONIALS</h5>
                    <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">What Our <span>Costumers
                            <img src="{{ static_asset('assets/images/shape/header-shape.png') }}" alt="shape"></span>
                        Say this</h2>
                </div>
                <div class="swiper testimonial-seven__slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-seven__item">
                                <div class="d-flex align-items-center gap-4 justify-content-between mb-15">
                                    <div class="star">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star disabled"></i>
                                    </div>
                                    <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path
                                                d="M21.5998 15.1662C21.4359 21.2706 20.2326 27.1028 17.1618 32.4687C15.0391 36.1766 11.8636 38.7708 8.31789 40.9881C8.09312 41.1284 7.80413 41.3886 7.55907 41.1588C7.2836 40.9002 7.52189 40.5673 7.66216 40.3087C8.9449 37.9646 10.3121 35.6645 11.4292 33.2309C12.6528 30.564 13.6212 27.811 14.2567 24.9396C14.4257 24.1774 14.255 24.0929 13.535 24.2484C7.64188 25.526 2.16112 21.8976 1.00852 15.9858C-0.0849304 10.38 3.84608 4.78603 9.51275 3.88694C15.9196 2.86954 21.5491 7.65063 21.5998 14.1522C21.6015 14.4902 21.5998 14.8282 21.5998 15.1662Z"
                                                fill="#2EB97E" />
                                            <path
                                                d="M44.25 15.2202C44.0793 21.5916 42.7949 27.6571 39.3912 33.1581C37.3175 36.5077 34.3228 38.8501 31.0746 40.9288C30.816 41.0945 30.4729 41.4375 30.1856 41.1198C29.9253 40.8325 30.2346 40.4877 30.3884 40.1987C31.6559 37.8462 33.0401 35.5562 34.1403 33.1142C35.3351 30.4642 36.2917 27.7382 36.9153 24.8939C37.0775 24.1536 36.8967 24.0827 36.2224 24.2415C30.2836 25.6358 24.4277 21.6338 23.5556 15.4348C22.7985 10.0537 26.7751 4.68115 32.1359 3.89022C38.7118 2.92353 44.2162 7.65053 44.25 14.2923C44.25 14.6016 44.25 14.9109 44.25 15.2202Z"
                                                fill="#2EB97E" />
                                        </g>
                                    </svg>
                                </div>
                                <p>Jesmin from Bhangagarah, Guwahati chose skills over dependence and enrolled in basic
                                    training program to shape her future to become financially independent—confident,
                                    self-reliant.</p>
                                <div class="d-flex align-items-center gap-3 mt-30">
                                    <img src="{{ static_asset('assets/images/testimonial/01.png') }}" alt="image">
                                    <div class="testi-info">
                                        <h4>Jesmin Sultana</h4>
                                        <p class="fs-14">12th, Guwahati</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-seven__item">
                                <div class="d-flex align-items-center gap-4 justify-content-between mb-15">
                                    <div class="star">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star disabled"></i>
                                    </div>
                                    <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path
                                                d="M21.5998 15.1662C21.4359 21.2706 20.2326 27.1028 17.1618 32.4687C15.0391 36.1766 11.8636 38.7708 8.31789 40.9881C8.09312 41.1284 7.80413 41.3886 7.55907 41.1588C7.2836 40.9002 7.52189 40.5673 7.66216 40.3087C8.9449 37.9646 10.3121 35.6645 11.4292 33.2309C12.6528 30.564 13.6212 27.811 14.2567 24.9396C14.4257 24.1774 14.255 24.0929 13.535 24.2484C7.64188 25.526 2.16112 21.8976 1.00852 15.9858C-0.0849304 10.38 3.84608 4.78603 9.51275 3.88694C15.9196 2.86954 21.5491 7.65063 21.5998 14.1522C21.6015 14.4902 21.5998 14.8282 21.5998 15.1662Z"
                                                fill="#2EB97E" />
                                            <path
                                                d="M44.25 15.2202C44.0793 21.5916 42.7949 27.6571 39.3912 33.1581C37.3175 36.5077 34.3228 38.8501 31.0746 40.9288C30.816 41.0945 30.4729 41.4375 30.1856 41.1198C29.9253 40.8325 30.2346 40.4877 30.3884 40.1987C31.6559 37.8462 33.0401 35.5562 34.1403 33.1142C35.3351 30.4642 36.2917 27.7382 36.9153 24.8939C37.0775 24.1536 36.8967 24.0827 36.2224 24.2415C30.2836 25.6358 24.4277 21.6338 23.5556 15.4348C22.7985 10.0537 26.7751 4.68115 32.1359 3.89022C38.7118 2.92353 44.2162 7.65053 44.25 14.2923C44.25 14.6016 44.25 14.9109 44.25 15.2202Z"
                                                fill="#2EB97E" />
                                        </g>
                                    </svg>
                                </div>
                                <p>Shital, daughter of Phoolsingh Choudhary from Indore. MP empowered herself by learning
                                    practical skills and became financially independent to support her family with pride and
                                    confidence.</p>
                                <div class="d-flex align-items-center gap-3 mt-30">
                                    <img src="{{ static_asset('assets/images/testimonial/02.png') }}" alt="image">
                                    <div class="testi-info">
                                        <h4>Shital Choudhary</h4>
                                        <p class="fs-14">12th,Indore</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-seven__item">
                                <div class="d-flex align-items-center gap-4 justify-content-between mb-15">
                                    <div class="star">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star disabled"></i>
                                    </div>
                                    <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path
                                                d="M21.5998 15.1662C21.4359 21.2706 20.2326 27.1028 17.1618 32.4687C15.0391 36.1766 11.8636 38.7708 8.31789 40.9881C8.09312 41.1284 7.80413 41.3886 7.55907 41.1588C7.2836 40.9002 7.52189 40.5673 7.66216 40.3087C8.9449 37.9646 10.3121 35.6645 11.4292 33.2309C12.6528 30.564 13.6212 27.811 14.2567 24.9396C14.4257 24.1774 14.255 24.0929 13.535 24.2484C7.64188 25.526 2.16112 21.8976 1.00852 15.9858C-0.0849304 10.38 3.84608 4.78603 9.51275 3.88694C15.9196 2.86954 21.5491 7.65063 21.5998 14.1522C21.6015 14.4902 21.5998 14.8282 21.5998 15.1662Z"
                                                fill="#2EB97E" />
                                            <path
                                                d="M44.25 15.2202C44.0793 21.5916 42.7949 27.6571 39.3912 33.1581C37.3175 36.5077 34.3228 38.8501 31.0746 40.9288C30.816 41.0945 30.4729 41.4375 30.1856 41.1198C29.9253 40.8325 30.2346 40.4877 30.3884 40.1987C31.6559 37.8462 33.0401 35.5562 34.1403 33.1142C35.3351 30.4642 36.2917 27.7382 36.9153 24.8939C37.0775 24.1536 36.8967 24.0827 36.2224 24.2415C30.2836 25.6358 24.4277 21.6338 23.5556 15.4348C22.7985 10.0537 26.7751 4.68115 32.1359 3.89022C38.7118 2.92353 44.2162 7.65053 44.25 14.2923C44.25 14.6016 44.25 14.9109 44.25 15.2202Z"
                                                fill="#2EB97E" />
                                        </g>
                                    </svg>
                                </div>
                                <p>Vivek from Varanasi, son of Mr. Shiv Shyam Tiwari, turned ambition into action by
                                    focusing on practical skills. Step by step, his efforts led to stable work and
                                    self-reliance.</p>
                                <div class="d-flex align-items-center gap-3 mt-30">
                                    <img src="{{ static_asset('assets/images/testimonial/03.png') }}" alt="image">
                                    <div class="testi-info">
                                        <h4>Vivek Kumar</h4>
                                        <p class="fs-14">Graduate,Varanasi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-60">
                    <div class="dot testimonial-seven__dot"></div>
                </div>
            </div>
        </section>
        <!-- Testimonial area end here -->

    </main>


@endsection





@push('script')
    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {

            let state = document.getElementById('state2').value;
            let district = document.getElementById('district2').value;

            if (!state || !district) {
                alert('Please select State and District');
                return;
            }

            fetch(`{{ route('partner.centers.search') }}?state=${state}&district=${district}`)
                .then(res => res.json())
                .then(response => {

                    let modalBody = document.querySelector('#partnerModal .modal-body');
                    modalBody.innerHTML = '';

                    if (response.data.length === 0) {
                        modalBody.innerHTML = `
                    <div class="text-center text-danger">
                        No Partner Centers Found
                    </div>
                `;
                    } else {

                        response.data.forEach(center => {
                            modalBody.innerHTML += `
                        <div class="col-md-12 mb-4">
                            <div class="blog__item p-4" style="border:1px solid #eee; border-radius:8px;">
                                <div class="blog__content">
                                    <h3 class="fs-22 fw-bold">${center.company_name}</h3>

                                    <p><strong>Owner:</strong> ${center.owner_name}</p>

                                    <p><strong>Address:</strong> ${center.address ?? 'N/A'}</p>

                                    <p><strong>Phone:</strong> ${center.phone}</p>

                                    <p>
                                        <strong>Map:</strong>
                                         <a href="${center.location ?? '#'}"
                                target="_blank"
                                class="btn btn-outline-primary btn-sm mt-2">
                                Open Location
                                </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                        });
                    }

                    let modal = new bootstrap.Modal(document.getElementById('partnerModal'));
                    modal.show();
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong');
                });
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const stateSelect = document.getElementById("state");
            const districtSelect = document.getElementById("district");

            // Fetch JSON file
            fetch("{{ static_asset('assets/india-states-districts.json') }}")
                .then(response => response.json())
                .then(data => {
                    const states = data.states;

                    // Populate State dropdown
                    states.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.state;
                        option.textContent = item.state;
                        stateSelect.appendChild(option);
                    });

                    // On state change -> populate districts
                    stateSelect.addEventListener("change", function() {
                        districtSelect.innerHTML = '<option value="">Select District</option>';
                        districtSelect.disabled = true;

                        const selectedState = this.value;
                        if (!selectedState) return;

                        const stateData = states.find(s => s.state === selectedState);

                        if (stateData) {
                            stateData.districts.forEach(district => {
                                const option = document.createElement("option");
                                option.value = district;
                                option.textContent = district;
                                districtSelect.appendChild(option);
                            });
                            districtSelect.disabled = false;
                        }
                    });
                })
                .catch(error => {
                    console.error("Error loading state-district JSON:", error);
                });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const stateSelect = document.getElementById("state2");
            const districtSelect = document.getElementById("district2");

            // Fetch JSON file
            fetch("{{ static_asset('assets/india-states-districts.json') }}")
                .then(response => response.json())
                .then(data => {
                    const states = data.states;

                    // Populate State dropdown
                    states.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.state;
                        option.textContent = item.state;
                        stateSelect.appendChild(option);
                    });

                    // On state change -> populate districts
                    stateSelect.addEventListener("change", function() {
                        districtSelect.innerHTML = '<option value="">Select District</option>';
                        districtSelect.disabled = true;

                        const selectedState = this.value;
                        if (!selectedState) return;

                        const stateData = states.find(s => s.state === selectedState);

                        if (stateData) {
                            stateData.districts.forEach(district => {
                                const option = document.createElement("option");
                                option.value = district;
                                option.textContent = district;
                                districtSelect.appendChild(option);
                            });
                            districtSelect.disabled = false;
                        }
                    });
                })
                .catch(error => {
                    console.error("Error loading state-district JSON:", error);
                });

        });
    </script>

    <script>
        document.addEventListener('hidden.bs.modal', function() {
            document.body.classList.remove('modal-open');

            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        });
    </script>
@endpush
