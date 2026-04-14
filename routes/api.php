<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CourseBuyApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\StudentController;
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

// POST  http: //localhost/laravel/efosupdated/public/api/apply-franchise

// All Center
// GET   http: //localhost/laravel/efosupdated/api/find-center

// Center by State
// GET   http: //localhost/laravel/efosupdated/api/find-center?state=Bihar

// Mentor
// GET   http: //localhost/laravel/efosupdated/api/mentorship

// Mentor  Details
// GET   http: //localhost/laravel/efosupdated/api/mentorship-details/mentor-efos

// Opportunity Highlights
// GET  http: //localhost/laravel/efosupdated/api/opportunity-highlights

// Opportunity Highlights
// GET  http: //localhost/laravel/efosupdated/api/opportunity-highlights

//Opportunity Highlights (Jobs by category slug
// GET   http: //localhost/laravel/efosupdated/api/opportunity-highlights/career-carnival

// Pages
// GET  http: //localhost/laravel/efosupdated/api/page/efos-founders

// Book Session
// GET  http: //localhost/laravel/efosupdated/api/book-session

// http: //localhost/laravel/efosupdated/api/student-register
// POST

// {
// "name":"Rahul",
// "email":"rahul@test.com",
// "phone":"9876543210",
// "state":"Haryana",
// "district":"Gurgaon",
// "looking_for":"Job"
// }

/* =====================
AUTH API (Student | Mentor | Franchise)
===================== */

// POST   http: //localhost/laravel/efosupdated/api/login

// Student Login
// {
// "email":"therahulray@gmail.com",
// "password":"Rahul9@12423"
// }

// Mentor Login
// {
// "email":"codersvox@gmail.com",
// "password":"9304457866"
// }

// Franchise Login
// {
// "email":"rahul@test.com",
// "password":"9876543210"
// }

// Logout
// POST   http: //localhost/laravel/efosupdated/api/logout

// {
// "status": true,
// "message": "Logout successful"
// }

Route::post('/login', [AuthApiController::class, 'login']);

