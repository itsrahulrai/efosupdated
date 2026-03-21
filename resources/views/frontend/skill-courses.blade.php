@extends('frontend.layout.layout')
@section('title', 'Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Skill Courses
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Skill Courses</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="courses-area pt-120 pb-120">
            <div class="container">
               
                <div class="row g-4">

                    @forelse($skillCourses as $course)
                        <div class="col-xl-4 col-md-6">
                            <div class="courses-two__item">
                                <div class="courses-two__image image">
                                    <img src="{{ static_asset($course->thumbnail) }}" alt="{{ $course->title }}">

                                    <span class="time">
                                        {{ $course->duration }}
                                    </span>
                                </div>

                                <div class="courses__content pt-4 p-0">
                                    <div class="courses-two__info pb-4">
                                        <a href="#">{{ $course->level }}</a>

                                        @if ($course->is_free)
                                            <h4>Free</h4>
                                        @elseif($course->has_discount)
                                            <h4>
                                                {{ $course->currency }} {{ $course->discount_price }}
                                            </h4>
                                        @else
                                            <h4>
                                                {{ $course->currency }} {{ $course->price }}
                                            </h4>
                                        @endif
                                    </div>

                                    <h3>
                                        <a href="{{ url('course/' . $course->slug) }}" class="primary-hover">
                                            {{ $course->title }}
                                        </a>
                                    </h3>

                                    <p class="mt-2">
                                        {{ Str::limit($course->short_description, 100) }}
                                    </p>

                                    <div class="bor-top pt-3 d-flex align-items-center justify-content-between gap-3">


                                        <div class="text-end">
                                            <a href="{{ route('course.details', $course->slug) }}" class="btn-one">
                                                Start Course <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No courses available.</p>
                    @endforelse

                </div>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-60">
                {{ $skillCourses->links() }}
            </div>
        </section>

    </main>

@endsection
