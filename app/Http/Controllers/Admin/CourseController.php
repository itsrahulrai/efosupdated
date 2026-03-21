<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::latest()->paginate(5);
        return view('backend.courses.index', compact('courses'));
    }


    public function show(Course $course)
    {
        return view('backend.courses.show', compact('course'));
    }


    public function create()
    {
        return view('backend.courses.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:5120', // 5MB
        ]);


        $imageName = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('uploads/courses'), $imageName);

        Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imageName,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course Added Successfully');
    }


    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $courses = Course::latest()->paginate(5);
        return view('backend.courses.create', compact('course', 'courses'));
    }


    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,svg|max:5120',
        ]);

        $imageName = $course->image;

        if ($request->hasFile('image')) {

            if (File::exists(public_path('uploads/courses/' . $course->image))) {
                File::delete(public_path('uploads/courses/' . $course->image));
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/courses'), $imageName);
        }

        $course->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imageName,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course Updated Successfully');
    }


    public function destroy(Course $course)
    {

        if (File::exists(public_path('uploads/courses/' . $course->image))) {
            File::delete(public_path('uploads/courses/' . $course->image));
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course Deleted Successfully');
    }
}
