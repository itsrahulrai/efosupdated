<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    
   public function apply(Job $job)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('student.login')
                ->with('error', 'Please login as student to apply.');
        }

        // Check if already applied
        $alreadyApplied = JobApplication::where('student_id', $student->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('info', 'You have already applied for this opportunity.');
        }

        // Apply job
        JobApplication::create([
            'student_id'   => $student->id,
            'job_id'       => $job->id,
            'job_title'    => $job->title,
            'company_name' => $job->company_name,
            'district'     => $job->district,
            'state'        => $job->state,
            'applied_at'   => now(),
        ]);

        return back()->with('success', 'Job applied successfully.');
    }

}
