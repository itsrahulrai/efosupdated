<style>
    .booking-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #eee;
    }

    .booking-table-v2 td {
        padding: 18px 12px;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
    }

    .student-cell {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #555;
    }

    .name {
        font-weight: 600;
        font-size: 14px;
    }

    .email {
        font-size: 12px;
        color: #888;
    }

    .price {
        font-weight: 600;
    }

    .old-price {
        font-size: 12px;
        color: #999;
        text-decoration: line-through;
    }

    .duration {
        font-size: 12px;
        color: #888;
    }

    .date {
        font-weight: 600;
    }

    .day {
        font-size: 12px;
        color: #777;
    }

    .time {
        font-size: 13px;
        color: #2563eb;
    }

    .payment-status {
        font-size: 12px;
        color: #16a34a;
    }

    .join-btn {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        display: inline-block;
        margin-top: 4px;
    }

    .status-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-accepted {
        background: #dcfce7;
        color: #166534;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-cancelled {
        background: #e5e7eb;
        color: #374151;
    }

    .action-group {
        display: flex;
        gap: 6px;
    }

    .action-btn {
        border: none;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        background: #f3f4f6;
        cursor: pointer;
    }

    .action-btn.approve {
        background: #dcfce7;
        color: #166534;
    }

    .action-btn.reject {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-btn.video {
        background: #e0e7ff;
    }

    .booking-status {

        min-width: 160px;

        font-size: 13px;

        border-radius: 8px;

        padding: 6px 10px;

    }
</style>

<div class="card booking-card">

    <div class="card-header">

        <h5>Bookings</h5>

    </div>



    <div class="table-responsive">

        <table class="table align-middle booking-table-v2">

            <thead>

                <tr>

                    <th>Student</th>

                    <th>Session</th>

                    <th>Schedule</th>

                    <th>Payment</th>

                    <th>Meeting</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>



            <tbody>

                @forelse($bookings as $booking)
                    <tr>

                        <!-- student -->
                        <td>

                            <div class="student-cell">

                                <div class="avatar">

                                    {{ strtoupper(substr($booking->student->name, 0, 1)) }}

                                </div>

                                <div>

                                    <div class="name">

                                        {{ $booking->student->name }}

                                    </div>

                                    <div class="email">

                                        {{ $booking->student->email }}

                                    </div>

                                </div>

                            </div>

                        </td>



                        <!-- session -->
                        <td>

                            <div class="price">

                                ₹{{ $booking->final_price }}

                            </div>

                            <div class="duration">

                                {{ $booking->duration_minutes }} min session

                            </div>

                        </td>



                        <!-- schedule -->
                        <td>

                            <div class="date">

                                {{ \Carbon\Carbon::parse($booking->session_date)->format('d M Y') }}

                            </div>

                            <div class="day">

                                {{ \Carbon\Carbon::parse($booking->session_date)->format('l') }}

                            </div>

                            <div class="time">

                                {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}

                                -

                                {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}

                            </div>

                        </td>



                        <!-- payment -->
                        <td>

                            <div class="price">

                                ₹{{ $booking->final_price }}

                            </div>

                            @if ($booking->discount_price)
                                <div class="old-price">

                                    ₹{{ $booking->price }}

                                </div>
                            @endif

                            <div class="payment-status">

                                {{ ucfirst($booking->payment_status) }}

                            </div>

                        </td>



                        <!-- meeting -->
                        <td>

                            <div class="meeting">

                                {{ ucfirst($booking->meeting_platform) }}

                            </div>

                            @if ($booking->meeting_platform == 'zoom')
                                <a href="{{ $booking->zoom_join_url }}" target="_blank" class="join-btn">

                                    Join

                                </a>
                            @endif

                        </td>



                        <!-- status -->
                        <td>

                            <span class="status-pill

status-{{ $booking->status }}">

                                {{ ucfirst($booking->status) }}

                            </span>

                        </td>



                        <!-- action -->
                        <td>

                            <div class="d-flex gap-2">

                                <select class="form-select form-select-sm booking-status"
                                    data-id="{{ $booking->id }}">

                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="accepted" {{ $booking->status == 'accepted' ? 'selected' : '' }}>
                                        Accepted
                                    </option>

                                    <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>

                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>

                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>

                                </select>



                                <button class="btn btn-light btn-sm" onclick="openMeetingModal({{ $booking->id }})">

                                    Meeting

                                </button>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            No bookings available

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

<style>
    .meeting-modal .modal-content {
        border-radius: 14px;
        border: none;
        overflow: hidden;
    }

    /* header */
    .meeting-modal .modal-header {
        background: #DC3545;
        color: #fff;
        border: none;
        padding: 18px 20px;
    }

    .meeting-modal .modal-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }

    /* body */
    .meeting-modal .modal-body {
        padding: 20px;
        background: #fff;
    }

    .meeting-modal label {
        font-size: 13px;
        font-weight: 600;
        color: #555;
        margin-bottom: 4px;
    }

    /* inputs */
    .meeting-modal .form-control,
    .meeting-modal .form-select {

        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid #eee;
        transition: 0.2s;

    }

    .meeting-modal .form-control:focus,
    .meeting-modal .form-select:focus {

        border-color: #DC3545;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.15);

    }

    /* footer */
    .meeting-modal .modal-footer {

        border: none;
        padding: 15px 20px;
        background: #fafafa;

    }

    /* button */
    .save-meeting-btn {

        background: #DC3545;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        transition: 0.2s;

    }

    .save-meeting-btn:hover {

        background: #bb2d3b;

    }

    .cancel-btn {

        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 10px 18px;

    }

    .cancel-btn:hover {

        background: #f8f9fa;

    }
