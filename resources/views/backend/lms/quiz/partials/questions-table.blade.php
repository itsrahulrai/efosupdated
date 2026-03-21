<div class="card-header d-flex align-items-center justify-content-between">

    <h6 class="card-title mb-0 fw-semibold">
        Questions Management
    </h6>

    <div class="d-flex align-items-center gap-2">

        <!-- Quiz Filter -->
       <select id="quizFilter" class="form-select form-select-sm" style="width:200px;">
            <option value="">All Quizzes</option>

            @foreach ($quizes as $quiz)
                <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
            @endforeach
        </select>

           <!-- Reset Filter -->
        <button type="button"
            class="btn btn-secondary btn-sm d-flex align-items-center gap-1"
            id="resetFilter">
           <i class="fa-solid fa-rotate"></i>
            Reset
        </button>   

        <!-- Upload Excel -->
        <button type="button"
            class="btn btn-success btn-sm d-flex align-items-center gap-2"
            id="uploadExcelBtn">
            <i class="fa-solid fa-upload"></i>
            Upload Excel
        </button>

        <!-- Add Question -->
        <button type="button"
            class="btn btn-primary btn-sm d-flex align-items-center gap-2"
            id="addQuestionBtn">
             <i class="fa-solid fa-plus"></i>
            Add Question
        </button>

    </div>
</div>

<div id="questionsTable">

    @include('backend.lms.quiz.partials.ajax.questions_table')

</div>



