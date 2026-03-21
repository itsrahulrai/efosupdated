@extends('frontend.layout.layout')
@section('title', 'Student Registration | EFOS Edumarketers Pvt Ltd')
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
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Student Registration
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Student Registration</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->

        <!-- Contact area start here -->
        <section class="contact-area pt-5 pb-120">
            <div class="container my-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-danger  py-3">
                        <h3 class="mb-0 text-center text-white">Registration / Enquiry Form</h3>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('student.store') }}" method="POST" id="leadForm" class="p-3">
                            @csrf
                            <div class="row g-4">

                                        <input type="hidden" name="utm_source" value="{{ request('utm_source', session('utm_source')) }}">
                                        <input type="hidden" name="utm_medium" value="{{ request('utm_medium', session('utm_medium')) }}">
                                        <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign', session('utm_campaign')) }}">
                                        <input type="hidden" name="utm_term" value="{{ request('utm_term', session('utm_term')) }}">
                                        <input type="hidden" name="utm_content" value="{{ request('utm_content', session('utm_content')) }}"> 

                                <div class="col-md-4">
                                    <label for="name" class="form-label">Your Name*</label>
                                    <input id="name" name="name" type="text" class="form-control" required
                                        placeholder="Your Name" value="{{ old('name') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" required
                                        placeholder="Your Number" value="{{ old('phone') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Your Email*</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                        placeholder="Your Email" value="{{ old('email') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="age_group" class="form-label">Age Group*</label>
                                    <select id="age_group" name="age_group" class="form-select" required>
                                        <option value="">Select Age Group</option>
                                        <option value="16_18">16 - 18</option>
                                        <option value="19_21">19 - 21</option>
                                        <option value="22_25">22 - 25</option>
                                        <option value="26_30">26 - 30</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="qualification" class="form-label">Select Highest Qualification</label>
                                    <select name="qualification" id="qualification" class="form-select">
                                        <option value="">Select Highest Qualification</option>
                                        <option value="Below 10th">Below 10th</option>
                                        <option value="10th">10th</option>
                                        <option value="ITI/Diploma">ITI / Diploma</option>
                                        <option value="12th Pass">12th Pass</option>
                                        <option value="Undergraduate">Undergraduate</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="present_status" class="form-label">Present Status</label>
                                    <select name="present_status" id="present_status" class="form-select">
                                        <option value="">Select Present Status</option>
                                        <option value="Student">Student</option>
                                        <option value="Looking for Job">Looking for Job</option>
                                        <option value="Working">Working</option>
                                        <option value="Retired">Retired</option>
                                        <option value="Ex-armyperson">Ex-armyperson</option>
                                        <option value="Woman after break">Woman after break</option>
                                    </select>
                                </div>

                              
                                <div class="col-md-4">
                                    <label for="state2" class="form-label">State*</label>
                                    <select id="state" name="state" class="form-select" data-state
                                        data-target="district2" required>
                                        <option value="">Select State</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="district2" class="form-label">District*</label>
                                    <select id="district" class="form-select" name="district" required>
                                        <option value="">Select District</option>
                                    </select>
                                </div>


                                <div class="col-md-4">
                                    <label for="looking_for" class="form-label">What Are You Looking For?</label>
                                    <select id="looking_for" name="looking_for" class="form-select" required>
                                        <option value="">Select an Option</option>
                                        <option value="education">Education</option>
                                        <option value="skill_course">Skill Course</option>
                                        <option value="Opportunity">Opportunity</option>
                                        <option value="learn_earn">Learn & Earn Program</option>
                                        <option value="career_counselling">Career Counselling</option>
                                        <option value="international_options">International Options</option>
                                    </select>
                                </div>
                            </div>


                                <div class="col-12 mt-3">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="agree_terms" 
                                                name="agree_terms" 
                                                value="1"
                                                required
                                            >
                                            <label class="form-check-label" for="agree_terms">
                                                I agree to receive information by signing up on 
                                                <strong> EFOS Edumarketers Private Limited</strong>
                                            </label>
                                        </div>
                                    </div>
                            <div class="text-center mt-4">
                                <button type="submit" id="submitBtn" class="btn-one wow fadeInDown">
                                    Send Now →
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!-- Contact area end here -->



    </main>


@endsection

@push('script')
 <script>
document.addEventListener("DOMContentLoaded", function () {

    const stateSelect = document.getElementById("state");
    const districtSelect = document.getElementById("district");

    // Fetch JSON file
    fetch("{{ static_asset('assets/india-states-districts.json') }}")
        .then(response => response.json())
        .then(data => {
            const states = data.states;

            // Populate State dropdown
            states.forEach(item => {
                const option = document.createElement("option");
                option.value = item.state;
                option.textContent = item.state;
                stateSelect.appendChild(option);
            });

            // On state change -> populate districts
            stateSelect.addEventListener("change", function () {
                districtSelect.innerHTML = '<option value="">Select District</option>';
                districtSelect.disabled = true;

                const selectedState = this.value;
                if (!selectedState) return;

                const stateData = states.find(s => s.state === selectedState);

                if (stateData) {
                    stateData.districts.forEach(district => {
                        const option = document.createElement("option");
                        option.value = district;
                        option.textContent = district;
                        districtSelect.appendChild(option);
                    });
                    districtSelect.disabled = false;
                }   
            });
        })
        .catch(error => {
            console.error("Error loading state-district JSON:", error);
        });

});
</script>

@endpush
