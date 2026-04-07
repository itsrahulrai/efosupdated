@extends('backend.layout.layouts')
@section('title', 'Session Booking List - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')
    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title">Session Booking</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Session Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Session Booking</h6>
                        </div>
                        <div class="card-body p-0 pb-2">
                            <table id="dt_basic" class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Mentor</th>
                                        <th>Student</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Meeting</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @forelse ($bookings as $index => $booking)
                                        <tr>
                                            <td>
                                                {{ $bookings->firstItem() + $index }}
                                            </td>
                                            <td>
                                                {{ $booking->mentor->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $booking->student->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($booking->session_date)->format('d M Y') }}
                                            </td>
                                            <td>
                                                {{ $booking->start_time }} - {{ $booking->end_time }}
                                            </td>
                                            <td>
                                                {{ $booking->duration_minutes }} min
                                            </td>
                                            <td>
                                                ₹{{ $booking->final_price }}
                                            </td>
                                            <td>
                                                @if ($booking->payment_status == 'success')
                                                    <span class="badge bg-success">
                                                        Paid
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <select class="form-select form-select-sm booking-status"
                                                    data-id="{{ $booking->id }}">
                                                    <option value="pending"
                                                        {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="accepted"
                                                        {{ $booking->status == 'accepted' ? 'selected' : '' }}>
                                                        Accepted
                                                    </option>
                                                    <option value="rejected"
                                                        {{ $booking->status == 'rejected' ? 'selected' : '' }}>
                                                        Rejected
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelled
                                                    </option>
                                                </select>
                                            </td>
                                            <td>

                                                @if ($booking->zoom_join_url)
                                                    <a href="{{ $booking->zoom_join_url }}" target="_blank"
                                                        class="btn btn-sm btn-primary">

                                                        Join

                                                    </a>
                                                @else
                                                    <span class="text-muted">
                                                        N/A
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning openMeetingModal"
                                                    data-id="{{ $booking->id }}"
                                                    data-platform="{{ $booking->meeting_platform }}"
                                                    data-meetingid="{{ $booking->zoom_meeting_id }}"
                                                    data-joinurl="{{ $booking->zoom_join_url }}"
                                                    data-starturl="{{ $booking->zoom_start_url }}"
                                                    data-password="{{ $booking->zoom_password }}">
                                                    Meeting
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">
                                                No bookings found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Meeting Details --}}
        <div class="modal fade" id="meetingModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="meetingForm">
                        @csrf
                        <input type="hidden" id="booking_id">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Update Meeting Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>
                                    Meeting Platform
                                </label>
                                <select id="meeting_platform" class="form-control">
                                    <option value="zoom">
                                        Zoom
                                    </option>
                                    <option value="google_meet">
                                        Google Meet
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>
                                    Zoom Meeting ID
                                </label>
                                <input type="text" id="zoom_meeting_id" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>
                                    Join URL
                                </label>
                                <input type="text" id="zoom_join_url" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>
                                    Start URL
                                </label>
                                <input type="text" id="zoom_start_url" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>
                                    Password
                                </label>
                                <input type="text" id="zoom_password" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('script')
    <script>
        $(document)
            .off('change', '.booking-status')
            .on('change', '.booking-status', function() {
                let bookingId = $(this).data('id');
                let status = $(this).val();
                $.ajax({
                    url: "{{ route('admin.session-booking.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: bookingId,
                        status: status
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function() {
                        toastr.error('Something went wrong');
                    }
                });
            });
    </script>

    <script>
        // open modal
        $(document).on('click', '.openMeetingModal', function() {
            $('#booking_id').val($(this).data('id'));
            $('#meeting_platform').val($(this).data('platform'));
            $('#zoom_meeting_id').val($(this).data('meetingid'));
            $('#zoom_join_url').val($(this).data('joinurl'));
            $('#zoom_start_url').val($(this).data('starturl'));
            $('#zoom_password').val($(this).data('password'));
            $('#meetingModal').modal('show');
        });
        // submit form
        $(document)
            .off('submit', '#meetingForm')
            .on('submit', '#meetingForm', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: "{{ route('admin.session-booking.updateMeeting') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $('#booking_id').val(),
                        meeting_platform: $('#meeting_platform').val(),
                        zoom_meeting_id: $('#zoom_meeting_id').val(),
                        zoom_join_url: $('#zoom_join_url').val(),
                        zoom_start_url: $('#zoom_start_url').val(),
                        zoom_password: $('#zoom_password').val()
                    },
                    success: function(res) {
                        toastr.success(res.message);
                        $('#meetingModal').modal('hide');
                        location.reload();
                    },
                    error: function() {
                        toastr.error('Something went wrong');
                    }
                });
            });
    </script>
@endpush
