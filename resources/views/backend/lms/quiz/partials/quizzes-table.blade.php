<div class="card-header d-flex align-items-center justify-content-between">
    <h6 class="card-title mb-0 fw-semibold">
        Quizzes
    </h6>

    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" id="addQuizBtn">
        <i class="bi bi-plus-lg"></i>
        Add Quiz
    </button>
</div>


<table class="table display">

    <thead class="table-light">
        <tr>
            <th width="70">S.No</th>
            <th>Course</th>
            <th>Quiz Title</th>
            <th>Total Marks</th>
            <th>Pass Marks</th>
            <th>Duration</th>
            <th>Status</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($quizzes as $index => $quiz)
            <tr>
                <td>{{ $quizzes->firstItem() + $index }}</td>
                <td>{{ $quiz->course->title ?? '-' }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->total_marks }}</td>
                <td>{{ $quiz->pass_marks }}</td>
                <td>{{ $quiz->duration_minutes }} min</td>
                <td>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $quiz->id }}"
                            {{ $quiz->is_active ? 'checked' : '' }}>
                    </div>
                </td>

                <td class="text-end">
                    <div class="d-inline-flex gap-2">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary editQuizBtn"
                            data-id="{{ $quiz->id }}" data-course="{{ $quiz->course_id }}"
                            data-chapter="{{ $quiz->chapter_id }}" data-title="{{ $quiz->title }}"
                            data-description="{{ $quiz->description }}" data-total="{{ $quiz->total_marks }}"
                            data-pass="{{ $quiz->pass_marks }}" data-duration="{{ $quiz->duration_minutes }}"
                            data-status="{{ $quiz->is_active }}">
                            Edit
                        </a>


                        <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted">
                    No quizzes found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($quizzes->hasPages())
    <div class="d-flex justify-content-end">
        {{ $quizzes->appends(['tab' => 'tab-quizzes'])->links() }}
    </div>
@endif


<div class="modal fade" id="quizModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="quizForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="quizModalTitle">Add Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Course --}}
                        <div class="col-md-12">
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select" id="course_id" required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Chapter --}}
                        <div class="col-md-12">
                            <label class="form-label">Chapter</label>
                            <select name="chapter_id" class="form-select" id="chapter_id" required>
                                <option value="">Select Chapter</option>
                                {{-- Chapters will be populated dynamically --}}
                            </select>
                        </div>


                        {{-- Title --}}
                        <div class="col-md-12">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        {{-- Total Marks --}}
                        <div class="col-md-4">
                            <label class="form-label">Total Marks</label>
                            <input type="number" name="total_marks" id="total_marks" class="form-control" required>
                        </div>

                        {{-- Pass Marks --}}
                        <div class="col-md-4">
                            <label class="form-label">Pass Marks</label>
                            <input type="number" name="pass_marks" id="pass_marks" class="form-control" required>
                        </div>

                        {{-- Duration --}}
                        <div class="col-md-4">
                            <label class="form-label">Duration (min)</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" class="form-control">
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Short description about this quiz"></textarea>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="quizSubmitBtn">
                        Submit
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('script')
    <script>
        const quizModal = new bootstrap.Modal(document.getElementById('quizModal'));

        // Helper: set modal mode
        function setQuizModal(mode, data = {}) {
            const isEdit = mode === 'edit';

            $('#quizModalTitle').text(isEdit ? 'Edit Quiz' : 'Add Quiz');
            $('#quizSubmitBtn').text(isEdit ? 'Update' : 'Submit');

            $('#quizForm').attr(
                'action',
                isEdit ?
                "{{ route('admin.quiz.update', ':id') }}".replace(':id', data.id) :
                "{{ route('admin.quiz.store') }}"
            );

            $('#formMethod').val(isEdit ? 'PUT' : 'POST');

            // Reset form first
            $('#quizForm')[0].reset();

            // Fill data for edit
            if (isEdit) {
                $('#course_id').val(data.course);

                // When chapters are loaded, select the correct chapter
              selectedChapterId = data.chapter;

            $('#course_id').trigger('change');

                $('#title').val(data.title);
                $('#description').val(data.description);
                $('#total_marks').val(data.total);
                $('#pass_marks').val(data.pass);
                $('#duration_minutes').val(data.duration);
                $('#is_active').prop('checked', data.status == 1);
            } else {
                $('#is_active').prop('checked', true);
            }

            quizModal.show();
        }

        // ADD
        $(document).on('click', '#addQuizBtn', function() {
            setQuizModal('create');
        });

        // EDIT
        $(document).on('click', '.editQuizBtn', function() {
            setQuizModal('edit', {
                id: $(this).data('id'),
                course: $(this).data('course'),
                chapter: $(this).data('chapter'),
                title: $(this).data('title'),
                description: $(this).data('description'),
                total: $(this).data('total'),
                pass: $(this).data('pass'),
                duration: $(this).data('duration'),
                status: $(this).data('status'),
            });
        });
    </script>

    <script>
        $(document).on('change', '.toggle-status', function() {
            let quizId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.quiz.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: quizId,
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

        // Fetch chapters when course changes
        // Fetch chapters when course changes

        let selectedChapterId = null;

            $(document).on('change', '#course_id', function() {

                let courseId = $(this).val();
                let chapterSelect = $('#chapter_id');

                chapterSelect.html('<option value="">Loading...</option>');

                if (courseId) {

        $.get("{{ url('admin/courses') }}/" + courseId + "/chapters", function(data) {

            let options = '<option value="">Select Chapter</option>';

            data.forEach(function(chapter) {
                options += `<option value="${chapter.id}">${chapter.title}</option>`;
            });

            chapterSelect.html(options);

            // Select chapter when editing
            if(selectedChapterId){
                chapterSelect.val(selectedChapterId);
            }

        });

    } else {

        chapterSelect.html('<option value="">Select Chapter</option>');

    }

});
    </script>
@endpush
