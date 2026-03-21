@extends('backend.layout.layouts')
@section('title', 'Quizzes - Career Guidance Services | EFOS Edumarketers Pvt Ltd')


@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Quizzes</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Quizzes</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Quizzes Mangment</h6>

                        </div>

                        <div class="card-body p-0 pb-2">
                            {{-- Tabs --}}
                            <div class="mx-3 my-4">
                                <ul class="nav nav-pills nav-fill gap-2 p-2 bg-light rounded-3 shadow-sm" id="quizTabs"
                                    role="tablist">

                                    <li class="nav-item">
                                        <button
                                            class="nav-link active d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                            data-bs-toggle="tab" data-bs-target="#tab-quizzes">
                                            <i class="bi bi-journal-text"></i>
                                            <span>Quizzes</span>
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button
                                            class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                            data-bs-toggle="tab" data-bs-target="#tab-questions">
                                            <i class="bi bi-question-circle"></i>
                                            <span>Questions</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                            class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                            data-bs-toggle="tab" data-bs-target="#tab-attempts">
                                            <i class="bi bi-clock-history"></i>
                                            <span>Quiz Results</span>
                                        </button>
                                    </li>


                                    <li class="nav-item">
                                        <button
                                            class="nav-link d-flex align-items-center justify-content-center gap-1 fw-semibold"
                                            data-bs-toggle="tab" data-bs-target="#tab-certificates">
                                            <i class="bi bi-award"></i>
                                            <span>Certificates</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content px-3 pb-3" id="quizTabsContent">

                                <div class="tab-pane fade show active" id="tab-quizzes">
                                    @include('backend.lms.quiz.partials.quizzes-table')
                                </div>

                                <div class="tab-pane fade" id="tab-questions">
                                    @include('backend.lms.quiz.partials.questions-table')
                                </div>

                                <div class="tab-pane fade" id="tab-attempts">
                                    @include('backend.lms.quiz.partials.attempts-table')
                                </div>

                                <div class="tab-pane fade" id="tab-certificates">
                                    @include('backend.lms.quiz.partials.certificates-table')
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
