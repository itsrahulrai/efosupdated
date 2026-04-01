@extends('frontend.layout.layout')

@section('title', 'Mentor Dashboard | EFOS Edumarketers Pvt Ltd')
<style>
    /* cards */
    .card-light {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 16px;
    }

    /* stat cards */
    .stat-card-light {
        background: #fafafa;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-title {
        font-size: 12px;
        color: #888;
        margin-bottom: 2px;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }

    .stat-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* soft colors */
    .bg-primary-soft {
        background: #eef2ff;
        color: #4f46e5;
    }

    .bg-success-soft {
        background: #e9fbf1;
        color: #198754;
    }

    .bg-danger-soft {
        background: #fdecec;
        color: #dc3545;
    }

    .bg-warning-soft {
        background: #fff6e5;
        color: #f59e0b;
    }

    /* tables */
    .table-modern {
        border-collapse: separate;
        border-spacing: 0 6px;
    }

    .table-modern tr {
        background: #fafafa;
    }

    .table-modern td {
        border: none;
        padding: 12px;
        font-size: 13px;
    }

    /* profile */
    .user-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-info img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
    }

    /* action buttons */
    .icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        background: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .icon-btn:hover {
        background: #E62434;
        color: white;
    }

    /* filter buttons */
    .filter-btn {
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #eee;
        background: #fff;
        font-size: 12px;
        margin-right: 6px;
    }

    .filter-btn.active {
        background: #E62434;
        color: #fff;
        border-color: #E62434;
    }

    /* schedule */
    .day-btn {
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #eee;
        background: #fafafa;
        font-size: 12px;
        margin-right: 6px;
        margin-bottom: 6px;
    }

    .day-btn.active {
        background: #035349;
        color: white;
        border-color: #035349;
    }

    .slot-card {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 14px;
    }

    .slot-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .slot-tag {
        background: #f5f5f5;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .slot-tag i {
        cursor: pointer;
        font-size: 11px;
    }
</style>
@section('content')

    <main>

        <div class="container mt-5 mb-5">

            <div class="row">

                {{-- ================= LEFT SIDEBAR ================= --}}
                <div class="col-md-3">

                    <div class="student-dashboard bg-danger rounded shadow-sm pt-3">

                        <h5 class="text-uppercase text-center text-white mb-3">
                            Mentor Panel
                        </h5>

                        <div class="bg-white p-3 rounded-bottom">

                            <ul class="nav flex-column nav-pills gap-2" id="mentorTabs" role="tablist">

                                <li class="nav-item">

                                    <button class="nav-link active w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#dashboard" type="button">

                                        Dashboard

                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#mentees" type="button">

                                        Mentees

                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#bookings" type="button">

                                        Bookings

                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#schedule" type="button">

                                        Scheduled Timings

                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#messages" type="button">

                                        Messages

                                    </button>

                                </li>
                                
