<?php

namespace App\Http\Controllers;

use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MentorController extends Controller
{
    use ImageUploadTrait;

    public function becomeAMentor()
    {
        $expertises = MentorCategory::where('status', 1)->get();
        return view('frontend.become-a-mentor', compact('expertises'));
    }

    public function storeMentor(Request $request)
    {
        $request->validate([
            'mentor_category_id' => 'required|exists:mentor_categories,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /* upload photo */

        $imagePath = null;

        if ($request->hasFile('profile_photo'))
        {
            $imagePath = $this->uploadImage($request, 'profile_photo', 'uploads/mentor'
            );
        }
        /* create user account */
        $password = $request->phone;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'role' => 'mentor',
        ]);

        /* create mentor profile */
        MentorProfile::create([
            'user_id' => $user->id,
            'mentor_category_id' => $request->mentor_category_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_photo' => $imagePath,
            'status' => 'pending',
        ]);

        /* send email */
        Mail::send('emails.mentor_welcome',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
            ],

            function ($message) use ($user)
            {
                $message->to($user->email)->subject('Welcome to EFOS Mentor Panel');
            }
        );

        return back()->with('success', 'Application submitted successfully. Login details sent to email.'

        );

    }

    public function mentorship()
    {
        $mentors = MentorProfile::where('status', 'approved')->get();
        return view('frontend.mentorship', compact('mentors'));
    }

    public function mentorshipDetails($slug)
    {
        $mentor = MentorProfile::select(
            'id',
            'mentor_category_id',
            'name',
            'slug',
            'email',
            'phone',
            'state',
            'city',
            'bio',
            'skills',
            'experience',
            'profile_photo'
        )->with([
                'category:id,name',
                'sessionPrices:id,mentor_id,duration_minutes,price,discount_price,session_type,meeting_platform',
                'availabilities:id,mentor_id,day,start_time,end_time,slot_gap,timezone',])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

            // dd($mentor);

        return view('frontend.mentorship-details', compact('mentor'));
    }

}
