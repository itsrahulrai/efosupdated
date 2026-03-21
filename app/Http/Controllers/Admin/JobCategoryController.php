<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobcategories = JobCategory::latest()->paginate(10);

        return view('backend.job-categories.index', compact('jobcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.job-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        JobCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job Category created successfully');
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
     public function edit(JobCategory $jobCategory)
        {
            return view('backend.job-categories.create', compact('jobCategory'));
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobCategory $jobCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jobCategory->update([
            'name'   => $request->name,
            'slug'   => $request->slug
                        ? Str::slug($request->slug)
                        : Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job Category updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobCategory $jobCategory)
    {
        $jobCategory->delete();

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job Category deleted successfully');
    }

      public function toggleStatus(Request $request)
    {
        $subcategory = JobCategory::findOrFail($request->id);
        $subcategory->status = $request->status;    
        $subcategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Subcategory status updated successfully',
        ]);
    }
}
