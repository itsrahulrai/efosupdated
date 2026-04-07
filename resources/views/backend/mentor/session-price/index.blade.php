<div class="row">
    <div class="col-lg-12">
        <div class="card overflow-hidden">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">Session Bookings</h6>
            </div>
            <div class="card-body p-0 pb-2">
                <table class="table display">
                    <thead class="table-light">
                        <tr>
                            <th width="70">S.No</th>
                            <th>Mentor Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Session Type</th>
                            <th>Platform</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($mentorSessionPrice as $index => $price)
                            <tr>
                                <td>
                                    {{ $mentorSessionPrice->firstItem() + $index }}
                                </td>
                                <td>
                                    {{ $price->mentor->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $price->duration_minutes }} min
                                </td>
                                <td>

                                    @if ($price->is_free)
                                        <span class="badge bg-success">FREE</span>
                                    @else
                                        ₹ {{ $price->price }}
                                    @endif

                                </td>
                                <td>
                                    {{ $price->discount_price ? '₹ ' . $price->discount_price : '-' }}
                                </td>
                                <td>
                                    {{ ucfirst($price->session_type) }}
                                </td>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $price->meeting_platform)) }}
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input session-price-status"
                                            data-id="{{ $price->id }}" {{ $price->status ? 'checked' : '' }}>
                                    </div>
                                </td>

                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary"
                                        onclick="openEditSessionPriceModal(
                                            '{{ $price->id }}',
                                            '{{ $price->mentor_id }}',
                                            '{{ $price->duration_minutes }}',
                                            '{{ $price->price }}',
                                            '{{ $price->discount_price }}',
                                            '{{ $price->is_free }}',
                                            '{{ $price->session_type }}',
                                            '{{ $price->meeting_platform }}',
                                            '{{ $price->status }}')">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.mentor-session-price.destroy', $price->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this session price?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="card overflow-hidden">

                                            <div class="card-header d-flex align-items-center justify-content-between">

                                                <h6 class="card-title mb-0">Availability</h6>

                                                <button class="btn btn-primary btn-sm"
                                                    onclick="openCreateAvailabilityModal()">
                                                    + Add New
                                                </button>

                                            </div>

                                            <div class="card-body p-0 pb-2">

                                                <table class="table">

                                                    <thead class="table-light">

                                                        <tr>
                                                            <th width="60">S.No</th>
                                                            <th>Mentor Name</th>
                                                            <th>Day</th>
                                                            <th>Start Time</th>
                                                            <th>End Time</th>
                                                            <th>Slot Gap</th>
                                                            <th>Timezone</th>
                                                            <th>Status</th>
                                                            <th class="text-end">Action</th>
                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        @forelse($mentorAvailability as $index => $availability)
                                                            <tr>

                                                                <td>
                                                                    {{ $mentorAvailability->firstItem() + $index }}
                                                                </td>

                                                                <td>
                                                                    {{ $availability->mentor->name ?? '-' }}
                                                                </td>

                                                                <td>
                                                                    {{ ucfirst($availability->day) }}
                                                                </td>

                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($availability->start_time)->format('h:i A') }}
                                                                </td>

                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($availability->end_time)->format('h:i A') }}
                                                                </td>

                                                                <td>
                                                                    {{ $availability->slot_gap }} min
                                                                </td>

                                                                <td>
                                                                    {{ $availability->timezone }}
                                                                </td>

                                                                <td>

                                                                    <div class="form-check form-switch">

                                                                        <input type="checkbox"
                                                                            class="form-check-input availability-status"
                                                                            data-id="{{ $availability->id }}"
                                                                            {{ $availability->is_active ? 'checked' : '' }}>

                                                                    </div>

                                                                </td>

                                                                <td class="text-end">

                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick="openEditAvailabilityModal(
                                        '{{ $availability->id }}',
                                        '{{ $availability->mentor_id }}',
                                        '{{ $availability->day }}',
                                        '{{ $availability->start_time }}',
                                        '{{ $availability->end_time }}',
                                        '{{ $availability->slot_gap }}',
                                        '{{ $availability->timezone }}'
                                        )">
                                                                        Edit
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('admin.mentor-availability.destroy', $availability->id) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Delete availability?')">

                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button class="btn btn-sm btn-danger">
                                                                            Delete
                                                                        </button>

                                                                    </form>

                                                                </td>

                                                            </tr>

                                                        @empty

                                                            <tr>

                                                                <td colspan="9" class="text-center">
                                                                    No availability found
                                                                </td>

                                                            </tr>
                                                        @endforelse

                                                    </tbody>

                                                </table>

                                                <div class="d-flex justify-content-end mt-3">

                                                    {{ $mentorAvailability->appends(['tab' => 'tab-availability'])->links() }}

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="modal fade" id="availabilityModal">

                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">

                                            <form method="POST" id="availabilityForm">

                                                @csrf

                                                <input type="hidden" name="_method" id="availabilityFormMethod">

                                                <input type="hidden" name="id" id="availability_id">

                                                <div class="modal-header">

                                                    <h5 class="modal-title">
                                                        Add Availability
                                                    </h5>


                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>

                                                </div>


                                                <div class="modal-body">


                                                    <div class="mb-3">

                                                        <label>Mentor</label>

                                                        <select name="mentor_id" id="mentor_id_availability"
                                                            class="form-control">

                                                            <option value="">Select Mentor</option>

                                                            @foreach ($mentorProfiles as $mentor)
                                                                <option value="{{ $mentor->id }}">

                                                                    {{ $mentor->name }}

                                                                </option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>Day</label>

                                                        <select name="day" id="day" class="form-control">

                                                            <option value="monday">Monday</option>
                                                            <option value="tuesday">Tuesday</option>
                                                            <option value="wednesday">Wednesday</option>
                                                            <option value="thursday">Thursday</option>
                                                            <option value="friday">Friday</option>
                                                            <option value="saturday">Saturday</option>
                                                            <option value="sunday">Sunday</option>

                                                        </select>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label>Start Time</label>
                                                            <input type="time" name="start_time" id="start_time"
                                                                class="form-control">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label>End Time</label>
                                                            <input type="time" name="end_time" id="end_time"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label>Slot Gap (minutes)</label>

                                                            <input type="number" name="slot_gap" id="slot_gap"
                                                                value="10" class="form-control">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label>Timezone</label>

                                                            <input type="text" name="timezone" id="timezone"
                                                                value="Asia/Kolkata" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="alert alert-info py-2 px-3 mx-2 small">
                                                    <b>Note:</b>
                                                    <ul class="mb-0 ps-3">
                                                        <li>Enter mentor working hours for the selected day.</li>
                                                        <li>Slot Gap = time between each session.</li>
                                                        <li>Avoid overlapping time slots.</li>
                                                        <li><b>Example:</b> 10:00 – 01:00 with 15 min gap → slots every
                                                            15 minutes.</li>
                                                    </ul>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        Save
                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                @push('script')
                                    <script>
                                        $(document)
                                            .off('change', '.availability-status')
                                            .on('change', '.availability-status', function() {

                                                let id = $(this).data('id');
                                                let status = $(this).prop('checked') ? 1 : 0;

                                                $.ajax({
                                                    url: "{{ route('admin.mentor-availability.status') }}",
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

                                        function confirmDelete() {
                                            return confirm("Are you sure you want to permanently delete this category?");
                                        }


                                        $('#end_time').on('change', function() {

                                            if ($('#start_time').val() >= $(this).val()) {

                                                alert('End time must be greater than start time');

                                                $(this).val('');

                                            }

                                        });



                                        function openCreateAvailabilityModal() {

                                            $('#availabilityForm')[0].reset();

                                            $('#availabilityModal .modal-title').text('Add Time Slot');

                                            $('#availabilityForm').attr(
                                                'action',
                                                "{{ route('admin.mentor-availability.store') }}"
                                            );

                                            $('#availabilityFormMethod').val('');

                                            $('#availability_id').val('');

                                            $('#mentor_id_availability').val('');

                                            $('#day').val('monday');

                                            $('#slot_gap').val(10);

                                            $('#timezone').val('Asia/Kolkata');

                                            $('#availabilityModal').modal('show');

                                        }



                                        function openEditAvailabilityModal(

                                            id,
                                            mentor_id,
                                            day,
                                            start_time,
                                            end_time,
                                            slot_gap,
                                            timezone

                                        ) {

                                            $('#availabilityModal .modal-title').text('Edit Time Slot');

                                            let url =
                                                "{{ route('admin.mentor-availability.update', ':id') }}";

                                            url = url.replace(':id', id);

                                            $('#availabilityForm').attr('action', url);

                                            $('#availabilityFormMethod').val('PUT');

                                            $('#availability_id').val(id);

                                            $('#mentor_id_availability').val(mentor_id);

                                            $('#day').val(day);

                                            $('#start_time').val(start_time);

                                            $('#end_time').val(end_time);

                                            $('#slot_gap').val(slot_gap);

                                            $('#timezone').val(timezone);

                                            $('#availabilityModal').modal('show');

                                        }
                                    </script>
                                @endpush

                                <td colspan="9" class="text-center">
                                    No session price found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">

                    {{ $mentorSessionPrice->appends(['tab' => 'tab-prices'])->links() }}

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sessionPriceModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="sessionPriceForm">
                @csrf
                <input type="hidden" name="_method" id="sessionPriceFormMethod">
                <input type="hidden" name="id" id="session_price_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="sessionPriceModalTitle">
                        Add Session Price
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Mentor</label>
                        <select name="mentor_id" id="mentor_id" class="form-control">
                            <option value="">Select Mentor</option>
                            @foreach ($mentorProfiles as $mentor)
                                <option value="{{ $mentor->id }}">
                                    {{ $mentor->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="mb-3">
                        <label>Duration (minutes)</label>
                        @php
                            $durations = [15, 20, 30, 45, 60, 90];
                        @endphp

                        <select name="duration_minutes" id="duration_minutes" class="form-control">

                            <option value="">Select Duration</option>

                            @foreach ($durations as $duration)
                                <option value="{{ $duration }}">

                                    {{ $duration }} min

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Discount Price</label>
                        <input type="number" name="discount_price" id="discount_price" class="form-control">
                    </div>

                    <div class="mb-3">

                        <label>Session Type</label>

                        <select name="session_type" id="session_type" class="form-control">
                            <option value="">Select Session Type </option>
                            <option value="video">Video</option>
                            <option value="chat">Chat</option>
                            <option value="call">Call</option>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label>Meeting Platform</label>
                        <select name="meeting_platform" id="meeting_platform" class="form-control">
                            <option value="">Select Meeting Platform</option>
                            <option value="zoom">Zoom</option>
                            <option value="google_meet">Google Meet</option>
                            <option value="teams">Teams</option>
                        </select>

                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_free" value="0">
                        <input type="checkbox" class="form-check-input" name="is_free" value="1"
                            id="is_free">

                        <label class="form-check-label">
                            Free Session
                        </label>

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-primary" id="sessionPriceSubmitBtn">

                        Save

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@push('script')
    <script>
        $(document)
            .off('change', '.session-price-status')
            .on('change', '.session-price-status', function() {

                let id = $(this).data('id');
                let status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('admin.mentor-session-price.status') }}",
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

        function confirmDelete() {
            return confirm("Are you sure you want to permanently delete this category?");
        }


        $(document).on('change', '#is_free', function() {

            if ($(this).is(':checked')) {

                $('#price').val(0);
                $('#discount_price').val('');

                $('#price').prop('readonly', true);
                $('#discount_price').prop('readonly', true);

            } else {

                $('#price').prop('readonly', false);
                $('#discount_price').prop('readonly', false);

            }

        });

        $('#discount_price').on('input', function() {
            let price = parseFloat($('#price').val());

            let discount = parseFloat($(this).val());

            if (discount > price) {

                alert('Discount cannot be greater than price');

                $(this).val('');

            }

        });

        function openCreateSessionPriceModal() {

            $('#sessionPriceForm')[0].reset();

            $('#sessionPriceModalTitle').text('Add Session Price');

            $('#sessionPriceSubmitBtn').text('Save');

            $('#sessionPriceForm').attr(
                'action',
                "{{ route('admin.mentor-session-price.store') }}"
            );

            $('#sessionPriceFormMethod').val('');

            $('#session_price_id').val('');

            $('#mentor_id').val('');

            $('#duration_minutes').val('');

            $('#session_type').val('');

            $('#meeting_platform').val('');

            $('#is_free')
                .prop('checked', false)
                .trigger('change');

            $('#price').prop('readonly', false);

            $('#discount_price').prop('readonly', false);

            $('#sessionPriceModal').modal('show');

        }

        function openEditSessionPriceModal(

            id,
            mentor_id,
            duration,
            price,
            discount_price,
            is_free,
            session_type,
            platform

        ) {

            $('#sessionPriceModalTitle').text('Edit Session Price');

            $('#sessionPriceSubmitBtn').text('Update');

            let url =
                "{{ route('admin.mentor-session-price.update', ':id') }}";

            url = url.replace(':id', id);

            $('#sessionPriceForm').attr('action', url);

            $('#sessionPriceFormMethod').val('PUT');

            $('#session_price_id').val(id);

            $('#mentor_id').val(mentor_id);

            $('#duration_minutes').val(duration);

            $('#price').val(price);

            $('#discount_price').val(discount_price);

            $('#session_type').val(session_type);

            $('#meeting_platform').val(platform);

            if (is_free == 1) {

                $('#is_free').prop('checked', true).trigger('change');

            } else {

                $('#is_free').prop('checked', false).trigger('change');

            }

            $('#sessionPriceModal').modal('show');

        }
    </script>
@endpush