</style>



<div class="modal fade meeting-modal" id="meetingModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="meetingForm">
                @csrf
                <input type="hidden" name="booking_id" id="booking_id">
                <div class="modal-header">
                    <h6 class="text-white">
                        Add Meeting Details
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>
                            Meeting Platform
                        </label>
                        <select name="meeting_platform" class="form-select">
                            <option value="zoom">
                                Zoom
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>
                            Meeting ID
                        </label>
                        <input type="text" name="zoom_meeting_id" class="form-control"
                            placeholder="Enter meeting id">
                    </div>
                    <div class="mb-3">
                        <label>
                            Join URL
                        </label>
                        <input type="text" name="zoom_join_url" class="form-control"
                            placeholder="https://zoom.us/j/...">
                    </div>
                    <div class="mb-3">
                        <label>
                            Start URL
                        </label>
                        <input type="text" name="zoom_start_url" class="form-control"
                            placeholder="Host meeting link">
                    </div>
                    <div class="mb-3">
                        <label>
                            Password
                        </label>
                        <input type="text" name="zoom_password" class="form-control" placeholder="Optional">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel-btn" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="save-meeting-btn">
                        Save Meeting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document)
            .off('change', '.booking-status')
            .on('change', '.booking-status', function() {
                let id = $(this).data('id');
                let status = $(this).val();
                $.ajax({
                    url: "{{ route('update.booking.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(res) {
                        toastr.success(res.message);
                    },
                    error: function(err) {
                        console.log(err.responseJSON);
                    }
                });
            });
    </script>

    <script>
        function openMeetingModal(id) {
            $("#meetingForm")[0].reset();
            $("#booking_id").val(id);
            /* get booking data */
            $.ajax({
                url: "{{ route('fetched.booking', '') }}/" + id,
                type: "GET",
                success: function(res) {
                    $("select[name=meeting_platform]")
                        .val(res.meeting_platform);
                    $("input[name=zoom_meeting_id]")
                        .val(res.zoom_meeting_id);
                    $("input[name=zoom_join_url]")
                        .val(res.zoom_join_url);
                    $("input[name=zoom_start_url]")
                        .val(res.zoom_start_url);
                    $("input[name=zoom_password]")
                        .val(res.zoom_password);
                }
            });
            $("#meetingModal").modal("show");

        }
        $("#meetingForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('update.booking.meeting') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    toastr.success(res.message);
                    $("#meetingModal").modal("hide");
                }
            });

        });
    </script>
@endpush
