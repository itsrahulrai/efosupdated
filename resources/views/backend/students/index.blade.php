 @extends('backend.layout.layouts')
 @section('title', 'Students - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

 <main class="app-wrapper">

     <div class="container">

         <div class="app-page-head d-flex align-items-center justify-content-between">
             <div class="clearfix">
                 <h1 class="app-page-title"> Students</h1>
                 <nav aria-label="breadcrumb">
                     <ol class="breadcrumb mb-0">
                         <li class="breadcrumb-item">
                             <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                         </li>
                         <li class="breadcrumb-item active" aria-current="page">Students</li>
                     </ol>
                 </nav>
             </div>
         </div>

         <div class="row">
             <div class="col-lg-12">
                 <div class="card overflow-hidden">

                      <div class="card-header d-flex align-items-center justify-content-between">

                            <h6 class="card-title mb-0">Students</h6>

                            <div class="d-flex gap-2">

                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#bulkAssignStudentModal">
                                    <i class="fa-solid fa-upload"></i>
                                    Upload Excel
                                </button>

                                <a href="{{ route('admin.create.student') }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    Add New
                                </a>

                            </div>

                        </div>

                     <div class="card-body p-0 pb-2">
                         {{-- FILTERS --}}
                         <form method="GET" action="{{ route('admin.all.students') }}">
                             <div class="row g-2 px-3 py-3">

                                 {{-- SEARCH --}}
                                 <div class="col-md-4">
                                     <input type="text"
                                         name="search"
                                         value="{{ request('search') }}"
                                         class="form-control form-control-sm"
                                         placeholder="Search name, phone, email, reg no">
                                 </div>

                                 {{-- LOOKING FOR --}}
                                 <div class="col-md-3">
                                     <select name="looking_for" class="form-select form-select-sm">
                                         <option value="">Looking For (All)</option>

                                         <option value="education"
                                             {{ request('looking_for') == 'education' ? 'selected' : '' }}>
                                             Education
                                         </option>

                                         <option value="skill_course"
                                             {{ request('looking_for') == 'skill_course' ? 'selected' : '' }}>
                                             Skill Course
                                         </option>

                                         <option value="opportunity"
                                             {{ request('looking_for') == 'opportunity' ? 'selected' : '' }}>
                                             Opportunity
                                         </option>

                                         <option value="learn_earn"
                                             {{ request('looking_for') == 'learn_earn' ? 'selected' : '' }}>
                                             Learn & Earn Program
                                         </option>

                                         <option value="career_counselling"
                                             {{ request('looking_for') == 'career_counselling' ? 'selected' : '' }}>
                                             Career Counselling
                                         </option>

                                         <option value="international_options"
                                             {{ request('looking_for') == 'international_options' ? 'selected' : '' }}>
                                             International Options
                                         </option>
                                     </select>

                                 </div>

                                 {{-- PROFILE STATUS --}}
                                 <div class="col-md-3">
                                     <select name="profile_completed"
                                         class="form-select form-select-sm">
                                         <option value="">Status (All)</option>
                                         <option value="pending" {{ request('profile_completed') == 'pending' ? 'selected' : '' }}>Pending</option>
                                         <option value="processing" {{ request('profile_completed') == 'processing' ? 'selected' : '' }}>Processing</option>
                                         <option value="completed" {{ request('profile_completed') == 'completed' ? 'selected' : '' }}>Completed</option>
                                         <option value="rejected" {{ request('profile_completed') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                         <option value="on_hold" {{ request('profile_completed') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                     </select>
                                 </div>

                                 {{-- BUTTONS --}}
                                 <div class="col-md-2 d-flex gap-2">
                                     <button class="btn btn-sm btn-primary w-100">
                                         Filter
                                     </button>

                                     <a href="{{ route('admin.all.students') }}"
                                         class="btn btn-sm btn-light border w-100">
                                         Reset
                                     </a>
                                 </div>

                             </div>
                         </form>

                         <table class="table display">
                             <thead class="table-light">
                                 <tr>
                                     <th width="60">#</th>
                                     <th>Name</th>
                                     <th>Reg. No</th>
                                     <th>Phone</th>
                                     <th>Email</th>
                                     <th>Location</th>
                                     <th>Looking For</th>
                                     <th>Status</th>
                                     <th class="text-end">Action</th>
                                 </tr>
                             </thead>


                             <tbody>
                                 @forelse ($students as $index => $student)
                                 <tr>
                                     <td>{{ $students->firstItem() + $index }}</td>

                                     <td>
                                         <div class="fw-semibold">{{ $student->name }}</div>
                                         <small class="text-muted">{{ $student->gender }} | {{ $student->age_group }}</small>
                                     </td>

                                     <td>{{ $student->registration_number }}</td>

                                     <td>{{ $student->phone }}</td>

                                     <td>{{ $student->email }}</td>

                                     <td>
                                         {{ $student->district }},
                                         <span class="text-muted">{{ $student->state }}</span>
                                     </td>

                                     <td>
                                         <span class="badge bg-info-subtle text-dark">
                                             {{ $student->looking_for }}
                                         </span>
                                     </td>

                                     <td>
                                         <select class="form-select form-select-sm profile-status"
                                             data-id="{{ $student->id }}">
                                             <option value="pending" {{ $student->profile_completed === 'pending' ? 'selected' : '' }}>Pending</option>
                                             <option value="processing" {{ $student->profile_completed === 'processing' ? 'selected' : '' }}>Processing</option>
                                             <option value="completed" {{ $student->profile_completed === 'completed' ? 'selected' : '' }}>Completed</option>
                                             <option value="rejected" {{ $student->profile_completed === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                             <option value="on_hold" {{ $student->profile_completed === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                         </select>

                                     </td>

                                     <td class="text-end">
                                         <div class="dropdown">
                                             <button class="btn btn-sm btn-light border dropdown-toggle"
                                                 type="button"
                                                 data-bs-toggle="dropdown"
                                                 aria-expanded="false">
                                                 Action
                                             </button>

                                             <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                               <li>
                                                   <a href="javascript:void(0)"
                                                            class="dropdown-item assign-franchise-btn"
                                                            data-student-id="{{ $student->id }}"
                                                            data-student-name="{{ $student->name }}">
                                                                <i class="bi bi-person-check me-2 text-success"></i>
                                                                Assign Franchise
                                                            </a>
                                                </li>
                                                     <a class="dropdown-item"
                                                         href="{{ route('admin.students.edit', $student->id) }}">
                                                         <i class="bi bi-pencil-square me-2 text-primary"></i> Edit
                                                     </a>
                                                 </li>


                                                 <li>
                                                     <a class="dropdown-item"
                                                         href="{{ route('admin.students.documents', $student->id) }}">
                                                         <i class="bi bi-folder2-open me-2 text-warning"></i> Documents
                                                     </a>
                                                 </li>

                                                 <li>
                                                     <hr class="dropdown-divider">
                                                 </li>

                                                 <li>
                                                     <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                         method="POST"
                                                         onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button class="dropdown-item text-danger">
                                                             <i class="bi bi-trash me-2"></i> Delete
                                                         </button>
                                                     </form>
                                                 </li>
                                             </ul>
                                         </div>
                                     </td>

                                 </tr>
                                 @empty
                                 <tr>
                                     <td colspan="9">
                                         <div class="text-center py-5">
                                             <i class="bi bi-people fs-1 text-muted mb-3"></i>
                                             <h6 class="fw-semibold">No Students Found</h6>
                                             <p class="text-muted mb-0">
                                                 Students will appear here once they register.
                                             </p>
                                         </div>
                                     </td>
                                 </tr>
 

                                 @endforelse
                             </tbody>


                             


                         </table>
                         <!-- Pagination -->
                         <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                             <div class="text-muted small">
                                 Showing {{ $students->firstItem() }} to {{ $students->lastItem() }}
                                 of {{ $students->total() }} Students
                             </div>
                             <div>
                                 {{ $students->links('pagination::bootstrap-5') }}
                             </div>

                         </div>
                     </div>
                 </div>
             </div>
         </div>

         {{-- ASSIGN FRANCHISE MODAL --}}
        <div class="modal fade" id="assignFranchiseModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Assign Franchise to <span id="studentName"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Franchise</label>
                            <select id="franchiseSelect" class="form-select">
                                <option value="">-- Select Franchise --</option>
                                @foreach($franchises as $franchise)
                                    <option value="{{ $franchise->id }}">
                                        {{ $franchise->company_name }} ({{ $franchise->district }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary" id="confirmAssign">
                            Assign
                        </button>
                    </div>

                </div>
            </div>
        </div>

          {{-- ASSIGN BULK STUDENT MODAL --}}
            <div class="modal fade" id="bulkAssignStudentModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Bulk Student  via Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="text-muted small">
                               Assign Bulk  student using the provided Excel template.
                            </div>

                            <a href="{{ route('admin.bulkassign.students.template') }}" class="btn btn-outline-primary btn-sm">
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

                             <div style="overflow-x:auto;">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Whatsapp</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Status</th>
                                    <th class="text-nowrap">Looking For</th>
                                    <th>Father</th>
                                    <th>Mother</th>
                                    <th>Category</th>
                                    <th>Address</th>
                                    <th>Qualification</th>
                                    <th>Experience</th>
                                    <th class="text-nowrap">UTM Source</th>
                                    <th class="text-nowrap">UTM Medium</th>
                                    <th>Campaign</th>
                                    <th>Term</th>
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody id="previewTable">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No file selected</td>
                                    </tr>
                                </tbody>
                            </table>

                            </div>

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
          
    <!-- PROFESSIONAL LOADING MODAL -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content border-0 shadow-lg rounded-4 p-4 text-center">

                <!-- animated loader -->
                <div class="mb-3">

                    <div class="spinner-grow text-success me-1"></div>
                    <div class="spinner-grow text-success me-1" style="animation-delay:.2s"></div>
                    <div class="spinner-grow text-success" style="animation-delay:.4s"></div>

                </div>

                <h5 class="fw-semibold mb-1">
                    Importing Students
                </h5>

                <p class="text-muted small mb-3">
                    Please wait while we process the Excel file
                </p>

                <!-- progress style bar animation -->
                <div class="progress" style="height:6px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                        style="width:100%">
                    </div>
                </div>

            </div>

        </div>
    </div>
            

 </main>

 @endsection

 @push('script')
 <script>
     $(document).on('change', '.toggle-status', function() {
         let categoryId = $(this).data('id');
         let status = $(this).is(':checked') ? 1 : 0;

         $.ajax({
             url: "{{ route('admin.categories.toggle-status') }}",
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
     const profileStatusUrl = "{{ route('admin.students.profileStatus', ':id') }}";
 </script>

 <script>
     $('.profile-status').on('change', function() {

         let studentId = $(this).data('id');
         let status = $(this).val();

         $.ajax({
             url: profileStatusUrl.replace(':id', studentId),
             type: 'POST',
             data: {
                 _token: '{{ csrf_token() }}',
                 profile_completed: status
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
 </script>

<script>
let selectedStudentId = null;

// OPEN MODAL
$(document).on('click', '.assign-franchise-btn', function () {
    selectedStudentId = $(this).data('student-id');
    $('#studentName').text($(this).data('student-name'));
    $('#franchiseSelect').val('');
    $('#assignFranchiseModal').modal('show');
});

// CONFIRM ASSIGN
$('#confirmAssign').on('click', function () {

    let franchiseId = $('#franchiseSelect').val();

    if (!franchiseId) {
        toastr.warning('Please select a franchise');
        return;
    }

    $.ajax({
        url: "{{ route('admin.students.assign.store', ':id') }}".replace(':id', selectedStudentId),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            franchise_id: franchiseId
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#assignFranchiseModal').modal('hide');
            }
        },
        error: function () {
            toastr.error('Failed to assign franchise');
        }
    });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
let fullData = [];
let currentPage = 1;
let perPage = 10;

// ================= FILE CHANGE =================
document.getElementById('excelFile').addEventListener('change', function(e) {

    let file = e.target.files[0];
    if (!file) return;

    let reader = new FileReader();

    reader.onload = function(event) {

        let data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, { type: 'array' });

        let sheetName = workbook.SheetNames[0];
        let sheet = workbook.Sheets[sheetName];

        let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        // remove header
       fullData = jsonData.slice(1).filter(row => {
            return row.some(cell => cell !== undefined && cell !== null && cell !== '');
        });

        currentPage = 1;

        renderTable();
        renderPagination();
    };

    reader.readAsArrayBuffer(file);
});


// ================= TABLE RENDER =================
function renderTable() {

    let start = (currentPage - 1) * perPage;
    let end = start + perPage;

    let rows = fullData.slice(start, end);

    let html = "";

    if (rows.length === 0) {
        html = `<tr><td colspan="21" class="text-center text-muted">No data found</td></tr>`;
    } else {

        rows.forEach(row => {

            html += `<tr>
                <td>${row[0] || '-'}</td>
                <td>${row[1] || '-'}</td>
                <td>${row[2] || '-'}</td>
                <td>${row[3] || '-'}</td>
                <td>${row[4] || '-'}</td>
                <td>${row[5] || '-'}</td>
                <td>${row[6] || '-'}</td>
                <td>${row[7] || '-'}</td>
                <td>${row[8] || '-'}</td>
                <td>${row[9] || '-'}</td>
                <td>${row[10] || '-'}</td>
                <td>${row[11] || '-'}</td>
                <td>${row[12] || '-'}</td>
                <td>${row[13] || '-'}</td>
                <td>${row[14] || '-'}</td>
                <td>${row[15] || '-'}</td>
                <td>${row[16] || '-'}</td>
                <td>${row[17] || '-'}</td>
                <td>${row[18] || '-'}</td>
                <td>${row[19] || '-'}</td>
                <td>${row[20] || '-'}</td>
            </tr>`;
        });
    }

    document.getElementById('previewTable').innerHTML = html;
}


// ================= PAGINATION =================
function renderPagination() {

    let totalPages = Math.ceil(fullData.length / perPage);

    if (totalPages <= 1) {
        document.getElementById('pagination').innerHTML = "";
        return;
    }

    let html = `<nav><ul class="pagination pagination-sm">`;

    // PREV
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Prev</a>
    </li>`;

    // PAGE NUMBERS
    for (let i = 1; i <= totalPages; i++) {
        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
        </li>`;
    }

    // NEXT
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
    </li>`;

    html += `</ul></nav>`;

    document.getElementById('pagination').innerHTML = html;
}


// ================= CHANGE PAGE =================
function changePage(page) {

    let totalPages = Math.ceil(fullData.length / perPage);

    if (page < 1 || page > totalPages) return;

    currentPage = page;

    renderTable();
    renderPagination();
}
</script>

<script>
document.getElementById('importBtn').onclick = function () {

    if (fullData.length === 0) {
        toastr.warning('No data to import');
        return;
    }

    let fileInput = document.getElementById('excelFile');

    let formData = new FormData();
    formData.append('file', fileInput.files[0]);
    formData.append('_token', "{{ csrf_token() }}");

    // show loading modal
    let loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    fetch("{{ route('admin.bulk.students.import') }}", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // hide loading
        loadingModal.hide();

        if (data.status) {

            toastr.success(data.message);

            // close excel modal
            bootstrap.Modal.getInstance(document.getElementById('bulkAssignStudentModal')).hide();

            setTimeout(() => location.reload(), 1200);

        } else {

            toastr.error(data.message);
            console.log(data.failed);

        }
    })
    .catch(() => {

        loadingModal.hide();

        toastr.error('Upload failed');

    });

};
</script>


 @endpush