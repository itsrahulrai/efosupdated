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
        <!-- Courses area start here -->
        <section class="courses-details-two-area pt-100 pb-100">
            <div class="container">
                <h3 class="mb-3" id="jobHeading">
                    Legal Trusted Verified Opportunities
                </h3>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <!-- Job Details Card -->
                        <div class="card shadow-sm filter-card border-0">
                            <div class="card-body">
                                <h4 class="filters-title bold"><i class="bi bi-funnel"></i> Filters</h4>
                                <div class="filter-box border-bottom pb-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center filter-toggle"
                                        data-bs-toggle="collapse" data-bs-target="#dateFilter" style="cursor: pointer;">
                                        <h5 class="mb-0">Date Posted</h5>
                                        <i class="bi bi-chevron-down small text-muted"></i>
                                    </div>
                                    <div id="dateFilter" class="collapse show mt-2">
                                        <div class="list-group border-0">
                                            <label class="list-group-item d-flex align-items-center px-0 border-0">
                                                <input class="form-check-input me-2" value="" type="radio"
                                                    name="datePosted" checked>
                                                All
                                            </label>
                                            <label class="list-group-item d-flex align-items-center px-0 border-0">
                                                <input class="form-check-input me-2" value="24h" type="radio"
                                                    name="datePosted">
                                                Last 24 hours
                                            </label>
                                            <label class="list-group-item d-flex align-items-center px-0 border-0">
                                                <input class="form-check-input me-2" value="3d" type="radio"
                                                    name="datePosted">
                                                Last 3 days
                                            </label>
                                            <label class="list-group-item d-flex align-items-center px-0 border-0">
                                                <input class="form-check-input me-2" value="7d" type="radio"
                                                    name="datePosted">
                                                Last 7 days
                                            </label>
                                        </div>
                                    </div>
                                    {{-- Category --}}
                                    <div class="filter-box border-bottom pb-2 mb-3">
                                        <h5 class="mb-2">Category</h5>
                                        <select id="job_category_id" class="form-select"
                                            data-sub-url="{{ url('jobs/subcategories') }}">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Sub Category --}}
                                    <div class="filter-box pb-2 mb-3">
                                        <h5 class="mb-2">Sub Category</h5>
                                        <select id="job_sub_category_id" class="form-select">
                                            <option value="">Select Category First</option>
                                        </select>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div id="jobsContainer">
                            @include('frontend.partials.jobs-list', ['jobs' => $jobs])
                        </div>
                    </div>
                </div>




            </div>
            </div>
        </section>
        <!-- Courses area end here -->
        <!-- Courses area end here -->

    </main>

    @push('script')
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
            const currentCategorySlug = "{{ optional($category)->slug }}";
        </script>


        <script>
            /* ==================================
                            GLOBAL JOB LOADER
                            ================================== */
            let jobRequest = null; // prevent duplicate AJAX calls

            window.loadJobs = function(page = 1) {

                // Abort previous request if running
                if (jobRequest) {
                    jobRequest.abort();
                }

                let url = (typeof currentCategorySlug !== 'undefined' && currentCategorySlug) ?
                    "{{ url('opportunity-highlights') }}/" + currentCategorySlug :
                    "{{ route('opportunity-highlights') }}";

                // Show loading
                $('#jobsContainer').addClass('opacity-50');

                jobRequest = $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        search: $('#jobSearch').val(),
                        job_category_id: $('#job_category_id').val(),
                        job_sub_category_id: $('#job_sub_category_id').val(),
                        date_posted: $('input[name="datePosted"]:checked').val(),
                        page: page
                    },

                    success: function(res) {
                        $('#jobsContainer').html(res);
                    },
                    complete: function() {
                        $('#jobsContainer').removeClass('opacity-50');
                        jobRequest = null;
                    },
                    error: function(xhr) {
                        if (xhr.status !== 0) {
                            console.error('Job load failed');
                        }
                    }
                });
            };


            /* ==================================
            EVENTS
            ================================== */
            $(document).ready(function() {

                /* DATE FILTER */
                $(document).on('change', 'input[name="datePosted"]', function() {
                    loadJobs(1);
                });

                /* CATEGORY → SUB CATEGORY */
                $('#job_category_id').on('change', function() {
                    let categoryId = $(this).val();
                    let baseUrl = $(this).data('sub-url');

                    // reset sub category
                    $('#job_sub_category_id')
                        .html('<option value="">Loading...</option>')
                        .prop('disabled', true);

                    // load jobs by category only
                    loadJobs(1);

                    if (!categoryId) {
                        $('#job_sub_category_id')
                            .html('<option value="">Select Category First</option>')
                            .prop('disabled', true);
                        return;
                    }

                    $.ajax({
                        url: baseUrl + '/' + categoryId,
                        type: 'GET',
                        success: function(data) {

                            let options = '<option value="">All Sub Categories</option>';

                            if (data.length === 0) {
                                options += '<option value="">No sub-categories</option>';
                            } else {
                                data.forEach(sub => {
                                    options +=
                                        `<option value="${sub.id}">${sub.name}</option>`;
                                });
                            }

                            $('#job_sub_category_id')
                                .html(options)
                                .prop('disabled', false);
                        },
                        error: function() {
                            alert('Sub-category loading failed');
                        }
                    });
                });


                /* SUB CATEGORY */
                $('#job_sub_category_id').on('change', function() {
                    loadJobs(1);
                });

                /* PAGINATION */
                $(document).on('click', '#jobsContainer .pegi a', function(e) {
                    e.preventDefault();
                    let page = new URL($(this).attr('href')).searchParams.get('page');
                    loadJobs(page || 1);
                });

                /* 🔍 SEARCH (DEBOUNCED) */
                let typingTimer;
                $('#jobSearch').on('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => loadJobs(1), 400);
                });

                $('.menu-search button').on('click', function() {
                    loadJobs(1);
                });

                /* INITIAL LOAD */
                loadJobs(1);
            });
        </script>
    @endpush





@endsection
