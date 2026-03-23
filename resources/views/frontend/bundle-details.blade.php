@extends('frontend.layout.layout')

@section('title', $bundle->title . ' | Course Bundle')
@section('meta_description', $bundle->short_description)
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())

@push('style')
    <style>
        .bundle-hero {
            padding: 80px 0;
        }

        .bundle-title {
            font-size: 48px;
            font-weight: 700;
        }

        .feature-list i {
            color: #28a745;
            margin-right: 8px;
        }

        .btn-enroll {
            background: #e42433;
            color: #fff;
            padding: 12px 28px;
            border-radius: 6px;
        }

        .btn-enroll:hover {
            background: #d42e3a;
            color: #fff;
        }

        .bundle-image {
            border-radius: 14px;
            overflow: hidden;
        }

        .bundle-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* COURSE CARD IN BUNDLE */
        .course-in-bundle {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .course-in-bundle:hover {
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.1);
            border-color: #e42433;
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
            gap: 12px;
        }

        .course-header h4 {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            flex: 1;
        }

        .course-badge {
            background: #e42433;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .course-meta {
            display: flex;
            gap: 16px;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .course-meta i {
            color: #e42433;
        }

        /* CURRICULUM WRAPPER */
        .curriculum-wrapper {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 12px;
        }

        .curriculum-header {
            background: #e42433;
            color: white;
            padding: 14px 16px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
            transition: all 0.3s ease;
        }

        .curriculum-header:hover {
            background: #d42e3a;
        }

        .curriculum-header.active {
            background: #e11d2e;
            color: #ffffff;
        }

        .curriculum-header.active span,
        .curriculum-header.active i,
        .curriculum-header.active div {
            color: #ffffff !important;
        }

        .curriculum-header.collapsed {
            background: #fff;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
        }

        .curriculum-header i {
            transition: transform 0.3s ease;
        }

        .curriculum-header.active i.arrow-icon {
            transform: rotate(180deg);
        }

        .curriculum-body {
            display: none;
            background: white;
        }

        .curriculum-body.show {
            display: block;
        }

        .curriculum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-top: 1px solid #f1f1f1;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .curriculum-row:hover {
            background: #f9fafb;
        }

        .curriculum-row .left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .curriculum-row i {
            color: #e42433;
            font-size: 13px;
            min-width: 16px;
        }

        .curriculum-row .right {
            color: #6b7280;
            font-size: 13px;
            white-space: nowrap;
        }

        .lesson-link {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .lesson-link:hover:not(.disabled) {
            background-color: #f0f9ff;
            color: #e42433;
        }

        .curriculum-row.disabled {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .curriculum-row.disabled .left {
            color: #999;
        }

        /* LOCKED INDICATOR */
        .lock-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: #e42433;
            margin-left: 4px;
            font-weight: 600;
        }

        /* TABS */
        .courses-details-two__tab {
            margin-bottom: 30px;
        }

        .nav-tabs {
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            gap: 0;
        }

        .nav-tabs .nav-item {
            margin: 0;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6b7280;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-tabs .nav-link:hover {
            color: #1f2937;
        }

        .nav-tabs .nav-link.active {
            color: #e42433;
            border-bottom-color: #e42433;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .bundle-title {
                font-size: 28px;
            }

            .course-header {
                flex-direction: column;
            }

            .course-badge {
                align-self: flex-start;
            }

            .course-meta {
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')

    <main>
        <!-- Banner -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>{{ $bundle->title }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>{{ $bundle->title }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Bundle Details Hero -->
        <section class="bundle-hero">
            <div class="container">
                <div class="row align-items-center g-5">

                    <!-- LEFT CONTENT -->
                    <div class="col-lg-6">

                        <h1 class="bundle-title mb-4">{{ $bundle->title }}</h1>

                        <p class="text-muted mb-4 lh-lg text-justify fw-normal">
                            {{ $bundle->short_description }}
                        </p>

                        <!-- Features List -->
                        <div class="row feature-list mb-4">

                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-book-open text-success me-2"></i>
                                {{ $bundle->courses->count() }} Courses
                            </div>

                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-video text-info me-2"></i>
                                {{ $bundle->courses->sum(fn($c) => $c->chapters->sum(fn($ch) => $ch->lessons->count())) }}
                                Lessons
                            </div>

                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-users text-primary me-2"></i>
                                {{ $bundle->courses->sum(fn($c) => $c->student_count ?? 0) }} Students
                            </div>

                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-certificate text-warning me-2"></i>
                                Certificate
                            </div>

                            <!-- PRICE -->
                            <div class="col-12 mt-2 d-flex align-items-center">
                                <i class="fa-solid fa-tag text-danger me-2"></i>

                                @if ($bundle->is_free)
                                    <span class="badge bg-success fs-6">FREE</span>
                                @else
                                    @if ($bundle->has_discount)
                                        <span class="text-muted text-decoration-line-through me-2">
                                            ₹{{ number_format($bundle->price) }}
                                        </span>
                                        <span class="fw-bold text-danger fs-5">
                                            ₹{{ number_format($bundle->discount_price) }}
                                        </span>
                                    @else
                                        <span class="fw-bold text-dark fs-5">
                                            ₹{{ number_format($bundle->price) }}
                                        </span>
                                    @endif
                                @endif
                            </div>

                        </div>

                        <!-- Enroll Button -->
                        <div class="d-flex gap-3 flex-wrap">

                            @if ($alreadyPurchased)
                                <a href="{{ route('student.dashboard') }}" class="btn-one fw-bold">
                                    <i class="fa-solid fa-book-open me-2"></i>
                                    Start Learning
                                </a>
                            @else
                                @if ($bundle->is_free)
                                    <a href="{{ route('bundle.enroll.free', $bundle->id) }}" class="btn-one fw-bold">
                                        <i class="fa-solid fa-play me-2"></i>
                                        Enroll for Free
                                    </a>
                                @else
                                    <a href="{{ route('bundle.course.checkout', $bundle->id) }}" class="btn btn-enroll fw-bold">
                                        <i class="fa-solid fa-cart-plus me-2"></i>
                                        Buy Bundle Now
                                    </a>
                                @endif
                            @endif

                        </div>

                    </div>

                    <!-- RIGHT IMAGE -->
                    <div class="col-lg-6">
                        <div class="bundle-image">
                            <img src="{{ static_asset($bundle->thumbnail) }}" alt="{{ $bundle->title }}"
                                class="img-fluid">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Bundle Courses Content -->
        <section class="courses-area pt-120 pb-120">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-8">

                        <!-- TABS -->
                        <div class="courses-details-two__tab mb-40">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#overview" id="overview-tab" data-bs-toggle="tab"
                                        role="tab">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#curriculum" id="curriculum-tab" data-bs-toggle="tab"
                                        role="tab">Courses Content ({{ $bundle->courses->count() }})</a>
                                </li>
                            </ul>
                        </div>

                        <!-- TAB CONTENT -->
                        <div class="tab-content">

                            <!-- OVERVIEW TAB -->
                            <div class="tab-pane fade active show" id="overview" role="tabpanel">
                                <div class="content mb-30">
                                    <h3 class="fs-30 mb-20">Bundle Description</h3>
                                    <div class="mb-4 p-3 bg-light rounded text-muted lh-lg text-justify">
                                        {!! $bundle->description ?? $bundle->short_description !!}
                                    </div>
                                </div>
                            </div>

                            <!-- CURRICULUM TAB -->
                            <div class="tab-pane fade" id="curriculum" role="tabpanel">
                                <div class="content mb-30">
                                    <h3 class="fs-30 mb-20">What's Included in This Bundle</h3>

                                    @php
                                        // BUNDLE LEVEL LOCK: If bundle is paid AND not purchased, lock all content
                                        $bundleIsLocked = !$bundle->is_free && !$alreadyPurchased;
                                    @endphp

                                    <!-- LOOP THROUGH COURSES -->
                                    @forelse ($bundle->courses as $courseIndex => $course)

                                        <div class="course-in-bundle">

                                            <!-- Course Header -->
                                            <div class="course-header">
                                                <h4>
                                                    <i class="fa-solid fa-play-circle"
                                                        style="color: #e42433; margin-right: 8px;"></i>
                                                    {{ $courseIndex + 1 }}. {{ $course->title }}
                                                </h4>
                                                <span class="course-badge">
                                                    Course {{ $courseIndex + 1 }}
                                                </span>
                                            </div>

                                            <!-- Course Meta -->
                                            <div class="course-meta">
                                                <span>
                                                    <i class="fa-solid fa-book-open"></i>
                                                    {{ $course->chapters->count() }} Chapters
                                                </span>
                                                <span>
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                    {{ $course->chapters->sum(fn($c) => $c->lessons->count()) }}
                                                    Lessons
                                                </span>
                                                <span>
                                                    <i class="fa-solid fa-signal"></i>
                                                    {{ $course->level }}
                                                </span>
                                                @if ($bundleIsLocked)
                                                    <span style="color: #e42433;">
                                                        <i class="fa-solid fa-lock"></i>
                                                        Locked - Purchase to Unlock
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Course Description -->
                                            <p style="font-size: 13px; color: #6b7280; margin-bottom: 12px;">
                                                {{ Str::limit($course->short_description, 150) }}
                                            </p>

                                            <!-- CHAPTERS & LESSONS -->
                                            <div class="curriculum-wrapper">

                                                @forelse ($course->chapters as $chIndex => $chapter)
                                                    <!-- CHAPTER HEADER -->
                                                    <div class="curriculum-header {{ $chIndex === 0 ? 'active' : 'collapsed' }}"
                                                        data-target="#course-{{ $course->id }}-chapter-{{ $chapter->id }}">

                                                        <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
                                                            <span>{{ $chIndex + 1 }}. {{ $chapter->title }}</span>
                                                            @if ($bundleIsLocked)
                                                                <span class="lock-indicator">
                                                                    <i class="fa-solid fa-lock"></i>
                                                                    Locked
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <i
                                                            class="fa-solid {{ $chIndex === 0 ? 'fa-chevron-up' : 'fa-chevron-down' }} arrow-icon"></i>
                                                    </div>

                                                    <!-- CHAPTER BODY (Lessons) -->
                                                    <div class="curriculum-body {{ $chIndex === 0 ? 'show' : '' }}"
                                                        id="course-{{ $course->id }}-chapter-{{ $chapter->id }}">

                                                        @forelse ($chapter->lessons as $lesson)
                                                            @php
                                                                $lessonUrl =
                                                                    $lesson->type === 'quiz'
                                                                        ? route('course.quiz', $lesson->id)
                                                                        : route('course.lesson', $lesson->slug);
                                                            @endphp

                                                            <a href="{{ $bundleIsLocked ? '#' : $lessonUrl }}"
                                                                class="curriculum-row lesson-link {{ $bundleIsLocked ? 'disabled' : '' }}"
                                                                @if ($lesson->type === 'quiz' && !$bundleIsLocked) target="_blank" @endif>

                                                                <!-- LEFT -->
                                                                <div class="left">
                                                                    @if ($lesson->type === 'video')
                                                                        <i class="fa-solid fa-play"></i>
                                                                    @elseif($lesson->type === 'quiz')
                                                                        <i class="fa-solid fa-clipboard-list"></i>
                                                                    @else
                                                                        <i class="fa-regular fa-file-lines"></i>
                                                                    @endif
                                                                    {{ $lesson->title }}

                                                                    @if ($bundleIsLocked)
                                                                        <span class="lock-indicator">
                                                                            <i class="fa-solid fa-lock"></i>
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                <!-- RIGHT -->
                                                                <div class="right">
                                                                    @if (!$bundleIsLocked)
                                                                        @if ($lesson->type === 'video' && $lesson->duration_seconds)
                                                                            {{ gmdate('i\m s\s', $lesson->duration_seconds) }}
                                                                        @elseif($lesson->type === 'quiz')
                                                                            Quiz
                                                                        @else
                                                                            Text
                                                                        @endif
                                                                    @endif
                                                                </div>

                                                            </a>

                                                        @empty

                                                            <div class="curriculum-row">
                                                                <div class="left text-muted">No lessons available
                                                                </div>
                                                            </div>
                                                        @endforelse

                                                    </div>

                                                @empty

                                                    <div class="curriculum-row">
                                                        <div class="left text-muted">No chapters available</div>
                                                    </div>
                                                @endforelse

                                            </div>

                                        </div>

                                    @empty

                                        <div class="alert alert-info">
                                            <i class="fa-solid fa-info-circle me-2"></i>
                                            No courses available in this bundle yet.
                                        </div>

                                    @endforelse

                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- SIDEBAR -->
                    <div class="col-lg-4">
                        <div class="courses-details__item-right">
                            <div class="item">
                                <h3>Bundle Includes:</h3>
                                <ul style="list-style: none; padding: 0; margin: 0;">

                                    <li style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                        <svg class="me-2" width="18" height="18" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.2857 2H5.71429C4.25714 2 3 3.25714 3 4.71429V15.2857C3 16.7429 4.25714 18 5.71429 18H14.2857C15.7429 18 17 16.7429 17 15.2857V4.71429C17 3.25714 15.7429 2 14.2857 2ZM15.4286 15.2857C15.4286 15.9857 14.85 16.5714 14.1429 16.5714H5.71429C5.01429 16.5714 4.42857 15.9857 4.42857 15.2857V4.71429C4.42857 4.01429 5.01429 3.42857 5.71429 3.42857H14.2857C14.9857 3.42857 15.5714 4.01429 15.5714 4.71429V15.2857H15.4286Z"
                                                fill="#2EB97E"></path>
                                            <path d="M12.5 10L8.5 12.5L8.5 7.5L12.5 10Z" fill="#2EB97E"></path>
                                        </svg>
                                        <p><strong>Courses:</strong> <span>{{ $bundle->title }}</span></p>
                                    </li>

                                    <li style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                        <svg class="me-2" width="18" height="18" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 16.5C6.41 16.5 3.5 13.59 3.5 10C3.5 6.41 6.41 3.5 10 3.5C13.59 3.5 16.5 6.41 16.5 10C16.5 13.59 13.59 16.5 10 16.5Z"
                                                fill="#2EB97E"></path>
                                            <path d="M10.75 6H9.5V10.5L13.88 13.28L14.52 12.36L10.75 9.88V6Z"
                                                fill="#2EB97E"></path>
                                        </svg>
                                        <p><strong>Lessons:</strong>
                                            <span>{{ $bundle->courses->sum(fn($c) => $c->chapters->sum(fn($ch) => $ch->lessons->count())) }}</span>
                                        </p>
                                    </li>

                                    <li style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                        <svg class="me-2" width="18" height="18" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 16.5C6.41 16.5 3.5 13.59 3.5 10C3.5 6.41 6.41 3.5 10 3.5C13.59 3.5 16.5 6.41 16.5 10C16.5 13.59 13.59 16.5 10 16.5Z"
                                                fill="#2EB97E"></path>
                                            <path
                                                d="M14.22 7.62L9.5 12.34L6.88 9.72L5.88 10.72L9.5 14.34L15.22 8.62L14.22 7.62Z"
                                                fill="#2EB97E"></path>
                                        </svg>
                                        <p><strong>Certificate:</strong> <span>Yes</span></p>
                                    </li>

                                    <li style="padding: 12px 0;">
                                        <svg class="me-2" width="18" height="18" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 16.5C6.41 16.5 3.5 13.59 3.5 10C3.5 6.41 6.41 3.5 10 3.5C13.59 3.5 16.5 6.41 16.5 10C16.5 13.59 13.59 16.5 10 16.5Z"
                                                fill="#2EB97E"></path>
                                            <path d="M9.5 7H10.5V10.5H14V11.5H9.5V7Z" fill="#2EB97E"></path>
                                        </svg>
                                        <p><strong>Lifetime Access:</strong> <span>Yes</span></p>
                                    </li>

                                </ul>

                                <a href="{{ $alreadyPurchased ? route('student.dashboard') : ($bundle->is_free ? route('bundle.enroll.free', $bundle->id) : route('bundle.course.checkout', $bundle->id)) }}"
                                    class="btn-one w-100" style="margin-top: 20px;">
                                    @if ($alreadyPurchased)
                                        Go to Dashboard
                                    @elseif($bundle->is_free)
                                        Enroll for Free
                                    @else
                                        Buy This Bundle
                                    @endif
                                    <i class="fa-light fa-arrow-right-long"></i>
                                </a>

                                <div class="share"
                                    style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                    <strong style="display: block; margin-bottom: 10px;">Share:</strong>
                                    <div class="social-icons">
                                        <a href="#0"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; border-radius: 50%; transition: all 0.3s; margin-right: 8px;"
                                            onmouseover="this.style.background='#e42433'; this.style.color='white'; this.style.borderColor='#e42433';"
                                            onmouseout="this.style.background=''; this.style.color=''; this.style.borderColor='';">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                        <a href="#0"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; border-radius: 50%; transition: all 0.3s; margin-right: 8px;"
                                            onmouseover="this.style.background='#e42433'; this.style.color='white'; this.style.borderColor='#e42433';"
                                            onmouseout="this.style.background=''; this.style.color=''; this.style.borderColor='';">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                        <a href="#0"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; border-radius: 50%; transition: all 0.3s; margin-right: 8px;"
                                            onmouseover="this.style.background='#e42433'; this.style.color='white'; this.style.borderColor='#e42433';"
                                            onmouseout="this.style.background=''; this.style.color=''; this.style.borderColor='';">
                                            <i class="fa-brands fa-linkedin-in"></i>
                                        </a>
                                        <a href="#0"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; border-radius: 50%; transition: all 0.3s;"
                                            onmouseover="this.style.background='#e42433'; this.style.color='white'; this.style.borderColor='#e42433';"
                                            onmouseout="this.style.background=''; this.style.color=''; this.style.borderColor='';">
                                            <i class="fa-brands fa-youtube"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

@endsection

@push('script')
    <script>
        document.querySelectorAll('.curriculum-header').forEach(header => {
            header.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.target);

                // Find all headers in this course
                const courseContainer = this.closest('.course-in-bundle');
                const courseHeaders = courseContainer.querySelectorAll('.curriculum-header');
                const courseBodies = courseContainer.querySelectorAll('.curriculum-body');

                // Close all chapters in this course
                courseHeaders.forEach(h => {
                    h.classList.remove('active');
                    h.classList.add('collapsed');
                    const arrow = h.querySelector('.arrow-icon');
                    if (arrow) {
                        arrow.classList.remove('fa-chevron-up');
                        arrow.classList.add('fa-chevron-down');
                    }
                });

                courseBodies.forEach(body => {
                    body.classList.remove('show');
                });

                // Open current chapter
                this.classList.add('active');
                this.classList.remove('collapsed');
                const arrow = this.querySelector('.arrow-icon');
                if (arrow) {
                    arrow.classList.remove('fa-chevron-down');
                    arrow.classList.add('fa-chevron-up');
                }

                if (target) {
                    target.classList.add('show');
                }
            });
        });

        // Open first chapter of each course by default
        document.querySelectorAll('.course-in-bundle').forEach(courseContainer => {
            const firstHeader = courseContainer.querySelector('.curriculum-header');
            if (firstHeader) {
                firstHeader.click();
            }
        });
    </script>
@endpush
