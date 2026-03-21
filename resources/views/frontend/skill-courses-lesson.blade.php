@extends('frontend.layout.layout')

@section('title', $lesson->title . ' | Lesson')

@push('style')
    <style>
        .lock-icon {
            font-size: 14px;
            margin-right: -96px;
            /* space before arrow */

        }

        .lesson-link.disabled {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')

    <!-- Banner -->
    <section class="banner-inner-area sub-bg bg-image">
        <div class="container">
            <div class="banner-inner__content">
                <h1>{{ $course->title }}</h1>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>{{ $course->title }}</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="lesson-container">

        <div class="container">
            <div class="row g-4 align-items-start">

                <!-- LEFT : VIDEO + CONTENT -->
                <div class="col-lg-8 col-md-12">
                    <div class="lesson-main-card">

                        {{-- VIDEO --}}
                        @if ($lesson->type === 'video' && $lesson->embed_video_url)
                            <div class="video-wrapper">
                                <iframe src="{{ $lesson->embed_video_url }}" allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                </iframe>
                            </div>
                        @endif

                        <div class="mx-3 mt-4 p-3 border rounded-3 bg-light">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    @if ($lesson->is_completed)
                                        <div class="text-success fw-semibold">
                                            <i class="bi bi-check-circle-fill me-2"></i>
                                            Lesson completed successfully
                                        </div>
                                        <small class="text-muted">
                                            Great job! You can now proceed to the next lesson.
                                        </small>
                                    @else
                                        <div class="fw-semibold">
                                            Mark this lesson as complete
                                        </div>
                                        <small class="text-muted">
                                            Finish all lessons and pass the quiz to earn your official course completion
                                            certificate.
                                        </small>
                                    @endif
                                </div>

                                <button onclick="completeLesson({{ $lesson->id }})"
                                    class="btn {{ $lesson->is_completed ? 'btn-success' : 'btn-outline-success' }} px-4"
                                    {{ $lesson->is_completed ? 'disabled' : '' }}>

                                    @if ($lesson->is_completed)
                                        <i class="bi bi-check-circle-fill"></i> Completed
                                    @else
                                        <i class="bi bi-check-circle"></i> Mark as Completed
                                    @endif
                                </button>

                            </div>

                        </div>


                        <div class="lesson-content">
                            <h1 class="lesson-title">{{ $lesson->title }}</h1>

                            <div class="lesson-meta">
                                <span class="meta-tag">
                                    <i class="fa-solid fa-play"></i>
                                    Video
                                </span>

                                @if ($lesson->chapter)
                                    <span class="meta-tag">
                                        <i class="fa-solid fa-book"></i>
                                        {{ $lesson->chapter->title }}
                                    </span>
                                @endif
                            </div>

                            @if ($lesson->content)
                                <div class="lesson-description">
                                    {!! $lesson->content !!}

                                    {{-- Download Button --}}
                                    <div class="text-end mb-4">
                                        <a href="{{ static_asset($lesson->pdf_file) }}" target="_blank" download
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-file-pdf me-1"></i>
                                            Download PDF
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- RIGHT : COURSE CONTENT -->
                <div class="col-lg-4 col-md-12">
                    <div class="lesson-sidebar">

                        <div class="curriculum-card">

                            {{-- PROGRESS --}}

                            <div class="curriculum-title">Course Content</div>

                            <div class="curriculum-content">
                                @foreach ($course->chapters as $index => $chapter)
                                    @php
                                        $isLocked = $chapter->is_locked;
                                    @endphp

                                    <div class="chapter-item">

                                        {{-- CHAPTER HEADER --}}
                                        <div class="chapter-header {{ $index === 0 ? 'active' : '' }}"
                                            data-target="#chap{{ $chapter->id }}">

                                            {{ $chapter->title }}

                                            {{-- LOCK ICON --}}
                                            @if ($isLocked)
                                                <i class="fa-solid fa-lock lock-icon ms-2"></i>
                                            @endif

                                            <i class="fa-solid fa-chevron-down chapter-icon"></i>
                                        </div>

                                        {{-- CHAPTER LESSONS --}}
                                        <div class="chapter-lessons {{ $index === 0 ? 'show' : '' }}"
                                            id="chap{{ $chapter->id }}">

                                            {{-- ================= LESSONS ================= --}}
                                            @foreach ($chapter->lessons as $l)
                                                <a href="{{ $isLocked ? '#' : route('course.lesson', $l->slug) }}"
                                                    class="lesson-link
                                                        {{ $l->id === ($lesson->id ?? null) ? 'active' : '' }}
                                                        {{ $isLocked ? 'disabled' : '' }}">

                                                    <div class="lesson-left">
                                                        <div class="lesson-icon">
                                                            @if ($l->type === 'video')
                                                                <i class="fa-solid fa-play"></i>
                                                            @else
                                                                <i class="fa-solid fa-file-lines"></i>
                                                            @endif
                                                        </div>

                                                        <span class="lesson-text">{{ $l->title }}</span>
                                                    </div>

                                                    {{-- DURATION ONLY FOR VIDEO --}}
                                                    @if ($l->type === 'video')
                                                        <span class="lesson-duration">
                                                            {{ gmdate('i\m s\s', $l->duration_seconds) }}
                                                        </span>
                                                    @endif
                                                </a>
                                            @endforeach


                                            {{-- ================= QUIZ ================= --}}
                                            @foreach ($chapter->quizzes as $quiz)
                                                <a href="{{ $isLocked ? '#' : route('course.quiz', $quiz->id) }}"
                                                    class="lesson-link quiz-link {{ $isLocked ? 'disabled' : '' }}"
                                                    target="_blank">

                                                    <div class="lesson-left">
                                                        <div class="lesson-icon quiz">
                                                            <i class="fa-solid fa-clipboard"></i>
                                                        </div>

                                                        <span class="lesson-text">
                                                            {{ $quiz->title }}
                                                            ({{ $quiz->questions->count() }} Questions)
                                                        </span>
                                                    </div>

                                                    <span class="lesson-duration">
                                                        {{ $quiz->total_marks }} Marks
                                                    </span>
                                                </a>
                                            @endforeach

                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
    <section class="courses-area pb-120">
        <div class="container">
            <div class="section-header mb-60 text-center">
                <h2 class="wow fadeInUp mt-5" data-wow-delay="200ms" data-wow-duration="1500ms">
                    Recommended Courses
                </h2>
            </div>

            <div class="swiper courses__slider">
                <div class="swiper-wrapper">

                    @foreach ($recommendedCourses as $course)
                        <div class="swiper-slide">
                            <div class="courses-two__item">

                                <!-- IMAGE -->
                                <div class="courses-two__image image">
                                    <img src="{{ static_asset($course->thumbnail) }}" alt="{{ $course->title }}">
                                    <span class="time">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        {{ $course->duration }}
                                    </span>
                                </div>

                                <!-- CONTENT -->
                                <div class="courses__content pt-4 p-0">

                                    <div class="courses-two__info pb-4">
                                        <a href="#">{{ ucfirst($course->level) }}</a>
                                        <h4>₹{{ $course->price }}</h4>
                                    </div>

                                    <h3>
                                        <a href="{{ route('course.details', $course->slug) }}" class="primary-hover">
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
                    @endforeach

                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // CHAPTER ACCORDION
            const chapterHeaders = document.querySelectorAll('.chapter-header');

            chapterHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const target = document.querySelector(this.dataset.target);

                    // Close all other chapters
                    chapterHeaders.forEach(h => {
                        if (h !== this) {
                            h.classList.remove('active');
                        }
                    });

                    document.querySelectorAll('.chapter-lessons').forEach(lessons => {
                        if (lessons !== target) {
                            lessons.classList.remove('show');
                        }
                    });

                    // Toggle current chapter
                    this.classList.toggle('active');
                    target.classList.toggle('show');
                });
            });

            // SCROLL TO ACTIVE LESSON
            const activeLesson = document.querySelector('.lesson-link.active');
            if (activeLesson) {
                setTimeout(() => {
                    activeLesson.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 200);
            }

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // CHAPTER ACCORDION
            const chapterHeaders = document.querySelectorAll('.chapter-header');

            chapterHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const target = document.querySelector(this.dataset.target);

                    chapterHeaders.forEach(h => h.classList.remove('active'));
                    document.querySelectorAll('.chapter-lessons').forEach(l => l.classList.remove(
                        'show'));

                    this.classList.add('active');
                    target.classList.add('show');
                });
            });

            // SCROLL TO ACTIVE LESSON
            const activeLesson = document.querySelector('.lesson-link.active');
            if (activeLesson) {
                activeLesson.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        });
    </script>

    <script>
        const lessonCompleteUrlTemplate = "{{ route('lesson.complete', ':id') }}";

        function completeLesson(lessonId) {

            let url = lessonCompleteUrlTemplate.replace(':id', lessonId);

            fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {
                        toastr.success(data.message);
                    } else {
                        toastr.error("Something went wrong.");
                    }

                })
                .catch(() => {
                    toastr.error("Server error occurred.");
                });
        }
    </script>
@endpush
