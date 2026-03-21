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
                        Career Updates
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Career Updates</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->

        <section class="blogs-area pt-120 pb-120">
            <div class="container">
                <div class="row g-4">
                    @forelse ($blogs as $blog)
                        <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="blog__item p-4">
                                <!-- Image -->
                                <a href="{{ route('career-updates.details', $blog->slug) }}"
                                    class="blog__image d-block image">
                                    <img src="{{ static_asset($blog->image ?? 'assets/images/blog/blog-image1.jpg') }}"
                                        alt="{{ $blog->alt ?? $blog->name }}">
                                </a>

                                <div class="blog__content">

                                    <!-- Date -->
                                    <div class="blog-tag">
                                        <h3 class="text-white">{{ $blog->created_at->format('d') }}</h3>
                                        <span class="text-white">{{ $blog->created_at->format('M') }}</span>
                                    </div>

                                    <!-- Info -->
                                    <ul class="blog-info mb-20 mt-40">
                                        <li>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.5436 5.19275C14.5436 7.69093 ..." stroke="#2EB97E"
                                                    stroke-width="1.3" />
                                                <path d="M18.2644 14.6706C18.1052..." stroke="#2EB97E" stroke-width="1.3" />
                                            </svg>
                                            <a href="#0">By Admin</a>
                                        </li>

                                        <li>
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.05666 18.75H8.05504C7.46832..." fill="#2EB97E" />
                                            </svg>

                                            <a href="#0">{{ $blog->category->name ?? 'Uncategorized' }}</a>
                                        </li>
                                    </ul>

                                    <!-- Title -->
                                    <h3>
                                        <a href="{{ route('career-updates.details', $blog->slug) }}" class="primary-hover">
                                            {{ $blog->name }}
                                        </a>
                                    </h3>

                                    <!-- Read More -->
                                    <a class="mt-15 read-more-btn"
                                        href="{{ route('career-updates.details', $blog->slug) }}">
                                        Read More <i class="fa-regular fa-arrow-right-long"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @empty

                        <div class="col-12 text-center">
                            <h4>No Blogs Found</h4>
                        </div>
                    @endforelse
                </div>
                @if ($blogs->hasPages())
                    <div class="pegi justify-content-center mt-60">

                        {{-- Previous Page --}}
                        @if ($blogs->onFirstPage())
                            <span class="border-none disabled">
                                <i class="fa-regular fa-arrow-left primary-color transition"></i>
                            </span>
                        @else
                            <a href="{{ $blogs->previousPageUrl() }}" class="border-none">
                                <i class="fa-regular fa-arrow-left primary-color transition"></i>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($blogs->links()->elements[0] as $page => $url)
                            @if ($page == $blogs->currentPage())
                                <a href="#" class="active">{{ sprintf('%02d', $page) }}</a>
                            @else
                                <a href="{{ $url }}">{{ sprintf('%02d', $page) }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page --}}
                        @if ($blogs->hasMorePages())
                            <a href="{{ $blogs->nextPageUrl() }}" class="border-none">
                                <i class="fa-regular fa-arrow-right primary-color transition"></i>
                            </a>
                        @else
                            <span class="border-none disabled">
                                <i class="fa-regular fa-arrow-right primary-color transition"></i>
                            </span>
                        @endif

                    </div>
                @endif

            </div>
        </section>
        <!-- Blog area end here -->
    </main>

@endsection
