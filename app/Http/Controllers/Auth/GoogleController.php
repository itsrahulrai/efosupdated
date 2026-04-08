<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            Log::info('Google callback started');

            $googleUser = Socialite::driver('google')->user();

            Log::info('Google user data', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
            ]);

            DB::beginTransaction();

           $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

            if (!$user) {

                Log::info('Creating new user');

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'student'
                ]);

                Log::info('User created', ['user_id' => $user->id]);

                $lastStudent = Student::latest()->first();

                $nextNumber = $lastStudent
                    ? (int) str_replace('EFOS', '', $lastStudent->registration_number) + 1
                    : 1;

                $registrationNumber = 'EFOS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                Student::create([
                    'user_id' => $user->id,
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'phone'=>null,
                    'registration_number' => $registrationNumber,
                    'profile_completed'=>'pending'
                ]);

                Log::info('Student created', [
                    'registration_number' => $registrationNumber
                ]);
            }

            Auth::login($user);

            request()->session()->regenerate();

            Log::info('User logged in', [
                'auth_check' => Auth::check(),
                'role' => $user->role
            ]);

            DB::commit();

            Log::info('Redirecting to dashboard');

            return redirect()->route('student.dashboard');

        }
        catch (\Exception $e) {

            DB::rollBack();

            Log::error('Google login error', [
                'message' => $e->getMessage()
            ]);

            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}