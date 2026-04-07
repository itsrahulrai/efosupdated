<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            DB::beginTransaction();

            // check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user)
            {

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'student',
                ]);

                // generate registration number
                $lastStudent = Student::orderBy('id', 'desc')->first();

                $nextNumber = 1;

                if ($lastStudent && $lastStudent->registration_number)
                {
                    $lastNumber = (int) str_replace('EFOS', '', $lastStudent->registration_number);
                    $nextNumber = $lastNumber + 1;
                }

                $registrationNumber = 'EFOS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                // create student record
                Student::create([
                    'user_id' => $user->id,
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'registration_number' => $registrationNumber,
                    'profile_completed' => 0,
                ]);

            }

            Auth::login($user);

            DB::commit();

            return redirect('/student/dashboard');

        }
        catch (\Exception $e)
        {

            DB::rollBack();

            return redirect('/login')->with('error', $e->getMessage());

        }
    }

}
