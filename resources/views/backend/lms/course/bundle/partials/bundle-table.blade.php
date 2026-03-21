<table class="table display">

    <thead class="table-light">
        <tr>
            <th width="70">S.No</th>
            <th>Thumbnail</th>
            <th>Bundle</th>
            <th>Price</th>
            <th>Courses</th>
            <th>Status</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($bundles as $index => $bundle)
            <tr>
                <td>{{ $bundles->firstItem() + $index }}</td>
                <td>
                    @if ($bundle->thumbnail)
                        <img src="{{ static_asset($bundle->thumbnail) }}" width="60" class="rounded">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>


                <td>
                    <strong>{{ $bundle->title }}</strong>
                </td>

                <td>
                    @if ($bundle->has_discount)
                        <span class="text-decoration-line-through text-muted">
                            ₹{{ $bundle->price }}
                        </span>
                        <br>
                        <span class="fw-bold text-success">
                            ₹{{ $bundle->discount_price }}
                        </span>
                    @else
                        ₹{{ $bundle->price }}
                    @endif
                </td>

                @php
                    $colors = ['primary', 'success', 'warning', 'info', 'secondary', 'dark'];
                @endphp

                <td>
                    @foreach ($bundle->courses as $index => $course)
                        <span class="badge bg-{{ $colors[$index % count($colors)] }} me-1 mb-1">
                            {{ $course->title }}
                        </span>
                    @endforeach
                </td>

                <td>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $bundle->id }}"
                            {{ $bundle->status ? 'checked' : '' }}>
                    </div>
                </td>

                <td class="text-end">
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.bundle-course.edit', $bundle->id) }}"
                            class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>

                        <form action="{{ route('admin.bundle-course.destroy', $bundle->id) }}" method="POST"
                            class="delete-form m-0">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No bundles found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($bundles->hasPages())
    <div class="d-flex justify-content-end mt-3">
        {{ $bundles->links() }}
    </div>
@endif


@push('script')
    <script>
        $(document).off('change', '.toggle-status').on('change', '.toggle-status', function() {

            let bundleId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.bundle-course.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: bundleId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });

        });
    </script>
@endpush