{{-- 
                               <li class="nav-item">
                                <a href="{{ route('mentor.messages') }}"
                                class="nav-link w-100 text-start 
                                {{ request()->routeIs('mentor.messages') ? 'active' : '' }}">

                                    Messages

                                </a>

                            </li> --}}


                                <li class="nav-item">

                                    <button class="nav-link w-100 text-start" data-bs-toggle="pill"
                                        data-bs-target="#settings" type="button">

                                        Settings

                                    </button>

                                </li>

                            </ul>


                            <form method="POST" action="{{ route('logout') }}" class="mt-4">

                                @csrf

                                <button type="submit" class="btn btn-outline-danger w-100">

                                    Logout

                                </button>

                            </form>


                        </div>

                    </div>

                </div>



                {{-- ================= RIGHT CONTENT ================= --}}

                <div class="col-md-9">

                    <div class="tab-content">




                        {{-- DASHBOARD --}}
                        <div class="tab-pane fade show active" id="dashboard">

                            <h5 class="mb-3 fw-semibold">
                                Dashboard
                            </h5>


                            <div class="row g-3">

                                <!-- CARD 1 -->
                                <div class="col-md-4">

                                    <div class="stat-card-light">

                                        <div>

                                            <p class="stat-title">
                                                Total Sessions
                                            </p>

                                            <h4 class="stat-value">
                                                120
                                            </h4>

                                        </div>

                                        <div class="stat-icon bg-primary-soft">

                                            <i class="bi bi-camera-video"></i>

                                        </div>

                                    </div>

                                </div>



                                <!-- CARD 2 -->
                                <div class="col-md-4">

                                    <div class="stat-card-light">

                                        <div>

                                            <p class="stat-title">
                                                Total Earnings
                                            </p>

                                            <h4 class="stat-value">
                                                ₹25,000
                                            </h4>

                                        </div>

                                        <div class="stat-icon bg-success-soft">

                                            <i class="bi bi-currency-rupee"></i>

                                        </div>

                                    </div>

                                </div>



                                <!-- CARD 3 -->
                                <div class="col-md-4">

                                    <div class="stat-card-light">

                                        <div>

                                            <p class="stat-title">
                                                Pending Requests
                                            </p>

                                            <h4 class="stat-value">
                                                8
                                            </h4>

                                        </div>

                                        <div class="stat-icon bg-danger-soft">

                                            <i class="bi bi-hourglass"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!-- RECENT SESSION TABLE -->

                            <div class="card-light mt-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <h6 class="fw-semibold mb-0">

                                        Recent Sessions

                                    </h6>

                                    <button class="btn btn-sm btn-light">

                                        View All

                                    </button>

                                </div>



                                <div class="table-responsive">

                                    <table class="table align-middle">

                                        <thead>

                                            <tr>

                                                <th>Student</th>

                                                <th>Date</th>

                                                <th>Type</th>

                                                <th>Status</th>

                                                <th width="160">Action</th>

                                            </tr>

                                        </thead>



                                        <tbody>

                                            <tr>

                                                <td>

                                                    <div class="d-flex align-items-center gap-2">

                                                        <img src="https://i.pravatar.cc/40" class="rounded-circle">

                                                        <div>

                                                            <div class="fw-semibold">

                                                                Rahul Sharma

                                                            </div>

                                                            <small class="text-muted">

                                                                rahul@mail.com

                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    20 Feb 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        10:00 AM
                                                    </small>

                                                </td>



                                                <td>

                                                    <span class="badge bg-primary-soft">

                                                        Video

                                                    </span>

                                                </td>



                                                <td>

                                                    <span class="badge bg-warning-soft">

                                                        Pending

                                                    </span>

                                                </td>



                                                <td>

                                                    <button class="btn btn-sm btn-success">

                                                        Accept

                                                    </button>

                                                    <button class="btn btn-sm btn-light">

                                                        View

                                                    </button>

                                                </td>

                                            </tr>




                                            <tr>

                                                <td>

                                                    <div class="d-flex align-items-center gap-2">

                                                        <img src="https://i.pravatar.cc/41" class="rounded-circle">

                                                        <div>

                                                            <div class="fw-semibold">

                                                                Priya Patel

                                                            </div>

                                                            <small class="text-muted">

                                                                priya@mail.com

                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    22 Feb 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        2:30 PM
                                                    </small>

                                                </td>



                                                <td>

                                                    <span class="badge bg-success-soft">

                                                        Audio

                                                    </span>

                                                </td>



                                                <td>

                                                    <span class="badge bg-success-soft">

                                                        Approved

                                                    </span>

                                                </td>



                                                <td>

                                                    <button class="btn btn-sm btn-outline-secondary">

                                                        Details

                                                    </button>

                                                </td>

                                            </tr>



                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>





                        {{-- MENTEES --}}
                        <div class="tab-pane fade" id="mentees">
                            <h4>Mentees</h4>
                            <div class="card-light">

                                <div class="table-responsive">

                                    <table class="table table-modern align-middle">

                                        <thead>

                                            <tr>

                                                <th>Name</th>

                                                <th>Date & Time</th>

                                                <th>Phone Number</th>

                                                <th>Status</th>

                                                <th width="90">Action</th>

                                            </tr>

                                        </thead>



                                        <tbody>



                                            <tr>

                                                <td>

                                                    <div class="user-info">

                                                        <img src="https://i.pravatar.cc/40?img=11">

                                                        <div>

                                                            <div class="fw-semibold">
                                                                Clifford Finley
                                                            </div>

                                                            <small class="text-muted">
                                                                clifford@example.com
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    05 Oct 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        04:30 PM
                                                    </small>

                                                </td>



                                                <td>
                                                    +1 17356 73485
                                                </td>



                                                <td>

                                                    <span class="status-badge success">
                                                        Accepted
                                                    </span>

                                                </td>



                                                <td>

                                                    <button class="action-btn">

                                                        <i class="bi bi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>




                                            <tr>

                                                <td>

                                                    <div class="user-info">

                                                        <img src="https://i.pravatar.cc/40?img=12">

                                                        <div>

                                                            <div class="fw-semibold">
                                                                James Torres
                                                            </div>

                                                            <small class="text-muted">
                                                                james@example.com
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    02 Dec 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        04:15 PM
                                                    </small>

                                                </td>



                                                <td>
                                                    +1 73498 21865
                                                </td>



                                                <td>

                                                    <span class="status-badge success">
                                                        Accepted
                                                    </span>

                                                </td>



                                                <td>

                                                    <button class="action-btn">

                                                        <i class="bi bi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>



                                            <tr>

                                                <td>

                                                    <div class="user-info">

                                                        <img src="https://i.pravatar.cc/40?img=13">

                                                        <div>

                                                            <div class="fw-semibold">
                                                                Janice Ortiz
                                                            </div>

                                                            <small class="text-muted">
                                                                janice@example.com
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    15 Dec 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        10:30 AM
                                                    </small>

                                                </td>



                                                <td>
                                                    +1 24966 73458
                                                </td>



                                                <td>

                                                    <span class="status-badge success">
                                                        Accepted
                                                    </span>

                                                </td>



                                                <td>

                                                    <button class="action-btn">

                                                        <i class="bi bi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>



                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>





                        {{-- BOOKINGS --}}
                        <div class="tab-pane fade" id="bookings">

                            <div class="card-light">

                                <!-- header -->
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <h6 class="fw-semibold mb-0">
                                        Bookings
                                    </h6>

                                    <input type="text" class="form-control form-control-sm w-auto"
                                        placeholder="Search">

                                </div>


                                <!-- filters -->
                                <div class="mb-3">

                                    <button class="filter-btn active">
                                        Upcoming
                                    </button>

                                    <button class="filter-btn">
                                        Completed
                                    </button>

                                    <button class="filter-btn">
                                        Cancelled
                                    </button>

                                </div>



                                <!-- table -->
                                <div class="table-responsive">

                                    <table class="table table-modern align-middle">

                                        <thead>

                                            <tr>

                                                <th>Name</th>

                                                <th>Date & Time</th>

                                                <th>Session Mode</th>

                                                <th width="140">Action</th>

                                            </tr>

                                        </thead>



                                        <tbody>


                                            <tr>

                                                <td>

                                                    <div class="user-info">

                                                        <img src="https://i.pravatar.cc/40?img=21">

                                                        <div>

                                                            <div class="fw-semibold">
                                                                Clifford Finley
                                                            </div>

                                                            <small class="text-muted">
                                                                clifford@example.com
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    05 Oct 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        04:30 PM
                                                    </small>

                                                </td>



                                                <td>

                                                    <span class="badge bg-primary-soft">

                                                        <i class="bi bi-camera-video"></i>
                                                        Video Call

                                                    </span>

                                                </td>



                                                <td>

                                                    <div class="d-flex gap-1">

                                                        <button class="icon-btn success">

                                                            <i class="bi bi-check"></i>

                                                        </button>


                                                        <button class="icon-btn danger">

                                                            <i class="bi bi-x"></i>

                                                        </button>


                                                        <button class="icon-btn">

                                                            <i class="bi bi-eye"></i>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>




                                            <tr>

                                                <td>

                                                    <div class="user-info">

                                                        <img src="https://i.pravatar.cc/40?img=22">

                                                        <div>

                                                            <div class="fw-semibold">
                                                                James Torres
                                                            </div>

                                                            <small class="text-muted">
                                                                james@example.com
                                                            </small>

                                                        </div>

                                                    </div>

                                                </td>



                                                <td>

                                                    02 Dec 2026
                                                    <br>

                                                    <small class="text-muted">
                                                        04:15 PM
                                                    </small>

                                                </td>



                                                <td>

                                                    <span class="badge bg-success-soft">

                                                        <i class="bi bi-telephone"></i>
                                                        Audio Call

                                                    </span>

                                                </td>



                                                <td>

                                                    <div class="d-flex gap-1">

                                                        <button class="icon-btn success">

                                                            <i class="bi bi-check"></i>

                                                        </button>


                                                        <button class="icon-btn danger">

                                                            <i class="bi bi-x"></i>

                                                        </button>


                                                        <button class="icon-btn">

                                                            <i class="bi bi-eye"></i>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>



                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>





                        {{-- SCHEDULE --}}
                        <div class="tab-pane fade" id="schedule">

                            <div class="card-light">

                                <h6 class="fw-semibold mb-2">
                                    Scheduled Timings
                                </h6>

                                <label class="small text-muted">
                                    Select Available Days
                                </label>

                                <div class="mb-3">

                                    <button class="day-btn active">Monday</button>
                                    <button class="day-btn">Tuesday</button>
                                    <button class="day-btn">Wednesday</button>
                                    <button class="day-btn">Thursday</button>
                                    <button class="day-btn">Friday</button>
                                    <button class="day-btn">Saturday</button>
                                    <button class="day-btn">Sunday</button>

                                </div>


                                <div class="slot-card">

                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                        <b class="small">
                                            Monday
                                        </b>

                                        <div class="d-flex gap-2">

                                            <button class="btn btn-sm btn-outline-success">

                                                + Slot

                                            </button>

                                            <button class="btn btn-sm btn-outline-dark">

                                                Edit

                                            </button>

                                            <button class="btn btn-sm btn-outline-danger">

                                                Delete

                                            </button>

                                        </div>

                                    </div>


                                    <div class="slot-tags mb-2">

                                        <span class="slot-tag">
                                            8:00 pm - 11:30 pm
                                            <i class="bi bi-x"></i>
                                        </span>

                                        <span class="slot-tag">
                                            11:30 pm - 1:30 pm
                                            <i class="bi bi-x"></i>
                                        </span>

                                        <span class="slot-tag">
                                            3:00 pm - 5:00 pm
                                            <i class="bi bi-x"></i>
                                        </span>

                                    </div>


                                    <label class="small text-muted">
                                        Fees
                                    </label>

                                    <input type="text" class="form-control form-control-sm" value="300">

                                </div>

                            </div>

                        </div>




                        {{-- MESSAGES --}}
                        <div class="tab-pane fade" id="messages">


                            @include('mentor.includes.message')


                        </div>





                        {{-- SETTINGS --}}
                        <div class="tab-pane fade" id="settings">
                            <div class="mb-3">

                                <button type="button" class="filter-btn active" data-tab="profileTab">
                                    Profile
                                </button>

                                <button type="button" class="filter-btn" data-tab="passwordTab">
                                    Change Password
                                </button>

                            </div>

                            <div id="profileTab" class="tab-content-box">
                                @include('mentor.includes.profile')

                            </div>

                            <div id="passwordTab" class="tab-content-box d-none">
                                @include('mentor.includes.change-password')
                            </div>


                        </div>


                    </div>

                </div>

            </div>

        </div>

    </main>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const buttons = document.querySelectorAll(".filter-btn");
        const tabs = document.querySelectorAll(".tab-content-box");

        buttons.forEach(btn => {

            btn.addEventListener("click", function() {

                // remove active class
                buttons.forEach(b => b.classList.remove("active"));

                // hide all tab content
                tabs.forEach(tab => tab.classList.add("d-none"));

                // add active class
                this.classList.add("active");

                // show selected tab
                const tabId = this.dataset.tab;

                if (tabId) {
                    document.getElementById(tabId).classList.remove("d-none");
                }

            });

        });

    });
</script>