Route::post('/logout', [AuthApiController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function ()
{
    Route::get('/student/dashboard', [AuthApiController::class, 'studentDashboard']);
    Route::get('/mentor/dashboard', [AuthApiController::class, 'mentorDashboard']);
    Route::get('/franchise/dashboard', [AuthApiController::class, 'franchiseDashboard']);
});

/* =====================
STUDENT API
===================== */

Route::middleware(['auth:sanctum'])->prefix('student')->group(function ()
{
    Route::get('/profile', [StudentController::class, 'profile']);
    Route::post('/profile-update', [StudentController::class, 'updateProfile']);
    Route::post('/change-password', [StudentController::class, 'changePassword']);
    Route::get('/courses', [StudentController::class, 'myCourses']);
    Route::get('/course/{slug}', [StudentController::class, 'courseDetails']);
    Route::get('/certificates', [StudentController::class, 'certificates']);
    Route::post('/quiz-submit', [StudentController::class, 'quizSubmit']);

    Route::get('/profile-download', [StudentController::class, 'downloadProfile']);
    Route::post('/documents-upload', [StudentController::class, 'uploadDocuments']);

    Route::post('/course-enroll-free/{course_id}', [CourseBuyApiController::class, 'enrollFree']);
    Route::post('/bundle-enroll-free/{bundle}', [CourseBuyApiController::class, 'enrollBundleFree']);

    Route::post('/payment-initiate/{course_id}', [CourseBuyApiController::class, 'initiatePayment']);
    Route::post('/bundle-payment-initiate/{bundle_id}', [CourseBuyApiController::class, 'initiateBundlePayment']);


    Route::post('/lesson-complete/{lesson_id}', [StudentController::class, 'markComplete']);

    Route::get('/quiz/{quiz_id}', [StudentController::class, 'show']);

    Route::get('/quiz-results', [StudentController::class, 'quizResults']);

    Route::get('/certificate/{id}', [StudentController::class, 'certificateDetails']);

    Route::post('/book-session', [MentorController::class, 'bookSession']);

});

// Profile Download
// GET    http: //localhost/laravel/efosupdated/api/student/profile-download

// Documents Upload
// POST   http: //localhost/laravel/efosupdated/api/student/documents-upload

// Body (form-data)

// KEY                         TYPE                        VALUE
// documents[0][title]           text                        Aadhaar Card
// documents[0][file]           file                        aadhaar.pdf
// documents[1][title]           text                        Photo
// documents[1][file]           file                        photo.jpg

// Buy Free Course
// POST http://localhost/laravel/efosupdated/api/student/course-enroll-free/3

// Buy Free Bundle Course
// POST http: //localhost/laravel/efosupdated/api/student/bundle-enroll-free/2

//Payment Initiate Course
//POST http://localhost/laravel/efosupdated/api/student/payment-initiate/5

//Payment Initiate Course Bundle
// POST  http: //localhost/laravel/efosupdated/api/student/bundle-payment-initiate/1




// POST /api/student/lesson-complete/{lesson_id}

// GET  /api/student/quiz/{quiz_id}
// GET  /api/student/quiz-results

// GET  /api/student/certificate/{id}

// POST /api/student/book-session

// After Login Response

// {
//     "status": true,
//     "message": "Login successful",
//     "data": {
//         "token": "3|XNJ4SWs44C0XOFiAy7FR5vZ3pgnxGFhYbKpnIHKVd9daf6c2",
//         "user": {
//             "id": 18,
//             "name": "Rahul Rai",
//             "email": "therahulray@gmail.com",
//             "phone": "9876545671",
//             "role": "student"
//         }
//     }
// }

// Get Profile
// GET  http: //localhost/laravel/efosupdated/api/student/profile

// Header
#KEY                                              VALUE
// Authorization                                   Bearer 3|XNJ4SWs44C0XOFiAy7FR5vZ3pgnxGFhYbKpnIHKVd9daf6c2
// Accept                                          application/json

// Update Profile
// POST  http://localhost/laravel/efosupdated/api/student/profile-update

// Header
#KEY                                              VALUE
// Authorization                                   Bearer 3|XNJ4SWs44C0XOFiAy7FR5vZ3pgnxGFhYbKpnIHKVd9daf6c2
// Accept                                         application/json
// Content-Type                                   application/json

// Body (raw  JSON)

// {
// "name":"Rahul Rai",
// "phone":"9999999999",
// "state":"Haryana",
// "district":"Gurgaon"
// }

// Pass Header and Body for Change Password API
// {
// "old_password":"Rahul9@12423",
// "new_password":"12345678"
// }
// POST    http: //localhost/laravel/efosupdated/api/student/change-password

// Get Student Courses
// Pass Header
// GET  http: //localhost/laravel/efosupdated/api/student/courses

// Get Student Course Details
// Pass Header
// GET http: //localhost/laravel/efosupdated/api/student/course/prompt-engineering-course

// Quiz Submit
// Pass Header and Body
// {
// "quiz_id":1,
// "answers":{
// "1":"A",
// "2":"C",
// "3":"B"
// },

// POST  http: //localhost/laravel/efosupdated/api/student/quiz-submit

/* =====================
POST ROUTES
===================== */

Route::post('/student-register', [StudentController::class, 'store']);
Route::post('/apply-job', [HomeApiController::class, 'applyJob']);
Route::post('/apply-franchise', [HomeApiController::class, 'applyFranchise']);
Route::post('/book-session', [HomeApiController::class, 'bookSession']);

/* =====================
GET ROUTES
===================== */

Route::get('/blogs', [HomeApiController::class, 'blogs']);
Route::get('/blog-details/{slug}', [HomeApiController::class, 'blogDetails']);
Route::get('/courses', [HomeApiController::class, 'courses']);
Route::get('/course-details/{slug}', [HomeApiController::class, 'coursesDetails']);
Route::get('/lesson-details/{slug}', [HomeApiController::class, 'lessonDetails']);
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
Route::get('/find-center', [HomeApiController::class, 'findCenter']);
Route::get('/opportunity-highlights/{slug?}', [HomeApiController::class, 'opportunityHighlights']);
Route::get('/mentorship', [HomeApiController::class, 'mentorship']);
Route::get('/mentorship-details/{slug}', [HomeApiController::class, 'mentorshipDetails']);
Route::get('/page/{slug}', [HomeApiController::class, 'pageDetails']);
