<?php

namespace App\Http\Controllers;

use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\MentorSessionPrice;
use App\Models\SessionBooking;
use App\Models\Student;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    // public function mentorshipDetails($slug)
    // {
    //     $mentor = MentorProfile::select(
    //         'id',
    //         'mentor_category_id',
    //         'name',
    //         'slug',
    //         'email',
    //         'phone',
    //         'state',
    //         'city',
    //         'bio',
    //         'skills',
    //         'experience',
    //         'profile_photo'
    //     )
    //         ->with([
    //             'category:id,name',
    //             'sessionPrices:id,mentor_id,duration_minutes,price,discount_price,session_type,meeting_platform',
    //             'availabilities:id,mentor_id,day,start_time,end_time,slot_gap,timezone',
    //         ])
    //         ->where('slug', $slug)
    //         ->where('status', 'approved')
    //         ->firstOrFail();

    //     /*
    //     generate time slots
    //     example:
    //     10:00 → 10:10 → 10:20
    //      */

    //     $availabilitySlots = [];

    //     foreach ($mentor->sessionPrices as $price)
    //     {

    //         $duration = $price->duration_minutes;

    //         foreach ($mentor->availabilities as $availability)
    //         {

    //             $startTime = strtotime($availability->start_time);
    //             $endTime = strtotime($availability->end_time);

    //             while ($startTime + ($duration * 60) <= $endTime)
    //             {

    //                 $availabilitySlots
    //                 [$duration]
    //                 [$availability->day][]
    //                 = date('h:i A', $startTime);

    //                 $startTime = strtotime(
    //                     "+{$availability->slot_gap} minutes",
    //                     $startTime
    //                 );
    //             }

    //         }
    //     }

    //     // $selectedDate = Carbon::today();
    //     $selectedDate = Carbon::parse('2026-04-10');

    //     $bookings = SessionBooking::where('mentor_id', $mentor->id)
    //         ->where('session_date', $selectedDate)
    //         ->whereIn('status', ['pending', 'accepted', 'completed'])
    //         ->get();

    //     $bookedSlots = [];

    //     foreach ($bookings as $booking)
    //     {
    //         $start = strtotime($booking->start_time);
    //         $end = strtotime($booking->end_time);

    //         while ($start < $end)
    //         {
    //             $dayName = strtolower(
    //                 Carbon::parse($booking->session_date)->format('l')
    //             );

    //             $bookedSlots[$dayName][] =
    //                 date('h:i A', $start);

    //             $start = strtotime(
    //                 "+{$mentor->availabilities->first()->slot_gap} minutes",
    //                 $start
    //             );
    //         }
    //     }

    //     //   dd($mentor->availabilities, $availabilitySlots);
    //     //   dd($bookedSlots);

    //     return view(
    //         'frontend.mentorship-details',
    //         compact(
    //             'mentor',
    //             'availabilitySlots',
    //             'bookedSlots'
    //         ));

    // }

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
        )
            ->with([
                'category:id,name',
                'sessionPrices:id,mentor_id,duration_minutes,price,discount_price,session_type,meeting_platform',
                'availabilities:id,mentor_id,day,start_time,end_time,slot_gap,timezone',
            ])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        /*
        Generate slots
         */

        $availabilitySlots = [];

        foreach ($mentor->sessionPrices as $price)
        {
            $duration = $price->duration_minutes;

            foreach ($mentor->availabilities as $availability)
            {
                $slotGap = $availability->slot_gap; // dynamic gap

                $startTime = strtotime($availability->start_time);
                $endTime = strtotime($availability->end_time);

                while ($startTime + ($duration * 60) <= $endTime)
                {
                    $availabilitySlots[$duration][$availability->day][] =
                        date('h:i A', $startTime);

                    $startTime = strtotime("+{$slotGap} minutes", $startTime);
                }
            }
        }

        /*
        get booked sessions (future)
         */

        $bookings =
        SessionBooking::where(
            'mentor_id',
            $mentor->id
        )

            ->whereDate(
                'session_date',
                '>=',
                now()
            )

            ->where(function ($q)
        {

                $q->where(
                    'payment_status',
                    'success'
                )

                    ->orWhereIn(
                        'status',
                        [
                            'accepted',
                            'completed',
                        ]
                    );

            })

            ->get();

        /*
        convert bookings to slot format
         */

        $bookedSlots = [];

        foreach ($bookings as $booking)
        {

            $start =
                strtotime(
                $booking->start_time
            );

            $end =
                strtotime(
                $booking->end_time
            );

            $dayName =
                strtolower(

                Carbon::parse(
                    $booking->session_date
                )->format('l')

            );

            while ($start < $end)
            {

                $bookedSlots
                [$dayName][]

                =
                    date(
                    'h:i A',
                    $start
                );

                $start =
                    strtotime(
                    "+{$mentor->availabilities->first()->slot_gap} minutes",
                    $start
                );

            }

        }

        return view(
            'frontend.mentorship-details',
            compact('mentor', 'availabilitySlots', 'bookedSlots')

        );

    }

    public function bookSession(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([

                'mentor_id' => 'required',

                'duration' => 'required',

                'day' => 'required',

                'time' => 'required',

            ]);

            /*
            get session price
             */

            $sessionPrice =
            MentorSessionPrice::where([

                'mentor_id' => $request->mentor_id,

                'duration_minutes' => $request->duration,

            ])->first();

            if (!$sessionPrice)
            {

                return response()->json([

                    'status' => false,

                    'message' => 'Session price not found',

                ]);

            }

            /*
            convert time
             */

            $startTime =
            Carbon::createFromFormat(

                'h:i A',

                $request->time

            );

            $endTime =
            (clone $startTime)
                ->addMinutes(
                    $request->duration
                );

            /*
            get session date
             */

            $sessionDate =
            Carbon::now()
                ->next(
                    ucfirst($request->day)
                );

            /*
            prevent overlapping booking
             */

            $alreadyBooked = SessionBooking::where('mentor_id', $request->mentor_id)
                ->where('session_date', $sessionDate->format('Y-m-d'))

                ->where(function ($q) use ($startTime, $endTime)
            {

                    $q->where('start_time', '<', $endTime->format('H:i:s'))
                        ->where('end_time', '>', $startTime->format('H:i:s'));

                })

                ->where(function ($q)
            {

                    $q->where('payment_status', 'success')
                        ->orWhere('status', 'accepted');

                })

                ->exists();

            if ($alreadyBooked)
            {

                return response()->json([

                    'status' => false,

                    'message' => 'This time slot is already booked',

                ]);

            }

            /*
            student
             */

            $student =
            Student::where(

                'user_id',

                auth()->id()

            )->first();

            if (!$student)
            {

                return response()->json([

                    'status' => false,

                    'message' => 'Student profile not found',

                ]);

            }

            /*
            calculate price
             */

            $price =
            $sessionPrice->discount_price ??
            $sessionPrice->price ??
                0;

            /*
            save booking
             */

            $booking =
            SessionBooking::create([

                'mentor_id' => $request->mentor_id,

                'student_id' => $student->id,

                'session_price_id' => $sessionPrice->id,

                'session_date' => $sessionDate->format('Y-m-d'),

                'start_time' => $startTime->format('H:i:s'),

                'end_time' => $endTime->format('H:i:s'),

                'duration_minutes' => $request->duration,

                'price' => $sessionPrice->price,

                'discount_price' => $sessionPrice->discount_price,

                'final_price' => $price,

                'payment_status' => 'pending',

                'meeting_platform' => 'zoom',

                'status' => 'pending',

            ]);

            DB::commit();

            return response()->json([

                'status' => true,

                'booking_id' => $booking->id,

                'message' => 'Redirecting to payment',

            ]);

        }
        catch (\Illuminate\Database\QueryException $e)
        {

            DB::rollBack();

            /*
            handle duplicate DB unique error
             */

            if ($e->errorInfo[1] == 1062)
            {

                return response()->json([

                    'status' => false,

                    'message' => 'This slot is already booked. Please select another time.',

                ]);

            }

            return response()->json([

                'status' => false,

                'message' => 'Database error occurred',

            ]);

        }
        catch (\Exception $e)
        {

            DB::rollBack();

            return response()->json([

                'status' => false,

                'message' => 'Something went wrong. Please try again.',

            ]);

        }

    }
}
