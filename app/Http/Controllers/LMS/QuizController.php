<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CourseChapter;
use App\Models\LearningCourse;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\Student;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $quizzes = Quiz::latest()->paginate(10, ['*'], 'quiz_page');
    //     $quizes = Quiz::where('is_active', 1)->latest()->get();



    //     $questions = QuizQuestion::latest()->paginate(10, ['*'], 'question_page');

    //     $students = Student::select('id', 'name', 'registration_number')
    //         ->orderBy('name')
    //         ->get();

    //     $courses = LearningCourse::where('status', 1)->get();

    //     $certificates = Certificate::with([
    //         'student:id,name,registration_number',
    //         'course:id,title',
    //     ])->latest()->paginate(10, ['*'], 'certificate_page');

    //     $quizResults = QuizResult::with([
    //         'quiz.course',
    //         'quizAnswers.question.correctOption',
    //         'quizAnswers.selectedOption',
    //     ])->latest()->paginate(10, ['*'], 'result_page');

    //     return view('backend.lms.quiz.index', compact(
    //         'quizzes',
    //          'quizes',
    //         'questions',
    //         'courses',
    //         'quizResults',
    //         'certificates',
    //         'students'
    //     ));
    // }


    public function index(Request $request)
    {
        $quizzes = Quiz::latest()->paginate(10, ['*'], 'quiz_page');

        $quizes = Quiz::where('is_active', 1)->latest()->get();

        $questions = QuizQuestion::with('quiz');

        // Quiz Filter
        if ($request->quiz_id) {
            $questions->where('quiz_id', $request->quiz_id);
        }

        $questions = $questions->latest()->paginate(10, ['*'], 'question_page');

        // AJAX request → return only table
        if ($request->ajax()) {
            return view('backend.lms.quiz.partials.ajax.questions_table', compact('questions'))->render();
        }

        $students = Student::select('id', 'name', 'registration_number')
            ->orderBy('name')
            ->get();

        $courses = LearningCourse::where('status', 1)->get();

        $certificates = Certificate::with([
            'student:id,name,registration_number',
            'course:id,title',
        ])->latest()->paginate(10, ['*'], 'certificate_page');

        $quizResults = QuizResult::with([
            'quiz.course',
            'quizAnswers.question.correctOption',
            'quizAnswers.selectedOption',
        ])->latest()->paginate(10, ['*'], 'result_page');

        return view('backend.lms.quiz.index', compact(
            'quizzes',
            'quizes',
            'questions',
            'courses',
            'quizResults',
            'certificates',
            'students'
        ));
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
            'course_id' => 'required|exists:learning_courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'title' => 'required|string|max:255',
            'total_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:0|lte:total_marks',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Quiz::create([
            'course_id' => $request->course_id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'description' => $request->description,
            'total_marks' => $request->total_marks,
            'pass_marks' => $request->pass_marks,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.quiz.index')
            ->with('success', 'Quiz created successfully.');
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
    public function update(Request $request, string $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:learning_courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'title' => 'required|string|max:255',
            'total_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:0|lte:total_marks',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $quiz->update([
            'course_id' => $request->course_id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'description' => $request->description,
            'total_marks' => $request->total_marks,
            'pass_marks' => $request->pass_marks,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.quiz.index')
            ->with('success', 'Quiz updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('admin.quiz.index')
            ->with('success', 'Quiz deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:quizzes,id',
            'status' => 'required|boolean',
        ]);

        $quiz = Quiz::findOrFail($request->id);
        $quiz->is_active = $request->status;
        $quiz->save();

        return response()->json([
            'success' => true,
            'message' => 'Quiz status updated successfully',
        ]);
    }

    public function getChapters($courseId)
    {
        $chapters = CourseChapter::where('course_id', $courseId)->get();
        return response()->json($chapters);
    }

    public function showModal($id)
    {
        $result = QuizResult::with([
            'quiz.course',
            'quizAnswers.question.correctOption',
            'quizAnswers.selectedOption',
        ])->findOrFail($id);

        return view('backend.lms.quiz.partials.result-modal-body', compact('result'));
    }

}
