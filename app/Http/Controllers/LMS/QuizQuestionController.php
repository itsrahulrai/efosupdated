<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use Illuminate\Http\Request;
use DB;
use App\Models\Quiz;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;



class QuizQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required',
            'question' => 'required',
            'type' => 'required|in:mcq,true_false',
            'marks' => 'required|numeric',
            'mcq_correct_option' => 'required_if:type,mcq',
            'tf_correct_option' => 'required_if:type,true_false',
        ]);

        DB::transaction(function () use ($request) {

            $question = QuizQuestion::create([
                'quiz_id' => $request->quiz_id,
                'question' => $request->question,
                'type' => $request->type,
                'marks' => $request->marks,
                'status' => 1,
            ]);

            // MCQ
            if ($request->type === 'mcq') {

                foreach ($request->mcq_options as $index => $option) {

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'is_correct' => ($index == $request->mcq_correct_option) ? 1 : 0,
                    ]);
                }
            }

            // TRUE FALSE
            if ($request->type === 'true_false') {

                foreach ($request->tf_options as $option) {

                    $isCorrect =
                        ($option === 'True' && $request->tf_correct_option == 1) ||
                        ($option === 'False' && $request->tf_correct_option == 0);

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'is_correct' => $isCorrect ? 1 : 0,
                    ]);
                }
            }

        });

        return back()->with('success', 'Question added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $request->validate([
            'quiz_id' => 'required',
            'question' => 'required',
            'type' => 'required|in:mcq,true_false',
            'marks' => 'required|numeric',
            'mcq_correct_option' => 'required_if:type,mcq',
            'tf_correct_option' => 'required_if:type,true_false',
        ]);

        DB::transaction(function () use ($request, $id) {

            $question = QuizQuestion::findOrFail($id);

            $question->update([
                'quiz_id' => $request->quiz_id,
                'question' => $request->question,
                'type' => $request->type,
                'marks' => $request->marks,
            ]);

            // delete old options
            QuizOption::where('question_id', $question->id)->delete();

            // MCQ
            if ($request->type === 'mcq') {

                foreach ($request->mcq_options as $index => $option) {

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'is_correct' => ($index == $request->mcq_correct_option) ? 1 : 0,
                    ]);
                }
            }

            // TRUE FALSE
            if ($request->type === 'true_false') {

                foreach ($request->tf_options as $option) {

                    $isCorrect =
                        ($option === 'True' && $request->tf_correct_option == 1) ||
                        ($option === 'False' && $request->tf_correct_option == 0);

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'is_correct' => $isCorrect ? 1 : 0,
                    ]);
                }
            }

        });

        return back()->with('success', 'Question updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            QuizOption::where('question_id', $id)->delete();
            QuizQuestion::findOrFail($id)->delete();
        });

        return back()->with('success', 'Question deleted successfully');
    }



    public function downloadTemplate()
    {
        $quizzes = Quiz::pluck('title')->toArray();

        $spreadsheet = new Spreadsheet();

        // Main sheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Questions');

        // Headers
        $headers = [
            'Quiz',
            'Question',
            'Type',
            'Marks',
            'Option A',
            'Option B',
            'Option C',
            'Option D',
            'Correct'
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Dropdown sheet
        $quizSheet = $spreadsheet->createSheet();
        $quizSheet->setTitle('QuizList');

        foreach ($quizzes as $index => $quiz) {
            $quizSheet->setCellValue('A'.($index+1), $quiz);
        }

        // QUIZ dropdown
    for ($row = 2; $row <= 200; $row++)
        {
            $validation = $sheet->getCell('A' . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1('QuizList!$A$1:$A$' . count($quizzes));

            // TYPE dropdown
            $typeValidation = $sheet->getCell('C' . $row)->getDataValidation();
            $typeValidation->setType(DataValidation::TYPE_LIST);
            $typeValidation->setAllowBlank(false);
            $typeValidation->setShowDropDown(true);
            $typeValidation->setFormula1('"MCQ,True / False"');

            // CORRECT dropdown
            $correctValidation = $sheet->getCell('I' . $row)->getDataValidation();
            $correctValidation->setType(DataValidation::TYPE_LIST);
            $correctValidation->setAllowBlank(false);
            $correctValidation->setShowDropDown(true);
            $correctValidation->setFormula1('"A,B,C,D,True,False"');
        }


        // Hide quiz sheet
        $quizSheet->setSheetState(
            \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
        );

        $fileName = "quiz-template.xlsx";

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        $writer->save("php://output");
    }



    public function importQuestions(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        DB::beginTransaction();

        try {

            foreach ($rows as $index => $row) {

                // Skip header
                if ($index == 0) continue;

                $quizTitle = trim($row[0]);
                $questionText = trim($row[1]);
                $type = strtolower(trim($row[2]));
                $marks = $row[3];

                if (!$quizTitle || !$questionText) {
                    continue;
                }

                $quiz = Quiz::where('title', $quizTitle)->first();

                if (!$quiz) {
                    continue;
                }

                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionText,
                    'type' => $type == 'true / false' ? 'true_false' : 'mcq',
                    'marks' => $marks,
                    'status' => 1,
                ]);

                // ================= MCQ =================

                if ($type == 'mcq') {

                    $options = [
                        $row[4],
                        $row[5],
                        $row[6],
                        $row[7]
                    ];

                    $correct = strtoupper($row[8]);

                    foreach ($options as $index => $option) {

                        if (!$option) continue;

                        QuizOption::create([
                            'question_id' => $question->id,
                            'option_text' => $option,
                            'is_correct' => ($correct == chr(65 + $index)) ? 1 : 0
                        ]);
                    }
                }

                // ================= TRUE FALSE =================

                if ($type == 'true / false') {

                    $correct = strtolower($row[8]);

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => 'True',
                        'is_correct' => $correct == 'true' ? 1 : 0
                    ]);

                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => 'False',
                        'is_correct' => $correct == 'false' ? 1 : 0
                    ]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Questions imported successfully');
    }

}
