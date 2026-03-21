<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseBundle;
use App\Models\BundleCourse;
use App\Models\LearningCourse;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BundleCourseController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bundles = CourseBundle::with('courses')->paginate(10);
        return view('backend.lms.course.bundle.index', compact('bundles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = LearningCourse::where('status', 1)->get();
        $bundle = new CourseBundle();

        return view('backend.lms.course.bundle.create', compact('bundle', 'courses'));

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:course_bundles,slug',
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:learning_courses,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug ?: Str::slug($request->title),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'currency' => $request->currency ?? 'INR',
                'price' => $request->price,
                'is_free' => $request->is_free ?? 0,
                'has_discount' => $request->has_discount ?? 0,
                'discount_price' => $request->discount_price,
                'discount_from' => $request->discount_from,
                'discount_to' => $request->discount_to,
                'status' => $request->status ?? 1,
            ];

            // Free logic
            if ($data['is_free'])
            {
                $data['price'] = 0;
                $data['discount_price'] = null;
                $data['has_discount'] = 0;
            }

            // Discount validation logic
            if ($data['has_discount'] && !$data['discount_price'])
            {
                throw new \Exception('Discount price required when discount is enabled');
            }

            // Upload image
            if ($request->hasFile('thumbnail'))
            {
                $data['thumbnail'] = $this->uploadImage(
                    $request,
                    'thumbnail',
                    'uploads/thumbnail'
                );
            }
            $bundle = CourseBundle::create($data);
            // Attach courses
            $bundle->courses()->sync($request->course_ids);
            DB::commit();

            return redirect()
                ->route('admin.bundle-course.index')
                ->with('success', 'Bundle created successfully');

        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
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

    public function edit($id)
    {
        $bundle = CourseBundle::with('courses')->findOrFail($id);
        $courses = LearningCourse::where('status', 1)->get();

        return view('backend.lms.course.bundle.create', compact('bundle', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bundle = CourseBundle::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:course_bundles,slug,' . $bundle->id,
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:learning_courses,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $data = [
                'title' => $request->title,
                'slug' => $request->slug ?: Str::slug($request->title),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'currency' => $request->currency ?? 'INR',
                'price' => $request->price,
                'is_free' => $request->is_free ?? 0,
                'has_discount' => $request->has_discount ?? 0,
                'discount_price' => $request->discount_price,
                'discount_from' => $request->discount_from,
                'discount_to' => $request->discount_to,
                'status' => $request->status ?? 1,
            ];

            //Free logic
            if ($data['is_free'])
            {
                $data['price'] = 0;
                $data['discount_price'] = null;
                $data['has_discount'] = 0;
            }

            // Discount validation
            if ($data['has_discount'] && !$data['discount_price'])
            {
                throw new \Exception('Discount price required when discount is enabled');
            }

            //  Image update (delete old + upload new)
            if ($request->hasFile('thumbnail'))
            {

                // delete old image (if exists)
                if ($bundle->thumbnail && file_exists(public_path($bundle->thumbnail)))
                {
                    unlink(public_path($bundle->thumbnail));
                }

                $data['thumbnail'] = $this->uploadImage(
                    $request,
                    'thumbnail',
                    'uploads/thumbnail'
                );
            }
            $bundle->update($data);
            $bundle->courses()->sync($request->course_ids);

            DB::commit();

            return redirect()
                ->route('admin.bundle-course.index')
                ->with('success', 'Bundle updated successfully');

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */


public function destroy(string $id)
{
    try {
        DB::beginTransaction();
        $bundle = CourseBundle::findOrFail($id);
        if (!empty($bundle->thumbnail)) {
            $this->deleteImage($bundle->thumbnail);
        }

        BundleCourse::where('bundle_id', $id)->delete();
        $bundle->delete();
        DB::commit();

        return redirect()
            ->route('admin.bundle-course.index')
            ->with('success', 'Course Bundle deleted successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Bundle Delete Error: ' . $e->getMessage());

        return redirect()
            ->back()
            ->with('error', 'Something went wrong while deleting');
    }
}


  public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:course_bundles,id',
            'status' => 'required|boolean',
        ]);

        $bundle = CourseBundle::findOrFail($request->id);
        $bundle->status = $request->status;
        $bundle->save();

        return response()->json([
            'success' => true,
            'message' => 'Bundle Course status updated successfully',
        ]);
    }

}