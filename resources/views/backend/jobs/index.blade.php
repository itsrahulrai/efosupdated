@extends('backend.layout.layouts')
@section('title', 'Jobs - Career Guidance Services | EFOS Edumarketers Pvt Ltd')

@section('content')
<main class="app-wrapper">
    <div class="container">

        <!-- Page Header -->
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">Opportunity</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Opportunity</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Jobs Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title mb-0">All Jobs</h6>
                        <a href="{{ route('admin.jobs.create') }}"
                           class="btn btn-primary btn-sm">
                            + Add New Job
                        </a>
                    </div>

                    <div class="card-body p-0 pb-2">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Opportunity Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($jobs as $index => $job)
                                    <tr>
                                        <td>
                                            {{ $jobs->firstItem() + $index }}
                                        </td>

                                        <td>
                                            <strong>{{ $job->title }}</strong><br>
                                            <small class="text-muted">{{ $job->slug }}</small>
                                        </td>

                                        <td>
                                            {{ $job->company_name ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $job->district }}, {{ $job->state }}
                                        </td>

                                        <td>
                                            {{ $job->category->name ?? '-' }}
                                        </td>

                                        <!-- Status Toggle -->
                                        <td>
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input toggle-status"
                                                    type="checkbox"
                                                    data-id="{{ $job->id }}"
                                                    {{ $job->status ? 'checked' : '' }}
                                                >
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-end">
                                            <a href="{{ route('admin.jobs.edit', $job->id) }}"
                                               class="btn btn-sm btn-primary me-1">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.jobs.destroy', $job->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No jobs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                            <div class="text-muted small">
                                Showing {{ $jobs->firstItem() }} to {{ $jobs->lastItem() }}
                                of {{ $jobs->total() }} jobs
                            </div>
                            <div>
                                {{ $jobs->links('pagination::bootstrap-5') }}
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
$(document).on('change', '.toggle-status', function () {
    let jobId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: "{{ route('admin.jobs.toggle-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: jobId,
            status: status
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
            }
        },
        error: function () {
            toastr.error('Something went wrong!');
        }
    });
});

function confirmDelete() {
    return confirm("Are you sure you want to permanently delete this job?");
}
</script>
@endpush
