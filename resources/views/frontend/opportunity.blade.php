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

@php
$ogImage = !empty($job->company_logo)
? static_asset($job->company_logo)
: static_asset('assets/images/share/job-share.jpg');
@endphp

@section('og_title', $job->title . ' | EFOS Opportunities')
@section('og_description', Str::limit(strip_tags($job->short_description), 160))
@section('og_image', $ogImage)
@section('og_url', url()->current())

@section('twitter_title', $job->title)
@section('twitter_description', Str::limit(strip_tags($job->short_description), 160))
@section('twitter_image', $ogImage)



<style>
    /* ===== MOBILE SHARE FIX ===== */
@media (max-width: 768px) {

    .share .social-icons {
        display: flex !important;
        gap: 12px;
        margin-top: 8px;
    }

    .share .social-icons a {
        width: 40px;
        height: 40px;
        border: 1px solid #ff0000;   /* same as desktop red border */
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: #ff0000;
        background: #fff;
        font-size: 16px;
    }

    .share strong {
        display: block;
        margin-bottom: 6px;
    }
}
</style>
@section('content')

<main>

    <!-- Courses area start here -->
    <section class="courses-details-two-area pt-120 pb-120">
        <div class="container">

            <div class="row g-4">
                <div class="col-lg-8 order-1 order-lg-1">

                    <!-- Job Details Card -->
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">

                            <!-- Job Title + Company -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    @if (!empty($job->company_logo))
                                    <img src="{{ static_asset($job->company_logo) }}" alt="{{ $job->company_name }}"
                                        class="rounded-circle border"
                                        style="
                                                width:48px;
                                                height:48px;
                                                object-fit:cover;
                                                background:#fff;
                                            ">
                                    @else
                                    <div class="bg-dark text-white rounded-circle fw-bold"
                                        style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                                        {{ strtoupper(substr($job->company_name ?? 'O', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>

                                <div>
                                    <h5 class="mb-0 fw-bold">{{ $job->title }}</h5>
                                    <small class="text-muted">
                                        {{ $job->company_name ?? 'Opportunity Provider' }}</small>
                                </div>
                            </div>

                            <!-- Location + Salary -->
                            <div class="d-flex justify-content-between mt-2">
                                <div class="text-muted">
                                    <i class="bi bi-geo-alt"></i> {{ $job->district }}, {{ $job->state }}
                                </div>
                                <div class="fw-semibold">
                                    {{ $job->salary }}
                                </div>
                            </div>

                            <hr>

                            <!-- Salary Boxes -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block">Eligibility </small>
                                        <span class="fw-semibold">{{ $job->eligibility }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block">Age Limit</small>
                                        <span class="fw-semibold">{{ $job->age_limit }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="badge text-dark border bg-primary-subtle">
                                    <i class="bi bi-building me-1"></i> {{ $job->work_mode }}
                                </span>
                                <span class="badge text-dark border bg-success-subtle">
                                    <i class="bi bi-briefcase me-1"></i> {{ $job->job_type }}
                                </span>
                                <span class="badge text-dark border bg-dark-subtle">
                                    <i class="bi bi-moon-stars me-1"></i> {{ $job->shift }}
                                </span>
                                <span class="badge text-dark border bg-warning-subtle">
                                    <i class="bi bi-person-check me-1"></i> {{ $job->experience }}
                                </span>
                                <span class="badge text-dark border bg-info-subtle">
                                    <i class="bi bi-translate me-1"></i> {{ $job->english_level }}
                                </span>
                            </div>


                            <!-- Job Actions Section -->
                            <div class="d-flex gap-2 mt-3">

                                <!-- Expired Alert -->
                                <div class="alert alert-danger py-2 px-3" id="expired-alert" style="display: none;">
                                    This Opportunity has expired
                                </div>



                                <!-- Apply Button -->
                                @auth
                                @if($alreadyApplied)
                                <button class="btn btn-secondary w-50" disabled>
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Already Applied
                                </button>

                                @else
                                <form action="{{ route('jobs.apply', $job->id) }}" method="POST" class="w-50">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        Apply for Opportunity
                                    </button>
                                </form>
                                @endif
                                @else
                                <a href="{{ route('student.login', ['redirect' => url()->current()]) }}"
                                    class="btn btn-success w-50">
                                    Apply for Opportunity
                                </a>
                                @endauth



                                <!-- Share Button -->
                                <button
                                    class="btn btn-outline-secondary w-50 d-flex justify-content-center align-items-center gap-2"
                                    id="share-btn">
                                    <i class="bi bi-share"></i>
                                    Share
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 rounded-3 p-3 mt-4">
                        <!-- Highlights Box -->
                        @if (!empty($job->highlights))
                        <div class="p-3 rounded border" style="background:#f3f7ff !important;">
                            <h4 class="fw-bold mb-3">Opportunity highlights</h4>

                            <div class="row g-3">
                                @foreach ($job->highlights as $index => $highlight)
                                @break($index == 4) {{-- max 4 only --}}

                                <div class="col-md-3 d-flex align-items-center gap-2">
                                    @if ($index == 0)
                                    <i class="bi bi-fire fs-4 text-danger"></i>
                                    @elseif($index == 1)
                                    <i class="bi bi-lightning-charge fs-4 text-primary"></i>
                                    @elseif($index == 2)
                                    <i class="bi bi-people fs-4 text-info"></i>
                                    @else
                                    <i class="bi bi-star fs-4 text-warning"></i>
                                    @endif

                                    <span>{{ $highlight }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif


                        <hr>
                        <!-- Job Description -->
                        <h4 class="fw-bold">Opportunity Description</h4>

                        <!-- Short Description -->
                        <p> {{ $job->short_description }}</p>

                        <!-- Full Description (Hidden by default) -->
                        <div id="fullDescription" style="display: none;">
                            <p>
                                {!! $job->description !!}
                            </p>
                        </div>

                        <!-- Toggle Button -->
                        <div class="d-flex justify-content-end">
                            <button id="toggleBtn" class="btn-one mt-2">Show More</button>
                        </div>

                    </div>

                    <div class="card shadow-sm border-0 rounded-3 p-3 mt-4">
                        <h4 class="fw-bold mb-3">Opportunity requirements</h4>
                        <div class="row gy-4">
                            <!-- Experience -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-briefcase fs-4 text-primary"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">Experience</h6>
                                        <p class="mb-0 text-muted">{{ $job->experience }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-mortarboard fs-4 text-success"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">Education</h6>
                                        <p class="mb-0 text-muted">{{ $job->education }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-pencil-square fs-4 text-warning"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">Skills</h6>
                                        <p class="mb-0 text-muted">
                                            {{ $job->skills }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- English Level -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-translate fs-4 text-info"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">English level</h6>
                                        <p class="mb-0 text-muted">{{ $job->english_level }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Age Limit -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-map fs-4 text-danger"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">Location </h6>
                                        <p class="mb-0 text-muted">{{ $job->district }}, {{ $job->state }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-person fs-4 text-secondary"></i>
                                    <div>
                                        <h6 class="fw-bold fs-5 mb-1 text-dark">Gender</h6>
                                        <p class="mb-0 text-muted">{{ $job->gender ?? 'Any gender' }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card shadow-sm border-0 rounded-3 p-3 mt-4">
                        <h4 class="fw-bold mb-3">About Opportunity Provider</h4>
                        <div class="mb-4">
                            <!-- Company Name -->
                            <div class="d-flex gap-3 mb-3">
                                <i class="bi bi-building fs-4 text-primary"></i>
                                <div>
                                    <h6 class="fw-bold fs-5 mb-1 text-dark">Name</h6>
                                    <p class="mb-0 fw-semibold"> {{ $job->company_name ?? 'Opportunity Provider' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Company Address -->
                            <div class="d-flex gap-3">
                                <i class="bi bi-geo-alt fs-4 text-danger"></i>
                                <div>
                                    <h6 class="fw-bold fs-5 mb-1 text-dark">Location</h6>
                                    <p class="mb-0">
                                        {{ $job->district }}, {{ $job->state }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Footer Note -->
                        <p class="mb-0">
                            Opportunity posted by <span class="fw-semibold">
                                {{ $job->posted_by ?? 'Opportunity Provider' }}</span>
                        </p>
                    </div>

                    {{-- ========== MOBILE SIMILAR OPPORTUNITIES ========== --}}
                    <div class="card shadow-sm border-0 rounded-3 p-3 mt-4 d-block d-lg-none">

                        <h4 class="fw-bold mb-3">Similar Opportunities</h4>

                        <ul class="list-group list-group-flush">

                            @forelse($similarJobs as $similar)
                            <li class="list-group-item px-0">
                                <a href="{{ route('jobs.show', $similar->slug) }}"
                                    class="fw-semibold text-dark text-decoration-none">
                                    {{ $similar->title }}
                                </a>
                            </li>
                            @empty
                            <li class="list-group-item px-0 text-muted">
                                No similar opportunities found.
                            </li>
                            @endforelse

                        </ul>

                          {{-- ================= MOBILE SHARE (SAME DESIGN) ================= --}}
                    <div class="d-block d-lg-none mt-4">
                          <div class="share">
                                <strong>Share:</strong>
                                <div class="social-icons">
                                    <!-- Facebook -->
                                    <a target="_blank"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <!-- Twitter (X) -->
                                    <a target="_blank"
                                        href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title ?? 'Check this out') }}">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <!-- LinkedIn -->
                                    <a target="_blank"
                                        href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    <!-- WhatsApp (very important for India 🇮🇳) -->
                                    <a target="_blank"
                                        href="https://api.whatsapp.com/send?text={{ urlencode(($blog->title ?? 'Check this post').' '.url()->current()) }}">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                      
                    </div>
                    </div>

                  



                </div>


                <div class="col-lg-4 order-2 order-lg-2">
                    <div class="mb-3">
                        <img class="img-fluid rounded"
                            src="{{static_asset('assets/images/job.jpg')}}"
                            alt="image">
                    </div>
                    <div class="courses-details__item-right bg-white">

                        <div class="item d-none d-lg-block">
                            <h3>Similar Opportunity </h3>
                            <!-- Job Item -->
                            <!-- Job Item -->
                            @forelse($similarJobs as $similar)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ static_asset($similar->company_logo ?? 'assets/images/favicon.png') }}"
                                        width="50" class="me-2 rounded" alt="logo">

                                    <div>
                                        <h5 class="mb-0 fw-semibold">
                                            <a href="{{ route('jobs.show', $similar->slug) }}"
                                                class="text-dark text-decoration-none">
                                                {{ $similar->title }}
                                            </a>
                                        </h5>
                                        <small class="text-muted">
                                            {{ $similar->company_name ?? 'Opportunity Provider' }}
                                        </small>
                                    </div>
                                </div>

                                <div class="text-muted mb-1 fw-semibold">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $similar->district }}, {{ $similar->state }}
                                </div>

                                @if ($similar->salary)
                                <div class="mb-2">{{ $similar->salary }}</div>
                                @endif

                                <div class="d-flex gap-2 flex-wrap">
                                    @if ($similar->work_mode)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-building"></i> {{ $similar->work_mode }}
                                    </span>
                                    @endif

                                    @if ($similar->job_type)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-clock"></i> {{ $similar->job_type }}
                                    </span>
                                    @endif

                                    @if ($similar->experience)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-briefcase"></i> {{ $similar->experience }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">No similar opportunities found.</p>
                            @endforelse


                            @auth
                            <a href="{{ route('student.dashboard') }}" class="btn-one">
                                Go to Dashboard
                                <i class="fa-light fa-arrow-right-long"></i>
                            </a>
                            @else
                            <a href="{{ route('student.login') }}" class="btn-one">
                                Apply for Opportunity
                                <i class="fa-light fa-arrow-right-long"></i>
                            </a>
                            @endauth
                            <div class="share">
                                <strong>Share:</strong>
                                <div class="social-icons">
                                    <!-- Facebook -->
                                    <a target="_blank"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <!-- Twitter (X) -->
                                    <a target="_blank"
                                        href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title ?? 'Check this out') }}">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <!-- LinkedIn -->
                                    <a target="_blank"
                                        href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    <!-- WhatsApp (very important for India 🇮🇳) -->
                                    <a target="_blank"
                                        href="https://api.whatsapp.com/send?text={{ urlencode(($blog->title ?? 'Check this post').' '.url()->current()) }}">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Courses area end here -->
    <!-- Courses area end here -->

</main>

<script>
    const fullDesc = document.getElementById("fullDescription");
    const toggleBtn = document.getElementById("toggleBtn");

    toggleBtn.addEventListener("click", () => {
        if (fullDesc.style.display === "none") {
            fullDesc.style.display = "block";
            toggleBtn.textContent = "Show Less";
        } else {
            fullDesc.style.display = "none";
            toggleBtn.textContent = "Show More";
        }
    });
</script>

<script>
    document.getElementById("share-btn").addEventListener("click", function() {
        let pageUrl = window.location.href;
        let text = "Check this page:";

        if (navigator.share) {
            // Mobile browsers (native share)
            navigator.share({
                title: document.title,
                text: text,
                url: pageUrl
            });
        } else {
            // Desktop fallback (WhatsApp example)
            let whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(text + " " + pageUrl);
            window.open(whatsappUrl, "_blank");
        }
    });
</script>



@endsection