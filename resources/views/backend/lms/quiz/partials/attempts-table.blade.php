<div class="card mt-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold">
            <i class="fa-solid fa-chart-column me-1"></i>
            Quiz Results
        </h6>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Quiz</th>
                    <th>Score</th>
                    <th>Answered</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

         <tbody>
            @forelse ($quizResults as $index => $result)

                @php
                    $totalMarks = 0;
                    $obtainedMarks = 0;

                    if (!empty($result->quizAnswers)) {
                        foreach ($result->quizAnswers as $ans) {
                            $marks = optional($ans->question)->marks ?? 0;

                            $totalMarks += $marks;

                            if ($ans->is_correct) {
                                $obtainedMarks += $marks;
                            }
                        }
                    }

                    $percentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;

                    $quiz = optional($result->quiz);
                    $course = optional($quiz->course);
                    $user = optional($result->user);
                @endphp

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>
                        <div class="fw-semibold">
                            {{ $user->name ?? 'N/A' }}
                        </div>
                        <small class="text-muted">
                            {{ $user->email ?? '' }}
                        </small>
                    </td>

                    <td>{{ $course->title ?? '-' }}</td>

                    <td>{{ $quiz->title ?? '-' }}</td>

                    <td>
                        <strong>{{ $obtainedMarks }}</strong>
                        /
                        {{ $totalMarks }}
                        <br>
                        <small class="text-muted">{{ $percentage }}%</small>
                    </td>

                    <td>
                        {{ $result->answered_questions ?? 0 }}
                        /
                        {{ $result->total_questions ?? 0 }}
                    </td>

                    <td>{{ $result->time_taken ?? 0 }} sec</td>

                    <td>
                        @if (!$quiz->id)
                            <span class="badge bg-secondary">Quiz Deleted</span>
                        @elseif ($obtainedMarks >= ($quiz->pass_marks ?? 0))
                            <span class="badge bg-success">PASS</span>
                        @else
                            <span class="badge bg-danger">FAIL</span>
                        @endif
                    </td>

                    <td class="text-end">
                        @if ($result->id)
                            <button class="btn btn-sm btn-outline-primary viewResultBtn"
                                    data-id="{{ $result->id }}">
                                View
                            </button>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>

                </tr>

            @empty
            <tr>
                <td colspan="9" class="text-center text-muted">
                    No quiz results found.
                </td>
            </tr>
            @endforelse
            </tbody>
                    </table>
                </div>
            </div>


<div class="modal fade" id="quizResultModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-clipboard-check me-1"></i>
                    Quiz Result Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="quizResultModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2 text-muted">Loading result...</p>
                </div>
            </div>

        </div>
    </div>
</div>


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('quizResultModal');
            const modalBody = document.getElementById('quizResultModalBody');
            const quizModal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.viewResultBtn').forEach(btn => {
                btn.addEventListener('click', function() {

                    const resultId = this.dataset.id;

                    modalBody.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-2 text-muted">Loading result...</p>
                        </div>
                    `;

                    quizModal.show();

                    fetch(`{{ url('admin/quiz-results') }}/${resultId}/modal`)
                        .then(res => res.text())
                        .then(html => {
                            modalBody.innerHTML = html;
                        })
                        .catch(() => {
                            modalBody.innerHTML =
                                '<p class="text-danger text-center">Failed to load result.</p>';
                        });
                });
            });

        });
    </script>
@endpush
