    @extends('backend.layout.layouts')
    @section('title', 'Mentor Platform - Career Guidance Services | EFOS Edumarketers Pvt Ltd')


    @section('content')

        <main class="app-wrapper">
            <div class="container">
                <div class="app-page-head d-flex align-items-center justify-content-between">
                    <div class="clearfix">
                        <h1 class="app-page-title"> Mentor Platform</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mentor Platform</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h6 class="card-title mb-0">Mentor Platform</h6>

                            </div>

                            <div class="card-body p-0 pb-2">
                                {{-- Tabs --}}
                                <div class="mx-3 my-4">
                                    <ul class="nav nav-pills nav-fill gap-2 p-2 bg-light rounded-3 shadow-sm" id="quizTabs"
                                        role="tablist">

                                        <li class="nav-item">
                                            <button
                                                class="nav-link active d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                                data-bs-toggle="tab" data-bs-target="#tab-expertise">
                                                <i class="bi bi-journal-text"></i>
                                                <span>Expertise</span>
                                            </button>
                                        </li>

                                        <li class="nav-item">
                                            <button
                                                class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                                data-bs-toggle="tab" data-bs-target="#tab-mentors">
                                                <i class="bi bi-question-circle"></i>
                                                <span>Mentors</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button
                                                class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                                data-bs-toggle="tab" data-bs-target="#tab-prices">
                                                <i class="bi bi-clock-history"></i>
                                                <span>Prices</span>
                                            </button>
                                        </li>

                                          <li class="nav-item">
                                            <button
                                                class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                                data-bs-toggle="tab" data-bs-target="#tab-availability">
                                               <i class="bi bi-calendar-check"></i>
                                                <span>Availability</span>
                                            </button>
                                        </li>

                                        <li class="nav-item">
                                            <button
                                                class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                                data-bs-toggle="tab" data-bs-target="#tab-bookings">
                                                <i class="bi bi-award"></i>
                                                <span>Bookings</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content px-3 pb-3" id="quizTabsContent">

                                    <div class="tab-pane fade show active" id="tab-expertise">
                                        @include('backend.mentor.categories.index')
                                    </div>

                                    <div class="tab-pane fade" id="tab-mentors">
                                        @include('backend.mentor.profile.index')
                                    </div>

                                    <div class="tab-pane fade" id="tab-prices">
                                         @include('backend.mentor.session-price.index')
                                    </div>
                                      <div class="tab-pane fade" id="tab-availability">
                                         @include('backend.mentor.availability.index')
                                    </div>

                                    <div class="tab-pane fade" id="tab-bookings">
                                    
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    @endsection
    @push('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let url = new URL(window.location.href);
                let tab = url.searchParams.get('tab');

                if (tab) {

                    let triggerEl = document.querySelector('[data-bs-target="#' + tab + '"]');

                    if (triggerEl) {
                        let tabObj = new bootstrap.Tab(triggerEl);
                        tabObj.show();
                    }

                }

            });
        </script>
    @endpush
