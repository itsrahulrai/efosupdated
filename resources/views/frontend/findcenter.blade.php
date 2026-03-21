@extends('frontend.layout.layout')
@section('title', 'Find Center | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@push('style')
    <style>
        .partner-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            background: #fff;
        }

        .partner-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        }

        /* Header Gradient using EFOS Red */
        .partner-header {
            background: linear-gradient(135deg, #E62E3C, #ff4d5a);
            color: #fff;
            padding: 18px;
            font-weight: 600;
            font-size: 18px;
            text-align: center;
        }

        /* Body */
        .partner-body {
            padding: 20px;
        }

        .partner-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .partner-info i {
            color: #E62E3C;
            margin-right: 8px;
            font-size: 15px;
        }

        /* Professional Rounded Button */
        .partner-btn {
            border-radius: 30px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 500;
            background-color: #E62E3C;
            border: none;
            transition: all 0.3s ease;
        }

        .partner-btn:hover {
            background-color: #c92431;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(230, 46, 60, 0.3);
        }
    </style>
@endpush
@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Find Center
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Find Center</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Discount area start here -->
        <section class="discout-three-area pt-120 pb-120 primary-bg">
            <div class="discout-two__shape-left">
                <img src="{{ static_asset('assets/images/shape/discout-two-shpe-left.png') }}" alt="shape">
            </div>
            <div class="discout-two__shape-right">
                <img src="{{ static_asset('assets/images/shape/discout-two-shpe-right.png') }}" alt="shape">
            </div>
            <div class="container">
                <div class="col-xl-7">
                    <div class="discout-three__item bg-white p-3 rounded">
                        <h2 class="text-dark wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                            Find EFOS Partner <br> Centers</h2>
                        <form id="searchForm">
                            <div class="search-bar mt-4">
                                <div class="row g-3 align-items-end">

                                    <div class="col-lg-4 col-md-4">
                                        <label for="state1" class="form-label">State *</label>
                                        <select class="form-select" id="state2">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <label for="district1" class="form-label">District *</label>
                                        <select class="form-select" id="district2">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4 d-grid">
                                        <button type="button" class="btn btn-primary" id="searchBtn">
                                            Search
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="discout-three__image">
                <img src="{{ static_asset('assets/images/offer/offer-hero2.png') }}" alt="image">
                <img class="shape" src="{{ static_asset('assets/images/shape/discout-three-item-line.png') }}"
                    alt="shape">
            </div>
        </section>
        <!-- Discount area end here -->


        <!-- ================= Partner Result Section ================= -->
        <section class="partner-result-area py-5 bg-light" id="partnerResultSection" style="display:none;">

            <div class="container">

                <!-- Section Heading -->
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">EFOS Partner Centers</h2>
                    <p class="text-muted">Verified centers available in your selected district</p>
                </div>

                <!-- Results Row -->
                <div class="row g-4" id="partnerResults">
                    <!-- Dynamic Cards will load here -->
                </div>

            </div>
        </section>



    </main>

@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const stateSelect = document.getElementById("state2");
            const districtSelect = document.getElementById("district2");

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
                    stateSelect.addEventListener("change", function() {
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



    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {

            let state = document.getElementById('state2').value;
            let district = document.getElementById('district2').value;
            let button = this;

            if (!state || !district) {
                alert('Please select State and District');
                return;
            }

            // Loading Button State
            button.disabled = true;
            button.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Searching...
    `;

            fetch(`{{ route('partner.centers.search') }}?state=${state}&district=${district}`)
                .then(res => res.json())
                .then(response => {

                    let resultSection = document.getElementById('partnerResultSection');
                    let resultContainer = document.getElementById('partnerResults');

                    resultContainer.innerHTML = '';

                    if (!response.data || response.data.length === 0) {

                        resultContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning text-center rounded-4 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        No Partner Centers Found in this area.
                    </div>
                </div>
            `;

                    } else {

                        response.data.forEach(center => {

                            resultContainer.innerHTML += `
                    <div class="col-lg-4 col-md-6">
                        <div class="card partner-card h-100">

                            <div class="partner-header text-center">
                                ${center.company_name}
                            </div>

                            <div class="partner-body">

                                <div class="partner-info">
                                    <i class="fa-solid fa-user"></i>
                                    <strong>Owner:</strong> ${center.owner_name}
                                </div>

                                <div class="partner-info">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <strong>Address:</strong> ${center.address ?? 'N/A'}
                                </div>

                                <div class="partner-info">
                                    <i class="fa-solid fa-phone"></i>
                                    <strong>Phone:</strong> ${center.phone}
                                </div>

                                ${center.location ? `
                                                                <a href="${center.location}"
                                                                   target="_blank"
                                                                   class="btn btn-primary partner-btn mt-3 w-100">
                                                                   <i class="fa-solid fa-map-location-dot me-2"></i>
                                                                   View on Google Maps
                                                                </a>
                                                            ` : ''}

                            </div>

                        </div>
                    </div>
                `;
                        });
                    }

                    resultSection.style.display = "block";
                    resultSection.scrollIntoView({
                        behavior: 'smooth'
                    });

                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong');
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = "Search";
                });

        });
    </script>
@endpush
