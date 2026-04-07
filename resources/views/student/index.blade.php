@extends('frontend.layout.layout')

@section('title', 'Student Dashboard | EFOS Edumarketers Pvt Ltd')
@section('meta_description', 'Student dashboard to manage profile, career guidance, and opportunities.')
@section('meta_keywords', 'student dashboard, EFOS, career guidance')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())

@section('content')
    <main>
        <div class="container mt-5 mb-5">
            <div class="row">

                {{-- ================= LEFT SIDEBAR ================= --}}
                <div class="col-md-3">
                    <div class="student-dashboard bg-danger rounded shadow-sm pt-3">
                        <h5 class="text-uppercase text-center text-white mb-3">
                            Student Dashboard
                        </h5>

                        <div class="bg-white p-3 rounded-bottom">
                            <ul class="nav flex-column nav-pills gap-2" id="studentTabs" role="tablist">

                                <li class="nav-item">
                                    <button class="nav-link active w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-dashboard" type="button">
                                        <i class="bi bi-mortarboard-fill me-2"></i>
                                        Dashboard
                                    </button>
                                </li>


                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-profile" type="button">
                                        <i class="bi bi-person-fill me-2"></i>
                                        Profile Edit
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-complete-profile" type="button">
                                        <i class="bi bi-person-check-fill me-2"></i>
                                        Complete Profile
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-course-lms" type="button">
                                        <i class="bi bi-journal-bookmark-fill me-2"></i>
                                        Course (LMS)
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-quizresult-lms" type="button">
                                        <i class="bi bi-bar-chart-line-fill me-2"></i>
                                        Quiz Results (LMS)
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-certificate-lms" type="button">
                                        <i class="bi bi-award-fill me-2"></i>
                                        Quiz Certificate (LMS)
                                    </button>
                                </li>




                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-documents"
                                        type="button">
                                        <i class="bi bi-file-earmark-arrow-up me-1"></i> Documents Upload
                                    </button>
                                </li>


                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-password" type="button">
                                        <i class="bi bi-shield-lock-fill me-2"></i>
                                        Change Password
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-opportunities" type="button">
                                        <i class="bi bi-briefcase me-2"></i>
                                        Opportunities
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#tab-job" type="button">
                                        <i class="bi bi-briefcase me-2"></i>
                                        Applied Opportunity
                                    </button>
                                </li>

                            </ul>
                            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ================= RIGHT CONTENT ================= --}}
                <div class="col-md-9">
                    <div class="tab-content bg-light rounded shadow-sm p-4">
                        {{-- DASHBOARD TAB --}}
                        <div class="tab-pane fade show active" id="tab-dashboard">

                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h3 class="fw-bold mb-1">
                                    Welcome {{ $student->name }} — your career journey starts here
                                </h3>

                                <p class="text-muted mb-0">
                                    Registration No: <strong>{{ $student->registration_number }}</strong>
                                </p>

                                {{-- SUCCESS MESSAGE --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        {{ session('success') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- ERROR MESSAGE --}}
                                <!-- @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                                                                                                                                                                                                                                                                                                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                                                                                                                                                                                                                                                                                                                        {{ session('error') }}

                                                                                                                                                                                                                                                                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                                                                                                                                                                                                                                                                                                            aria-label="Close"></button>
                                                                                                                                                                                                                                                                                                                                                    </div>
    @endif -->
                            </div>

                            {{-- CAREER GUIDANCE --}}
                            <div class="card border-0 shadow-sm mb-4 bg-white">
                                <div class="card-body">

                                    <h5 class="fw-semibold mb-3">
                                        🎯 Career Guidance for You
                                    </h5>

                                    @if ($student->highest_qualification)
                                        <p class="text-muted mb-3">
                                            Based on your qualification
                                            <strong>{{ ucfirst($student->highest_qualification) }}</strong>,
                                            these are recommended next steps:
                                        </p>

                                        <div class="row g-3 text-center">

                                            <div class="col-md-4">
                                                <div class="bg-primary bg-opacity-10 border rounded p-3 h-100 text-center">
                                                    <i class="bi bi-mortarboard-fill fs-4 text-primary"></i>
                                                    <div class="fw-medium mt-2">
                                                        Skill Certification
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="bg-success bg-opacity-10 border rounded p-3 h-100 text-center">
                                                    <i class="bi bi-tools fs-4 text-success"></i>
                                                    <div class="fw-medium mt-2">
                                                        Practical Training
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="bg-warning bg-opacity-10 border rounded p-3 h-100 text-center">
                                                    <i class="bi bi-compass fs-4 text-warning"></i>
                                                    <div class="fw-medium mt-2">
                                                        Career Counselling
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            Please complete your education details to unlock career guidance.
                                        </div>
                                    @endif

                                </div>
                            </div>

                            {{-- OPPORTUNITIES --}}
                            <div class="card border-0 shadow-sm bg-white">
                                <div class="card-body">

                                    <h5 class="fw-semibold mb-3">
                                        💼 Opportunities Suggested for You
                                    </h5>

                                    @if ($student->looking_for)
                                        <p class="text-muted mb-3">
                                            You are currently interested in
                                            <strong>{{ $student->looking_for }}</strong>
                                        </p>

                                        <ul class="list-group list-group-flush small">

                                            @if ($student->looking_for === 'Jobs')
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-briefcase text-primary"></i>
                                                    Job opportunities matching your profile
                                                </li>
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-building text-success"></i>
                                                    Private & government vacancies
                                                </li>
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-lightning-charge text-warning"></i>
                                                    Apprenticeship & trainee roles
                                                </li>
                                            @elseif($student->looking_for === 'Skill Course')
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-journal-check text-primary"></i>
                                                    Certified skill development programs
                                                </li>
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-award text-success"></i>
                                                    Placement-linked courses
                                                </li>
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar-event text-warning"></i>
                                                    Short-term training batches
                                                </li>
                                            @else
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-lines-fill text-primary"></i>
                                                    Career counselling sessions
                                                </li>
                                                <li class="list-group-item d-flex align-items-center gap-2">
                                                    <i class="bi bi-arrow-right-circle text-success"></i>
                                                    Guided next career steps
                                                </li>
                                            @endif

                                        </ul>
                                    @else
                                        <div class="alert alert-info mb-0">
                                            Update your preferences to see matched opportunities.
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>




                        {{-- ================= Upload Documents Details ================= --}}

                        <div class="tab-pane fade" id="tab-documents">

                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h4 class="fw-bold mb-1">Upload Your Documents</h4>
                                <p class="text-muted mb-0">
                                    Add document title and upload files (Aadhaar, Resume, Certificates, etc.)
                                </p>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body">

                                    <form action="{{ route('student.documents.upload') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        {{-- DOCUMENT ROWS --}}
                                        <div id="document-wrapper">

                                            {{-- SINGLE ROW --}}
                                            <div class="row g-3 align-items-end document-row mb-2">

                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium">Document Title</label>
                                                    <input type="text" name="documents[0][title]" class="form-control"
                                                        placeholder="" required>
                                                </div>

                                                <div class="col-md-5">
                                                    <label class="form-label fw-medium">Select File</label>
                                                    <input type="file" name="documents[0][file]" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                                </div>

                                                <div class="col-md-3 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row d-none">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- ACTION BUTTONS --}}
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-primary" id="add-more">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                Add More Document
                                            </button>

                                            <button class="btn btn-primary px-4">
                                                <i class="bi bi-upload me-1"></i>
                                                Upload Documents
                                            </button>
                                        </div>

                                        @if ($student->documents->count())
                                            <div class="mb-4">
                                                <h5 class="fw-semibold mb-3 mt-4"> Uploaded Documents</h5>

                                                @foreach ($student->documents as $doc)
                                                    <div
                                                        class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">

                                                        <div>
                                                            <div class="fw-medium">{{ $doc->title }}</div>
                                                            <div class="text-muted small">
                                                                {{ strtoupper($doc->file_type) }}
                                                            </div>
                                                        </div>

                                                        <div class="d-flex gap-2">
                                                            {{-- VIEW --}}
                                                            <a href="{{ static_asset($doc->file_path) }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye me-1"></i> View
                                                            </a>

                                                            {{-- DOWNLOAD --}}
                                                            <a href="{{ static_asset($doc->file_path) }}" download
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="bi bi-download me-1"></i> Download
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>
                                        @endif
                                    </form>

                                </div>
                            </div>

                        </div>



                        {{-- PROFILE EDIT TAB --}}
                        <div class="tab-pane fade" id="tab-profile">
                            <h4 class="mb-3">Edit Profile</h4>

                            {{-- SUCCESS MESSAGE --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- ERROR MESSAGE --}}
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('complete_profile_msg'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Welcome to EFOS!</strong>  Please complete your profile so we can provide you with the best career guidance and opportunities.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif


                            <form method="POST" action="{{ route('student.update', $student->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    {{-- ================= BASIC REGISTRATION ================= --}}

                                    <div class="col-md-6 mb-3">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $student->name }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Phone *</label>
                                        <input type="text" class="form-control" value="{{ $student->phone }}"
                                            disabled>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Whatsapp Number</label>
                                        <input type="text" name="whatsapp" class="form-control"
                                            value="{{ $student->whatsapp }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $student->email }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Age Group</label>
                                        <select name="age_group" class="form-select">
                                            @foreach (['Less Than 16', '16-18', '19-21', '22-25', '26-30', 'Above 30'] as $age)
                                                <option value="{{ $age }}" @selected($student->age_group == $age)>
                                                    {{ $age }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Gender</label>
                                        <select name="gender" class="form-select">
                                            @foreach (['Male', 'Female', 'Others'] as $g)
                                                <option value="{{ $g }}" @selected($student->gender == $g)>
                                                    {{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control"
                                            value="{{ $student->state }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>District</label>
                                        <input type="text" name="district" class="form-control"
                                            value="{{ $student->district }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Present Status</label>
                                        <select name="present_status" class="form-select">
                                            @foreach (['Student', 'Looking for Job', 'Working', 'Retired', 'Ex-army', 'Woman after break'] as $s)
                                                <option value="{{ $s }}" @selected($student->present_status == $s)>
                                                    {{ $s }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>What are you looking for?</label>
                                        <select name="looking_for" class="form-select">
                                            @foreach (['Education', 'Skill Course', 'Jobs', 'Learn & Earn Program', 'Career Counselling', 'International Options'] as $l)
                                                <option value="{{ $l }}" @selected($student->looking_for == $l)>
                                                    {{ $l }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- ================= PROFILE SUMMARY ================= --}}
                                    <div class="mb-4 bg-white p-4 border rounded">
                                        <h5 class="fw-bold border-bottom pb-2 mb-3">Profile Summary</h5>
                                        <textarea name="profile_summary" class="form-control" rows="5" placeholder="Write about yourself...">{{ old('profile_summary', $student->profile_summary) }}</textarea>

                                    </div>


                                    {{-- ================= PERSONAL DETAILS ================= --}}

                                    <div class="mb-4 bg-white p-4 border rounded">

                                        <h5 class="fw-bold border-bottom pb-2 mb-3">Personal Details</h5>

                                        <!-- <div class="row small">
                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Father Name:</strong> {{ $student->father_name }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Mother Name:</strong> {{ $student->mother_name }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Gender:</strong> {{ $student->gender }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Age Group:</strong> {{ $student->age_group }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Category:</strong> {{ $student->category }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Blood Group:</strong> {{ $student->blood_group }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Passport:</strong> {{ $student->passport }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                            <p><strong>Relocation:</strong> {{ $student->relocation }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->


                                        <div class="row small">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Father Name</strong></label>
                                                <input type="text" name="father_name" class="form-control"
                                                    value="{{ old('father_name', $student->father_name) }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Mother Name</strong></label>
                                                <input type="text" name="mother_name" class="form-control"
                                                    value="{{ old('mother_name', $student->mother_name) }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Gender</strong></label>
                                                <select name="gender" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="Male"
                                                        {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                    <option value="Other"
                                                        {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Age Group</strong></label>
                                                <select id="age_group" name="age_group" class="form-select" required>
                                                    <option value="">Select Age Group</option>

                                                    <option value="16_18"
                                                        {{ old('age_group', $student->age_group) == '16_18' ? 'selected' : '' }}>
                                                        16 - 18
                                                    </option>

                                                    <option value="19_21"
                                                        {{ old('age_group', $student->age_group) == '19_21' ? 'selected' : '' }}>
                                                        19 - 21
                                                    </option>

                                                    <option value="22_25"
                                                        {{ old('age_group', $student->age_group) == '22_25' ? 'selected' : '' }}>
                                                        22 - 25
                                                    </option>

                                                    <option value="26_30"
                                                        {{ old('age_group', $student->age_group) == '26_30' ? 'selected' : '' }}>
                                                        26 - 30
                                                    </option>

                                                    <option value="30_40"
                                                        {{ old('age_group', $student->age_group) == '30_40' ? 'selected' : '' }}>
                                                        30 - 40
                                                    </option>

                                                    <option value="40_50"
                                                        {{ old('age_group', $student->age_group) == '40_50' ? 'selected' : '' }}>
                                                        40 - 50
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Category</strong></label>
                                                <input type="text" name="category" class="form-control"
                                                    value="{{ old('category', $student->category) }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Blood Group</strong></label>
                                                <input type="text" name="blood_group" class="form-control"
                                                    value="{{ old('blood_group', $student->blood_group) }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Passport</strong></label>
                                                <select name="passport" class="form-select">
                                                    <option value="No"
                                                        {{ old('passport', $student->passport) == 'No' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="Yes"
                                                        {{ old('passport', $student->passport) == 'Yes' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Relocation</strong></label>
                                                <select name="relocation" class="form-select">
                                                    <option value="No"
                                                        {{ old('relocation', $student->relocation) == 'No' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="Yes"
                                                        {{ old('relocation', $student->relocation) == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- ================= HIGHEST QUALIFICATION ================= --}}

                                    <div class="col-md-6 mb-3">
                                        <label>Highest Qualification</label>
                                        <select name="highest_qualification" id="highestQualification"
                                            class="form-select">
                                            <option value="">Select</option>
                                            <option value="10th" @selected($student->highest_qualification == '10th')>10th Pass</option>
                                            <option value="12th" @selected($student->highest_qualification == '12th')>12th Pass</option>
                                            <option value="graduate" @selected($student->highest_qualification == 'graduate')>Graduate</option>
                                            <option value="post_graduate" @selected($student->highest_qualification == 'post_graduate')>Post Graduate
                                            </option>
                                            <option value="phd" @selected($student->highest_qualification == 'phd')>PhD</option>
                                        </select>
                                    </div>

                                </div>

                                {{-- ================= EDUCATION SECTIONS ================= --}}

                                <div id="edu-10th" class="education-section" style="display:none;">
                                    <h5>10th Education</h5>
                                    <input name="tenth_board" class="form-control mb-2" placeholder="Board"
                                        value="{{ $student->tenth_board }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input name="tenth_year" class="form-control mb-2" placeholder="Passing Year"
                                                value="{{ $student->tenth_year }}">
                                        </div>

                                        <div class="col-md-4">
                                            <input name="tenth_marks" class="form-control mb-2" placeholder="Marks"
                                                value="{{ $student->tenth_marks }}">
                                        </div>

                                        <div class="col-md-4">
                                            <select name="tenth_stream" class="form-select mb-2">
                                                <option value="">Stream</option>
                                                <option value="General"
                                                    {{ $student->tenth_stream == 'General' ? 'selected' : '' }}>General
                                                </option>
                                                <option value="Vocational"
                                                    {{ $student->tenth_stream == 'Vocational' ? 'selected' : '' }}>
                                                    Vocational</option>
                                                <option value="Arts"
                                                    {{ $student->tenth_stream == 'Arts' ? 'selected' : '' }}>Arts</option>
                                                <option value="Others"
                                                    {{ $student->tenth_stream == 'Others' ? 'selected' : '' }}>Others
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div id="edu-12th" class="education-section" style="display:none;">
                                    <h5>12th Education</h5>
                                    <input name="twelfth_board" class="form-control mb-2" placeholder="Board"
                                        value="{{ $student->twelfth_board }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input name="twelfth_year" class="form-control mb-2"
                                                placeholder="Passing Year" value="{{ $student->twelfth_year }}">
                                        </div>

                                        <div class="col-md-4">
                                            <input name="twelfth_marks" class="form-control mb-2" placeholder="Marks"
                                                value="{{ $student->twelfth_marks }}">
                                        </div>

                                        <div class="col-md-4">
                                            <select name="twelfth_stream" class="form-select mb-2">
                                                <option value="">Stream</option>
                                                <option value="PCM"
                                                    {{ $student->twelfth_stream == 'PCM' ? 'selected' : '' }}>PCM</option>
                                                <option value="PCB"
                                                    {{ $student->twelfth_stream == 'PCB' ? 'selected' : '' }}>PCB</option>
                                                <option value="PCMB"
                                                    {{ $student->twelfth_stream == 'PCMB' ? 'selected' : '' }}>PCMB
                                                </option>
                                                <option value="Commerce"
                                                    {{ $student->twelfth_stream == 'Commerce' ? 'selected' : '' }}>Commerce
                                                </option>
                                                <option value="Arts"
                                                    {{ $student->twelfth_stream == 'Arts' ? 'selected' : '' }}>Arts
                                                </option>
                                                <option value="Vocational"
                                                    {{ $student->twelfth_stream == 'Vocational' ? 'selected' : '' }}>
                                                    Vocational</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div id="edu-graduate" class="education-section" style="display:none;">
                                    <h5>Graduation</h5>
                                    <input name="graduation_university" class="form-control mb-2"
                                        placeholder="University" value="{{ $student->graduation_university }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input name="graduation_year" class="form-control mb-2"
                                                placeholder="Passing Year" value="{{ $student->graduation_year }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="graduation_marks" class="form-control mb-2" placeholder="Marks"
                                                value="{{ $student->graduation_marks }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="graduation_stream" class="form-control mb-2"
                                                placeholder="Stream" value="{{ $student->graduation_stream }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="graduation_field" class="form-control mb-2" placeholder="Field"
                                                value="{{ $student->graduation_field }}">
                                        </div>
                                    </div>

                                </div>

                                <div id="edu-post_graduate" class="education-section" style="display:none;">
                                    <h5>Post Graduation</h5>
                                    <input name="pg_university" class="form-control mb-2" placeholder="University"
                                        value="{{ $student->pg_university }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input name="pg_year" class="form-control mb-2" placeholder="Passing Year"
                                                value="{{ $student->pg_year }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="pg_marks" class="form-control mb-2" placeholder="Marks"
                                                value="{{ $student->pg_marks }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="pg_stream" class="form-control mb-2" placeholder="Stream"
                                                value="{{ $student->pg_stream }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input name="pg_field" class="form-control mb-2" placeholder="Field"
                                                value="{{ $student->pg_field }}">
                                        </div>
                                    </div>

                                </div>

                                <div id="edu-phd" class="education-section" style="display:none;">
                                    <h5>PhD Details</h5>
                                    <input name="phd_university" class="form-control mb-2"
                                        placeholder="University / Institute" value="{{ $student->phd_university }}">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input name="phd_year" class="form-control mb-2"
                                                placeholder="Completion / Ongoing Year" value="{{ $student->phd_year }}">
                                        </div>

                                        <div class="col-md-4">
                                            <input name="phd_subject" class="form-control mb-2"
                                                placeholder="Research Subject" value="{{ $student->phd_subject }}">
                                        </div>

                                        <div class="col-md-4">
                                            <input name="phd_status" class="form-control mb-2"
                                                placeholder="Status (Ongoing / Completed)"
                                                value="{{ $student->phd_status }}">
                                        </div>
                                    </div>

                                </div>

                                {{-- ================= SKILL / DIPLOMA ================= --}}

                                <hr>
                                <h5>Diploma / Skill / Certificate</h5>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <select name="skill_type" class="form-select">
                                            <option>ITI</option>
                                            <option>Diploma</option>
                                            <option>DCA</option>
                                            <option>PGDCA</option>
                                            <option>DVoc</option>
                                            <option>BVoc</option>
                                            <option>MVoc</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <input name="skill_trade" class="form-control" placeholder="Trade / Institute"
                                            value="{{ $student->skill_trade }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <input name="skill_year" class="form-control" placeholder="Passing Year"
                                            value="{{ $student->skill_year }}">
                                    </div>
                                </div>

                                {{-- ================= JOB EXPERIENCE ================= --}}

                                <hr>
                                <h5>Job Experience</h5>

                                <div class="col-md-4 mb-3">
                                    <label>Experience Type</label>
                                    <select name="experience_type" id="experienceType" class="form-select">
                                        <option value="Fresher" @selected($student->experience_type == 'Fresher')>Fresher</option>
                                        <option value="Experienced" @selected($student->experience_type == 'Experienced')>Experienced</option>
                                    </select>
                                </div>

                                {{-- EXPERIENCE CONTAINER --}}
                                {{-- ================= EXPERIENCE CONTAINER ================= --}}
                                <div id="experienceContainer" style="display:none;">

                                    <h5 class="mb-3">Work Experience</h5>

                                    <div id="experienceWrapper">

                                        @if ($student->experiences->count())
                                            @foreach ($student->experiences as $exp)
                                                <div class="experience-item border rounded p-3 mb-3">

                                                    <h6 class="mb-3">Company Experience</h6>

                                                    <div class="row">

                                                        <div class="col-md-4 mb-3">
                                                            <label>Company Name</label>
                                                            <input type="text" name="company_name[]"
                                                                class="form-control" value="{{ $exp->company_name }}">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label>Profile</label>
                                                            <select name="job_profile[]" class="form-select">
                                                                <option value="">Select Profile</option>
                                                                @foreach (['Helper', 'Operator', 'Technician', 'Supervisor', 'Engineer', 'Manager', 'Others'] as $profile)
                                                                    <option value="{{ $profile }}"
                                                                        @selected($exp->job_profile === $profile)>
                                                                        {{ $profile }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label>Duration</label>
                                                            <input type="text" name="job_duration[]"
                                                                class="form-control" value="{{ $exp->job_duration }}">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label>State</label>
                                                            <input type="text" name="job_state[]" class="form-control"
                                                                value="{{ $exp->job_state }}">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label>District</label>
                                                            <input type="text" name="job_district[]"
                                                                class="form-control" value="{{ $exp->job_district }}">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label>Salary Range</label>
                                                            <select name="salary_range[]" class="form-select">
                                                                @foreach (['10000-15000', '15000-25000', '25000-40000', '40000-75000', '75000 and above'] as $salary)
                                                                    <option value="{{ $salary }}"
                                                                        @selected($exp->salary_range === $salary)>
                                                                        {{ $salary }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <label>Job Summary</label>
                                                            <textarea name="job_summary[]" class="form-control" rows="3">{{ $exp->job_summary }}</textarea>
                                                        </div>

                                                    </div>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-experience">
                                                        Remove
                                                    </button>

                                                </div>
                                            @endforeach
                                        @else
                                            {{-- EMPTY TEMPLATE FOR NEW USER --}}
                                            <div class="experience-item border rounded p-3 mb-3">

                                                <h6 class="mb-3">Company Experience</h6>

                                                <div class="row">

                                                    <div class="col-md-4 mb-3">
                                                        <label>Company Name</label>
                                                        <input type="text" name="company_name[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label>Profile</label>
                                                        <select name="job_profile[]" class="form-select">
                                                            <option value="">Select Profile</option>
                                                            @foreach (['Helper', 'Operator', 'Technician', 'Supervisor', 'Engineer', 'Manager', 'Others'] as $profile)
                                                                <option value="{{ $profile }}">{{ $profile }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label>Duration</label>
                                                        <input type="text" name="job_duration[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label>State</label>
                                                        <input type="text" name="job_state[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label>District</label>
                                                        <input type="text" name="job_district[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label>Salary Range</label>
                                                        <select name="salary_range[]" class="form-select">
                                                            @foreach (['10000-15000', '15000-25000', '25000-40000', '40000-75000', '75000 and above'] as $salary)
                                                                <option value="{{ $salary }}">{{ $salary }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label>Job Summary</label>
                                                        <textarea name="job_summary[]" class="form-control" rows="3"></textarea>
                                                    </div>

                                                </div>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-experience">
                                                    Remove
                                                </button>

                                            </div>
                                        @endif

                                    </div>

                                    <button type="button" id="addExperienceBtn" class="btn btn-sm btn-outline-primary">
                                        + Add More Experience
                                    </button>

                                </div>


                                {{-- ================= CERTIFICATE CONTAINER ================= --}}
                                <div id="certificateContainer" style="display:none;">

                                    <h5 class="mb-3">Diploma / Skill Certificates</h5>

                                    <div id="certificateWrapper">

                                        <div class="certificate-item border rounded p-3 mb-3">
                                            <div class="row">

                                                <div class="col-md-4 mb-3">
                                                    <label>Certificate Name</label>
                                                    <input type="text" name="certificate_name[]" class="form-control">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label>Institute</label>
                                                    <input type="text" name="certificate_institute[]"
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label>Year</label>
                                                    <input type="text" name="certificate_year[]" class="form-control">
                                                </div>

                                            </div>

                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-certificate">
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                    <button type="button" id="addCertificateBtn" class="btn btn-sm btn-outline-primary">
                                        + Add More Certificate
                                    </button>

                                </div>


                                {{-- ADD MORE BUTTON --}}
                                <div class="mt-2" id="addExperienceWrapper" style="display:none;">
                                    <button type="button" id="addExperienceBtn" class="btn btn-sm btn-outline-primary">
                                        + Add More Experience
                                    </button>
                                </div>


                                {{-- ================= OTHER DETAILS ================= --}}

                                <hr>

                                <div class="row">

                                    {{-- PASSPORT --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Passport</label>
                                        <select name="passport" class="form-select">
                                            <option value="Yes" @selected($student->passport === 'Yes')>Yes</option>
                                            <option value="No" @selected($student->passport === 'No')>No</option>
                                        </select>
                                    </div>

                                    {{-- RELOCATION --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Relocation</label>
                                        <select name="relocation" class="form-select">
                                            <option value="Yes" @selected($student->relocation === 'Yes')>Yes</option>
                                            <option value="No" @selected($student->relocation === 'No')>No</option>
                                        </select>
                                    </div>

                                    {{-- BLOOD GROUP --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Blood Group</label>
                                        <select name="blood_group" class="form-select">
                                            @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                                <option value="{{ $bg }}" @selected($student->blood_group === $bg)>
                                                    {{ $bg }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- PHOTO UPLOAD --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Upload Photo</label>
                                        <input type="file" name="photo" class="form-control">

                                        @if ($student->photo)
                                            <div class="mt-2">
                                                <img src="{{ static_asset($student->photo) }}" alt="Student Photo"
                                                    class="img-thumbnail" style="height:80px;">
                                            </div>
                                        @endif
                                    </div>

                                </div>


                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" required>
                                    <label class="form-check-label">I accept Terms & Conditions</label>
                                </div>


                                <button type="submit" class="btn btn-primary mt-4 px-5">Update Profile</button>

                            </form>
                        </div>

                        <!-- Purchased Courses start  -->
                        <div class="tab-pane fade" id="tab-course-lms">
                            <div class="card shadow-sm border-0">

                                <!-- HEADER -->
                                <div class="card-header bg-white border-bottom">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="mb-0 fw-semibold">
                                                <i class="fa-solid fa-graduation-cap me-2 text-primary"></i>
                                                Purchased Courses
                                            </h4>
                                            <small class="text-muted">Access and continue your learning</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- BODY -->
                                <div class="card-body p-0">

                                    @if ($courseBuys->count())
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-muted small">
                                                        <th>#</th>
                                                        <th>Course</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Purchased</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($courseBuys as $index => $buy)
                                                        <tr>

                                                            <!-- INDEX -->
                                                            <td class="fw-semibold">{{ $index + 1 }}</td>

                                                            <!-- COURSE -->
                                                            <td>
                                                                <div class="fw-semibold text-dark">
                                                                    {{ $buy->course->title ?? 'N/A' }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    {{ $buy->course->category->name ?? '' }}
                                                                </small>
                                                            </td>

                                                            <!-- TYPE -->
                                                            <td>
                                                                <span
                                                                    class="badge rounded-pill
                                            {{ $buy->type === 'free' ? 'bg-info' : 'bg-success' }}">
                                                                    {{ ucfirst($buy->type) }}
                                                                </span>
                                                            </td>

                                                            <!-- AMOUNT -->
                                                            <td>
                                                                <div class="fw-semibold">
                                                                    ₹{{ number_format($buy->amount, 2) }}
                                                                </div>

                                                                @if ($buy->discount_amount > 0)
                                                                    <small class="text-success">
                                                                        <i class="fa-solid fa-tag me-1"></i>
                                                                        -₹{{ number_format($buy->discount_amount, 2) }}
                                                                        off
                                                                    </small>
                                                                @endif
                                                            </td>

                                                            <!-- STATUS -->
                                                            <td>
                                                                @if ($buy->is_refunded)
                                                                    <span class="badge bg-danger">
                                                                        <i class="fa-solid fa-rotate-left me-1"></i>
                                                                        Refunded
                                                                    </span>
                                                                @elseif ($buy->is_active)
                                                                    <span class="badge bg-success">
                                                                        <i class="fa-solid fa-circle-check me-1"></i>
                                                                        Active
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fa-solid fa-clock me-1"></i> Expired
                                                                    </span>
                                                                @endif
                                                            </td>

                                                            <!-- PURCHASE DATE -->
                                                            <td>
                                                                {{ optional($buy->purchased_at)->format('d M Y') }}
                                                            </td>


                                                            <!-- ACTION -->
                                                            <td class="text-end">
                                                                {{-- @php
                                                                    $firstLesson = optional($buy->course)
                                                                        ->chapters->flatMap->lessons->sortBy(
                                                                            'sort_order',
                                                                        )
                                                                        ->first();
                                                                @endphp --}}

                                                                @php
                                                                    $firstLesson = collect($buy->course?->chapters ?? [])
                                                                        ->flatMap(fn($ch) => $ch->lessons ?? [])
                                                                        ->sortBy('sort_order')
                                                                        ->first();
                                                                    @endphp
                                                                

                                                                @if ($firstLesson)
                                                                    <a href="{{ route('course.lesson', $firstLesson->slug) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="fa-solid fa-play me-1"></i>
                                                                        Start
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted small">No Lessons</span>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <!-- EMPTY STATE -->
                                        <div class="text-center py-5">
                                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                                            <h6 class="fw-semibold mb-1">No Courses Purchased</h6>
                                            <p class="text-muted mb-0">
                                                Explore courses and start your learning journey.
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Bundle Cousre Start -->
                                        
                                   @if(isset($bundleBuys) && $bundleBuys->count())

                                            <div class="p-3 bg-white rounded shadow-sm mt-4">

                                                <!-- HEADER -->
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="fw-bold mb-0">
                                                        <i class="fa-solid fa-box-open text-danger me-2"></i>
                                                        My Bundles
                                                    </h5>

                                                    <span class="badge bg-danger">
                                                        {{ $bundleBuys->count() }} Bundles
                                                    </span>
                                                </div>

                                                <div class="accordion" id="bundleAccordion">

                                                    @foreach($bundleBuys as $index => $bundleBuy)

                                                        @php
                                                            $bundle = $bundleBuy->bundle ?? null;
                                                        @endphp

                                                        @if(!$bundle)
                                                            @continue
                                                        @endif

                                                        <div class="accordion-item border-0 shadow-sm mb-3 rounded">

                                                            <!-- HEADER -->
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed rounded"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#bundle{{ $index }}">

                                                                    <div class="d-flex align-items-center w-100">

                                                                        <!-- ICON -->
                                                                        <div class="me-3">
                                                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                                                                style="width:45px;height:45px;">
                                                                                <i class="fa-solid fa-layer-group"></i>
                                                                            </div>
                                                                        </div>

                                                                        <!-- INFO -->
                                                                        <div class="flex-grow-1">

                                                                            <div class="fw-semibold text-dark">
                                                                                {{ $bundle->title }}
                                                                            </div>

                                                                            <small class="text-muted">
                                                                                {{ $bundle->courses->count() }} Courses • 
                                                                                Purchased: {{ optional($bundleBuy->purchased_at)->format('d M Y') }}
                                                                            </small>

                                                                        </div>

                                                                        <!-- BADGE -->
                                                                        <span class="badge bg-light text-danger border">
                                                                            Bundle
                                                                        </span>

                                                                    </div>
                                                                </button>
                                                            </h2>

                                                            <!-- BODY -->
                                                            <div id="bundle{{ $index }}"
                                                                class="accordion-collapse collapse"
                                                                data-bs-parent="#bundleAccordion">

                                                                <div class="accordion-body bg-light rounded-bottom">

                                                                    @foreach($bundle->courses as $course)

                                                                        @php
                                                                            $firstLesson = collect($course->chapters ?? [])
                                                                                ->flatMap(fn($ch) => $ch->lessons ?? [])
                                                                                ->sortBy('sort_order')
                                                                                ->first();
                                                                        @endphp

                                                                        <div class="d-flex justify-content-between align-items-center p-2 mb-2 bg-white rounded shadow-sm ">

                                                                            <!-- COURSE INFO -->
                                                                            <div>
                                                                                <div class="fw-medium">
                                                                                    <i class="fa-solid fa-play text-danger me-2"></i>
                                                                                    {{ $course->title }}
                                                                                </div>

                                                                                <small class="text-muted">
                                                                                    {{ $course->chapters->count() ?? 0 }} Chapters
                                                                                </small>
                                                                            </div>

                                                                            <!-- ACTION -->
                                                                            @if($firstLesson)
                                                                                <a href="{{ route('course.lesson', $firstLesson->slug) }}"
                                                                                class="btn btn-sm btn-danger">
                                                                                    ▶ Start
                                                                                </a>
                                                                            @else
                                                                                <span class="text-muted small">No Lessons</span>
                                                                            @endif

                                                                        </div>

                                                                    @endforeach

                                                                </div>
                                                            </div>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            </div>

                                            @endif

                                     <!-- Bundle Cousre End -->



                                </div>
                            </div>
                        </div>

                        

                        <!-- Purchased Courses End  -->


                        <!-- Quiz Result start -->
                        <div class="tab-pane fade" id="tab-quizresult-lms">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="fw-semibold mb-2 text-muted">
                                            <i class="fa-solid fa-ranking-star me-1 text-warning"></i>
                                            Grade System
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-success">A+ : Excellent (90–100%)</span>
                                            <span class="badge bg-primary">A : Very Good (80–89%)</span>
                                            <span class="badge bg-info text-dark">B : Good (70–79%)</span>
                                            <span class="badge bg-warning text-dark">C : Average (60–69%)</span>
                                            <span class="badge bg-secondary">D : Below Average (50–59%)</span>
                                            <span class="badge bg-danger">F : Fail (&lt;50%)</span>
                                        </div>
                                    </div>

                                    @forelse($quizResults as $result)

                                        @php
                                            $totalMarks = 0;
                                            $obtainedMarks = 0;

                                            foreach ($result->quizAnswers as $a) {
                                                $totalMarks += $a->question->marks ?? 0;
                                                if ($a->is_correct) {
                                                    $obtainedMarks += $a->question->marks ?? 0;
                                                }
                                            }

                                            $percentage =
                                                $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;

                                            // Grade Logic
                                            if ($percentage >= 90) {
                                                $grade = 'A+';
                                                $gradeClass = 'bg-success';
                                            } elseif ($percentage >= 80) {
                                                $grade = 'A';
                                                $gradeClass = 'bg-success';
                                            } elseif ($percentage >= 70) {
                                                $grade = 'B';
                                                $gradeClass = 'bg-primary';
                                            } elseif ($percentage >= 60) {
                                                $grade = 'C';
                                                $gradeClass = 'bg-info';
                                            } elseif ($percentage >= 50) {
                                                $grade = 'D';
                                                $gradeClass = 'bg-warning';
                                            } else {
                                                $grade = 'F';
                                                $gradeClass = 'bg-danger';
                                            }
                                        @endphp

                                        {{-- ================= ATTEMPT CARD ================= --}}
                                        <div class="card shadow-sm mb-4 border-0">

                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center">

                                                    {{-- LEFT SIDE --}}
                                                    <div>
                                                      <h6 class="fw-bold mb-1">
                                                      {{ optional($result->quiz)->title }}
                                                    </h6>

                                                        <small class="text-muted">
                                                            Attempt #{{ $loop->iteration }} |
                                                            {{ $result->created_at->format('d M Y, h:i A') }}
                                                        </small>
                                                    </div>

                                                    {{-- RIGHT SIDE SUMMARY --}}
                                                    <div class="text-end">

                                                        <div class="fw-bold">
                                                            {{ $obtainedMarks }} / {{ $totalMarks }} Marks
                                                        </div>

                                                        <small class="text-muted">
                                                            {{ $percentage }}%
                                                        </small>

                                                        <div class="mt-1">
                                                            <span class="badge {{ $gradeClass }}">
                                                                {{ $grade }}
                                                            </span>

                                                            @if ($result->is_passed)
                                                                <span class="badge bg-success">PASS</span>
                                                            @else
                                                                <span class="badge bg-danger">FAIL</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- PROGRESS BAR --}}
                                                <div class="progress mt-3" style="height: 6px;">
                                                    <div class="progress-bar {{ $percentage >= 50 ? 'bg-success' : 'bg-danger' }}"
                                                        style="width: {{ $percentage }}%">
                                                    </div>
                                                </div>

                                                {{-- VIEW DETAILS BUTTON --}}
                                                <div class="text-end mt-3">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#resultDetails{{ $result->id }}">
                                                        View Details
                                                    </button>
                                                </div>

                                            </div>

                                            {{-- ================= COLLAPSIBLE DETAILS ================= --}}
                                            <div class="collapse" id="resultDetails{{ $result->id }}">
                                                <div class="card-body border-top">

                                                    {{-- ================= QUESTION DETAILS ================= --}}
                                                    @foreach ($result->quizAnswers as $index => $answer)
                                                        @php
                                                            $qMarks = $answer->question->marks ?? 0;
                                                            $earned = $answer->is_correct ? $qMarks : 0;
                                                        @endphp

                                                        <div class="border rounded p-3 mb-3">

                                                            {{-- QUESTION HEADER --}}
                                                            <div
                                                                class="d-flex justify-content-between align-items-start mb-2">

                                                                <div class="fw-semibold">
                                                                    Q{{ $index + 1 }}.
                                                                    {{ $answer->question->question }}
                                                                </div>

                                                                {{-- MARKS DISPLAY --}}
                                                                <div class="text-end">
                                                                    <div class="fw-bold">
                                                                        {{ $earned }} / {{ $qMarks }}
                                                                    </div>
                                                                    <small class="text-muted">Marks</small>
                                                                </div>

                                                            </div>

                                                            {{-- YOUR ANSWER --}}
                                                            <p class="mb-1">
                                                                <strong>Your Answer:</strong>
                                                                <span
                                                                    class="{{ $answer->is_correct ? 'text-success' : 'text-danger' }}">
                                                                    {{ $answer->selectedOption->option_text ?? 'Not Answered' }}
                                                                </span>
                                                            </p>

                                                            {{-- CORRECT ANSWER IF WRONG --}}
                                                            @if (!$answer->is_correct)
                                                                <p class="mb-1">
                                                                    <strong>Correct Answer:</strong>
                                                                    <span class="text-success">
                                                                        {{ $answer->question->correctOption->option_text ?? '' }}
                                                                    </span>
                                                                </p>
                                                            @endif

                                                            {{-- STATUS BADGE --}}
                                                            <span
                                                                class="badge {{ $answer->is_correct ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $answer->is_correct ? 'Correct' : 'Wrong' }}
                                                            </span>

                                                        </div>
                                                    @endforeach


                                                </div>
                                            </div>

                                        </div>

                                    @empty

                                        <div class="text-center py-5 text-muted">
                                            No quiz attempts found.
                                        </div>

                                    @endforelse

                                </div>

                            </div>
                        </div>

                        <!-- Quiz Result End -->

                        {{-- certificate Start --}}
                        <div class="tab-pane fade" id="tab-certificate-lms">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <h5 class="mb-3">My Certificate</h5>

                                    @if ($certificate)
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Certificate No</th>
                                                        <th>Course</th>
                                                        <th>Name</th>
                                                        <th>Issue Date</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $certificate->certificate_number }}</td>
                                                        <td>{{ $certificate->course->title }}</td>
                                                        <td>{{ $certificate->student->name }}</td>
                                                        <td>{{ optional($certificate->issue_date)->format('d M Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('certificate.print', $certificate->id) }}"
                                                                class="btn btn-sm btn-primary" target="_blank">
                                                                View / Print
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No certificate available yet.
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>


                        {{-- certificate End --}}



                        {{-- COMPLETE PROFILE TAB --}}


                        <div class="tab-pane fade" id="tab-complete-profile">

                            {{-- ================= PROFILE HEADER WITH LOGO ================= --}}
                            <div
                                class="d-flex align-items-center justify-content-between mb-4 p-3 border rounded bg-light">

                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ static_asset('assets/images/logo/logo.jpg') }}" alt="EFOS"
                                        style="height:50px;">
                                    <div>
                                        <h5 class="mb-0 fw-bold">EFOS Student Profile</h5>
                                        <small class="text-muted">Employment Facilitation & Opportunity System</small>
                                    </div>
                                </div>

                                <div class="text-end small">
                                    <div><strong>Reg No:</strong> {{ $student->registration_number }}</div>
                                    <div><strong>Date:</strong> {{ now()->format('d M Y') }}</div>
                                </div>

                            </div>

                            <div class="row g-4">

                                {{-- ================= LEFT COLUMN ================= --}}
                                <div class="col-md-4">


                                    {{-- PROFILE CARD --}}
                                    <div class="card shadow-sm text-center">
                                        <div class="card-body">

                                            @if ($student->photo)
                                                <img src="{{ static_asset($student->photo) }}"
                                                    class="rounded-circle mb-3 border"
                                                    style="width:120px;height:120px;object-fit:cover;">
                                            @endif

                                            <h5 class="fw-bold mb-0">{{ $student->name }}</h5>
                                            <span class="badge bg-primary mt-1">
                                                {{ $student->present_status }}
                                            </span>

                                            <hr>

                                            <div class="text-start small">
                                                <p><strong>Reg No:</strong> {{ $student->registration_number }}</p>
                                                <p><strong>Phone:</strong> {{ $student->phone }}</p>
                                                <p><strong>Whatsapp:</strong> {{ $student->whatsapp }}</p>
                                                <p><strong>Email:</strong> {{ $student->email }}</p>
                                                <p class="mb-0">
                                                    <strong>Location:</strong>
                                                    {{ $student->state }}, {{ $student->district }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SKILLS --}}
                                    <div class="card shadow-sm mt-3">
                                        <div class="card-header fw-bold">Skills</div>
                                        <div class="card-body small">
                                            <span class="badge bg-success">{{ $student->skill_type }}</span>
                                            <p class="mt-2 mb-1">{{ $student->skill_trade }}</p>
                                            <p class="mb-0 text-muted">Passing Year: {{ $student->skill_year }}</p>
                                        </div>
                                    </div>

                                </div>

                                {{-- ================= RIGHT COLUMN ================= --}}
                                <div class="col-md-8">

                                    {{-- PROFILE SUMMARY --}}
                                    <div class="mb-4">
                                        <h5 class="fw-bold border-bottom pb-2">Profile Summary</h5>
                                        <p class="text-muted">{{ $student->profile_summary }}</p>
                                    </div>

                                    {{-- PERSONAL DETAILS --}}
                                    <div class="mb-4">
                                        <h5 class="fw-bold border-bottom pb-2">Personal Details</h5>

                                        <div class="row small">
                                            <div class="col-md-6">
                                                <p><strong>Father Name:</strong> {{ $student->father_name }}</p>
                                                <p><strong>Mother Name:</strong> {{ $student->mother_name }}</p>
                                                <p><strong>Gender:</strong> {{ $student->gender }}</p>
                                                <p><strong>Age Group:</strong> {{ $student->age_group }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Category:</strong> {{ $student->category }}</p>
                                                <p><strong>Blood Group:</strong> {{ $student->blood_group }}</p>
                                                <p><strong>Passport:</strong> {{ $student->passport }}</p>
                                                <p><strong>Relocation:</strong> {{ $student->relocation }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- WORK EXPERIENCE --}}
                                    @if ($student->experience_type === 'Experienced' && $student->experiences->count())
                                        <div class="mb-4">
                                            <h5 class="fw-bold border-bottom pb-2">Work Experience</h5>

                                            @foreach ($student->experiences as $exp)
                                                <div class="mb-3 p-3 border rounded bg-light">
                                                    <h6 class="fw-bold mb-0">{{ $exp->company_name }}</h6>
                                                    <small class="text-muted">
                                                        {{ $exp->job_profile }} | {{ $exp->job_duration }}
                                                    </small>

                                                    <p class="small mt-1 mb-1">
                                                        {{ $exp->job_state }}, {{ $exp->job_district }}
                                                        • Salary: {{ $exp->salary_range }}
                                                    </p>

                                                    <p class="small mb-0">{{ $exp->job_summary }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- EDUCATION --}}

                                    <div class="mb-4">
                                        <h5 class="fw-bold border-bottom pb-2 mb-3">
                                            Education
                                        </h5>

                                        <!-- Highest Qualification -->
                                        @if ($student->highest_qualification)
                                            <p class="mb-3">
                                                <strong>Highest Qualification:</strong>
                                                <span class="badge bg-info text-dark text-uppercase">
                                                    {{ $student->highest_qualification }}
                                                </span>
                                            </p>
                                        @endif

                                        <!-- 10th -->
                                        @if ($student->tenth_board)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>10th Standard</strong>
                                                <div class="small text-muted mt-1">
                                                    Board: {{ $student->tenth_board }} |
                                                    Year: {{ $student->tenth_year }} |
                                                    Marks: {{ $student->tenth_marks }}% |
                                                    Stream: {{ $student->tenth_stream }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- 12th -->
                                        @if ($student->twelfth_board)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>12th Standard</strong>
                                                <div class="small text-muted mt-1">
                                                    Board: {{ $student->twelfth_board }} |
                                                    Year: {{ $student->twelfth_year }} |
                                                    Marks: {{ $student->twelfth_marks }}% |
                                                    Stream: {{ $student->twelfth_stream }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Graduation -->
                                        @if ($student->graduation_university)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>Graduation</strong>
                                                <div class="small text-muted mt-1">
                                                    University: {{ $student->graduation_university }} |
                                                    Year: {{ $student->graduation_year }} |
                                                    Marks: {{ $student->graduation_marks }}% |
                                                    Field: {{ $student->graduation_field }} |
                                                    Stream: {{ $student->graduation_stream }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Post Graduation -->
                                        @if ($student->pg_university)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>Post Graduation</strong>
                                                <div class="small text-muted mt-1">
                                                    University: {{ $student->pg_university }} |
                                                    Year: {{ $student->pg_year }} |
                                                    Marks: {{ $student->pg_marks }}% |
                                                    Field: {{ $student->pg_field }} |
                                                    Stream: {{ $student->pg_stream }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- PhD -->
                                        @if ($student->phd_university)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>PhD</strong>
                                                <div class="small text-muted mt-1">
                                                    University: {{ $student->phd_university }} |
                                                    Year: {{ $student->phd_year }} |
                                                    Subject: {{ $student->phd_subject }} |
                                                    Status:
                                                    <span
                                                        class="badge {{ $student->phd_status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                        {{ ucfirst($student->phd_status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Skill / ITI -->
                                        @if ($student->skill_type)
                                            <div class="border rounded p-3 mb-2 bg-light">
                                                <strong>Skill / ITI</strong>
                                                <div class="small text-muted mt-1">
                                                    Type: {{ $student->skill_type }} |
                                                    Trade: {{ $student->skill_trade }} |
                                                    Year: {{ $student->skill_year }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('student.profile.download') }}"
                                    class="btn btn-outline-primary btn-sm">
                                    ⬇ Download Profile (PDF)
                                </a>
                            </div>

                        </div>

                        {{-- ================= OPPORTUNITIES TAB ================= --}}
                        <div class="tab-pane fade" id="tab-opportunities">

                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h4 class="fw-bold mb-1">
                                    Opportunities for You 🚀
                                </h4>
                                <p class="text-muted mb-0">
                                    Personalized suggestions based on your profile & preferences
                                </p>
                            </div>

                            {{-- PROFILE STATUS CHECK --}}
                            @if (!$student->profile_completed)
                                <div class="alert alert-warning">
                                    ⚠ Please complete your profile to unlock personalized opportunities.
                                </div>
                            @else
                                {{-- OPPORTUNITY CARDS --}}
                                <div class="row g-3">

                                    {{-- JOB OPPORTUNITIES --}}
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <i class="bi bi-briefcase-fill fs-1 text-primary mb-3"></i>
                                                <h6 class="fw-bold">Job Opportunities</h6>
                                                <p class="text-muted small">
                                                    Local & national job openings matching your skills.
                                                </p>

                                                <span class="badge bg-success">
                                                    {{ $student->experience_type === 'Experienced' ? 'Experienced Roles' : 'Fresher Roles' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SKILL COURSES --}}
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <i class="bi bi-tools fs-1 text-warning mb-3"></i>
                                                <h6 class="fw-bold">Skill Courses</h6>
                                                <p class="text-muted small">
                                                    Industry-ready training programs with certification.
                                                </p>

                                                <span class="badge bg-warning text-dark">
                                                    {{ $student->skill_type ?? 'Multiple Options' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CAREER GUIDANCE --}}
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <i class="bi bi-compass-fill fs-1 text-danger mb-3"></i>
                                                <h6 class="fw-bold">Career Guidance</h6>
                                                <p class="text-muted small">
                                                    Expert counselling to choose the right career path.
                                                </p>

                                                <span class="badge bg-danger">
                                                    Personalized Advice
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- NEXT STEPS --}}
                                <div class="alert alert-info mt-4">
                                    Our team will contact you soon with the best opportunities based on your profile.
                                </div>
                            @endif

                        </div>


                        {{-- ================= JOB OPPORTUNITIES TAB ================= --}}
                        <div class="tab-pane fade" id="tab-job">

                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h4 class="fw-bold mb-1">
                                    Your Applied Jobs
                                </h4>
                                <p class="text-muted mb-0">
                                    Track all the opportunities you’ve applied for and stay updated on their status.
                                </p>
                            </div>



                            {{-- APPLIED JOBS --}}
                            @if ($student->jobApplications->count())
                                <div class="mt-4">

                                    <div class="row g-3">
                                        @foreach ($student->jobApplications as $application)
                                            <div class="col-md-6">
                                                <div class="card border-0 shadow-sm h-100">
                                                    <div class="card-body">

                                                        <h6 class="fw-semibold mb-1">
                                                            {{ $application->job_title }}
                                                        </h6>

                                                        <p class="text-muted mb-1 small">
                                                            {{ $application->company_name ?? 'Opportunity Provider' }}
                                                            • {{ $application->district }}, {{ $application->state }}
                                                        </p>

                                                        <span
                                                            class="badge 
                                                            @if ($application->status == 'applied') bg-primary
                                                            @elseif($application->status == 'shortlisted') bg-warning
                                                            @elseif($application->status == 'selected') bg-success
                                                            @else bg-danger @endif
                                                        ">
                                                            {{ ucfirst($application->status) }}
                                                        </span>

                                                        <small class="text-muted d-block mt-2">
                                                            Applied on {{ $application->applied_at?->format('d M Y') }}
                                                        </small>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary mt-4">
                                    You haven’t applied to any jobs yet.
                                </div>
                            @endif



                        </div>


                        <div class="tab-pane fade" id="tab-password">

                            <div class="row justify-content-center">
                                <div class="col-md-12">

                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-4">

                                            {{-- HEADER --}}
                                            <div class="text-center mb-4">
                                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex 
                                    align-items-center justify-content-center mb-3"
                                                    style="width:60px;height:60px;">
                                                    <i class="bi bi-shield-lock text-danger fs-3"></i>
                                                </div>

                                                <h4 class="fw-bold mb-1">Change Password</h4>
                                                <p class="text-muted mb-0">
                                                    Keep your account secure by updating your password regularly
                                                </p>
                                            </div>

                                            {{-- SUCCESS --}}
                                            @if (session('password_success'))
                                                <div class="alert alert-success alert-dismissible fade show">
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    {{ session('password_success') }}
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert"></button>
                                                </div>
                                            @endif

                                            {{-- ERROR --}}
                                            @if (session('password_error'))
                                                <div class="alert alert-danger alert-dismissible fade show">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    {{ session('password_error') }}
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert"></button>
                                                </div>
                                            @endif

                                            {{-- FORM --}}
                                            <form method="POST" action="{{ route('student.password.update') }}">
                                                @csrf

                                                {{-- CURRENT PASSWORD --}}
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        Current Password
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">
                                                            <i class="bi bi-lock-fill"></i>
                                                        </span>
                                                        <input type="password" name="current_password"
                                                            class="form-control" placeholder="Enter current password"
                                                            required>
                                                    </div>
                                                </div>

                                                {{-- NEW PASSWORD --}}
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        New Password
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">
                                                            <i class="bi bi-key-fill"></i>
                                                        </span>
                                                        <input type="password" name="new_password" class="form-control"
                                                            placeholder="Enter new password" required>
                                                    </div>
                                                    <small class="text-muted">
                                                        Minimum 6 characters recommended
                                                    </small>
                                                </div>

                                                {{-- CONFIRM PASSWORD --}}
                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">
                                                        Confirm New Password
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">
                                                            <i class="bi bi-check2-circle"></i>
                                                        </span>
                                                        <input type="password" name="new_password_confirmation"
                                                            class="form-control" placeholder="Re-enter new password"
                                                            required>
                                                    </div>
                                                </div>

                                                {{-- ACTION --}}
                                                <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                                                    <i class="bi bi-arrow-repeat me-2"></i>
                                                    Update Password
                                                </button>

                                            </form>

                                        </div>
                                    </div>

                                    {{-- SECURITY NOTE --}}
                                    <p class="text-center text-muted small mt-3">
                                        🔒 Your password is encrypted and never shared with anyone
                                    </p>

                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {

            const stateSelect = document.getElementById('state');
            const districtSelect = document.getElementById('district');

            // Existing values (for edit page)
            const selectedState = "{{ $student->state ?? '' }}";
            const selectedDistrict = "{{ $student->district ?? '' }}";

            fetch("{{ static_asset('assets/india-states-districts.json') }}")
                .then(res => res.json())
                .then(data => {

                    // Populate states
                    data.states.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.state;
                        option.textContent = item.state;

                        if (item.state === selectedState) {
                            option.selected = true;
                        }

                        stateSelect.appendChild(option);
                    });

                    // Load districts if state already selected
                    if (selectedState) {
                        loadDistricts(selectedState, data.states);
                    }

                    // On state change
                    stateSelect.addEventListener('change', function() {
                        loadDistricts(this.value, data.states);
                    });

                })
                .catch(err => console.error('State JSON load error:', err));

            function loadDistricts(stateName, statesData) {
                districtSelect.innerHTML = '<option value="">Select District</option>';

                const stateObj = statesData.find(s => s.state === stateName);
                if (!stateObj) return;

                stateObj.districts.forEach(dist => {
                    const option = document.createElement('option');
                    option.value = dist;
                    option.textContent = dist;

                    if (dist === selectedDistrict) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                });
            }
        });
    </script>

    {{-- ================= JS ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const experienceType = document.getElementById('experienceType');
            const experienceContainer = document.getElementById('experienceContainer');
            const certificateContainer = document.getElementById('certificateContainer');


            function toggleSections() {
                if (experienceType.value === 'Experienced') {
                    experienceContainer.style.display = 'block';
                    certificateContainer.style.display = 'none';
                } else if (experienceType.value === 'Certificate') {
                    certificateContainer.style.display = 'block';
                    experienceContainer.style.display = 'none';
                } else {
                    experienceContainer.style.display = 'none';
                    certificateContainer.style.display = 'none';
                }
            }

            experienceType.addEventListener('change', toggleSections);
            toggleSections(); // edit mode support


            // ===== ADD EXPERIENCE =====
            document.getElementById('addExperienceBtn')?.addEventListener('click', function() {
                const wrapper = document.getElementById('experienceWrapper');
                const item = wrapper.querySelector('.experience-item').cloneNode(true);
                item.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
                wrapper.appendChild(item);
            });


            // ===== REMOVE EXPERIENCE =====
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-experience')) {
                    const items = document.querySelectorAll('.experience-item');
                    if (items.length > 1) {
                        e.target.closest('.experience-item').remove();
                    }
                }
            });


            // ===== ADD CERTIFICATE =====
            document.getElementById('addCertificateBtn')?.addEventListener('click', function() {
                const wrapper = document.getElementById('certificateWrapper');
                const item = wrapper.querySelector('.certificate-item').cloneNode(true);
                item.querySelectorAll('input').forEach(el => el.value = '');
                wrapper.appendChild(item);
            });


            // ===== REMOVE CERTIFICATE =====
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-certificate')) {
                    const items = document.querySelectorAll('.certificate-item');
                    if (items.length > 1) {
                        e.target.closest('.certificate-item').remove();
                    }
                }
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const q = document.getElementById('highestQualification');
            const sections = document.querySelectorAll('.education-section');

            function hideAll() {
                sections.forEach(s => s.style.display = 'none');
            }

            function show(id) {
                const el = document.getElementById(id);
                if (el) el.style.display = 'block';
            }

            function toggleEdu() {
                hideAll();

                switch (q.value) {
                    case '10th':
                        show('edu-10th');
                        break;

                    case '12th':
                        show('edu-10th');
                        show('edu-12th');
                        break;

                    case 'graduate':
                        show('edu-10th');
                        show('edu-12th');
                        show('edu-graduate');
                        break;

                    case 'post_graduate':
                        show('edu-10th');
                        show('edu-12th');
                        show('edu-graduate');
                        show('edu-post_graduate');
                        break;

                    case 'phd':
                        show('edu-10th');
                        show('edu-12th');
                        show('edu-graduate');
                        show('edu-post_graduate');
                        show('edu-phd'); // 👈 NEW
                        break;
                }
            }

            q.addEventListener('change', toggleEdu);
            toggleEdu(); // load on edit
        });
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let index = 1;

            document.getElementById('add-more').addEventListener('click', function() {

                const wrapper = document.getElementById('document-wrapper');

                const row = document.createElement('div');
                row.className = 'row g-3 align-items-end document-row mb-2';

                row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label fw-medium">Document Title</label>
                <input type="text"
                       name="documents[${index}][title]"
                       class="form-control"
                       placeholder=""
                       required>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-medium">Select File</label>
                <input type="file"
                       name="documents[${index}][file]"
                       class="form-control"
                       accept=".pdf,.jpg,.jpeg,.png"
                       required>
            </div>

            <div class="col-md-3 text-end">
                <button type="button"
                        class="btn btn-danger btn-sm remove-row">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
        `;

                wrapper.appendChild(row);
                index++;
            });

            // Remove row
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    e.target.closest('.document-row').remove();
                }
            });

        });
    </script>

{{-- Profile Edit Tab Open when user registration --}}
    @if(session('open_profile'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    let tabTrigger = document.querySelector('[data-bs-target="#tab-profile"]');
    if (tabTrigger) {
        let tab = new bootstrap.Tab(tabTrigger);
        tab.show();
    }
});
</script>
@endif
@endpush
