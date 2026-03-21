@extends('backend.layout.layouts')
@section('title', 'Applied Jobs')

@section('content')
<main class="app-wrapper">
<div class="container">

    <!-- Header -->
    <div class="app-page-head mb-4">
        <h1 class="app-page-title">Applied Jobs</h1>
        <p class="text-muted mb-0">
            Track students and the opportunities they have applied for
        </p>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($applications as $index => $app)
                    <tr>
                        <td>{{ $applications->firstItem() + $index }}</td>

                        <!-- Student -->
                        <td>
                            <strong>{{ $app->student->name }}</strong><br>
                            <small class="text-muted">
                                {{ $app->student->registration_number }}
                            </small>
                        </td>

                        <!-- Job -->
                        <td>
                            {{ $app->job_title }} <br>
                        </td>

                        <!-- Company -->
                        <td>{{ $app->company_name ?? 'Opportunity Provider' }}</td>

                        <!-- Location -->
                        <td>{{ $app->district }}, {{ $app->state }}</td>

                        <!-- Status -->
                       <td>
                        <select class="form-select form-select-sm application-status"
                                data-id="{{ $app->id }}"
                                style="min-width:130px">

                            <option value="applied" 
                                {{ $app->status === 'applied' ? 'selected' : '' }}>
                                Applied
                            </option>

                            <option value="shortlisted" 
                                {{ $app->status === 'shortlisted' ? 'selected' : '' }}>
                                Shortlisted
                            </option>

                            <option value="selected" 
                                {{ $app->status === 'selected' ? 'selected' : '' }}>
                                Selected
                            </option>

                            <option value="rejected" 
                                {{ $app->status === 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>
                    </td>

                        <!-- Applied Date -->
                        <td>
                            {{ optional($app->applied_at)->format('d M Y') }}
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.job-applications.destroy', $app->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this application?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No job applications found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $applications->links('pagination::bootstrap-5') }}
    </div>

</div>
</main>
@endsection

@push('script')
<script>
$(document).on('change', '.application-status', function () {

    let applicationId = $(this).data('id');
    let status = $(this).val();

    $.ajax({
        url: "{{ route('admin.job-applications.update-status') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: applicationId,
            status: status
        },
        success: function (res) {
            toastr.success(res.message);
        },
        error: function () {
            toastr.error('Failed to update status');
        }
    });
});
</script>
@endpush
