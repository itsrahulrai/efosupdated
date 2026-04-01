<div class="row">
    <div class="col-lg-12">
        <div class="card overflow-hidden">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">Mentor Price Session</h6>
                <button class="btn btn-primary btn-sm" onclick="openCreateSessionPriceModal()">
                    + Add New
                </button>
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
                        <input type="checkbox" class="form-check-input" name="is_free" value="1" id="is_free">

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
