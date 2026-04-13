<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseBundle;
use App\Models\CourseBuy;
use App\Models\CourseLesson;
use App\Models\FranchiseProfile;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use App\Models\LearningCourse;
use App\Models\LessonProgress;
use App\Models\NewsEvent;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function index()
    {
        $blogs = Blog::where('status', 1)
            ->latest()
            ->limit(3)
            ->get();

        $courses = Course::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        $jobs = Job::where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        $youtubeVideos = YoutubeVideo::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.index', compact('blogs', 'courses', 'jobs', 'youtubeVideos'));
    }

    public function skillCourses()
    {
        $skillCourses = LearningCourse::where('status', 1)
            ->latest()
            ->paginate(9); // show 9 courses per page

        return view('frontend.skill-courses', compact('skillCourses'));
    }

    public function BundleCourses()
    {
        $bundles = CourseBundle::with('courses')
            ->where('status', 1)
            ->latest()
            ->paginate(9);

        return view('frontend.bundle-courses', compact('bundles'));
    }

    // new code with bundle

    public function coursesDetails($slug)
    {
        // First check COURSE
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

            // Course Purchase Check
            $alreadyPurchased = false;

            if (Auth::check() && Auth::user()->role === 'student')
            {

                $alreadyPurchased = CourseBuy::where('user_id', Auth::id())
                    ->where('learning_course_id', $course->id)
                    ->where('payment_status', 'success')
                    ->exists();

                // ALSO CHECK BUNDLE PURCHASE
                if (!$alreadyPurchased)
                {
                    $alreadyPurchased = CourseBuy::where('user_id', Auth::id())
                        ->whereHas('bundle.courses', function ($q) use ($course)
                    {
                            $q->where('learning_courses.id', $course->id);
                        })
                        ->where('payment_status', 'success')
                        ->exists();
                }
            }

            return view('frontend.skill-courses-details', compact('course', 'alreadyPurchased'));
        }

        // IF NOT COURSE → CHECK BUNDLE 
        $bundle = CourseBundle::with(['courses'])
            ->where('slug', $slug)
            ->first();

            // dd($bundle);


        if ($bundle)
        {

            $alreadyPurchased = false;

            if (Auth::check() && Auth::user()->role === 'student')
            {
                $alreadyPurchased = CourseBuy::where('user_id', Auth::id())
                    ->where('bundle_id', $bundle->id)
                    ->where('payment_status', 'success')
                    ->exists();
            }

            return view('frontend.bundle-details', compact('bundle', 'alreadyPurchased'));
        }

        // NOT FOUND
        abort(404);
    }

    public function lesson($slug)
    {
        $lesson = CourseLesson::with([
            'chapter.course',
            'quiz.questions',
        ])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $user = auth()->user();

        //  ADD THIS BLOCK
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

        // ------------------------------------

        $course = LearningCourse::with([
            'chapters' => function ($q)
            {
                $q->active()->orderBy('sort_order');
            },
            'chapters.lessons' => function ($q)
            {
                $q->where('status', 1)->orderBy('sort_order');
            },
            'chapters.quizzes.questions',
        ])->findOrFail($lesson->course_id);

        $recommendedCourses = LearningCourse::where('status', 1)
            ->where('id', '!=', $course->id)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.skill-courses-lesson',
            compact('lesson', 'course', 'recommendedCourses'));
    }

    public function quiz($id)
    {
        $quiz = Quiz::with(['questions.options', 'course'])
            ->where('id', $id)
            ->where('is_active', 1)
            ->firstOrFail();

        $questions = QuizQuestion::with('options')
            ->where('quiz_id', $quiz->id)
            ->orderBy('id')
            ->get()
            ->map(function ($q)
        {
                return [
                    'id' => $q->id,
                    'text' => $q->question,
                    'marks' => $q->marks,
                    'options' => $q->options->map(function ($opt)
                {
                        return [
                            'id' => $opt->id,
                            'text' => $opt->option_text,
                        ];
                    })->values(),
                ];
            });

        return view('frontend.skill-courses-quiz', compact('quiz', 'questions'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'state' => 'required',
            'district' => 'required',
        ]);

        $centers = FranchiseProfile::with('user')
            ->where('state', $request->state)
            ->where('district', $request->district)
            ->where('status', 'approved')
            ->where('is_active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $centers,
        ]);
    }

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $seo = [
            'title' => $course->meta_title ?? $course->title,
            'description' => $course->meta_description ?? $course->short_description,
            'keywords' => $course->meta_keywords ?? $course->title,
            'robots' => 'index, follow',
            'canonical' => url()->current(),
        ];

        return view('frontend.course-details', compact('course', 'seo'));
    }

    public function opportunityHighlights(Request $request, JobCategory $category = null)
    {

        $categories = JobCategory::where('status', 1)->get();
        $subCategories = JobSubCategory::where('status', 1)->get();

        $jobs = Job::where('status', 1)

        // CATEGORY LOGIC (SLUG vs DROPDOWN)
            ->when(
                $request->job_category_id,
                // if dropdown is used → use it
                fn($q) => $q->where('job_category_id', $request->job_category_id),
                // else → use slug category (menu click)
                fn($q) => $category
                ? $q->where('job_category_id', $category->id)
                : $q
            )

        // SUB CATEGORY (only if category dropdown selected)
            ->when(
                $request->job_category_id && $request->job_sub_category_id,
                fn($q) => $q->where('job_sub_category_id', $request->job_sub_category_id)
            )

        // Date filter
            ->when($request->date_posted, function ($q) use ($request)
        {
                match ($request->date_posted)
            {
                    '24h' => $q->where('created_at', '>=', now()->subDay()),
                    '3d' => $q->where('created_at', '>=', now()->subDays(3)),
                    '7d' => $q->where('created_at', '>=', now()->subDays(7)),
                    default => null,
                };
            })

        // Search
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

        // AJAX response
        if ($request->ajax())
            {
            return view('frontend.partials.jobs-list', compact('jobs'))->render();
        }

        return view('frontend.opportunity-highlights', compact(
            'jobs',
            'categories',
            'subCategories',
            'category'
        ));
    }

    public function getSubCategories($categoryId)
        {

        return JobSubCategory::where('job_category_id', $categoryId)
            ->where('status', 1)
            ->select('id', 'name')
            ->get();
    }

    public function showJobs(Job $job)
        {
        if (!$job->status)
            {
            abort(404);
        }
        // Similar jobs
        $similarJobs = Job::where('job_sub_category_id', $job->job_sub_category_id)
            ->where('id', '!=', $job->id)
            ->where('status', 1)
            ->limit(5)
            ->get();
        // Check if already applied
        $alreadyApplied = false;

        if (Auth::check() && Auth::user()->student)
            {
            $alreadyApplied = JobApplication::where('student_id', Auth::user()->student->id)
                ->where('job_id', $job->id)
                ->exists();
        }

        return view(
            'frontend.opportunity',
            compact('job', 'similarJobs', 'alreadyApplied')
        );
    }
   

    public function newsEvents()
        {
        $newsEvents = NewsEvent::with('images')->latest()->get();

        return view('frontend.news-events', compact('newsEvents'));
    }

    public function careerUpdates(Request $request)
        {
        $query = Blog::where('status', 1);

        if ($request->filled('category'))
            {
            $query->whereHas('category', function ($q) use ($request)
                {
                $q->where('slug', $request->category);
            });
        }

        $blogs = $query->latest()->paginate(21);

        $seo = [
            'title' => 'Career Guidance Services | EFOS Edumarketers Pvt Ltd',
            'description' => 'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill development support.',
            'keywords' => 'career guidance, career counselling, education services',
            'robots' => 'index, follow',
            'canonical' => url()->current(),
        ];

        return view('frontend.career-updates', compact('blogs', 'seo'));
    }

    public function careerUpdatesDetails($slug)
        {
        $slug = strtolower($slug);

        $blog = Blog::whereRaw('LOWER(slug) = ?', [$slug])
            ->where('status', 1)
            ->firstOrFail();
        $seo = [
            'title' => $blog->meta_title ?? $blog->name,
            'description' => $blog->meta_description ?? Str::limit(strip_tags($blog->content), 160),
            'keywords' => $blog->meta_keywords ?? $blog->name,
            'robots' => $blog->meta_robot ?? 'index, follow',
            'canonical' => url()->current(),
        ];

        $jobcategories = Category::withCount([
            'blogs' => fn($q) => $q->where('status', 1),
        ])
            ->where('status', 1)
            ->latest()
            ->limit(10)
            ->get();

        $recentBlogs = Blog::where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        return view(
            'frontend.career-updates-details',
            compact('blog', 'seo', 'jobcategories', 'recentBlogs')
        );
    }

    public function applyFranchise(Request $request)
        {
        $request->validate([
            'owner_name' => 'required|string',
            'company_name' => 'required|string',
            'phone' => 'required|unique:users,phone|unique:franchise_profiles,phone',
            'email' => 'required|email|unique:users,email|unique:franchise_profiles,email',
            'state' => 'required',
            'district' => 'required',
            'business_experience' => 'required',
        ]);

        $password = $request->phone;
        $user = User::create([
            'name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($password),
            'role' => 'franchise',
        ]);
        // 2. Create franchise profile
        FranchiseProfile::create([
            'user_id' => $user->id,
            'owner_name' => $request->owner_name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'state' => $request->state,
            'district' => $request->district,
            'business_experience' => $request->business_experience,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->back()->with(
            'success',
            'Thank you! Your franchise application has been submitted successfully. Our team will contact you shortly.'
        );
    }

    public function sendContact(Request $request)
        {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:5000',
        ]);
        $name = e($validated['name']);
        $email = e($validated['email']);
        $phone = e($validated['phone']);
        $messageText = nl2br(e($validated['message'] ?? 'No message provided.'));

        $toEmail = "connect@efos.in";

        $html = '
            <div style="font-family: Arial, sans-serif; max-width:650px; margin:auto; border:1px solid #e5e5e5; border-radius:10px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.05);">
                <div style="background:#081016; padding:20px; color:#fff; text-align:center;">
                    <h2 style="margin:0;">New Contact Enquiry</h2>
                </div>

                <div style="padding:25px; background:#f9f9f9;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr><td style="padding:10px 0; width:30%; font-weight:bold;">Name:</td><td>' . $name . '</td></tr>
                        <tr><td style="padding:10px 0; font-weight:bold;">Email:</td><td><a href="mailto:' . $email . '">' . $email . '</a></td></tr>
                        <tr><td style="padding:10px 0; font-weight:bold;">Phone:</td><td>' . $phone . '</td></tr>
                        <tr><td style="padding:10px 0; font-weight:bold; vertical-align:top;">Message:</td><td>' . $messageText . '</td></tr>
                    </table>
                </div>

                <div style="padding:20px; background:#fff; text-align:center;">
                    <a href="mailto:' . $email . '"
                        style="display:inline-block; margin:6px; padding:10px 25px; background:#081016; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold;">
                        Reply Now
                    </a>
                </div>

                <div style="background:#081016; color:#fff; text-align:center; padding:10px; font-size:13px;">
                    © ' . date('Y') . ' EFOS. All rights reserved.
                </div>
            </div>';

        try     {
            Mail::html($html, function ($message) use ($toEmail, $email, $name)
                {
                $message->to($toEmail)
                    ->subject('New Contact Enquiry from ' . $name)
                    ->replyTo($email, $name);
            });

            return redirect()->route('thank.you');

        }
            catch (\Exception $e)
            {
            return back()->with('error', 'Mail sending failed: ' . $e->getMessage());
        }
    }

    public function findCenter()
        {

        return view('frontend.findcenter');

    }

}
