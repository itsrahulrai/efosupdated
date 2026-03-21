

    @forelse($jobs as $job)
        <div class="card shadow-sm filter-card border-0 mb-3">
            <div class="card-body">

                <!-- Title + Company -->
                <div class="d-flex align-items-center">
                    <img src="{{ static_asset($job->company_logo ?? 'assets/images/favicon.png') }}"
                         width="50"
                         class="me-2 rounded"
                         alt="logo">

                    <div>
                      <h5 class="mb-0 fw-semibold">
                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-dark text-decoration-none">
                            {{ $job->title }}
                        </a>
                    </h5>
                                            <small class="text-muted">
                            {{ $job->company_name ?? 'Opportunity Provider' }}
                        </small>
                    </div>
                </div>

                <!-- Location -->
                <div class="text-muted mb-1 fw-semibold mt-2">
                    <i class="bi bi-geo-alt"></i>
                    {{ $job->district }}, {{ $job->state }}
                </div>

                <!-- Salary -->
                @if($job->salary)
                    <div class="mb-2">{{ $job->salary }}</div>
                @endif

                <!-- Badges -->
                <div class="mt-3 d-flex flex-wrap gap-2">

                    @if($job->work_mode)
                        <span class="badge text-dark border bg-primary-subtle">
                            <i class="bi bi-building me-1"></i> {{ $job->work_mode }}
                        </span>
                    @endif

                    @if($job->job_type)
                        <span class="badge text-dark border bg-success-subtle">
                            <i class="bi bi-briefcase me-1"></i> {{ $job->job_type }}
                        </span>
                    @endif

                    @if($job->shift)
                        <span class="badge text-dark border bg-dark-subtle">
                            <i class="bi bi-moon-stars me-1"></i> {{ $job->shift }}
                        </span>
                    @endif

                    @if($job->experience)
                        <span class="badge text-dark border bg-warning-subtle">
                            <i class="bi bi-person-check me-1"></i> {{ $job->experience }}
                        </span>
                    @endif

                    @if($job->english_level)
                        <span class="badge text-dark border bg-info-subtle">
                            <i class="bi bi-translate me-1"></i> {{ $job->english_level }}
                        </span>
                    @endif

                </div>

                <!-- Short Description -->
                @if($job->short_description)
                    <p class="mt-3 mb-0 text-muted">
                        {{ $job->short_description }}
                    </p>
                @endif

                <!-- Apply Button -->
                <div class="mt-3 d-flex gap-2">

                    @auth
                        @if(isset($job->already_applied) && $job->already_applied)
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Already Applied
                            </button>
                        @else
                            <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-send me-1"></i>
                                   Apply for Opportunity
                                </button>
                            </form>
                        @endif
                    @else
                        {{-- <a href="{{ route('student.login', ['redirect' => route('jobs.show', $job->slug)]) }}"
                        class="btn btn-success btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login to Apply
                        </a> --}}
                        <a href="{{ route('student.login', ['apply_job' => $job->id]) }}"
                            class="btn btn-success btn-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Login to Apply
                            </a>
                            @endauth

                </div>

            </div>
        </div>

    @empty
       <div class="card border-0 shadow-sm text-center py-5">
    <div class="card-body">
        <i class="bi bi-briefcase fs-1 text-warning mb-3"></i>
        <h5 class="fw-semibold mb-2">No Opportunities Found</h5>
        <p class="text-muted mb-0">
            We couldn’t find any jobs matching your current filters.
            Try adjusting your search criteria.
        </p>
    </div>
</div>

    @endforelse
    
<!-- <div class="alert alert-warning mb-3">
    <strong>Pagination Debug</strong><br>

    Total Jobs: {{ $jobs->total() }} <br>
    Per Page: {{ $jobs->perPage() }} <br>
    Current Page: {{ $jobs->currentPage() }} <br>
    Last Page: {{ $jobs->lastPage() }} <br>
    Has Pages: {{ $jobs->hasPages() ? 'YES' : 'NO' }} <br>
    Has More Pages: {{ $jobs->hasMorePages() ? 'YES' : 'NO' }}
</div> -->




@if ($jobs->hasPages())
<div class="pegi justify-content-center mt-60">

    {{-- Previous --}}
    @if ($jobs->onFirstPage())
        <span class="border-none disabled">
            <i class="fa-regular fa-arrow-left"></i>
        </span>
    @else
        <a href="{{ $jobs->previousPageUrl() }}" class="border-none">
            <i class="fa-regular fa-arrow-left"></i>
        </a>
    @endif

    {{-- Pages --}}
    @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
        @if ($page == $jobs->currentPage())
            <a href="javascript:void(0)" class="active">
                {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
            </a>
        @else
            <a href="{{ $url }}">
                {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
            </a>
        @endif
    @endforeach

    {{-- Next --}}
    @if ($jobs->hasMorePages())
        <a href="{{ $jobs->nextPageUrl() }}" class="border-none">
            <i class="fa-regular fa-arrow-right"></i>
        </a>
    @else
        <span class="border-none disabled">
            <i class="fa-regular fa-arrow-right"></i>
        </span>
    @endif

</div>
@endif



