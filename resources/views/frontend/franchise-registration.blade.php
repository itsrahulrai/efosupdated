@extends('frontend.layout.layout')
@section('title', 'Franchise Registration | EFOS Edumarketers Pvt Ltd')
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
                        Partner Registration
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Partner Registration</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->


        <!-- Contact area start here -->
        <section class="contact-area pt-50 pb-20">
            <div class="container my-5">
                <div class="card shadow-lg border-0 rounded-3">
                      {{-- SUCCESS MESSAGE --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <i class="fi fi-rr-check-circle me-2"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                    <div class="card-header bg-danger  py-3">
                        <h3 class="mb-0 text-center text-white">Partner Registration</h3>
                    </div>

                    <div class="card-body p-4">
                       
                        <form action="{{route('franchises.store')}}" method="POST" id="franchiseForm" class="p-3">
                             @csrf  
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label for="owner_name" class="form-label">Owner Name*</label>
                                    <input id="owner_name" name="owner_name" type="text" class="form-control" required
                                        placeholder="Enter Owner Name">
                                </div>

                                <div class="col-md-3">
                                    <label for="company_name" class="form-label">Company / Institute Name*</label>
                                    <input id="company_name" name="company_name" type="text" class="form-control"
                                        required placeholder="Institute / Business Name">
                                </div>

                                <div class="col-md-3">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" required
                                        placeholder="Phone Number">
                                </div>

                                <div class="col-md-3">
                                    <label for="email" class="form-label">Email Address*</label>
                                    <input id="email" name="email" type="email" class="form-control" required
                                        placeholder="Your Email">
                                </div>
                                        <div class="col-md-4">
                                            <label for="state" class="form-label">State*</label>
                                            <select id="state" name="state" class="form-select" required>
                                                <option value="">Select State</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="district" class="form-label">District*</label>
                                            <select id="district" name="district" class="form-select" required disabled>
                                                <option value="">Select District</option>
                                            </select>
                                        </div>


                                <div class="col-md-4">
                                    <label for="business_experience" class="form-label">Business Experience*</label>
                                    <select id="business_experience" name="business_experience" class="form-select"
                                        required>
                                        <option value="">Select Option</option>
                                        <option value="0_1">0-1 Years</option>
                                        <option value="1_3">1-3 Years</option>
                                        <option value="3_5">3-5 Years</option>
                                        <option value="5_plus">5+ Years</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="message" class="form-label">Message / Requirements</label>
                                    <textarea id="message" name="message" class="form-control" rows="3" placeholder="Enter your message..."></textarea>
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" id="submitBtn" class="btn-one wow fadeInDown"
                                    style="visibility: visible; animation-name: fadeInDown;">
                                    Register Now →
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!-- Contact area end here -->

    </main>


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
@endsection