{{-- Question Add Modal --}}
<div class="modal fade" id="questionModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="questionForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="questionFormMethod" value="POST">

                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="questionModalTitle">
                        Add Question
                    </h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Quiz --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Quiz</label>
                            <select name="quiz_id" id="quiz_id" class="form-select" required>
                                <option value="">Select Quiz</option>
                                @foreach ($quizes as $quiz)
                                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Question --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Question</label>
                            <textarea name="question" id="question" class="form-control" rows="3" required></textarea>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Question Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="mcq">MCQ</option>
                                <option value="true_false">True / False</option>
                            </select>
                        </div>

                        {{-- Marks --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Marks</label>
                            <input type="number" name="marks" id="marks" class="form-control" required>
                        </div>

                        {{-- OPTIONS --}}
                        <div class="col-12 d-none" id="optionWrapper">

                            <div class="border rounded-3 p-3 bg-light">

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="bi bi-ui-checks-grid me-1"></i> Answer Options
                                    </h6>
                                    <span class="badge bg-secondary" id="optionTypeLabel">MCQ</span>
                                </div>

                               
                             {{-- MCQ OPTIONS --}}
                                    <div id="mcqOptions" class="d-none">
                                    @for ($i = 0; $i < 4; $i++)
                                    <div class="input-group mb-2">
                                    <span class="input-group-text">
                                    <input class="form-check-input mt-0"
                                    type="radio"
                                    name="mcq_correct_option"
                                    value="{{ $i }}">
                                    </span>

                                    <input type="text"
                                    name="mcq_options[]"
                                    class="form-control"
                                    placeholder="Option {{ chr(65 + $i) }}">
                                    </div>
                                    @endfor

                                    <small class="text-muted d-block mt-2">
                                    Select the correct answer
                                    </small>
                                    </div>

                                {{-- TRUE / FALSE OPTIONS --}}
                                <div id="trueFalseOptions" class="d-none">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="w-100 border rounded p-2 cursor-pointer">
                                                <input class="form-check-input me-2" type="radio"
                                                    name="tf_correct_option" value="1">
                                                True
                                                <input type="hidden" name="tf_options[]" value="True">
                                            </label>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="w-100 border rounded p-2 cursor-pointer">
                                                <input class="form-check-input me-2" type="radio"
                                                    name="tf_correct_option" value="0">
                                                False
                                                <input type="hidden" name="tf_options[]" value="False">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>




{{-- Question Add Modal Excel --}}
<div class="modal fade" id="excelUploadModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('admin.quiz-question.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Modal Header -->
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-semibold">
                        Upload Questions via Excel
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>


                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Download Sample -->
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="text-muted small">
                            Upload questions using the provided Excel template.
                        </div>

                        <a href="{{ route('admin.quiz-question.template') }}"
                           class="btn btn-outline-primary btn-sm">
                           <i class="bi bi-download me-1"></i>
                           Download Sample File
                        </a>

                    </div>


                    <!-- Upload Section -->
                    <div class="border rounded p-4 bg-light mb-4 text-center">

                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>

                        <h6 class="mt-2 fw-semibold">
                            Select CSV File
                        </h6>

                        <p class="text-muted small mb-3">
                            Choose the CSV file containing quiz questions
                        </p>

                        <input type="file"
                               name="file"
                               id="excelFileInput"
                               class="form-control w-50 mx-auto"
                               accept=".csv"
                               required>

                    </div>


                    <!-- Preview -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold mb-0">
                            Preview Data
                        </h6>

                        <span class="badge bg-secondary">
                            Showing first rows
                        </span>
                    </div>


                   <div class="table-responsive border rounded">

                    <table class="table table-hover table-sm mb-0" id="excelPreviewTable">
                        <thead class="table-light">
                            <tr>
                                <th>Quiz</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Marks</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Correct</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No file selected
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    </div>

                   <div class="d-flex justify-content-between align-items-center mt-3">

                        <small id="previewCount"></small>

                        <ul class="pagination pagination-sm mb-0" id="previewPagination"></ul>

                    </div>

                </div>


                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                        class="btn btn-success">
                        <i class="bi bi-upload me-1"></i>
                        Import Questions
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>



@push('script')
    <script>

const questionModal = new bootstrap.Modal(
    document.getElementById('questionModal')
);



// ================= TYPE CHANGE =================

$('#type').on('change', function () {

    const type = $(this).val();

    // hide everything first
    $('#optionWrapper').addClass('d-none');
    $('#mcqOptions').addClass('d-none');
    $('#trueFalseOptions').addClass('d-none');

    if (type === 'mcq') {

        $('#optionWrapper').removeClass('d-none');
        $('#mcqOptions').removeClass('d-none');
        $('#optionTypeLabel').text('MCQ');

    }

    if (type === 'true_false') {

        $('#optionWrapper').removeClass('d-none');
        $('#trueFalseOptions').removeClass('d-none');
        $('#optionTypeLabel').text('TRUE / FALSE');

    }

});



// trigger initially
$('#type').trigger('change');



// ================= ADD QUESTION =================

$('#addQuestionBtn').on('click', function () {

    $('#questionModalTitle').text('Add Question');

    $('#questionForm').attr(
        'action',
        "{{ route('admin.quiz-question.store') }}"
    );

    $('#questionFormMethod').val('POST');

    $('#questionForm')[0].reset();

    // reset radios
    $('input[name="mcq_correct_option"]').prop('checked', false);
    $('input[name="tf_correct_option"]').prop('checked', false);

    $('#type').trigger('change');

    questionModal.show();

});



// ================= EDIT QUESTION =================

$(document).on('click', '.editQuestionBtn', function () {

    $('#questionModalTitle').text('Edit Question');

    let id = $(this).data('id');
    let type = $(this).data('type');
    let options = $(this).data('options');
    let quiz_id = $(this).data('quiz');
    let questionText = $(this).data('question');
    let marks = $(this).data('marks');

    if (typeof options === 'string') {
        options = JSON.parse(options);
    }

    // set form action
    $('#questionForm').attr(
        'action',
        "{{ url('admin/quiz-question') }}/" + id
    );

    $('#questionFormMethod').val('PUT');



    // fill main fields
    $('#quiz_id').val(quiz_id);
    $('#question').val(questionText);
    $('#type').val(type);
    $('#marks').val(marks);



    // reset fields
    $('input[name="mcq_correct_option"]').prop('checked', false);
    $('input[name="tf_correct_option"]').prop('checked', false);
    $('input[name="mcq_options[]"]').val('');



    // trigger type display
    $('#type').trigger('change');



    // ================= MCQ =================
    if (type === 'mcq') {

        options.forEach((opt, index) => {

            $('input[name="mcq_options[]"]').eq(index).val(opt.option_text);

            if (opt.is_correct == 1) {

                $('input[name="mcq_correct_option"][value="' + index + '"]')
                    .prop('checked', true);

            }

        });

    }



    // ================= TRUE FALSE =================
    if (type === 'true_false') {

        options.forEach((opt) => {

            if (opt.is_correct == 1) {

                let value = opt.option_text === 'True' ? 1 : 0;

                $('input[name="tf_correct_option"][value="' + value + '"]')
                    .prop('checked', true);

            }

        });

    }



    questionModal.show();

});




const excelModal = new bootstrap.Modal(
    document.getElementById('excelUploadModal')
);

$('#uploadExcelBtn').on('click', function () {
    excelModal.show();
});




</script>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>

let excelRows = [];
let currentPage = 1;
let rowsPerPage = 10;

$('#excelFileInput').on('change', function(e){

    let file = e.target.files[0];
    if(!file) return;

    let reader = new FileReader();

    reader.onload = function(event){

        let data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, {type:'array'});
        let sheet = workbook.Sheets[workbook.SheetNames[0]];

        let rows = XLSX.utils.sheet_to_json(sheet, {header:1});

        rows.shift(); // remove header

        excelRows = rows;

        currentPage = 1;

        renderTable();
        renderPagination();

    };

    reader.readAsArrayBuffer(file);

});


function renderTable(){

    let tbody = $('#excelPreviewTable tbody');
    tbody.html('');

    let start = (currentPage-1)*rowsPerPage;
    let end = start + rowsPerPage;

    let pageRows = excelRows.slice(start,end);

    pageRows.forEach(row=>{

        let tr = '<tr>';

        for(let i=0;i<9;i++){
            tr += '<td>'+(row[i] ?? '')+'</td>';
        }

        tr += '</tr>';

        tbody.append(tr);

    });

    $('#previewCount').text(
        "Showing "+(start+1)+" to "+Math.min(end,excelRows.length)+" of "+excelRows.length+" rows"
    );

}


function renderPagination(){

    let totalPages = Math.ceil(excelRows.length / rowsPerPage);

    let pagination = $('#previewPagination');
    pagination.html('');

    if(totalPages <=1) return;

    // Prev
    pagination.append(
        `<li class="page-item ${currentPage==1?'disabled':''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage-1})">Prev</a>
        </li>`
    );

    for(let i=1;i<=totalPages;i++){

        pagination.append(
            `<li class="page-item ${currentPage==i?'active':''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`
        );

    }

    // Next
    pagination.append(
        `<li class="page-item ${currentPage==totalPages?'disabled':''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage+1})">Next</a>
        </li>`
    );

}


function changePage(page){

    let totalPages = Math.ceil(excelRows.length / rowsPerPage);

    if(page<1 || page>totalPages) return;

    currentPage = page;

    renderTable();
    renderPagination();

}  


function loadQuestions(url, data = {}) {

    $.get(url, data, function (response) {
        $('#questionsTable').html(response);
    });

}

// Quiz Filter
$('#quizFilter').on('change', function () {
    loadQuestions("{{ route('admin.quiz.index') }}", {
        quiz_id: $(this).val()
    });
});

// Reset Filter
$('#resetFilter').on('click', function () {

    $('#quizFilter').val('');

    loadQuestions("{{ route('admin.quiz.index') }}");
});

// Pagination
$(document).on('click', '#questionsTable .pagination a', function (e) {

    e.preventDefault();

    loadQuestions($(this).attr('href'));

});
</script>
@endpush
