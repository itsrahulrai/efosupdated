<?php

namespace App\Http\Controllers;

use App\Models\MentorAvailability;
use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\MentorSessionPrice;
use App\Models\SessionBooking;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MentorDashboard extends Controller
{
    use ImageUploadTrait;

    // public function index()
    // {
    //     // get categories
    //     $expertises = MentorCategory::where('status', 1)
    //         ->orderBy('name')
    //         ->get();

    //     // get mentor profile
    //     $mentor = MentorProfile::where('user_id', auth()->id())
    //         ->with([
    //             'sessionPrices',
    //             'availabilities',
    //         ])
    //         ->first();

    //     $mentorAvailability = MentorAvailability::where(
    //         'mentor_id',
    //         auth()->user()->mentorProfile->id
    //     )
    //         ->latest()
    //         ->paginate(10, ['*'], 'mentor_availability');

    //         $bookings = SessionBooking::with(['student'])
    //     ->where('mentor_id', $mentor->id)
    //     ->latest()
    //     ->paginate(10, ['*'], 'bookings')

    //     return view('mentor.dashboard', compact(
    //         'expertises',
    //         'mentor',
    //         'mentorAvailability'
    //     ));

    // }

        public function index()
        {
            // categories
            $expertises = MentorCategory::where('status', 1)
                ->orderBy('name')
                ->get();

            // mentor profile
            $mentor = MentorProfile::where('user_id', auth()->id())
                ->with([
                    'sessionPrices',
                    'availabilities',
                ])
                ->first();

            // mentor availability
            $mentorAvailability = MentorAvailability::where(
                'mentor_id',
                $mentor->id
            )
                ->latest()
                ->paginate(10, ['*'], 'mentor_availability');

            // session bookings
            $bookings = SessionBooking::with(['student',
                'sessionPrice'])
                ->where('mentor_id', $mentor->id)
                ->latest()
                ->paginate(10, ['*'], 'bookings');

            // dd($bookings);

            return view('mentor.dashboard', compact(
                'expertises',
                'mentor',
                'mentorAvailability',
                'bookings'
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
        if (!Hash::check($request->current_password, $user->password))
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

    public function storePrice(Request $request)
    {
        $mentorId = auth()->user()->mentorProfile->id;
        $request->validate([
            'duration_minutes' => 'required',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'session_type' => 'required',
            'meeting_platform' => 'required',
        ]);

        /* prevent duplicate duration */

        $exists = MentorSessionPrice::where('mentor_id', $mentorId)
            ->where('duration_minutes',
                $request->duration_minutes
            )->exists();

        if ($exists)
        {
            return back()->with('error', 'Price already exists for this duration');
        }

        /* free session logic */
        $price = $request->is_free ? 0 : $request->price;
        $discount = $request->is_free ? 0 : $request->discount_price;
        /* discount validation */

        if ($discount > $price)
        {
            return back()->with('error', 'Discount cannot be greater than price');
        }

        MentorSessionPrice::create([
            'mentor_id' => $mentorId,
            'duration_minutes' => $request->duration_minutes,
            'price' => $price,
            'discount_price' => $discount,
            'session_type' => $request->session_type,
            'meeting_platform' => $request->meeting_platform,
            'is_free' => $request->is_free ?? 0,
            'status' => 1,
        ]);
        return back()->with('success', 'Session price created successfully'
        );

    }

    public function updatePrice(Request $request, $id)
    {
        $mentorId = auth()->user()->mentorProfile->id;
        $request->validate([
            'duration_minutes' => 'required',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'session_type' => 'required',
            'meeting_platform' => 'required',
        ]);

        /* prevent duplicate duration except current record */
        $exists = MentorSessionPrice::where(
            'mentor_id',
            $mentorId
        )->where('duration_minutes', $request->duration_minutes)
            ->where('id', '!=', $id)
            ->exists();
        if ($exists)
        {
            return back()->with('error', 'Duration already exists');
        }

        /* free logic */
        $price = $request->is_free ? 0 : $request->price;
        $discount = $request->is_free ? 0 : $request->discount_price;
        if ($discount > $price)
        {
            return back()->with('error', 'Discount cannot be greater than price');
        }

        MentorSessionPrice::where('id', $id)
            ->update([
                'duration_minutes' => $request->duration_minutes,
                'price' => $price,
                'discount_price' => $discount,
                'session_type' => $request->session_type,
                'meeting_platform' => $request->meeting_platform,
                'is_free' => $request->is_free ?? 0,
            ]);
        return back()->with('success', 'Session price updated successfully'
        );

    }

    public function deletePrice($id)
    {
        MentorSessionPrice::find($id)->delete();
        return back()->with('success', 'Session price deleted successfully');

    }

    public function storeSlot(Request $request)
    {
        $mentorId = auth()->user()->mentorProfile->id;
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_gap' => 'required|numeric|min:5|max:120',
            'timezone' => 'required',
        ]);

        /* overlap check */

        $overlap = MentorAvailability::where('mentor_id', $mentorId)
            ->where('day', $request->day)
            ->where(function ($query) use ($request)
        {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request)
            {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);

                    });
            })->exists();

        if ($overlap)
        {
            throw ValidationException::withMessages(['start_time' => 'This time overlaps existing slot']);
        }

