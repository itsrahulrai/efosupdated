<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobSubCategory;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;;

class JobSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = JobSubCategory::with('category')->latest()->paginate(10);
        return view('backend.job-sub-categories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobcategories = JobCategory::where('status', 1)->get();
        return view('backend.job-sub-categories.create', compact('jobcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_category_id' => 'required|exists:job_categories,id',
            'name'            => 'required|string|max:255',
        ]);

        JobSubCategory::create([
            'job_category_id' => $request->job_category_id,
            'name'            => $request->name,
            'slug'            => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),
            'status'          => 1,
        ]);

        return redirect()
            ->route('admin.job-sub-categories.index')
            ->with('success', 'Job Sub Category created successfully');
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
    public function edit(JobSubCategory $jobSubCategory)
    {
        $jobcategories = JobCategory::where('status', 1)->get();
        return view('backend.job-sub-categories.create', compact('jobSubCategory', 'jobcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobSubCategory $jobSubCategory)
    {
        $request->validate([
            'job_category_id' => 'required|exists:job_categories,id',
            'name'            => 'required|string|max:255',
        ]);

        $jobSubCategory->update([
            'job_category_id' => $request->job_category_id,
            'name'            => $request->name,
            'slug'            => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),
            'status'          => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.job-sub-categories.index')
            ->with('success', 'Job Sub Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(JobSubCategory $jobSubCategory)
    {
        $jobSubCategory->delete();

        return redirect()
            ->route('admin.job-sub-categories.index')
            ->with('success', 'Job Sub Category deleted successfully');
    }

    public function toggleStatus(Request $request)
    {
        $subcategory = JobSubCategory::findOrFail($request->id);
        $subcategory->status = $request->status;
        $subcategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Job Subcategory status updated successfully',
        ]);
    }
}
