<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Certificate;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\CourseBuy;
use App\Models\CourseLesson;
use App\Models\Document;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\Student;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class StudentController extends Controller
{
    use ImageUploadTrait;

//    public function dashboard(Request $request)
//     {
//         $student = Student::with([
//             'experiences',
//             'documents',
//             'jobApplications.job',
//         ])
//             ->where('user_id', Auth::id())
//             ->first();

//         if (!$student)
//         {
//             return redirect()->route('home')
//                 ->with('error', 'Student profile not found.');
//         }

//               /** ---------------------------------
//                 * Auto Apply if user came from job
//             * --------------------------------- */
            
//               if ($request->session()->has('apply_job'))
//                 {
//                     $jobId = $request->session()->get('apply_job');

//                     // Check if job exists
//                     $job = Job::find($jobId);

//                     if (!$job)
//                     {
//                         $request->session()->forget('apply_job');

//                         return redirect()
//                             ->route('opportunity-highlights')
//                             ->with('error', 'Opportunity not found.');
//                     }

//                     // Get student
//                     $student = Student::where('user_id', Auth::id())->first();

//                     // Check already applied
//                     $alreadyApplied = JobApplication::where('student_id', $student->id)
//                         ->where('job_id', $job->id)
//                         ->exists();

//                     if (!$alreadyApplied)
//                     {

//                         JobApplication::create([
//                             'student_id' => $student->id,
//                             'job_id' => $job->id,
//                             'job_title' => $job->title,
//                             'company_name' => $job->company_name,
//                             'district' => $job->district,
//                             'state' => $job->state,
//                             'applied_at' => now(),
//                         ]);

//                         $message = 'Your application has been submitted successfully.';
//                     }
//                     else
//                     {
//                         $message = 'You have already applied for this opportunity.';
//                     }

//                     $request->session()->forget('apply_job');

//                     return redirect()
//                         ->route('jobs.show', $job->slug)
//                         ->with('success', $message);
//                 }



//         $courseBuys = CourseBuy::with([
//             'course.chapters.lessons' => function ($q)
//             {
//                 $q->where('status', 1)->orderBy('sort_order');
//             },
//         ])
//             ->where('user_id', Auth::id())
//             ->where('payment_status', 'success')
//             ->latest()
//             ->get();

//         $quizResults = QuizResult::with([
//             'quiz.course',
//             'quizAnswers.question.correctOption',
//             'quizAnswers.selectedOption',
//         ])
//             ->where('user_id', Auth::id())
//             ->latest()
//             ->get();

//         $certificate = Certificate::with([
//             'student:id,name,registration_number',
//             'course:id,title',
//         ])
//             ->where('student_id', $student->id)
//             ->first();

            
//         return view('student.index', compact(
//             'student',
//             'courseBuys',
//             'quizResults',
//             'certificate'
//         ));
//     }




 public function dashboard(Request $request)
    {
        $student = Student::with([
            'experiences',
            'documents',
            'jobApplications.job',
        ])
            ->where('user_id', Auth::id())
            ->first();

        if (!$student)
        {
            return redirect()->route('home')
                ->with('error', 'Student profile not found.');
        }

              /** ---------------------------------
                * Auto Apply if user came from job
            * --------------------------------- */
            
              if ($request->session()->has('apply_job'))
                {
                    $jobId = $request->session()->get('apply_job');

                    // Check if job exists
                    $job = Job::find($jobId);

                    if (!$job)
                    {
                        $request->session()->forget('apply_job');

                        return redirect()
                            ->route('opportunity-highlights')
                            ->with('error', 'Opportunity not found.');
                    }

                    // Get student
                    $student = Student::where('user_id', Auth::id())->first();

                    // Check already applied
                    $alreadyApplied = JobApplication::where('student_id', $student->id)
                        ->where('job_id', $job->id)
                        ->exists();

                    if (!$alreadyApplied)
                    {

                        JobApplication::create([
                            'student_id' => $student->id,
                            'job_id' => $job->id,
                            'job_title' => $job->title,
                            'company_name' => $job->company_name,
                            'district' => $job->district,
                            'state' => $job->state,
                            'applied_at' => now(),
                        ]);

                        $message = 'Your application has been submitted successfully.';
                    }
                    else
                    {
                        $message = 'You have already applied for this opportunity.';
                    }

                    $request->session()->forget('apply_job');

                    return redirect()
                        ->route('jobs.show', $job->slug)
                        ->with('success', $message);
                }


             // ================= COURSES (ONLY NORMAL) =================
            $courseBuys = CourseBuy::with([
                'course.category',
                'course.chapters.lessons' => function ($q) {
                    $q->where('status', 1)->orderBy('sort_order');
                },
            ])
                ->where('user_id', Auth::id())
                ->where('payment_status', 'success')
                ->whereNotNull('learning_course_id') // only courses
                ->where(function ($q) {
                    $q->whereNull('bundle_id') // direct purchase
                    ->orWhere('type', '!=', 'bundle_course'); // exclude bundle courses
                })
                ->latest()
                ->get();


                //  dd($courseBuys);
            // ================= BUNDLES =================
            $bundleBuys = CourseBuy::with([
                    'bundle.courses.chapters.lessons' => function ($q) {
                        $q->where('status', 1)->orderBy('sort_order');
                    }
                ])
                ->where('user_id', Auth::id())
                ->where('payment_status', 'success')
                ->whereNotNull('bundle_id')              // must be bundle
                ->whereNull('learning_course_id')        // only bundle main row
                ->whereIn('type', ['bundle_free', 'bundle_paid','admin_assign_bundle']) // correct types
                ->latest()
                ->get(); 

                // dd($bundleBuys);

              
       

        $quizResults = QuizResult::with([
            'quiz.course',
            'quizAnswers.question.correctOption',
            'quizAnswers.selectedOption',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $certificate = Certificate::with([
            'student:id,name,registration_number',
            'course:id,title',
        ])
            ->where('student_id', $student->id)
            ->first();

            
        return view('student.index', compact(
            'student',
            'courseBuys',
             'bundleBuys', 
            'quizResults',
            'certificate'
        ));
    }

    public function downloadProfile()
    {
        $student = Student::with([
            'experiences',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('student.profile-pdf', compact('student'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Profile_' . $student->registration_number . '.pdf');
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'documents.*.title' => 'required|string|max:255',
            'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $user = Auth::user();
        $student = $user->student;

        if (!$student)
        {
            return back()->with('error', 'Student profile not found.');
        }

        $uploadPath = public_path('uploads/documents');
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }

        foreach ($request->documents as $doc)
        {

            $file = $doc['file'];

            $extension = $file->extension();
            $sizeKB = round($file->getSize() / 1024);

            $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $extension;
            $file->move($uploadPath, $fileName);

            Document::create([
                'user_id' => $user->id,
                'student_id' => $student->id,
                'title' => $doc['title'],
                'file_path' => 'uploads/documents/' . $fileName,
                'file_type' => $extension,
                'file_size' => $sizeKB,
            ]);
        }

        return back()->with('success', 'Documents uploaded successfully.');
    }

    public function index()
    {

    }

    public function create()
    {
        return view('student.register');
    }

   

    // public function store(StoreStudentRequest $request)
    // {
   

    //     // If email or phone already exists → redirect to login
    //     $existingUser = User::where('email', $request->email)
    //         ->orWhere('phone', $request->phone)
    //         ->first();

    //     if ($existingUser)
    //     {
    //         return redirect()
    //             ->route('student.login')
    //             ->with('error', 'This email is already registered. Please log in to access your dashboard.');
    //     }

    //     return DB::transaction(function () use ($request)
    //     {

    //         /** -----------------------------
    //          * Generate Registration Number
    //          * ----------------------------- */
    //         $last = Student::orderBy('id', 'desc')->lockForUpdate()->first();

    //         if ($last && preg_match('/EFOS(\d+)/', $last->registration_number, $m))
    //         {
    //             $nextNumber = (int) $m[1] + 1;
    //         }
    //         else
    //         {
    //             $nextNumber = 1;
    //         }

    //         $registrationNumber = 'EFOS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    //         /** -----------------------------
    //          *  Create User First
    //          * ----------------------------- */
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'role' => 'student',
    //             'password' => Hash::make($request->phone), // or random password
    //         ]);

    //         /** -----------------------------
    //          * Create Student Profile
    //          * ----------------------------- */

    //         // -------------------------------
    //         // UTM AUTO-DETECTION LOGIC
    //         // -------------------------------
    //         $utmSource = $request->utm_source;
    //         $utmMedium = $request->utm_medium;
    //         $utmCampaign = $request->utm_campaign;
    //         $utmTerm = $request->utm_term;
    //         $utmContent = $request->utm_content;

    //         // If UTM not present, detect from referrer
    //         if (!$utmSource)
    //         {
    //             $ref = $request->headers->get('referer');

    //             if ($ref)
    //             {
    //                 if (str_contains($ref, 'facebook.com'))
    //                 {
    //                     $utmSource = 'facebook';
    //                     $utmMedium = 'social';
    //                 }
    //                 elseif (str_contains($ref, 'instagram.com'))
    //                 {
    //                     $utmSource = 'instagram';
    //                     $utmMedium = 'social';
    //                 }
    //                 elseif (str_contains($ref, 'linkedin.com'))
    //                 {
    //                     $utmSource = 'linkedin';
    //                     $utmMedium = 'social';
    //                 }
    //                 elseif (str_contains($ref, 'youtube.com'))
    //                 {
    //                     $utmSource = 'youtube';
    //                     $utmMedium = 'video';
    //                 }
    //                 elseif (str_contains($ref, 'google.com'))
    //                 {
    //                     $utmSource = 'google';
    //                     $utmMedium = 'organic';
    //                 }
    //             }
    //         }

    //         // Final fallbacks
    //         $utmSource = $utmSource ?? 'direct';
    //         $utmMedium = $utmMedium ?? 'none';
    //         $utmCampaign = $utmCampaign ?? 'direct';

    //         Student::create([
    //             'user_id' => $user->id,
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //             'email' => $request->email,
    //             'state' => $request->state,
    //             'district' => $request->district,
    //             'looking_for' => $request->looking_for,
    //             'registration_number' => $registrationNumber,

    //             'agree_terms' => $request->boolean('agree_terms'),

    //             // UTM FIELDS (SMART)
    //             'utm_source' => $utmSource,
    //             'utm_medium' => $utmMedium,
    //             'utm_campaign' => $utmCampaign,
    //             'utm_term' => $utmTerm,
    //             'utm_content' => $utmContent,
    //         ]);

    //         Mail::send(
    //             'emails.student_welcome',
    //             [
    //                 'name' => $user->name,
    //                 'registrationNumber' => $registrationNumber,
    //                 'email' => $user->email,
    //                 'password' => $request->phone, // temporary password
    //             ],
    //             function ($message) use ($user)
    //             {
    //                 $message->to($user->email)
    //                     ->subject('Welcome to EFOS - Your Login Details');
    //             }
    //         );

    //         /** -----------------------------
    //          * Redirect / View
    //          * ----------------------------- */
    //         return redirect()
    //             ->route('student.login')
    //             ->with('success', 'Registration successful. Your Registration ID is: ' . $registrationNumber);

    //     });
    // }

        
    public function store(StoreStudentRequest $request)
    {

    // dd($request->all());


        // If email or phone already exists → redirect to login
      $emailExists = User::where('email', $request->email)->exists();
        $phoneExists = User::where('phone', $request->phone)->exists();

        if ($emailExists || $phoneExists)
        {
            return redirect()
                ->route('student.login')
                ->with('error', 'This email or phone is already registered. Please login.');
        }


        return DB::transaction(function () use ($request)
        {

            /** -----------------------------
             * Generate Registration Number
             * ----------------------------- */
            $last = Student::orderBy('id', 'desc')->lockForUpdate()->first();

            if ($last && preg_match('/EFOS(\d+)/', $last->registration_number, $m))
            {
                $nextNumber = (int) $m[1] + 1;
            }
            else
            {
                $nextNumber = 1;
            }

            $registrationNumber = 'EFOS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            /** -----------------------------
             *  Create User First
             * ----------------------------- */
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'student',
                'password' => Hash::make($request->phone), // or random password
            ]);

            /** -----------------------------
             * Create Student Profile
             * ----------------------------- */

            // -------------------------------
            // UTM AUTO-DETECTION LOGIC
            // -------------------------------
            $utmSource = $request->utm_source;
            $utmMedium = $request->utm_medium;
            $utmCampaign = $request->utm_campaign;
            $utmTerm = $request->utm_term;
            $utmContent = $request->utm_content;

            // If UTM not present, detect from referrer
            if (!$utmSource)
            {
                $ref = $request->headers->get('referer');

                if ($ref)
                {
                    if (str_contains($ref, 'facebook.com'))
                    {
                        $utmSource = 'facebook';
                        $utmMedium = 'social';
                    }
                    elseif (str_contains($ref, 'instagram.com'))
                    {
                        $utmSource = 'instagram';
                        $utmMedium = 'social';
                    }
                    elseif (str_contains($ref, 'linkedin.com'))
                    {
                        $utmSource = 'linkedin';
                        $utmMedium = 'social';
                    }
                    elseif (str_contains($ref, 'youtube.com'))
                    {
                        $utmSource = 'youtube';
                        $utmMedium = 'video';
                    }
                    elseif (str_contains($ref, 'google.com'))
                    {
                        $utmSource = 'google';
                        $utmMedium = 'organic';
                    }
                }
            }

            // Final fallbacks
            $utmSource = $utmSource ?? 'direct';
            $utmMedium = $utmMedium ?? 'none';
            $utmCampaign = $utmCampaign ?? 'direct';

            Student::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'state' => $request->state,
                'district' => $request->district,
                'looking_for' => $request->looking_for,
                'registration_number' => $registrationNumber,

                'agree_terms' => $request->boolean('agree_terms'),

                // UTM FIELDS (SMART)
                'utm_source' => $utmSource,
                'utm_medium' => $utmMedium,
                'utm_campaign' => $utmCampaign,
                'utm_term' => $utmTerm,
                'utm_content' => $utmContent,
            ]);

            Mail::send(
                'emails.student_welcome',
                [
                    'name' => $user->name,
                    'registrationNumber' => $registrationNumber,
                    'email' => $user->email,
                    'password' => $request->phone, // temporary password
                ],
                function ($message) use ($user)
                {
                    $message->to($user->email)
                        ->subject('Welcome to EFOS - Your Login Details');
                }
            );
                /** -----------------------------
                 * Auto Login After Registration
                 * ----------------------------- */

                Auth::login($user);
                $request->session()->regenerate();

                    if ($request->session()->has('apply_job'))
                    {
                        $jobId = $request->session()->get('apply_job');

                        // Check if job exists
                        $job = Job::find($jobId);

                        if (!$job)
                        {
                            $request->session()->forget('apply_job');

                            return redirect()
                                ->route('opportunity-highlights')
                                ->with('error', 'Opportunity not found.');
                        }

                        // Get student record
                        $student = Student::where('user_id', $user->id)->first();

                        // Check if already applied
                        $alreadyApplied = JobApplication::where('student_id', $student->id)
                            ->where('job_id', $job->id)
                            ->exists();

                        if (!$alreadyApplied)
                        {

                            JobApplication::create([
                                'student_id' => $student->id,
                                'job_id' => $job->id,
                                'job_title' => $job->title,
                                'company_name' => $job->company_name,
                                'district' => $job->district,
                                'state' => $job->state,
                                'applied_at' => now(),
                            ]);

                            $message = 'Registration successful and your application has been submitted.';
                        }
                        else
                        {
                            $message = 'You have already applied for this opportunity.';
                        }

                        $request->session()->forget('apply_job');

                        return redirect()
                            ->route('jobs.show', $job->slug)
                            ->with('success', $message);
                    }




                /** -----------------------------
                 * Redirect to Dashboard
                 * ----------------------------- */
            return redirect()
                ->route('student.dashboard')
                ->with('success', 'Registration successful. Your Registration ID is: ' . $registrationNumber)
                ->with('open_profile', true)
                ->with('complete_profile_msg', true);

                        
                    });
    }




    public function update(Request $request, $id)
    {

        $student = Student::findOrFail($id);

        DB::beginTransaction();

        try {

            /* ================= PHOTO UPDATE (USING TRAIT) ================= */
            if ($request->hasFile('photo'))
            {
                $student->photo = $this->updateImage(
                    $request,
                    'photo',
                    'uploads/students',
                    $student->photo
                );
            }

            /* ================= UPDATE STUDENT ================= */
            $student->update([

                // BASIC
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'age_group' => $request->age_group,
                'gender' => $request->gender,
                'state' => $request->state,
                'district' => $request->district,
                'present_status' => $request->present_status,
                'looking_for' => $request->looking_for,

                // PROFILE
                'profile_summary' => $request->profile_summary,

                // PERSONAL
                'pincode' => $request->pincode,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'category' => $request->category,
                'address' => $request->address,

                // EDUCATION
                'highest_qualification' => $request->highest_qualification,

                // 10th
                'tenth_board' => $request->tenth_board,
                'tenth_year' => $request->tenth_year,
                'tenth_marks' => $request->tenth_marks,
                'tenth_stream' => $request->tenth_stream,

                // 12th
                'twelfth_board' => $request->twelfth_board,
                'twelfth_year' => $request->twelfth_year,
                'twelfth_marks' => $request->twelfth_marks,
                'twelfth_stream' => $request->twelfth_stream,

                // Graduation
                'graduation_university' => $request->graduation_university,
                'graduation_year' => $request->graduation_year,
                'graduation_marks' => $request->graduation_marks,
                'graduation_stream' => $request->graduation_stream,
                'graduation_field' => $request->graduation_field,

                // PG
                'pg_university' => $request->pg_university,
                'pg_year' => $request->pg_year,
                'pg_marks' => $request->pg_marks,
                'pg_stream' => $request->pg_stream,
                'pg_field' => $request->pg_field,

                'phd_university' => $request->phd_university,
                'phd_year' => $request->phd_year,
                'phd_subject' => $request->phd_subject,
                'phd_status' => $request->phd_status,

                // SKILL
                'skill_type' => $request->skill_type,
                'skill_trade' => $request->skill_trade,
                'skill_year' => $request->skill_year,

                // JOB TYPE
                'experience_type' => $request->experience_type,

                // OTHER
                'passport' => $request->passport,
                'relocation' => $request->relocation,
                'blood_group' => $request->blood_group,

                'profile_completed' => true,
            ]);

            /* ================= JOB EXPERIENCES ================= */

            // Remove previous records
            StudentExperience::where('student_id', $student->id)->delete();

            if (
                $request->experience_type === 'Experienced' &&
                is_array($request->company_name)
            )
            {
                foreach ($request->company_name as $index => $company)
                {

                    if (!empty($company))
                    {
                        StudentExperience::create([
                            'student_id' => $student->id,
                            'company_name' => $company,
                            'job_profile' => $request->job_profile[$index] ?? null,
                            'job_duration' => $request->job_duration[$index] ?? null,
                            'job_state' => $request->job_state[$index] ?? null,
                            'job_district' => $request->job_district[$index] ?? null,
                            'salary_range' => $request->salary_range[$index] ?? null,
                            'job_summary' => $request->job_summary[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Profile updated successfully.');

        }
        catch (\Exception $e)
        {

            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong!')
                ->withInput();
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password))
        {
            return back()->with('password_error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('password_success', 'Password updated successfully.');
    }

    // public function quizStore(Request $request, Quiz $quiz)
    // {
    //     $request->validate([
    //         'answers' => 'required|array',
    //         'time_taken' => 'required|integer',
    //         'submit_type' => 'nullable|in:manual,auto',
    //     ]);

    //     $user = auth()->user();

    //     if (
    //         QuizResult::where('user_id', $user->id)
    //         ->where('quiz_id', $quiz->id)
    //         ->exists()
    //     )
    //     {
    //         return response()->json([
    //             'message' => 'Quiz already submitted',
    //         ], 409);
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $answers = array_values($request->answers);
    //         $score = 0;

    //         $questions = QuizQuestion::where('quiz_id', $quiz->id)
    //             ->orderBy('id')
    //             ->get();

    //         // Create quiz result
    //         $quizResult = QuizResult::create([
    //             'user_id' => $user->id,
    //             'quiz_id' => $quiz->id,
    //             'answers' => $answers,
    //             'total_questions' => $questions->count(),
    //             'answered_questions' => collect($answers)->filter()->count(),
    //             'time_taken' => $request->time_taken,
    //             'submit_type' => $request->submit_type ?? 'manual',
    //             'submitted_at' => now(),
    //         ]);

    //         // Map answers to real question IDs
    //         foreach ($questions as $index => $question)
    //         {
    //             $optionId = $answers[$index] ?? null;

    //             if (!$optionId)
    //             {
    //                 continue;
    //             }

    //             $option = QuizOption::where('id', $optionId)
    //                 ->where('question_id', $question->id)
    //                 ->first();

    //             if (!$option)
    //             {
    //                 continue;
    //             }

    //             $isCorrect = $option->is_correct ? 1 : 0;

    //             if ($isCorrect)
    //             {
    //                 $score++;
    //             }

    //             QuizAnswer::create([
    //                 'attempt_id' => $quizResult->id,
    //                 'question_id' => $question->id,
    //                 'selected_option_id' => $option->id,
    //                 'is_correct' => $isCorrect,
    //             ]);
    //         }

    //         // Update score
    //         $quizResult->update([
    //             'score' => $score,
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Quiz submitted successfully',
    //             'total_questions' => $questions->count(),
    //             'answered_questions' => collect($answers)->filter()->count(),
    //             'score' => $score,
    //             'time_taken' => $request->time_taken,
    //         ]);

    //     }
    //     catch (\Throwable $e)
    //     {

    //         DB::rollBack();

    //         Log::error('Quiz submission failed', [
    //             'user_id' => $user->id,
    //             'quiz_id' => $quiz->id,
    //             'error' => $e->getMessage(),
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Something went wrong while submitting the quiz.',
    //         ], 500);
    //     }
    // }

    public function quizStore(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
            'time_taken' => 'required|integer',
            'submit_type' => 'nullable|in:manual,auto',
        ]);

        $user = auth()->user();

        if (
            QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->exists()
        )
        {
            return response()->json([
                'message' => 'Quiz already submitted',
            ], 409);
        }

        DB::beginTransaction();

        try {

            $certificateGenerated = false; // IMPORTANT

            $answers = array_values($request->answers);
            $score = 0;

            $questions = QuizQuestion::where('quiz_id', $quiz->id)
                ->orderBy('id')
                ->get();

            // Create quiz result
            $quizResult = QuizResult::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'answers' => $answers,
                'total_questions' => $questions->count(),
                'answered_questions' => collect($answers)->filter()->count(),
                'time_taken' => $request->time_taken,
                'submit_type' => $request->submit_type ?? 'manual',
                'submitted_at' => now(),
            ]);

            // Loop answers
            foreach ($questions as $index => $question)
            {

                $optionId = $answers[$index] ?? null;

                if (!$optionId)
                {
                    continue;
                }

                $option = QuizOption::where('id', $optionId)
                    ->where('question_id', $question->id)
                    ->first();

                if (!$option)
                {
                    continue;
                }

                $isCorrect = $option->is_correct ? 1 : 0;

                if ($isCorrect)
                {
                    $score++;
                }

                QuizAnswer::create([
                    'attempt_id' => $quizResult->id,
                    'question_id' => $question->id,
                    'selected_option_id' => $option->id,
                    'is_correct' => $isCorrect,
                ]);
            }

            // ======================
            // PASS CALCULATION
            // ======================

            $totalQuestions = $questions->count();
            $passPercentage = 50;
            $requiredCorrect = ceil(($totalQuestions * $passPercentage) / 100);
            $isPassed = $score >= $requiredCorrect;

            $quizResult->update([
                'score' => $score,
                'is_passed' => $isPassed,
            ]);

            // ======================
            // CERTIFICATE LOGIC
            // ======================

            if ($isPassed)
            {

                // Get all quizzes of this course
                $courseQuizIds = Quiz::where('course_id', $quiz->course_id)
                    ->orderBy('id')
                    ->pluck('id');

                $lastQuizId = $courseQuizIds->last();

                // Check all quizzes passed
                $passedQuizCount = QuizResult::where('user_id', $user->id)
                    ->whereIn('quiz_id', $courseQuizIds)
                    ->where('is_passed', 1)
                    ->distinct('quiz_id')
                    ->count('quiz_id');

                $totalQuizCount = $courseQuizIds->count();

                $allQuizzesPassed = $passedQuizCount === $totalQuizCount;
                $isLastQuiz = $quiz->id == $lastQuizId;

                // Check all lessons completed (ONLY ACTIVE)
                $totalLessons = CourseLesson::where('course_id', $quiz->course_id)
                    ->where('status', 1)
                    ->count();

                $completedLessons = LessonProgress::where([
                    'user_id' => $user->id,
                    'course_id' => $quiz->course_id,
                    'is_completed' => 1,
                ])->count();

                $allLessonsCompleted = $totalLessons > 0 && $totalLessons === $completedLessons;

                // Final check
                if ($allQuizzesPassed && $isLastQuiz && $allLessonsCompleted)
                {

                    $student = $user->student;

                    if ($student)
                    {

                        $certificateExists = Certificate::where([
                            'student_id' => $student->id,
                            'course_id' => $quiz->course_id,
                        ])->exists();

                        if (!$certificateExists)
                        {

                            Certificate::create([
                                'course_id' => $quiz->course_id,
                                'student_id' => $student->id,
                                'certificate_number' => $student->registration_number,
                                'issue_date' => now(),
                            ]);

                            $certificateGenerated = true;
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz submitted successfully',
                'total_questions' => $totalQuestions,
                'answered_questions' => collect($answers)->filter()->count(),
                'score' => $score,
                'is_passed' => $isPassed,
                'certificate_generated' => $certificateGenerated,
                'time_taken' => $request->time_taken,
            ]);

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            Log::error('Quiz submission failed', [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while submitting the quiz.',
            ], 500);
        }
    }

    public function print($id)
    {
        $certificate = Certificate::with([
            'student:id,name,registration_number',
            'course:id,title',
        ])->findOrFail($id);

        // dd($certificate);

        return view('backend.lms.certificates.certificate', compact('certificate'));
    }
}
