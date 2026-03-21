<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseChapter;
use App\Models\LearningCourse;
use Illuminate\Http\Request;

class CourseChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = CourseChapter::latest()->paginate(10);
        return view('backend.lms.chapter.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = LearningCourse::where('status', 1)->get();

        return view('backend.lms.chapter.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:learning_courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $chapter = new CourseChapter();
        $chapter->course_id = $request->course_id;
        $chapter->title = $request->title;
        $chapter->description = $request->description;
        $chapter->sort_order = $request->sort_order ?? 0;
        $chapter->status = $request->status;
        $chapter->save();

        return redirect()->route('admin.course-chapter.index')
            ->with('success', 'Course chapter created successfully');
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
        $chapter = CourseChapter::findOrFail($id);
        $courses = LearningCourse::where('status', 1)->get();

        return view('backend.lms.chapter.create', compact('chapter', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|exists:learning_courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $chapter = CourseChapter::findOrFail($id);

        $chapter->course_id = $request->course_id;
        $chapter->title = $request->title;
        $chapter->description = $request->description;
        $chapter->sort_order = $request->sort_order ?? 0;
        $chapter->status = $request->status;
        $chapter->save();

        return redirect()->route('admin.course-chapter.index')
            ->with('success', 'Course chapter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chapter = CourseChapter::findOrFail($id);
        $chapter->delete();

        return redirect()->route('admin.course-chapter.index')
            ->with('success', 'Course chapter deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:course_chapters,id',
            'status' => 'required|boolean',
        ]);

        $chapter = CourseChapter::findOrFail($request->id);
        $chapter->status = $request->status;
        $chapter->save();

        return response()->json([
            'success' => true,
            'message' => 'Chapter status updated successfully',
        ]);
    }
}
