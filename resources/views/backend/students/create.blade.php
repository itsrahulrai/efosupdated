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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Students</h6>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                        @php $isEdit = isset($student) && $student->exists; @endphp


                            <form class="row" method="POST"
                                action="{{ $isEdit
                                            ? route('admin.students.update', $student->id)
                                            : route('admin.students.store') }}">
                                @csrf
                                @if ($isEdit)
                                @method('PUT')
                                @endif


    <div class="row">

    {{-- ================= BASIC REGISTRATION ================= --}}

    <div class="col-md-6 mb-3">
        <label>Name *</label>
        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Phone *</label>
        <input type="text" name="phone" class="form-control" value="{{ $student->phone }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Whatsapp Number</label>
        <input type="text" name="whatsapp"  class="form-control" value="{{ $student->whatsapp }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" value="{{ $student->email }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Age Group</label>
        <select name="age_group" class="form-select">
            @foreach(['Less Than 16','16-18','19-21','22-25','26-30','Above 30'] as $age)
                <option value="{{ $age }}" @selected($student->age_group==$age)>{{ $age }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Gender</label>
        <select name="gender" class="form-select">
            @foreach(['Male','Female','Others'] as $g)
                <option value="{{ $g }}" @selected($student->gender==$g)>{{ $g }}</option>
            @endforeach
        </select>
    </div>  

    <div class="col-md-6 mb-3">
        <label>State</label>
        <input type="text" name="state" class="form-control" value="{{ $student->state }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>District</label>
        <input type="text" name="district" class="form-control" value="{{ $student->district }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Present Status</label>
        <select name="present_status" class="form-select">
            @foreach(['Student','Looking for Job','Working','Retired','Ex-army','Woman after break'] as $s)
                <option value="{{ $s }}" @selected($student->present_status==$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label>What are you looking for?</label>
        <select name="looking_for" class="form-select">
            @foreach(['Education','Skill Course','Jobs','Learn & Earn Program','Career Counselling','International Options'] as $l)
                <option value="{{ $l }}" @selected($student->looking_for==$l)>{{ $l }}</option>
            @endforeach
        </select>
    </div>

    {{-- ================= PROFILE SUMMARY ================= --}}
   <div class="mb-4 bg-white p-4 border rounded">

    <h5 class="fw-bold border-bottom pb-2 mb-3">Profile Summary</h5>

    <textarea
        name="profile_summary"
        class="form-control"
        rows="4"
        placeholder="Write a short profile summary (max 100 words)"
    >{{ old('profile_summary', $student->profile_summary ?? '') }}</textarea>

    <small class="text-muted">
        Brief summary about the student, skills, and career goals.
    </small>

</div>


{{-- ================= PERSONAL DETAILS ================= --}}
<div class="mb-4 bg-white p-4 border rounded">

    <h5 class="fw-bold border-bottom pb-2 mb-3">Personal Details</h5>

    <div class="row">

        {{-- Father Name --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Father Name</label>
            <input type="text"
                   name="father_name"
                   class="form-control"
                   value="{{ old('father_name', $student->father_name ?? '') }}">
        </div>

        {{-- Mother Name --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Mother Name</label>
            <input type="text"
                   name="mother_name"
                   class="form-control"
                   value="{{ old('mother_name', $student->mother_name ?? '') }}">
        </div> 

        {{-- Category --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                @foreach(['GEN','OBC','SC','ST','Other'] as $cat)
                    <option value="{{ $cat }}"
                        @selected(old('category', $student->category ?? '') === $cat)>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>
       

    </div>
</div>


    {{-- ================= HIGHEST QUALIFICATION ================= --}}

    <div class="col-md-6 mb-3">
        <label>Highest Qualification</label>
        <select name="highest_qualification" id="highestQualification" class="form-select">
            <option value="">Select</option>
            <option value="10th" @selected($student->highest_qualification=='10th')>10th Pass</option>
            <option value="12th" @selected($student->highest_qualification=='12th')>12th Pass</option>
            <option value="graduate" @selected($student->highest_qualification=='graduate')>Graduate</option>
            <option value="post_graduate" @selected($student->highest_qualification=='post_graduate')>Post Graduate</option>
            <option value="phd" @selected($student->highest_qualification=='phd')>PhD</option>
        </select>
    </div>

    </div>

    {{-- ================= EDUCATION SECTIONS ================= --}}

    <div id="edu-10th" class="education-section" style="display:none;">
        <h5>10th Education</h5>
        <input name="tenth_board" class="form-control mb-2" placeholder="Board" value="{{ $student->tenth_board }}">
        <input name="tenth_year" class="form-control mb-2" placeholder="Passing Year" value="{{ $student->tenth_year }}">
        <input name="tenth_marks" class="form-control mb-2" placeholder="Marks" value="{{ $student->tenth_marks }}">
        <select name="tenth_stream" class="form-select mb-2">
            <option>General</option><option>Vocational</option><option>Arts</option><option>Others</option>
        </select>
    </div>

    <div id="edu-12th" class="education-section" style="display:none;">
        <h5>12th Education</h5>
        <input name="twelfth_board" class="form-control mb-2" placeholder="Board" value="{{ $student->twelfth_board }}">
        <input name="twelfth_year" class="form-control mb-2" placeholder="Passing Year" value="{{ $student->twelfth_year }}">
        <input name="twelfth_marks" class="form-control mb-2" placeholder="Marks" value="{{ $student->twelfth_marks }}">
        <select name="twelfth_stream" class="form-select mb-2">
            <option>PCM</option><option>PCB</option><option>PCMB</option>
            <option>Commerce</option><option>Arts</option><option>Vocational</option>
        </select>
    </div>

    <div id="edu-graduate" class="education-section" style="display:none;">
        <h5>Graduation</h5>
        <input name="graduation_university" class="form-control mb-2" placeholder="University" value="{{ $student->graduation_university }}">
        <input name="graduation_year" class="form-control mb-2" placeholder="Passing Year" value="{{ $student->graduation_year }}">
        <input name="graduation_marks" class="form-control mb-2" placeholder="Marks" value="{{ $student->graduation_marks }}">
        <input name="graduation_stream" class="form-control mb-2" placeholder="Stream" value="{{ $student->graduation_stream }}">
        <input name="graduation_field" class="form-control mb-2" placeholder="Field" value="{{ $student->graduation_field }}">
    </div>

    <div id="edu-post_graduate" class="education-section" style="display:none;">
        <h5>Post Graduation / PhD</h5>
        <input name="pg_university" class="form-control mb-2" placeholder="University" value="{{ $student->pg_university }}">
        <input name="pg_year" class="form-control mb-2" placeholder="Passing Year" value="{{ $student->pg_year }}">
        <input name="pg_marks" class="form-control mb-2" placeholder="Marks" value="{{ $student->pg_marks }}">
        <input name="pg_stream" class="form-control mb-2" placeholder="Stream" value="{{ $student->pg_stream }}">
        <input name="pg_field" class="form-control mb-2" placeholder="Field" value="{{ $student->pg_field }}">
    </div>

    {{-- ================= SKILL / DIPLOMA ================= --}}

    <hr>
    <h5>Diploma / Skill / Certificate</h5>

    <div class="row">
        <div class="col-md-4 mb-3">
            <select name="skill_type" class="form-select">
                <option>ITI</option><option>Diploma</option><option>DCA</option>
                <option>PGDCA</option><option>DVoc</option><option>BVoc</option><option>MVoc</option><option>Others</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <input name="skill_trade" class="form-control" placeholder="Trade / Institute" value="{{ $student->skill_trade }}">
        </div>
        <div class="col-md-4 mb-3">
            <input name="skill_year" class="form-control" placeholder="Passing Year" value="{{ $student->skill_year }}">
        </div>
    </div>

    {{-- ================= JOB EXPERIENCE ================= --}}

    <hr>
    <h5>Job Experience</h5>

    <div class="col-md-4 mb-3">
        <label>Experience Type</label>
        <select name="experience_type" id="experienceType" class="form-select">
            <option value="Fresher" @selected($student->experience_type=='Fresher')>Fresher</option>
            <option value="Experienced" @selected($student->experience_type=='Experienced')>Experienced</option>
        </select>
    </div>

    {{-- EXPERIENCE CONTAINER --}}
    <div id="experienceContainer" style="display:none;">

        {{-- EXPERIENCE BLOCK --}}
        <div class="experience-item border rounded p-3 mb-3">
        @if($student->experiences->count())
        @foreach($student->experiences as $index => $exp)

            <div class="experience-item border rounded p-3 mb-3">
                <h6 class="mb-3">Company Experience</h6>

                <div class="row">

                    {{-- COMPANY NAME --}}
                    <div class="col-md-4 mb-3">
                        <label>Company Name</label>
                        <input type="text" name="company_name[]" class="form-control"
                            value="{{ $exp->company_name }}">
                    </div>

                    {{-- PROFILE --}}
                    <div class="col-md-4 mb-3">
                        <label>Profile</label>
                        <select name="job_profile[]" class="form-select">
                            <option value="">Select Profile</option>
                            @foreach(['Helper','Operator','Technician','Supervisor','Engineer','Manager','Others'] as $profile)
                                <option value="{{ $profile }}"
                                    @selected($exp->job_profile === $profile)>
                                    {{ $profile }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DURATION --}}
                    <div class="col-md-4 mb-3">
                        <label>Duration (From – To)</label>
                        <input type="text" name="job_duration[]" class="form-control"
                            value="{{ $exp->job_duration }}">
                    </div>

                    {{-- LOCATION --}}
                    <div class="col-md-4 mb-3">
                        <label>State</label>
                        <input type="text" name="job_state[]" class="form-control"
                            value="{{ $exp->job_state }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>District</label>
                        <input type="text" name="job_district[]" class="form-control"
                            value="{{ $exp->job_district }}">
                    </div>

                    {{-- SALARY --}}
                    <div class="col-md-4 mb-3">
                        <label>Salary Range (Per Month)</label>
                        <select name="salary_range[]" class="form-select">
                            @foreach(['10000-15000','15000-25000','25000-40000','40000-75000','75000 and above'] as $salary)
                                <option value="{{ $salary }}"
                                    @selected($exp->salary_range === $salary)>
                                    {{ $salary }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- JOB SUMMARY --}}
                    <div class="col-md-12 mb-3">
                        <label>Job Summary (Max 100 words)</label>
                        <textarea name="job_summary[]" class="form-control" rows="3" maxlength="700">{{ $exp->job_summary }}</textarea>
                    </div>

                </div>

                <button type="button" class="btn btn-sm btn-outline-danger remove-experience">
                    Remove
                </button>
            </div>

        @endforeach
    @endif

        </div>

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
                <option value="No"  @selected($student->passport === 'No')>No</option>
            </select>
        </div>

        {{-- RELOCATION --}}
        <div class="col-md-3 mb-3">
            <label>Relocation</label>
            <select name="relocation" class="form-select">
                <option value="Yes" @selected($student->relocation === 'Yes')>Yes</option>
                <option value="No"  @selected($student->relocation === 'No')>No</option>
            </select>
        </div>

        {{-- BLOOD GROUP --}}
        <div class="col-md-3 mb-3">
            <label>Blood Group</label>
            <select name="blood_group" class="form-select">
                @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
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

            @if($student->photo)
                <div class="mt-2">
                    <img src="{{ static_asset($student->photo) }}"
                        alt="Student Photo"
                        class="img-thumbnail"
                        style="height:80px;">
                </div>
            @endif
        </div>

    </div>


    <div class="form-check mt-3">
        <input class="form-check-input" type="checkbox" required>
        <label class="form-check-label">I accept Terms & Conditions</label>
    </div>

                            
                                

                                <!-- Submit -->
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEdit ? 'Update' : 'Submit' }}
                                    </button>
                                    <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    @endsection

    @push('script')
  <script>
document.addEventListener('DOMContentLoaded', function () {

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
            stateSelect.addEventListener('change', function () {
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
document.addEventListener('DOMContentLoaded', function () {

    const experienceType = document.getElementById('experienceType');
    const experienceContainer = document.getElementById('experienceContainer');
    const addWrapper = document.getElementById('addExperienceWrapper');
    const addBtn = document.getElementById('addExperienceBtn');

    function toggleExperience() {
        const isExperienced = experienceType.value === 'Experienced';

        experienceContainer.style.display = isExperienced ? 'block' : 'none';
        addWrapper.style.display = isExperienced ? 'block' : 'none';
    }

    experienceType.addEventListener('change', toggleExperience);

    // Edit mode support
    toggleExperience();

    // Add more experience
    addBtn.addEventListener('click', function () {
        const template = document.querySelector('.experience-item').cloneNode(true);
        template.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
        experienceContainer.appendChild(template);
    });

    // Remove experience
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-experience')) {
            const items = document.querySelectorAll('.experience-item');
            if (items.length > 1) {
                e.target.closest('.experience-item').remove();
            }
        }
    });

});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const q = document.getElementById('highestQualification');
    const sections = document.querySelectorAll('.education-section');
    const exp = document.getElementById('experienceType');
    const expBox = document.getElementById('experienceBox');

    function toggleEdu() {
        sections.forEach(s => s.style.display = 'none');
        if (q.value) {
            const el = document.getElementById('edu-' + q.value);
            if (el) el.style.display = 'block';
        }
    }

    function toggleExp() {
        expBox.style.display = exp.value === 'Experienced' ? 'block' : 'none';
    }

    q.addEventListener('change', toggleEdu);
    exp.addEventListener('change', toggleExp);

    toggleEdu();
    toggleExp();
});
</script>
    @endpush
