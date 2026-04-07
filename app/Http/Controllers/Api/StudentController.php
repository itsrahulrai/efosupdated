<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

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

}


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