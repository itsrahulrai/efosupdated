<?php

namespace App\Http\Controllers;

use App\Models\SessionBooking;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class MentorPaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {

        $booking = SessionBooking::findOrFail($request->booking_id);

        if ($booking->payment_status == 'success')
        {
            return redirect()->back()->with('error', 'Already paid');
        }

        $orderId = 'MENTOR_' . Str::random(10);

        $booking->update([
            'transaction_id' => $orderId,
            'payment_gateway' => 'cashfree',
        ]);

        $response = Http::withHeaders([
            'x-client-id' => env('CASHFREE_API_KEY'),
            'x-client-secret' => env('CASHFREE_API_SECRET'),
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json',
        ])
            ->post(env('CASHFREE_URL'), [

                "order_id" => $orderId,

                "order_amount" => $booking->final_price,

                "order_currency" => "INR",

                "customer_details" => [

                    "customer_id" => (string) $booking->student_id,

                    "customer_name" => auth()->user()->name,

                    "customer_email" => auth()->user()->email,

                    "customer_phone" => "9999999999",

                ],

                "order_meta" => [
                    "return_url" =>
                    route('mentor.payment.success') . "?order_id={order_id}",
                ],

            ]);

        if (!$response->successful())
        {
            return back()->with('error', 'Payment failed');
        }

        return view(
            'frontend.payment.cashfree-checkout',

            [
                'paymentSessionId' => $response['payment_session_id'],

                'cashfreeMode' => env('CASHFREE_MODE'),
            ]
        );

    }

    public function paymentSuccess(Request $request, ZoomService $zoom)
    {
        $orderId = $request->order_id;
        $booking = SessionBooking::where('transaction_id', $orderId)->first();

        if (!$booking)
        {
            return redirect('/student/dashboard');

        }

        $response = Http::withHeaders([
            'x-client-id' => env('CASHFREE_API_KEY'),
            'x-client-secret' => env('CASHFREE_API_SECRET'),
            'x-api-version' => '2022-09-01',
        ])->get(env('CASHFREE_URL') . '/' . $orderId);

        if ($response['order_status'] == "PAID")
        {
             DB::beginTransaction();
            try {

                $startDateTime = Carbon::parse(
                    $booking->session_date . ' ' . $booking->start_time
                );

                $zoomMeeting = $zoom->createMeeting( 'Mentor Session', $startDateTime->toIso8601String(), $booking->duration_minutes);
                $booking->update([
                    'payment_status' => 'success',
                    'status' => 'accepted',
                    'zoom_meeting_id' => $zoomMeeting['id'] ?? null,
                    'zoom_join_url' => $zoomMeeting['join_url'] ?? null,
                    'zoom_start_url' => $zoomMeeting['start_url'] ?? null,
                    'zoom_password' => $zoomMeeting['password'] ?? null,
                ]);

                DB::commit();
                return redirect('/student/dashboard')->with('success', 'Session booked successfully');

            }
            catch (\Exception $e)
            {

                DB::rollBack();

                return redirect('/student/dashboard')
                    ->with('error', 'Zoom meeting creation failed');

            }

        }

        $booking->update([

            'payment_status' => 'failed',

        ]);

        return redirect('/student/dashboard')
            ->with('error', 'Payment failed');

    }

    public function paymentFailure(Request $request)
    {

        $orderId = $request->order_id;

        if (!$orderId)
        {

            return redirect('/student/dashboard')
                ->with('error', 'Invalid payment');

        }

        $booking =
        SessionBooking::where('transaction_id', $orderId)
            ->first();

        if ($booking)
        {

            $booking->update([

                'payment_status' => 'failed',

                'status' => 'pending',

            ]);

        }

        return redirect('/student/dashboard')
            ->with('error', 'Payment failed or cancelled');

    }

}
