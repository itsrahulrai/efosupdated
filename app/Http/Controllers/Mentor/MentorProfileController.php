<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MentorProfileController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentorProfiles = MentorProfile::latest()->paginate(10);
        $expertises = MentorCategory::where('status', 1)->get();
        return view('backend.mentor.profile.index', compact('mentorProfiles', 'expertises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.mentor.profile.create');

    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'mentor_category_id' => 'required',
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'phone' => 'required|digits:10|unique:users,phone',
    //         'state' => 'nullable',
    //         'city' => 'nullable',
    //         'zip_code' => 'nullable',
    //         'address' => 'nullable',
    //         'bio' => 'nullable',
    //         'skills' => 'nullable',
    //         'experience' => 'nullable',
    //         'profile_photo' => 'nullable|image',
    //     ]);

    //     //upload image
    //     $imagePath = $this->uploadImage($request, 'profile_photo', 'uploads/mentor');
    //     $password = $request->phone;
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'password' => Hash::make($password),
    //         'role' => 'mentor',

    //     ]);

    //     //create mentor profile
    //     MentorProfile::create([
    //         'user_id' => $user->id,
    //         'mentor_category_id' => $request->mentor_category_id,
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'state' => $request->state,
    //         'city' => $request->city,
    //         'zip_code' => $request->zip_code,
    //         'address' => $request->address,
    //         'bio' => $request->bio,
    //         'skills' => $request->skills,
    //         'experience' => $request->experience,
    //         'profile_photo' => $imagePath,
    //         'status' => 'approved',
    //     ]);

    //     return redirect()->route('admin.mentor-categories.index')->with('success', 'Mentor Profile created successfully. Login password is phone number');
    // }

    public function store(Request $request)
    {

        $request->validate([
            'mentor_category_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'state' => 'nullable',
            'city' => 'nullable',
            'zip_code' => 'nullable',
            'address' => 'nullable',
            'bio' => 'nullable',
            'skills' => 'nullable',
            'experience' => 'nullable',
            'profile_photo' => 'nullable|image',
        ]);

        $imagePath = $this->uploadImage($request, 'profile_photo', 'uploads/mentor');

        $password = $request->phone;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'role' => 'mentor',
        ]);

        MentorProfile::create([
            'user_id' => $user->id,
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
            'status' => 'approved',
        ]);

        Mail::send('emails.mentor_welcome',
            ['name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => $password,
            ],
            function ($message) use ($user)
            {
                $message->to($user->email)->subject('Welcome to EFOS Mentor Panel');
            }
        );

        return redirect()->route('admin.mentor-categories.index')->with('success', 'Mentor created successfully & login details sent to email');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.mentor.profile.create');

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $mentor = MentorProfile::findOrFail($id);
        $user = User::findOrFail($mentor->user_id);
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
            'profile_photo' => 'nullable|image',
        ]);

        $imagePath = $this->uploadImage($request, 'profile_photo', 'uploads/mentor');
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $mentor->update([
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
            'profile_photo' => $imagePath ? $imagePath : $mentor->profile_photo,
        ]);
        return redirect()->route('admin.mentor-categories.index')->with('success', 'Mentor Profile updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $mentor = MentorProfile::findOrFail($id);
        if ($mentor->profile_photo)
        {
            $this->deleteImage($mentor->profile_photo);
        }
        User::where('id', $mentor->user_id)->delete();
        $mentor->delete();

        return redirect()->route('admin.mentor-categories.index')->with('success', 'Mentor Profile deleted successfully');

    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mentor_profiles,id',
            'status' => 'required|in:pending,approved,rejected',
            ]);
            
        $mentor = MentorProfile::find($request->id);
        $mentor->status = $request->status;
        $mentor->save();

        return response()->json([
            'success' => true,
            'message' => 'Mentor Profile status updated successfully',

        ]);

    }
}
