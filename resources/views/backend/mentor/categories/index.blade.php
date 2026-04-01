<div class="row">
    <div class="col-lg-12">
        <div class="card overflow-hidden">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">Expertise</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#expertiseModal"
                    onclick="openCreateModal()">
                    + Add New
                </button>
            </div>

            <div class="card-body p-0 pb-2">
                <table class="table display">
                    <thead class="table-light">
                        <tr>
                            <th width="70">S.No</th>
                            <th class="minw-200px">Name</th>
                            <th class="minw-150px">Slug</th>
                            <th class="minw-150px">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($expertises as $index => $category)
                            <tr>
                               <td>{{ $expertises->firstItem() + $index }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <div class="form-check form-switch fs-5">
                                        <input class="form-check-input toggle-status" type="checkbox"
                                            data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                    </div>
                                </td>

                                {{-- Action --}}
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary"
                                        onclick="openEditModal(
                                            '{{ $category->id }}',
                                            '{{ $category->name }}',
                                            '{{ $category->slug }}',
                                            '{{ $category->description }}'
                                            )">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.mentor-categories.destroy', $category->id) }}"
                                        method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
              <div class="d-flex justify-content-end px-3 pb-3">
                {{ $expertises->appends([
                'tab' => 'tab-expertise'
                ])->links() }}

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="expertiseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="expertiseForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod">
                <input type="hidden" id="expertise_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        Add Expertise
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Enter Expertise Name" required>
                        </div>
                        {{-- Slug --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control"
                                placeholder="Auto generated">
                            <small class="text-muted">
                                Leave empty to auto generate
                            </small>
                        </div>
                        {{-- Description --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Write short description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
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
        $(document).off('change', '.toggle-status').on('change', '.toggle-status', function() {

            let categoryId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.mentor-categories.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: categoryId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }

                },
                error: function() {
                    toastr.error('Something went wrong');
                }

            });

        });

        function confirmDelete() {
            return confirm("Are you sure you want to permanently delete this category?");
        }
    </script>


    <script>
        function openCreateModal() {
            $('#modalTitle').text('Add Expertise');
            $('#expertiseForm').attr(
                'action',
                "{{ route('admin.mentor-categories.store') }}"
            );
            $('#formMethod').val('');
            $('#name').val('');
            $('#slug').val('');
            $('#description').val('');
            $('#expertiseModal').modal('show');

        }

        function openEditModal(id, name, slug, description) {
            $('#modalTitle').text('Edit Expertise');
            let updateUrl =
                "{{ route('admin.mentor-categories.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', id);
            $('#expertiseForm').attr('action', updateUrl);
            $('#formMethod').val('PUT');
            $('#name').val(name);
            $('#slug').val(slug);
            $('#description').val(description);
            $('#expertiseModal').modal('show');
        }
        //// auto slug generate
        let slugEdited = false;
        $('#slug').on('input', function() {
            slugEdited = true;
        });

        $('#name').on('input', function() {

            if (!slugEdited) {
                let slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/&/g, 'and')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                $('#slug').val(slug);
            }

        });
    </script>
@endpush
