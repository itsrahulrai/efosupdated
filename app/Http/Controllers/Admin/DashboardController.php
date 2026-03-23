<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BundleCourse;
use App\Models\CourseBuy;
use App\Models\FranchiseProfile;
use App\Models\JobApplication;
use App\Models\LearningCourse;
use App\Models\Job;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\CourseLesson;



class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalFranchise = FranchiseProfile::count();
        $jobapplication = JobApplication::count();
        $learningCourse = LearningCourse::count();
        $Quiz = Quiz::count();
        $courseLesson = CourseLesson::count();
        $courseOrders = CourseBuy::count();
        $bundleCourse = BundleCourse::count();
        $opportunity = Job::count();

        $totalBlogs = Blog::count();

         $recentApplications = JobApplication::with('student')
            ->latest()
            ->take(5)
            ->get();

           $currentOpportunity = Job::withCount('applications')
                ->latest()
                ->take(4)
                ->get();

                // dd($currentOpportunity);



        return view('backend.index', compact(
            'totalStudents',
            'totalFranchise',
            'jobapplication',
            'totalBlogs',
            'learningCourse',
            'recentApplications',
            'currentOpportunity',
            'Quiz',
            'courseLesson',
            'courseOrders',
            'bundleCourse',
            'opportunity'
        ));
    }
}
