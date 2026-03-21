<table class="table display">
    <thead class="table-light">
        <tr>
            <th width="70">S.No</th>
            <th>Quiz</th>
            <th>Question</th>
            <th>Type</th>
            <th>Marks</th>
            <th>Status</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($questions as $index => $question)
            <tr>
                <td>{{ $questions->firstItem() + $index }}</td>
                <td>{{ $question->quiz->title ?? '-' }}</td>
                <td>{{ Str::limit($question->question, 60) }}</td>

                <td>
                    @if ($question->type === 'mcq')
                        <span class="badge bg-primary">MCQ</span>
                    @elseif($question->type === 'true_false')
                        <span class="badge bg-success">True / False</span>
                    @else
                        <span class="badge bg-warning text-dark">Text</span>
                    @endif
                </td>

                <td>{{ $question->marks }}</td>

                <td>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input toggle-question-status"
                               type="checkbox"
                               data-id="{{ $question->id }}"
                               {{ $question->status ? 'checked' : '' }}>
                    </div>
                </td>

                <td class="text-end">
                    <div class="d-inline-flex gap-2">

                        <button class="btn btn-sm btn-primary editQuestionBtn"
                            data-id="{{ $question->id }}"
                            data-quiz="{{ $question->quiz_id }}"
                            data-question="{{ $question->question }}"
                            data-type="{{ $question->type }}"
                            data-marks="{{ $question->marks }}"
                            data-options='@json($question->options->values())'
                            data-correct="{{ $question->options->values()->pluck('is_correct')->search(1) }}">
                            Edit
                        </button>

                        <form action="{{ route('admin.quiz-question.destroy',$question->id) }}"
                              method="POST"
                              class="delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>

                    </div>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center text-muted">
                    No questions found.
                </td>
            </tr>

        @endforelse
    </tbody>
</table>


@if ($questions->hasPages())
<div class="d-flex justify-content-end">
 {{ $questions->appends(request()->query())->links() }}
</div>
@endif