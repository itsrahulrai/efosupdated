<div class="row">
    <div class="col-lg-12">

        <div class="card overflow-hidden">

            <div class="card-header d-flex align-items-center justify-content-between">

                <h6 class="card-title mb-0">Availability</h6>

                <button class="btn btn-primary btn-sm" onclick="openCreateAvailabilityModal()">
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

                                        <input type="checkbox" class="form-check-input availability-status"
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

                                    <form action="{{ route('admin.mentor-availability.destroy', $availability->id) }}"
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


                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">


                    <div class="mb-3">

                        <label>Mentor</label>

                        <select name="mentor_id" id="mentor_id_availability" class="form-control">

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
                            <input type="time" name="start_time" id="start_time" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Slot Gap (minutes)</label>

                            <input type="number" name="slot_gap" id="slot_gap" value="10" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Timezone</label>

                            <input type="text" name="timezone" id="timezone" value="Asia/Kolkata"
                                class="form-control">
                        </div>
                    </div>

                </div>
                <div class="alert alert-info py-2 px-3 mx-2 small">
                    <b>Note:</b>
                    <ul class="mb-0 ps-3">
                        <li>Enter mentor working hours for the selected day.</li>
                        <li>Slot Gap = time between each session.</li>
                        <li>Avoid overlapping time slots.</li>
                        <li><b>Example:</b> 10:00 – 01:00 with 15 min gap → slots every 15 minutes.</li>
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
