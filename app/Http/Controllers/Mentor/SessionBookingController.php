<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\SessionBooking;
use Illuminate\Http\Request;

class SessionBookingController extends Controller
{

    public function sessionBookings()
    {
        $bookings = SessionBooking::with([
            'mentor',
            'student',
            'sessionPrice',
        ])->latest()->paginate(15);

        return view(
            'backend.mentor.session-bookings.index',
            compact('bookings')
        );

    }

    public function updateStatus(Request $request)
    {
        $booking = SessionBooking::findOrFail($request->id);
        $booking->status = $request->status;
        $booking->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function updateMeeting(Request $request)
    {
        $booking = SessionBooking::findOrFail($request->id);
        $booking->meeting_platform = $request->meeting_platform;
        $booking->zoom_meeting_id = $request->zoom_meeting_id;
        $booking->zoom_join_url = $request->zoom_join_url;
        $booking->zoom_start_url = $request->zoom_start_url;
        $booking->zoom_password = $request->zoom_password;
        $booking->save();
        return response()->json(['success' => true,'message' => 'Session Booking updated successfully',

        ]);

    }
}
