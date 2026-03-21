<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobAppliedController extends Controller
{
    /**
     * Display applied jobs list
     */
    public function index(Request $request)
    {
        $applications = JobApplication::with([
                'student.user',
                'job'
            ])
            ->when($request->student, function ($q) use ($request) {
                $q->whereHas('student', function ($sq) use ($request) {
                    $sq->where('name', 'like', '%' . $request->student . '%');
                });
            })
            ->latest()
            ->paginate(15);
          

        return view('backend.jobs.applied-jobs', compact('applications'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:job_applications,id',
            'status' => 'required|in:applied,shortlisted,selected,rejected',
        ]);

        JobApplication::where('id', $request->id)
            ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully'
        ]);
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();

        return back()->with('success', 'Job application deleted successfully.');
    }

}
