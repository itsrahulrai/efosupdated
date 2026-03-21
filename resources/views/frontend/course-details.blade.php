@extends('frontend.layout.layout')
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])
@section('meta_robots', $seo['robots'])
@section('canonical', $seo['canonical'])

@section('content')

<main>
    <!-- Banner area start -->
    <section class="banner-inner-area sub-bg bg-image">
        <div class="container">
            <div class="banner-inner__content">
                <h1>{{ $course->title }}</h1>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>Courses</li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>{{ $course->title }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Banner area end -->

    <!-- Course details area start -->
    <section class="blog-detals-area pt-120 pb-120">
        <div class="container">
            <div class="row">

                <!-- LEFT CONTENT -->
                <div class="col-lg-12 order-2 order-lg-1">
                    <div class="blog-details__item-left">

                        <div class="image">
                            <img src="{{ static_asset('uploads/courses/'.$course->image) }}"
                                 alt="{{ $course->title }}">
                        </div>

                        <h2 class="mt-4">{{ $course->title }}</h2>

                        <p class="mt-3 text-muted">
                            {{ $course->short_description }}
                        </p>

                      <div class="description mt-4 editor-content">
                            {!! $course->description !!}
                        </div>


                    </div>
                </div>

               
            </div>
        </div>
    </section>
    <!-- Course details area end -->
</main>

@endsection
