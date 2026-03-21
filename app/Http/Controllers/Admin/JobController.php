<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display all jobs
     */
    public function index()
    {
        $jobs = Job::with(['category', 'subCategory'])
            ->latest()
            ->paginate(10);

        return view('backend.jobs.index', compact('jobs'));
    }

    /**
     * Show job create form
     */
        public function create()
        {
            $categories = JobCategory::where('status', 1)->get();
            $subCategories = JobSubCategory::where('status', 1)->get();

            return view('backend.jobs.create', compact('categories', 'subCategories'));
        }

    /**
     * Store new job
     */
    public function store(Request $request)
    {

        $request->validate([
            'job_category_id'     => 'required',
            'job_sub_category_id' => 'required',
            'title'           => 'required|string|max:255',
            'company_name'    => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
             // SEO validation
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
            'meta_keywords'       => 'nullable|string|max:255',
            'meta_robots'         => 'nullable|string|max:50',
            'canonical_url'       => 'nullable|url',
            // OG validation
            'og_title'            => 'nullable|string|max:255',
            'og_description'      => 'nullable|string|max:255',
            'og_image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request, 'image', 'uploads/jobs');
            }

             /* =============================
            OG IMAGE (SOCIAL SHARE)
            ============================= */
            $ogImagePath = null;
            if ($request->hasFile('og_image')) {
                $ogImagePath = $this->uploadImage($request, 'og_image', 'uploads/og');
            }

            Job::create([
                'job_category_id' => $request->job_category_id,
                'job_sub_category_id' => $request->job_sub_category_id,
                'title'           => $request->title,
                'company_name'    => $request->company_name,
                'company_logo'    => $imagePath,
                'posted_by'       => $request->posted_by,
                'area'            => $request->area,
                'district'        => $request->district,
                'state'           => $request->state,
                'salary'          => $request->salary,
                'job_type'        => $request->job_type,
                'work_mode'       => $request->work_mode,
                'shift'           => $request->shift,
                'experience'      => $request->experience,
                'education'       => $request->education,
                'eligibility'     => $request->eligibility,
                'age_limit'       => $request->age_limit,
                'gender'          => $request->gender,
                'english_level'   => $request->english_level,
                'skills'          => $request->skills,
                'short_description' => $request->short_description,
                'description'       => $request->description,
                'highlights'        => $request->highlights,
                'slug'              => Str::slug($request->title),
                'is_featured'       => $request->is_featured ?? 0,
                'status'            => $request->status ?? 1,
                'expiry_date'       => $request->expiry_date,

                'meta_title'       => $request->meta_title ?? $request->title,
                'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->short_description), 160),
                'meta_keywords'    => $request->meta_keywords,
                'meta_robots'      => $request->meta_robots ?? 'index, follow',
                'canonical_url'    => $request->canonical_url,
          
                'og_title'         => $request->og_title ?? $request->title,
                'og_description'   => $request->og_description ?? Str::limit(strip_tags($request->short_description), 160),
                'og_image'         => $ogImagePath ?? 'assets/images/share/job-share.jpg',

                ]);

            DB::commit();

            return redirect()
                ->route('admin.jobs.index')
                ->with('success', 'Job added successfully');

        } catch (\Exception $e) {
            DB::rollback();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);
        $categories = JobCategory::where('status', 1)->get();
        $subCategories = JobSubCategory::where('status', 1)->get();

        return view('backend.jobs.create', compact('job', 'categories', 'subCategories'));
    }

    /**
     * Update job
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);

        DB::beginTransaction();

        try {
            $imagePath = $job->company_logo;

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request, 'image', 'uploads/jobs', $job->company_logo);
            }


             /* =============================
                OG IMAGE
                ============================= */
                $ogImagePath = $job->og_image;
                if ($request->hasFile('og_image')) {
                    $ogImagePath = $this->uploadImage(
                        $request,
                        'og_image',
                        'uploads/og',
                        $job->og_image
                    );
                }

            $job->update([
               'job_category_id'     => $request->job_category_id,
                'job_sub_category_id' => $request->job_sub_category_id,
                'title'           => $request->title,
                'company_name'    => $request->company_name,
                'company_logo'    => $imagePath,
                'posted_by'       => $request->posted_by,
                'area'            => $request->area,
                'district'        => $request->district,
                'state'           => $request->state,
                'salary'          => $request->salary,
                'job_type'        => $request->job_type,
                'work_mode'       => $request->work_mode,
                'shift'           => $request->shift,
                'experience'      => $request->experience,
                'education'       => $request->education,
                'eligibility'     => $request->eligibility,
                'age_limit'       => $request->age_limit,
                'gender'          => $request->gender,
                'english_level'   => $request->english_level,
                'skills'          => $request->skills,
                'short_description' => $request->short_description,
                'description'       => $request->description,
                'highlights'        => $request->highlights,
                'is_featured'       => $request->is_featured ?? 0,
                'status'            => $request->status ?? 1,
                'expiry_date'       => $request->expiry_date,

                 // SEO Meta
                'meta_title'          => $request->meta_title ?? $request->title,
                'meta_description'    => $request->meta_description
                    ?? Str::limit(strip_tags($request->short_description), 160),
                'meta_keywords'       => $request->meta_keywords,
                'meta_robots'         => $request->meta_robots ?? 'index, follow',
                'canonical_url'       => $request->canonical_url,

                // Open Graph
                'og_title'            => $request->og_title ?? $request->title,
                'og_description'      => $request->og_description
                    ?? Str::limit(strip_tags($request->short_description), 160),
                'og_image'            => $ogImagePath ?? 'assets/images/share/job-share.jpg',
                ]);

            DB::commit();

            return redirect()
                ->route('admin.jobs.index')
                ->with('success', 'Job updated successfully');

        } catch (\Exception $e) {
            DB::rollback();

            return back()
                ->withInput()
                ->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete job
     */
    public function destroy(string $id)
    {
        try {
            $job = Job::findOrFail($id);

            if ($job->company_logo) {
                $this->deleteImage($job->company_logo);
            }

            $job->delete();

            return back()->with('success', 'Job deleted successfully');

        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Request $request)
    {
        try {
            $job = Job::findOrFail($request->id);

            $job->status = $request->status;
            $job->save();

            return response()->json([
                'success' => true,
                'message' => $request->status
                    ? 'Job activated successfully'
                    : 'Job deactivated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }


    public function getSubCategories($categoryId)
    {
        try {
            $subCategories = JobSubCategory::where('job_category_id', $categoryId)
                ->where('status', 1)
                ->get(['id', 'name']);

            return response()->json($subCategories);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

}
