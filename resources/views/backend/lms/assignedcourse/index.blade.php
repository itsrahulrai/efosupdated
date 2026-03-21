@extends('backend.layout.layouts')
@section('title', 'Courses - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title">Assigned Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Assigned Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">

                            <h6 class="card-title mb-0">Assigned Courses</h6>

                            <div class="d-flex gap-2">

                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#bulkAssignModal">
                                    <i class="fa-solid fa-upload"></i>
                                    Upload Excel
                                </button>

                                <a href="{{ route('admin.assigned-course.create') }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    Add New
                                </a>

                            </div>

                        </div>

                        <div class="card-body p-0 pb-2">
                            <table class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th width="70">S.No</th>
                                        <th>Thumbnail</th>
                                        <th>Course</th>
                                        <th>Student</th>
                                        <th>Language</th>
                                        <th>Duration</th>
                                        <th>Assigned Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($assignedCourses as $index => $assign)
                                        @php
                                            $item = $assign->course ?? $assign->bundle;
                                        @endphp

                                        <tr>

                                            <td>{{ $assignedCourses->firstItem() + $index }}</td>

                                            {{-- Thumbnail --}}
                                            <td>
                                                @if ($item && $item->thumbnail)
                                                    <img src="{{ static_asset($item->thumbnail) }}" width="60"
                                                        class="rounded">
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            {{-- Title --}}
                                            <td>
                                                {{ $item->title ?? '-' }}

                                                @if ($assign->bundle && !$assign->course)
                                                    <span class="badge bg-success ms-1">Bundle</span>

                                                    <div class="mt-1">
                                                        @foreach ($assign->bundle->courses as $course)
                                                            <div class="text-muted small">
                                                                {{ $course->title }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="badge bg-primary ms-1">Course</span>
                                                @endif
                                            </td>

                                            <td>{{ $assign->student->name ?? '-' }}</td>
                                            <td>
                                                {{ $assign->course->language ?? '—' }}
                                            </td>
                                            <td>
                                                {{ $assign->course->duration ?? '—' }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($assign->assigned_at)->format('d-m-Y') }}
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                <div class="form-check form-switch fs-5">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        data-id="{{ $assign->id }}"
                                                        {{ $assign->status ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">

                                                    <a href="{{ route('admin.assigned-course.edit', $assign->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('admin.assigned-course.destroy', $assign->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">
                                                No assigned courses found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            @if ($assignedCourses->hasPages())
                                <div class="d-flex justify-content-end px-3">
                                    {{ $assignedCourses->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="bulkAssignModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Assign Courses via Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="text-muted small">
                            Bulk assign single courses and bundle courses using the provided Excel template.
                        </div>

                        <a href="{{ route('admin.assigned-course.template') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-1"></i>
                            Download Sample File
                        </a>

                    </div>



                    {{-- Upload Section --}}
                    <div class="border rounded p-4 text-center bg-light mb-4">

                        <h6>Select Excel File</h6>
                        <p class="text-muted small">Upload file with student email/phone + course/bundle</p>

                        <input type="file" id="excelFile" class="form-control w-50 mx-auto">

                    </div>

                    {{-- Preview Table --}}
                    <div>
                        <div class="d-flex justify-content-between mb-2">
                            <h6>Preview Data</h6>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Bundle</th>
                                </tr>
                            </thead>
                            <tbody id="previewTable">
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No file selected</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" class="mt-3 d-flex justify-content-end"></div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="importBtn">
                        Import Assignments
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).on('change', '.toggle-status', function() {
            let categoryId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.learning-course.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: categoryId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });

        function confirmDelete() {
            return confirm("Are you sure you want to permanently delete this category?");
        }
    </script>

    <script>
        let fullData = [];
        let currentPage = 1;
        let perPage = 10;

        document.getElementById('excelFile').addEventListener('change', function(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            reader.onload = function(event) {
                let data = new Uint8Array(event.target.result);

                let workbook = XLSX.read(data, {
                    type: 'array'
                });

                let sheetName = workbook.SheetNames[0];
                let sheet = workbook.Sheets[sheetName];

                let jsonData = XLSX.utils.sheet_to_json(sheet, {
                    header: 1
                });

                // Remove header row
                fullData = jsonData.slice(1);
                currentPage = 1;

                renderTable();
                renderPagination();
            };

            reader.readAsArrayBuffer(file);
        });

        function renderTable() {
            let start = (currentPage - 1) * perPage;
            let end = start + perPage;
            let rows = fullData.slice(start, end);

            let html = "";

            if (rows.length === 0) {
                html = `<tr><td colspan="4" class="text-center text-muted">No data found</td></tr>`;
            } else {
                rows.forEach(row => {
                    html += `<tr>
                    <td>${row[0] || ''}</td>
                    <td>${row[1] || ''}</td>
                    <td>${row[2] || ''}</td>
                    <td>${row[3] || ''}</td>
                </tr>`;
                });
            }

            document.getElementById('previewTable').innerHTML = html;
        }

        function renderPagination() {
            let totalPages = Math.ceil(fullData.length / perPage);
            let html = "";

            // pagination only if data > perPage
            if (fullData.length <= perPage) {
                document.getElementById('pagination').innerHTML = "";
                return;
            }

            html += `<nav>
            <ul class="pagination pagination-sm mb-0">`;

            // Prev Button
            html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="changePage(${currentPage - 1})">
                &laquo;
            </a>
        </li>`;

            // Page Numbers
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="changePage(${i})">
                    ${i}
                </a>
            </li>`;
            }

            // Next Button
            html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="changePage(${currentPage + 1})">
                &raquo;
            </a>
        </li>`;

            html += `</ul></nav>`;

            document.getElementById('pagination').innerHTML = html;
        }

        function changePage(page) {
            let totalPages = Math.ceil(fullData.length / perPage);

            if (page < 1 || page > totalPages) return;

            currentPage = page;
            renderTable();
            renderPagination();
        }
    </script>

    <script>
        const importBtn = document.getElementById('importBtn');

        if (importBtn) {
            importBtn.onclick = function () {

                this.disabled = true;

                let fileInput = document.getElementById('excelFile');

                if (!fileInput.files.length) {
                    toastr.warning('Please select file');
                    this.disabled = false;
                    return;
                }

                let formData = new FormData();
                formData.append('file', fileInput.files[0]);
                formData.append('_token', "{{ csrf_token() }}");

                fetch("{{ route('admin.assigned-course.import') }}", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    console.log('data displayed', data);

                    if (data.status) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }

                    // reload after 2 sec (optional)
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Upload failed');
                })
                .finally(() => {
                    this.disabled = false;
                });
            };
        }
    </script>
@endpush
