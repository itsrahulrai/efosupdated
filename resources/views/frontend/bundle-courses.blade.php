@extends('frontend.layout.layout')
@section('title', 'Bundle Courses | EFOS Edumarketers Pvt Ltd')
@section('meta_description', 'Explore our course bundles with included courses and special pricing.')
@section('meta_keywords', 'bundle courses, course bundles, online learning, skill development')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/bundles'))

@push('style')
    <style>
        :root {
            --red: #e63946;
            --blue: #0f4c75;
            --gray: #6b7280;
            --light-gray: #f9fafb;
        }

        /* CARD */
        .bundle-card-clean {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .bundle-card-clean:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-6px);
            border-color: var(--red);
        }

        /* IMAGE */


        .bundle-card-clean:hover img {
            transform: scale(1.08);
        }

        /* BADGE */
        .duration-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--red);
            color: #fff;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
            font-weight: 600;
        }

        /* BODY */
        .bundle-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* HEADER ROW */
        .bundle-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .level-badge {
            font-size: 11px;
            padding: 5px 10px;
            border-radius: 6px;
            background: #eef2ff;
            color: var(--blue);
            font-weight: 600;
        }

        .price {
            font-size: 16px;
            font-weight: 700;
            color: var(--red);
        }

        /* TITLE */
        .bundle-body h3 {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .bundle-body h3 a {
            color: #111827;
            text-decoration: none;
        }

        .bundle-body h3 a:hover {
            color: var(--red);
        }

        /* DESCRIPTION */
        .bundle-body p {
            font-size: 14px;
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 12px;
        }

        /* COURSES SECTION */
        .bundle-courses-section {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 14px;
        }

        /* LABEL */
        .courses-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* COURSE ITEMS */
        .course-item {
            font-size: 13px;
            padding: 6px 10px;
            background: #fff;
            border-radius: 6px;
            margin-bottom: 6px;
            border-left: 3px solid var(--red);
            color: #1f2937;
        }

        /* MORE */
        .courses-more {
            font-size: 12px;
            color: var(--blue);
            font-weight: 600;
        }

        /* BUTTON */


        /* RESPONSIVE */
        @media (max-width: 768px) {
            .bundle-img {
                height: 140px;
            }

            .bundle-body {
                padding: 12px;
            }

            .bundle-title {
                font-size: 14px;
            }

            .bundle-desc {
                font-size: 11px;
            }

            .course-item {
                font-size: 10px;
            }
        }

        @media (max-width: 480px) {
            .bundle-body {
                padding: 10px;
            }

            .bundle-title {
                font-size: 13px;
            }

            .bundle-courses-section {
                padding: 6px;
            }
        }
    </style>
@endpush

@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>Bundle Courses</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Bundle Courses</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="courses-area pt-120 pb-120">
            <div class="container">
                <div class="row g-4 mb-5">

                    @foreach ($bundles as $bundle)
                        <div class="col-xl-4 col-md-6">
                            <div class="bundle-card-clean">

                                <!-- IMAGE WITH BADGES -->
                                <div class="courses-two__image image">
                                    <img src="{{ static_asset($bundle->thumbnail) }}" alt="{{ $bundle->title }}">

                                    <span class="duration-badge">
                                        <i class="fa-solid fa-book"></i>
                                        {{ $bundle->courses->count() }} COURSES
                                    </span>
                                </div>

                                <!-- CONTENT -->
                                <div class="bundle-body">

                                    <!-- TOP ROW (Level & Price) -->
                                    <div class="bundle-header-row">
                                        <span class="level-badge">Bundle</span>

                                        <!-- PRICE -->
                                        @if ($bundle->is_free)
                                            <span class="price">FREE</span>
                                        @elseif($bundle->has_discount)
                                            <span class="price">
                                                {{ $bundle->currency }} {{ number_format($bundle->discount_price) }}
                                            </span>
                                        @else
                                            <span class="price">
                                                {{ $bundle->currency }} {{ number_format($bundle->price) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- TITLE -->
                                    <h3>
                                        <a href="{{ route('course.details', $bundle->slug) }}" class="primary-hover">
                                            {{ $bundle->title }}
                                        </a>
                                    </h3>
                                    <!-- DESCRIPTION -->
                                    <p class="mt-2 text-justify">
                                        {{ $bundle->short_description }}
                                    </p>

                                    <!-- COURSES INCLUDED SECTION -->
                                    <div class="bundle-courses-section">
                                        <div class="courses-label">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            Includes:
                                        </div>
                                        <div class="courses-list">
                                            @forelse ($bundle->courses->take(2) as $course)
                                                <div class="course-item">
                                                    ✓ {{ Str::limit($course->title, 45) }}
                                                </div>
                                            @empty
                                                <div class="course-item">No courses yet</div>
                                            @endforelse

                                            @if ($bundle->courses->count() > 2)
                                                <div class="courses-more">
                                                    + {{ $bundle->courses->count() - 2 }} more courses
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('course.details', $bundle->slug) }}" class="btn-one">
                                            View Bundle <i class="fa-light fa-arrow-right-long"></i>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

            <!-- Pagination -->
            @if ($bundles->hasPages())
                <div class="pegi justify-content-center mt-60 d-flex align-items-center gap-2">

                    {{-- Previous --}}
                    @if ($bundles->onFirstPage())
                        <span class="border-none disabled">
                            <i class="fa-regular fa-arrow-left"></i>
                        </span>
                    @else
                        <a href="{{ $bundles->previousPageUrl() }}" class="border-none">
                            <i class="fa-regular fa-arrow-left"></i>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($bundles->getUrlRange(1, $bundles->lastPage()) as $page => $url)
                        @if ($page == $bundles->currentPage())
                            <a href="#" class="active">{{ sprintf('%02d', $page) }}</a>
                        @else
                            <a href="{{ $url }}">{{ sprintf('%02d', $page) }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($bundles->hasMorePages())
                        <a href="{{ $bundles->nextPageUrl() }}" class="border-none">
                            <i class="fa-regular fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="border-none disabled">
                            <i class="fa-regular fa-arrow-right"></i>
                        </span>
                    @endif

                </div>
            @endif
        </section>

    </main>

@endsection
