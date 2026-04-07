<div class="row">
    <div class="col-lg-12">
        <div class="card overflow-hidden">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">Mentor Profiles</h6>
                <button class="btn btn-primary btn-sm" onclick="openCreateMentorModal()">
                    + Add New
                </button>
            </div>
            <div class="card-body p-0 pb-2">
                <table class="table display">
                    <thead class="table-light">
                        <tr>
                            <th width="70">S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Experience</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mentorProfiles as $index => $mentor)
                            <tr>
                                <td>
                                    {{ $mentorProfiles->firstItem() + $index }}
                                </td>
                                <td>{{ $mentor->name }}</td>
                                <td>{{ $mentor->email }}</td>
                                <td>{{ $mentor->phone }}</td>
                                <td>
                                    {{ $mentor->category->name ?? '-' }}
                                </td>
                                <td>{{ $mentor->experience }}</td>
                                <td>
                                    <select class="form-select form-select-sm mentor-status"
                                        data-id="{{ $mentor->id }}">
                                        <option value="pending" {{ $mentor->status == 'pending' ? 'selected' : '' }}>
                                            Pending </option>
                                        <option value="approved" {{ $mentor->status == 'approved' ? 'selected' : '' }}>
                                            Approved </option>
                                        <option value="rejected" {{ $mentor->status == 'rejected' ? 'selected' : '' }}>
                                            Rejected </option>
                                    </select>

                                </td>
                                <td class="text-end">

                                    <button class="btn btn-sm btn-primary"
                                        onclick="openEditMentorModal(

                                        '{{ $mentor->id }}',
                                        '{{ $mentor->mentor_category_id }}',
                                        '{{ $mentor->name }}',
                                        '{{ $mentor->email }}',
                                        '{{ $mentor->phone }}',
                                        '{{ $mentor->experience }}',
                                        `{{ $mentor->skills }}`,
                                        `{{ $mentor->shortbio }}`,
                                        `{{ $mentor->bio }}`,
                                        `{{ $mentor->state }}`,
                                        `{{ $mentor->city }}`,
                                        `{{ $mentor->zip_code }}`,
                                        `{{ $mentor->address }}`,
                                        '{{ static_asset($mentor->profile_photo) }}'
                                        )">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.mentor-profile.destroy', $mentor->id) }}"
                                        method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No mentor profiles found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                {{-- Pagination --}}
                {{ $mentorProfiles->appends(['tab' => 'tab-mentors'])->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mentorModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" id="mentorForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="mentorFormMethod">
                <div class="modal-header">
                    <h5 class="modal-title" id="mentorModalTitle">
                        Add Mentor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- category --}}
                        <div class="col-md-6 mb-3">
                            <label>Expertise</label>
                            <select name="mentor_category_id" id="mentor_category_id" class="form-control" required>
                                <option value="">Select Expertise</option>
                                @foreach ($expertises as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- name --}}
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="mentor_name" class="form-control" required>
                        </div>
                        {{-- email --}}
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="mentor_email" class="form-control">
                        </div>
                        {{-- phone --}}
                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="mentor_phone" class="form-control">
                        </div>
                        {{-- state --}}
                        <div class="col-md-4 mb-3">
                            <label>State</label>
                            <input type="text" name="state" id="mentor_state" class="form-control">
                        </div>
                        {{-- city --}}
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" name="city" id="mentor_city" class="form-control">
                        </div>
                        {{-- zip --}}
                        <div class="col-md-4 mb-3">
                            <label>Zip Code</label>
                            <input type="text" name="zip_code" id="mentor_zip" class="form-control">
                        </div>
                        {{-- address --}}
                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <input type="text" name="address" id="mentor_address" class="form-control">
                        </div>
                        {{-- experience --}}
                        <div class="col-md-6 mb-3">
                            <label>Experience</label>
                            <input type="text" name="experience" id="mentor_experience" class="form-control">
                        </div>
                        {{-- skills --}}
                        <div class="col-md-6 mb-3">
                            <label>Skills</label>
                            <input type="text" name="skills" id="mentor_skills" class="form-control">
                        </div>
                         {{-- bio --}}
                       
                          <div class="col-md-12 mb-3">
                            <label>Short Bio</label>
                            <textarea name="shortbio" id="short_bio" class="form-control" rows="3"></textarea>
                        </div>

                        {{-- bio --}}
                        <div class="col-md-12 mb-3">
                            <label>Bio</label>
                            <textarea name="bio" id="mentor_bio" class="form-control" rows="3"></textarea>
                        </div>
                        {{-- photo --}}
                        <div class="col-md-6 mb-3">
                            <label>Profile Photo</label>
                            <input type="file" name="profile_photo" id="mentor_photo" class="form-control">
                            <img id="photoPreview" src=""
                                style="margin-top:10px;
                                    max-height:80px;
                                    display:none;
                                    border-radius:6px;">
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
        $(document)
            .off('change', '.mentor-status')
            .on('change', '.mentor-status', function() {

                let id = $(this).data('id');
                let status = $(this).val();

                $.ajax({
                    url: "{{ route('admin.mentor-profile.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(res) {
                        toastr.success(res.message);
                    }
                });

            });


        function confirmDelete() {
            return confirm("Are you sure you want to permanently delete this category?");
        }


        function openCreateMentorModal() {
            $('#mentorModalTitle').text('Add Mentor');
            $('#mentorForm').attr(
                'action',
                "{{ route('admin.mentor-profile.store') }}"
            );

             $('#short_bio').val('');
            $('#mentorFormMethod').val('');
            $('#mentor_category_id').val('');
            $('#mentor_name').val('');
            $('#mentor_email').val('');
            $('#mentor_phone').val('');
            $('#mentor_experience').val('');
            $('#mentor_skills').val('');
            if (joditBio) {
                joditBio.value = '';
            }
            $('#mentorModal').modal('show');

        }



        function openEditMentorModal(
            id,
            category_id,
            name,
            email,
            phone,
            experience,
            skills,
            shortbio,
            bio,
            state,
            city,
            zip_code,
            address,
            photo
        ) {
            $('#mentorModalTitle').text('Edit Mentor');
            let updateUrl =
                "{{ route('admin.mentor-profile.update', ':id') }}";

            updateUrl = updateUrl.replace(':id', id);
            $('#mentorForm').attr('action', updateUrl);
            $('#mentorFormMethod').val('PUT');
            $('#mentor_category_id').val(category_id);
            $('#mentor_name').val(name);
            $('#mentor_email').val(email);
            $('#mentor_phone').val(phone);
            $('#mentor_experience').val(experience);
           $('#mentor_skills').val(skills);
                $('#short_bio').val(shortbio);

                if (joditBio) {
                    joditBio.value = bio;
                }
            // important
            if (joditBio) {
                joditBio.value = bio;
            }
            $('#mentor_state').val(state);
            $('#mentor_city').val(city);
            $('#mentor_zip').val(zip_code);
            $('#mentor_address').val(address);
            if (photo) {
                $('#photoPreview').attr('src', photo).show();
            } else {
                $('#photoPreview').hide();
            }
            $('#mentorModal').modal('show');

        }
    </script>

    <script>
        let joditBio;
        document.addEventListener('DOMContentLoaded', function() {
            const mentor_bio = document.getElementById('mentor_bio');
            if (mentor_bio) {

                joditBio = new Jodit(mentor_bio, {
                    height: 300,
                    toolbarAdaptive: false,
                    buttons: [
                        'bold', 'italic', 'underline',
                        '|', 'ul', 'ol',
                        '|', 'link', 'image',
                        '|', 'align', 'undo', 'redo'
                    ]
                });

            }

        });
    </script>
@endpush
