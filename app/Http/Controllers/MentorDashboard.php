<?php

namespace App\Http\Controllers;

use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class MentorDashboard extends Controller
{
    use ImageUploadTrait;

    public function index()
    {

        // get categories
        $expertises = MentorCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        // dd($categories);

        // get mentor profile
        $mentor = MentorProfile::where('user_id', auth()->id())->first();

        return view('mentor.dashboard', compact(
            'expertises',
            'mentor'
        ));

    }

    public function MentorProfileupdate(Request $request)
    {
        $mentor = MentorProfile::where('user_id', auth()->id())->first();
        $user = User::findOrFail(auth()->id());

        $request->validate([
            'mentor_category_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|digits:10|unique:users,phone,' . $user->id,
            'state' => 'nullable',
            'city' => 'nullable',
            'zip_code' => 'nullable',
            'address' => 'nullable',
            'bio' => 'nullable',
            'skills' => 'nullable',
            'experience' => 'nullable',
            'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imagePath = $mentor->profile_photo ?? null;
        if ($request->hasFile('profile_photo'))
        {
            // delete old image
            if ($mentor && $mentor->profile_photo)
            {
                $this->deleteImage($mentor->profile_photo);
            }
            // upload new image
            $imagePath = $this->uploadImage($request, 'profile_photo', 'uploads/mentor');
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        MentorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'mentor_category_id' => $request->mentor_category_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                'bio' => $request->bio,
                'skills' => $request->skills,
                'experience' => $request->experience,
                'profile_photo' => $imagePath,
            ]
        );
        return redirect()->route('mentor.dashboard')->with('success', 'Profile updated successfully');
    }
  

    public function MentorupdatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(auth()->id());
        if (!Hash::check($request->current_password,$user->password))
        {
            return back()->with('error', 'Current password incorrect');
        }
        $user->update(['password' => Hash::make($request->new_password),

        ]);
        return back()->with('success', 'Password updated successfully');

    }

    public function messages(Request $request)
    {
        return view('mentor.includes.message');

    }
}
 