<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseChapter;
use App\Models\CourseLesson;
use App\Models\LearningCourse;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseLessonController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = CourseLesson::latest()->paginate(10);
        return view('backend.lms.lesson.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.lms.lesson.create', [
            'isEdit' => false,
            'lesson' => null,
            'courses' => LearningCourse::active()->get(),
            'chapters' => [],
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:learning_courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_lessons,slug',
            'type' => 'required|in:video,text',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'video_source' => 'nullable|in:youtube,upload',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'duration_seconds' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_free_preview' => 'required|boolean',
            'is_mandatory' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {

            $lesson = new CourseLesson();
            $lesson->course_id = $validated['course_id'];
            $lesson->chapter_id = $validated['chapter_id'];
            $lesson->title = $validated['title'];
            $lesson->slug = $validated['slug'] ?? Str::slug($validated['title']);
            $lesson->type = $validated['type'];
            $lesson->video_source = $validated['video_source'] ?? null;
            $lesson->video_url = $validated['video_url'] ?? null;
            $lesson->content = $validated['content'] ?? null;
            $lesson->duration_seconds = $validated['duration_seconds'] ?? 0;
            $lesson->sort_order = $validated['sort_order'] ?? 0;
            $lesson->is_free_preview = $validated['is_free_preview'];
            $lesson->is_mandatory = $validated['is_mandatory'];
            $lesson->status = $validated['status'];

            if ($request->type === 'text')
            {
                $lesson->pdf_file = $this->uploadPDF($request, 'pdf_file', 'uploads/lessons/pdfs');
            }

            $lesson->save();

            DB::commit();

            return redirect()
                ->route('admin.lesson.index')
                ->with('success', 'Lesson created successfully.');

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            Log::error('Lesson creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the lesson.');
        }
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
        $lesson = CourseLesson::findOrFail($id);

        return view('backend.lms.lesson.create', [
            'isEdit' => true,
            'lesson' => $lesson,
            'courses' => LearningCourse::active()->get(),
            'chapters' => CourseChapter::where('course_id', $lesson->course_id)
                ->where('status', 1)
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lesson = CourseLesson::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:learning_courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_lessons,slug,' . $lesson->id,
            'type' => 'required|in:video,text,quiz',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'video_source' => 'nullable|in:youtube,vimeo,upload',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'duration_seconds' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_free_preview' => 'required|boolean',
            'is_mandatory' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {

            $lesson->course_id = $validated['course_id'];
            $lesson->chapter_id = $validated['chapter_id'];
            $lesson->title = $validated['title'];
            $lesson->slug = $validated['slug'] ?? Str::slug($validated['title']);
            $lesson->type = $validated['type'];
            $lesson->video_source = $validated['video_source'] ?? null;
            $lesson->video_url = $validated['video_url'] ?? null;
            $lesson->content = $validated['content'] ?? null;
            $lesson->duration_seconds = $validated['duration_seconds'] ?? 0;
            $lesson->sort_order = $validated['sort_order'] ?? 0;
            $lesson->is_free_preview = $validated['is_free_preview'];
            $lesson->is_mandatory = $validated['is_mandatory'];
            $lesson->status = $validated['status'];

            if ($request->type === 'text')
            {
                $lesson->pdf_file = $this->updatePdf($request, 'pdf_file', 'uploads/lessons/pdfs', $lesson->pdf_file);
            }
            $lesson->save();
            DB::commit();

            return redirect()
                ->route('admin.lesson.index')
                ->with('success', 'Lesson updated successfully.');

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            Log::error('Lesson update failed', [
                'lesson_id' => $lesson->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the lesson.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $lesson = CourseLesson::findOrFail($id);

            if ($lesson->pdf_file)
            {
                $this->deleteImage($lesson->pdf_file);
            }
            $lesson->delete();

            DB::commit();

            return redirect()
                ->route('admin.lesson.index')
                ->with('success', 'Lesson deleted successfully.');

        }
        catch (\Throwable $e)
        {
            DB::rollBack();
            Log::error('Lesson delete failed', [
                'lesson_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to delete lesson.');
        }
    }

    /**
     * Return chapters by course (AJAX)
     */
    public function getByCourse($courseId)
    {
        return CourseChapter::where('course_id', $courseId)
            ->where('status', 1)
            ->select('id', 'title')
            ->orderBy('sort_order')
            ->get();
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:course_lessons,id',
            'status' => 'required|boolean',
        ]);

        $chapter = CourseLesson::findOrFail($request->id);
        $chapter->status = $request->status;
        $chapter->save();

        return response()->json([
            'success' => true,
            'message' => 'Lesson status updated successfully',
        ]);
    }
}