/* insert */

        MentorAvailability::create([
            'mentor_id' => $mentorId,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slot_gap' => $request->slot_gap,
            'timezone' => $request->timezone,
            'is_active' => 1,
        ]);

        return back()->with('success', 'Time slot created');
    }

    public function updateSlot(Request $request, $id)
    {
        $mentorId = auth()->user()->mentorProfile->id;
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_gap' => 'required|numeric|min:5|max:120',
            'timezone' => 'required',
        ]);

        $availability = MentorAvailability::findOrFail($id);

/* overlap check except current */

        $overlap = MentorAvailability::where(
            'mentor_id', $mentorId

        )->where('day', $request->day)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request)
        {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time,
                    ])->orWhere(function ($q) use ($request)
            {
                    $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                });
            })
            ->exists();

        if ($overlap)
        {
            throw ValidationException::withMessages([
                'start_time' => 'This time overlaps existing slot',
            ]);
        }

        /* update */
        $availability->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slot_gap' => $request->slot_gap,
            'timezone' => $request->timezone,
        ]);

        return back()->with('success', 'Time slot updated');

    }

    public function deleteSlot($id)
    {
        MentorAvailability::findOrFail($id)->delete();
        return back()->with('success', 'Mentor availability deleted successfully');
    }

    public function updateBookingStatus(Request $request)
    {
        $booking = SessionBooking::findOrFail($request->id);
        /* validation */
        $validStatus = [
            'pending',
            'accepted',
            'rejected',
            'cancelled',
            'completed',
        ];

        if (!in_array($request->status, $validStatus))
        {
            return response()->json(['message' => 'Invalid status'], 422);
        }

        $booking->status = $request->status;
        $booking->save();
        return response()->json(['message' => 'Booking Status updated successfully']);

    }

    public function updateBookingMeeting(Request $request)
    {
        $booking = SessionBooking::findOrFail(
            $request->booking_id
        );
        $booking->meeting_platform = $request->meeting_platform;
        $booking->zoom_meeting_id = $request->zoom_meeting_id;
        $booking->zoom_join_url = $request->zoom_join_url;
        $booking->zoom_start_url = $request->zoom_start_url;
        $booking->zoom_password = $request->zoom_password;
        $booking->save();
        return response()->json(['message' => 'Booking Meeting details updated',]);

    }

    public function getBooking($id)
    {
        $booking = SessionBooking::where('mentor_id',auth()->user()->mentorProfile->id)->findOrFail($id);
         return response()->json($booking);

    }
}
