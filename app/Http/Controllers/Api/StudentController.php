<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CourseBuy;
use App\Models\LearningCourse;
use App\Models\QuizResult;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /*
    =====================
    REGISTER
    =====================
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'state' => 'nullable|string',
            'district' => 'nullable|string',
            'looking_for' => 'nullable|string',
        ]);
        // check existing user
        $emailExists = User::where('email', $request->email)->exists();
        $phoneExists = User::where('phone', $request->phone)->exists();

        if ($emailExists || $phoneExists)
        {
            return response()->json([
                'status' => false,
                'message' => 'Email or phone already registered',
            ], 409);
        }

        DB::beginTransaction();

        try {

            /*
            Generate Registration Number
            Example: EFOS001
             */

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

            /*
            Create User
             */

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'student',
                'password' => Hash::make($request->phone),
            ]);

            /*
            Create Student
             */

            $student = Student::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'state' => $request->state,
                'district' => $request->district,
                'looking_for' => $request->looking_for,
                'registration_number' => $registrationNumber,

                // UTM (optional)
                'utm_source' => $request->utm_source ?? 'direct',
                'utm_medium' => $request->utm_medium ?? 'none',
                'utm_campaign' => $request->utm_campaign ?? 'direct',
                'utm_term' => $request->utm_term,
                'utm_content' => $request->utm_content,
            ]);

            /*
            Optional Email Send
             */

            // Mail::send('emails.student_welcome', [
            //     'name' => $user->name,
            //     'registrationNumber' => $registrationNumber,
            //     'email' => $user->email,
            //     'password' => $request->phone,
            // ], function ($message) use ($user) {
            //     $message->to($user->email)
            //             ->subject('Welcome - Login Details');
            // });

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Student registered successfully',
                'registration_number' => $registrationNumber,
                'data' => $student,
            ], 201);

        }
        catch (\Exception $e)
        {

            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);

        }

    }

    /*
    =====================
    PROFILE
    =====================
     */

    public function profile(Request $request)
    {

        $student = Student::where('user_id', $request->user()->id)->first();

        return response()->json([
            'status' => true,
            'data' => $student,
        ]);

    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $user = $request->user();

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        Student::where('user_id', $user->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'state' => $request->state,
                'district' => $request->district,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated',
        ]);

    }

    /*
    =====================
    PASSWORD
    =====================
     */

    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password))
        {
            return response()->json([
                'status' => false,
                'message' => 'Old password wrong',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated',
        ]);

    }

    /*
    =====================
    COURSES
    =====================
     */

    public function myCourses(Request $request)
    {

        $courses = CourseBuy::with('course')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $courses,
        ]);

    }

    public function courseDetails($slug)
    {

        $course = LearningCourse::where('slug', $slug)
            ->with('chapters.lessons')
            ->first();

        return response()->json([
            'status' => true,
            'data' => $course,
        ]);

    }

    /*
    =====================
    CERTIFICATES
    =====================
     */

    public function certificates(Request $request)
    {
        $student = Student::where('user_id', $request->user()->id)->first();
        if (!$student)
        {
            return response()->json(['status' => false, 'message' => 'Student not found']);
        }
        $certificates = Certificate::with('course')
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $certificates,
        ]);
    }

    /*
    =====================
    QUIZ
    =====================
     */

    public function quizSubmit(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required',
            'answers' => 'required|array',
            'total_questions' => 'required',
            'answered_questions' => 'required',
            'score' => 'required',
            'time_taken' => 'required',
        ]);

        $result = QuizResult::create([
            'user_id' => $request->user()->id,
            'quiz_id' => $request->quiz_id,
            'answers' => $request->answers,
            'total_questions' => $request->total_questions,
            'answered_questions' => $request->answered_questions,
            'score' => $request->score,
            'is_passed' => $request->score >= 40 ? 1 : 0,
            'time_taken' => $request->time_taken,
            'submit_type' => 'manual',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Quiz submitted successfully',
            'data' => $result,
        ]);

    }

    public function downloadProfile(Request $request)
    {
        $student = $request->user()->student;

        if (!$student)
        {
            return response()->json([
                'status' => false,
                'message' => 'Student not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $student,

        ]);

    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'documents.*.title' => 'required|string|max:255',
            'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $user = $request->user();
        $student = $user->student;

        if(!$student)
        {
            return response()->json([
                'status'=>false,
                'message'=>'Student profile not found'
            ],404);
        }

        $uploadPath = public_path('uploads/documents');

        if(!file_exists($uploadPath))
        {
            mkdir($uploadPath,0777,true);
        }
        $uploadedDocs = [];
        foreach($request->documents as $doc)
        {
            $file = $doc['file'];
            $extension = $file->extension();
            $sizeKB = round($file->getSize()/1024);
            $fileName = 'doc_'.time().'_'.uniqid().'.'.$extension;
            $file->move($uploadPath,$fileName);

            $document = Document::create([
                'user_id'=>$user->id,
                'student_id'=>$student->id,
                'title'=>$doc['title'],
                'file_path'=>'uploads/documents/'.$fileName,
                'file_type'=>$extension,
                'file_size'=>$sizeKB,
                'is_verified'=>0
            ]);
            $uploadedDocs[] = $document;
        }
        return response()->json([
            'status'=>true,
            'message'=>'Documents uploaded successfully',
            'data'=>$uploadedDocs

        ]);

    }

}
