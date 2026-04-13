<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\HomeApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Student Registration API
|--------------------------------------------------------------------------
 */

// Student Register
//POST http: //localhost/laravel/efosupdated/api/student-register

// Blogs
// GET  http: //localhost/laravel/efosupdated/api/blogs
// Blogs Details
// GET  hthttp: //localhost/laravel/efosupdated/api/blog-details/why-global-finance-careers-like-acca-will-dominate-the-future-of-employment
// Courses
// GET  http: //localhost/laravel/efosupdated/api/courses
// Courses Deatils
// GET  http: //localhost/laravel/efosupdated/api/course-details/retail-management-course
// Courses lesson
// GET  http: //localhost/laravel/efosupdated/api/lesson-details/introduction-to-ai-and-prompt-engineering-video-lecture

// Quiz details
// GET http: //localhost/laravel/efosupdated/api/quiz/2

// Courses bundle
// GET  http: //localhost/laravel/efosupdated/api/bundles
// Jobs
// GET  http: //localhost/laravel/efosupdated/api/jobs
// Similar Jobs
// GET http: //localhost/laravel/efosupdated/api/similar-jobs/mca-degree-online
// Apply Job
// POST http: //localhost/laravel/efosupdated/api/apply-job



// Jobs Deatils
// GET   http: //localhost/laravel/efosupdated/api/job-details/btech-electrical-engineering-lateral-entry
// Jobs Filter
// GET   http: //localhost/laravel/efosupdated/api/jobs-filter
// Jobs Filter with Job category
// GET   http: //localhost/laravel/efosupdated/api/jobs-filter?job_category_id=2
// Jobs Filter with Search
// GET  http: //localhost/laravel/efosupdated/api/jobs-filter?search=Picker%20Packer%20Job%20in%20North%20India
// Jobs Filter with Job Category and Job Sub Category
// GET   http: //localhost/laravel/efosupdated/api/jobs-filter?job_category_id=6&job_sub_category_id=20
// Job Category
// GET  http: //localhost/laravel/efosupdated/api/job-categories
// Job Job Subcategories
// GET  http: //localhost/laravel/efosupdated/api/job-subcategories/3
// News Event
// GET  http: //localhost/laravel/efosupdated/api/news-events
// YouTube
// GET  http: //localhost/laravel/efosupdated/api/youtube-videos






/* =====================
POST ROUTES
===================== */

Route::post('/student-register', [StudentController::class,'store']);
Route::post('/apply-job', [HomeApiController::class, 'applyJob']);



/* =====================
GET ROUTES
===================== */

Route::get('/blogs', [HomeApiController::class, 'blogs']);
Route::get('/blog-details/{slug}', [HomeApiController::class,'blogDetails']);
Route::get('/courses', [HomeApiController::class, 'courses']);
Route::get('/course-details/{slug}', [HomeApiController::class,'coursesDetails']);
Route::get('/lesson-details/{slug}', [HomeApiController::class,'lessonDetails']);
Route::get('/quiz/{id}', [HomeApiController::class, 'quizDetails']);
Route::get('/bundles', [HomeApiController::class, 'bundles']);
Route::get('/jobs', [HomeApiController::class, 'jobs']);
Route::get('/similar-jobs/{slug}', [HomeApiController::class, 'similarJobs']);
Route::get('/job-categories', [HomeApiController::class, 'jobCategories']);
Route::get('/job-subcategories/{categoryId}', [HomeApiController::class, 'jobSubCategories']);
Route::get('/job-details/{slug}', [HomeApiController::class, 'jobDetails']);
Route::get('/jobs-filter', [HomeApiController::class, 'jobsFilter']);
Route::get('/news-events', [HomeApiController::class, 'newsEvents']);
Route::get('/youtube-videos', [HomeApiController::class, 'youtubeVideos']);





