<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\LearningCourse;
use App\Models\Subject;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LearningCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use ImageUploadTrait;

    public function index()
    {
        $learningCourse = LearningCourse::latest()->paginate(10);
        return view('backend.lms.course.index', compact('learningCourse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::where('is_active', 1)->get();

        return view('backend.lms.course.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:learning_courses,slug',
            'language' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'duration' => 'nullable|string|max:50',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'demo_video' => 'nullable|url',
            'currency' => 'nullable|string|max:10',
            'price' => 'nullable|numeric',
            'is_free' => 'required|boolean',
            'has_discount' => 'required|boolean',
            'discount_price' => 'nullable|numeric',
            'discount_from' => 'nullable|date',
            'discount_to' => 'nullable|date|after_or_equal:discount_from',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        /* ---------- Fix booleans ---------- */
        $data['is_free'] = (bool) $request->is_free;
        $data['has_discount'] = (bool) $request->has_discount;
        $data['status'] = (bool) $request->status;

        /* ---------- Slug ---------- */
        if (empty($data['slug']))
        {
            $data['slug'] = Str::slug($data['title']);
        }

        /* ---------- Thumbnail Upload ---------- */
        if ($request->hasFile('thumbnail'))
        {
            $data['thumbnail'] = $this->uploadImage(
                $request,
                'thumbnail',
                'uploads/thumbnail'
            );
        }

        /* ---------- Free Course Logic ---------- */
        if ($data['is_free'])
        {
            $data['price'] = 0;
            $data['has_discount'] = 0;
            $data['discount_price'] = null;
            $data['discount_from'] = null;
            $data['discount_to'] = null;
        }

        LearningCourse::create($data);

        return redirect()
            ->route('admin.learning-course.index')
            ->with('success', 'Course created successfully');
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
        $course = LearningCourse::findOrFail($id);
        $subjects = Subject::where('is_active', 1)->get();

        return view('backend.lms.course.create', compact('course', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = LearningCourse::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:learning_courses,slug,' . $course->id,
            'language' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'duration' => 'nullable|string|max:50',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'demo_video' => 'nullable|url',
            'currency' => 'nullable|string|max:10',
            'price' => 'nullable|numeric',
            'is_free' => 'required|boolean',
            'has_discount' => 'required|boolean',
            'discount_price' => 'nullable|numeric',
            'discount_from' => 'nullable|date',
            'discount_to' => 'nullable|date|after_or_equal:discount_from',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        /* ---------- Boolean Fix ---------- */
        $data['is_free'] = (bool) $request->is_free;
        $data['has_discount'] = (bool) $request->has_discount;
        $data['status'] = (bool) $request->status;

        /* ---------- Slug ---------- */
        if (empty($data['slug']))
        {
            $data['slug'] = Str::slug($data['title']);
        }

        /* ---------- Thumbnail ---------- */
        if ($request->hasFile('thumbnail'))
        {
            if ($course->thumbnail && file_exists(public_path($course->thumbnail)))
            {
                unlink(public_path($course->thumbnail));
            }

            $data['thumbnail'] = $this->uploadImage(
                $request,
                'thumbnail',
                'uploads/thumbnail'
            );
        }

        /* ---------- Free Course Logic ---------- */
        if ($data['is_free'])
        {
            $data['price'] = 0;
            $data['has_discount'] = 0;
            $data['discount_price'] = null;
            $data['discount_from'] = null;
            $data['discount_to'] = null;
        }

        $course->update($data);

        return redirect()
            ->route('admin.learning-course.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = LearningCourse::findOrFail($id);
        if (!empty($course->thumbnail))
        {
            $this->deleteImage($course->thumbnail);
        }
        $course->delete();

        return redirect()
            ->route('admin.learning-course.index')
            ->with('success', 'Course deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:learning_courses,id',
            'status' => 'required|boolean',
        ]);

        $course = LearningCourse::findOrFail($request->id);
        $course->status = $request->status;
        $course->save();

        return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully',
        ]);
    }

}
