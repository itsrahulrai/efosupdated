<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\FranchiseProfile;
use App\Models\JobApplication;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalFranchise = FranchiseProfile::count();
        $jobapplication = JobApplication::count();
        $totalBlogs = Blog::count();

        return view('backend.index', compact(
            'totalStudents',
            'totalFranchise',
            'jobapplication',
            'totalBlogs'
        ));
    }
}
