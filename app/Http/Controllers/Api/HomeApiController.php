<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CourseBundle;
use App\Models\CourseLesson;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use App\Models\LearningCourse;
use App\Models\LessonProgress;
use App\Models\NewsEvent;
use App\Models\Quiz;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeApiController extends Controller
{
    
    /**
     * Get all blogs list
     */
    public function blogs()
    {
        $blogs = Blog::where('status', 1)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $blogs,
        ]);
    }

    /**
     * Get single blog details using slug
     * Includes SEO + categories + recent blogs
     */
    public function blogDetails($slug)
    {
        $slug = strtolower($slug);

        $blog = Blog::whereRaw('LOWER(slug) = ?', [$slug])
            ->where('status', 1)
            ->first();

        if (!$blog)
        {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        // SEO data
        $seo = [
            'title' => $blog->meta_title ?? $blog->name,
            'description' => $blog->meta_description ?? Str::limit(strip_tags($blog->content), 160),
            'keywords' => $blog->meta_keywords ?? $blog->name,
            'robots' => $blog->meta_robot ?? 'index, follow',
            'canonical' => url()->current(),
        ];

        // categories with blog count
        $jobcategories = Category::withCount([
            'blogs' => function ($q)
            {
                $q->where('status', 1);
            },
        ])
            ->where('status', 1)
            ->latest()
            ->limit(10)
            ->get();

        // recent blogs
        $recentBlogs = Blog::where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'blog' => $blog,
            'seo' => $seo,
            'categories' => $jobcategories,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    /**
     * Get all courses list
     */

    public function courses()
    {
        $courses = LearningCourse::where('status', 1)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

     /**
     * Get course details OR bundle details using slug
     */

    public function coursesDetails($slug)
    {
        // check course
        $course = LearningCourse::with([
            'subject',
            'chapters' => function ($q)
            {
                $q->active()->orderBy('sort_order');
            },
            'chapters.lessons' => function ($q)
            {
                $q->where('status', 1)->orderBy('sort_order');
            },
        ])
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        if ($course)
        {

            return response()->json([
                'success' => true,
                'type' => 'course',
                'data' => $course,
            ]);
        }

        // check bundle
        $bundle = CourseBundle::with('courses')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        if ($bundle)
        {

            return response()->json([
                'success' => true,
                'type' => 'bundle',
                'data' => $bundle,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Course not found',
        ], 404);
    }

    /**
     * Get lesson details using slug
     * includes course structure + quiz questions
     */

    public function lessonDetails($slug)
    {
        $lesson = CourseLesson::with([
            'chapter.course',
            'quiz.questions.options',
        ])
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$lesson)
        {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found',
            ], 404);
        }

        $user = auth()->user();

        // check completed lesson
        $lesson->is_completed = false;

        if ($user)
        {
            $lesson->is_completed = LessonProgress::where([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'course_id' => $lesson->course_id,
                'is_completed' => 1,
            ])->exists();
        }

        // course with chapters
        $course = LearningCourse::with([
            'chapters' => function ($q)
            {
                $q->active()->orderBy('sort_order');
            },
            'chapters.lessons' => function ($q)
            {
                $q->where('status', 1)->orderBy('sort_order');
            },
            'chapters.quizzes.questions.options',
        ])->find($lesson->course_id);

        // recommended courses
        $recommendedCourses = LearningCourse::where('status', 1)
            ->where('id', '!=', $course->id)
            ->latest()
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'lesson' => $lesson,
            'course' => $course,
            'recommendedCourses' => $recommendedCourses,
        ]);
    }

        /**
     * Get quiz details with questions & options
     */

    public function quizDetails($id)
    {
        $quiz = Quiz::with(['questions.options', 'course'])
            ->where('id', $id)
            ->where('is_active', 1)
            ->first();

        if (!$quiz)
        {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $quiz,
        ]);
    }

     /**
     * Get all course bundles
     */

    public function bundles()
    {
        $bundles = CourseBundle::with('courses')
            ->where('status', 1)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bundles,
        ]);
    }

     /**
     * Get all jobs list
     */
    public function jobs()
    {
        $jobs = Job::where('status', 1)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jobs,
        ]);
    }

    /**
     * Get similar jobs using slug
    */
    public function similarJobs($slug)
    {
        $job = Job::where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$job)
        {
            return response()->json([
                'success' => false,
                'message' => 'Job not found',
            ], 404);
        }

        $similarJobs = Job::where('job_sub_category_id', $job->job_sub_category_id)
            ->where('id', '!=', $job->id)
            ->where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        if ($similarJobs->isEmpty())
        {

            $similarJobs = Job::where('job_category_id', $job->job_category_id)
                ->where('id', '!=', $job->id)
                ->where('status', 1)
                ->latest()
                ->limit(5)
                ->get();
        }

        return response()->json([
            'success' => true,
            'current_job' => $job,
            'similar_jobs' => $similarJobs,
        ]);
    }

    /**
     * Get job categories list
     */

    public function jobCategories()
    {
        $categories = JobCategory::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get job sub categories using category id
     */

    public function jobSubCategories($categoryId)
    {
        $subCategories = JobSubCategory::where('job_category_id', $categoryId)
            ->where('status', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subCategories,
        ]);
    }

    /**
     * Get single job details using slug
     */
    public function jobDetails($slug)
    {
        $job = Job::where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$job)
        {
            return response()->json([
                'success' => false,
                'message' => 'Job not found',
            ], 404);
        }

        // similar jobs
        $similarJobs = Job::where('job_sub_category_id', $job->job_sub_category_id)
            ->where('id', '!=', $job->id)
            ->where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'job' => $job,
            'similarJobs' => $similarJobs,
        ]);
    }

    /**
     * Filter jobs using category, sub category, search
     */
    public function jobsFilter(Request $request)
    {
        $jobs = Job::where('status', 1)

            ->when($request->job_category_id, function ($q) use ($request)
        {
                $q->where('job_category_id', $request->job_category_id);
            })

            ->when($request->job_sub_category_id, function ($q) use ($request)
        {
                $q->where('job_sub_category_id', $request->job_sub_category_id);
            })

            ->when($request->search, function ($q) use ($request)
        {
                $q->where(function ($sq) use ($request)
            {
                    $sq->where('title', 'like', "%{$request->search}%")
                        ->orWhere('company_name', 'like', "%{$request->search}%")
                        ->orWhere('district', 'like', "%{$request->search}%")
                        ->orWhere('state', 'like', "%{$request->search}%");
                });
            })

            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $jobs,
        ]);
    }

    /**
     * Apply job
     */
    public function applyJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'student_id' => 'required|exists:students,id',
        ]);

        // get job details
        $job = Job::find($request->job_id);

        if (!$job)
        {
            return response()->json([
                'success' => false,
                'message' => 'Job not found',
            ], 404);
        }

        // check already applied
        $alreadyApplied = JobApplication::where('student_id', $request->student_id)
            ->where('job_id', $request->job_id)
            ->exists();

        if ($alreadyApplied)
        {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this opportunity',
            ]);
        }

        // apply job
        $application = JobApplication::create([
            'student_id' => $request->student_id,
            'job_id' => $job->id,
            'job_title' => $job->title,
            'company_name' => $job->company_name,
            'district' => $job->district,
            'state' => $job->state,
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job applied successfully',
            'data' => $application,
        ]);
    }

    /**
     * Get news & events list
     */
    public function newsEvents()
    {
        $newsEvents = NewsEvent::with('images')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $newsEvents,
        ]);
    }

    /**
     * Get youtube videos list
     */
    public function youtubeVideos()
    {
        $youtubeVideos = YoutubeVideo::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $youtubeVideos,
        ]);
    }
}
