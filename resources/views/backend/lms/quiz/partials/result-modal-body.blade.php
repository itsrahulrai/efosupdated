{{-- ================= HEADER ================= --}}
<div class="border-bottom pb-3 mb-4">
    <div class="d-flex align-items-center">

        <div class="me-3">
            <img src="{{ static_asset('assets/images/logo/logo.jpg') }}" height="42">
        </div>

        <div>
            <h5 class="mb-0 fw-bold">
                {{ $result->quiz->course->title ?? 'Course Name' }}
            </h5>
            <small class="text-muted">
                {{ $result->quiz->title }}
            </small>
        </div>

    </div>
</div>

{{-- ================= CALCULATIONS ================= --}}
@php
    $totalMarks = 0;
    $obtainedMarks = 0;

    foreach ($result->quizAnswers as $a) {
        $totalMarks += $a->question->marks ?? 0;
        if ($a->is_correct) {
            $obtainedMarks += $a->question->marks ?? 0;
        }
    }

    $percentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;

    if ($percentage >= 90) {
        $grade = 'A+';
        $gradeClass = 'bg-success';
    } elseif ($percentage >= 80) {
        $grade = 'A';
        $gradeClass = 'bg-success';
    } elseif ($percentage >= 70) {
        $grade = 'B';
        $gradeClass = 'bg-primary';
    } elseif ($percentage >= 60) {
        $grade = 'C';
        $gradeClass = 'bg-info';
    } elseif ($percentage >= 50) {
        $grade = 'D';
        $gradeClass = 'bg-warning';
    } else {
        $grade = 'F';
        $gradeClass = 'bg-danger';
    }
@endphp

{{-- ================= SUMMARY BAR ================= --}}
<div class="border rounded bg-light p-3 mb-4">
    <div class="row text-center g-3">

        <div class="col-md-2">
            <div class="fw-bold">{{ $result->quizAnswers->count() }}</div>
            <small class="text-muted">Questions</small>
        </div>

        <div class="col-md-2">
            <div class="fw-bold">{{ $totalMarks }}</div>
            <small class="text-muted">Total Marks</small>
        </div>

        <div class="col-md-2">
            <div class="fw-bold text-success">{{ $obtainedMarks }}</div>
            <small class="text-muted">Marks Obtained</small>
        </div>

        <div class="col-md-2">
            <div class="fw-bold">{{ $percentage }}%</div>
            <small class="text-muted">Percentage</small>
        </div>

        <div class="col-md-2">
            <div class="fw-bold">{{ $result->time_taken }}s</div>
            <small class="text-muted">Time Taken</small>
        </div>

        <div class="col-md-2">
            <span class="badge {{ $gradeClass }} fs-6 px-3 py-2">
                {{ $grade }}
            </span>
            <br>
            @if ($obtainedMarks >= $result->quiz->pass_marks)
                <span class="badge bg-success mt-1">PASS</span>
            @else
                <span class="badge bg-danger mt-1">FAIL</span>
            @endif
        </div>

    </div>
</div>

{{-- ================= QUESTIONS ================= --}}
@foreach ($result->quizAnswers as $index => $answer)
    @php
        $qMarks = $answer->question->marks ?? 0;
        $earned = $answer->is_correct ? $qMarks : 0;
    @endphp

    <div class="border rounded p-3 mb-3">

        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="fw-semibold">
                Q{{ $index + 1 }}. {{ $answer->question->question }}
            </div>

            <span class="badge bg-primary">
                {{ $earned }} / {{ $qMarks }} Marks
            </span>
        </div>

        <p class="mb-1">
            <strong>Your Answer:</strong>
            <span class="{{ $answer->is_correct ? 'text-success' : 'text-danger' }}">
                {{ $answer->selectedOption->option_text ?? 'Not Answered' }}
            </span>
        </p>

        @if (!$answer->is_correct)
            <p class="mb-1">
                <strong>Correct Answer:</strong>
                <span class="text-success">
                    {{ $answer->question->correctOption->option_text ?? '' }}
                </span>
            </p>
        @endif

        <span class="badge {{ $answer->is_correct ? 'bg-success' : 'bg-danger' }}">
            {{ $answer->is_correct ? 'Correct' : 'Wrong' }}
        </span>
    </div>
@endforeach

{{-- ================= GRADE INFO ================= --}}
<div class="mt-4">
    <div class="fw-semibold mb-2 text-muted">
        <i class="fa-solid fa-ranking-star me-1 text-warning"></i>
        Grade System
    </div>

    <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-success">A+ : Excellent (90–100%)</span>
        <span class="badge bg-primary">A : Very Good (80–89%)</span>
        <span class="badge bg-info text-dark">B : Good (70–79%)</span>
        <span class="badge bg-warning text-dark">C : Average (60–69%)</span>
        <span class="badge bg-secondary">D : Below Average (50–59%)</span>
        <span class="badge bg-danger">F : Fail (&lt;50%)</span>
    </div>
</div>
