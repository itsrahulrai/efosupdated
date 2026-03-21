<div class="card-header d-flex align-items-center justify-content-between">
    <h6 class="card-title mb-0 fw-semibold">
        Certificates Mangment
    </h6>

    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" id="addCertificatesBtn">
        <i class="bi bi-plus-lg"></i>
        Add Certificates
    </button>
</div>

<table class="table display">
    <thead class="table-light">
        <tr>
            <th width="70">S.No</th>
            <th>Student Name</th>
            <th>Registration No</th>
            <th>Course</th>
            <th>Certificate No</th>
            <th>Issue Date</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($certificates as $index => $certificate)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $certificate->student->name }}</td>
                <td>{{ $certificate->student->registration_number }}</td>
                <td>{{ $certificate->course->title }}</td>
                <td>{{ $certificate->certificate_number }}</td>
                <td>{{ optional($certificate->issue_date)->format('d M Y') }}</td>

                <td class="text-end">
                    <a href="{{ route('admin.certificates.print', $certificate->id) }}" target="_blank"
                        class="btn btn-sm btn-success">
                        Print
                    </a>
                    <button class="btn btn-sm btn-primary editCertificateBtn" data-id="{{ $certificate->id }}"
                        data-student="{{ $certificate->student_id }}" data-course="{{ $certificate->course_id }}"
                        data-number="{{ $certificate->certificate_number }}"
                        data-date="{{ optional($certificate->issue_date)->format('Y-m-d') }}">
                        Edit
                    </button>

                    <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No Certificates Found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>



@if ($certificates->hasPages())
    <div class="d-flex justify-content-end">
        {{ $certificates->appends(['tab' => 'tab-certificates'])->links() }}
    </div>
@endif


<div class="modal fade" id="certificateModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="certificateModalTitle">
                    Add Certificate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="certificateForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="" selected disabled> Select Student </option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} ({{ $student->registration_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Course</label>
                        <select name="course_id" id="course_id" class="form-select" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Certificate Number</label>
                        <input type="text" name="certificate_number" id="certificate_number" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Issue Date</label>
                        <input type="date" name="issue_date" id="issue_date" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="certificateSubmitBtn">
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


@push('script')
    <script>
        const certificateModal = new bootstrap.Modal(
            document.getElementById('certificateModal')
        );

        // ADD
        $('#addCertificatesBtn').on('click', function() {

            $('#certificateModalTitle').text('Add Certificate');
            $('#certificateSubmitBtn').text('Submit');

            $('#certificateForm').attr(
                'action',
                "{{ route('admin.certificates.store') }}"
            );

            $('#methodField').html(''); // remove PUT if exists

            $('#certificateForm')[0].reset();

            certificateModal.show();
        });


        // EDIT
        $(document).on('click', '.editCertificateBtn', function() {

            let id = $(this).data('id');

            $('#certificateModalTitle').text('Edit Certificate');
            $('#certificateSubmitBtn').text('Update');

            let updateUrl = "{{ route('admin.certificates.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', id);

            $('#certificateForm').attr('action', updateUrl);

            // Proper way to add PUT method
            $('#methodField').html('@method('PUT')');

            $('#student_id').val($(this).data('student'));
            $('#course_id').val($(this).data('course'));
            $('#certificate_number').val($(this).data('number'));
            $('#issue_date').val($(this).data('date'));

            certificateModal.show();
        });
    </script>
@endpush
