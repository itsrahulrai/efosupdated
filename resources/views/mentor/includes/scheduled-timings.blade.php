<div class="card-light">
    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-semibold mb-0">
            Scheduled Timings
        </h6>
        <button class="btn btn-danger btn-sm" onclick="openCreateSlotModal()">
            + Add Slot
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Gap</th>
                    <th>Status</th>
                    <th width="120">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($mentorAvailability as $index => $slot)
                    <tr>
                        <td>
                            {{ $mentorAvailability->firstItem() + $index }}
                        </td>
                        <td>
                            {{ ucfirst($slot->day) }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                        </td>
                        <td>
                            {{ $slot->slot_gap }} min
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" {{ $slot->is_active ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <button class="icon-btn"
                                onclick="editSlot(
                                '{{ $slot->id }}',
                                '{{ $slot->day }}',
                                '{{ $slot->start_time }}',
                                '{{ $slot->end_time }}',
                                '{{ $slot->slot_gap }}')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="" class="icon-btn text-danger" onclick="return confirm('Delete slot?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No slots added
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $mentorAvailability->links() }}
    </div>
</div>


<div class="modal fade" id="slotModal">
    <div class="modal-dialog">
        <div class="modal-content shadow border-0">
            <form method="POST" id="slotForm">
                @csrf
                <input type="hidden" name="slot_id" id="slot_id">
                <!-- header -->
                <div class="modal-header border-0">
                    <div>
                        <h6 class="fw-semibold mb-1">
                            Scheduled Timing
                        </h6>
                        <small class="text-muted">
                            Add your available working hours
                        </small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <!-- body -->
                <div class="modal-body pt-2">
                    <!-- day -->
                    <div class="mb-3">
                        <label class="small text-muted">
                            Day
                        </label>
                        <select name="day" id="day" class="form-select">
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div>
                    <!-- time -->
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="small text-muted">
                                Start Time
                            </label>
                            <input type="time" name="start_time" id="start_time" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">
                                End Time
                            </label>
                            <input type="time" name="end_time" id="end_time" class="form-control">
                        </div>
                    </div>
                    <!-- gap -->
                    <div class="mt-3">
                        <label class="small text-muted">
                            Slot Gap (minutes)
                        </label>
                        <input type="number" name="slot_gap" id="slot_gap" value="15" class="form-control">
                    </div>
                    <input type="hidden" name="timezone" value="Asia/Kolkata">
                    <!-- note -->
                    <div class="alert alert-light border mt-3 small">
                        <b>Note:</b>
                        <ul class="mb-0 ps-3">
                            <li>Enter mentor working hours for selected day</li>
                            <li>Slot Gap = session interval</li>
                            <li>Avoid overlapping time slots</li>
                            <li>
                                Example:
                                10:00 – 13:00 with 15 min gap
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- footer -->
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-danger px-4">
                        Save Slot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateSlotModal() {
        document.getElementById("slotForm").action =
            "{{ route('mentorslot.store') }}";
        document.getElementById("slotForm").reset();
        document.getElementById("slot_id").value = "";
        new bootstrap.Modal(
            document.getElementById('slotModal')
        ).show();

    }

    function editSlot(id,day,start,end,gap) {
        document.getElementById("slotForm").action =
            "{{ url('/mentor/slot/update') }}/" + id;
        document.getElementById("slot_id").value = id;
        /* set dropdown value */
        document.getElementById("day").value = day.trim();
        document.getElementById("start_time").value = start;
        document.getElementById("end_time").value = end;
        document.getElementById("slot_gap").value = gap;
        new bootstrap.Modal(
            document.getElementById('slotModal')
        ).show();

    }
</script>
