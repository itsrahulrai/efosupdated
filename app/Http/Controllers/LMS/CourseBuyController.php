<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseBuy;
use App\Models\LearningCourse;
use App\Models\CourseBundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CourseBuyController extends Controller
{

    /**
     * Enroll user in a FREE course
     */
    
    // public function enrollFree(LearningCourse $course)
    // {

    //     if (!$course->is_free)
    //     {
    //         abort(403, 'This course is not free.');
    //     }
    //     $alreadyEnrolled = CourseBuy::where('user_id', Auth::id())
    //         ->where('learning_course_id', $course->id)
    //         ->exists();

    //     if ($alreadyEnrolled)
    //     {
    //         return redirect()
    //             ->route('student.dashboard')
    //             ->with('error', 'You are already enrolled in this course. You can access it from your dashboard.');
    //     }
    //     CourseBuy::create([
    //         'user_id' => Auth::id(),
    //         'learning_course_id' => $course->id,
    //         'type' => 'free',
    //         'amount' => 0,
    //         'payment_status' => 'success',
    //         'purchased_at' => now(),
    //     ]);

    //     return redirect()
    //         ->route('student.dashboard')
    //         ->with('success', 'You have successfully enrolled in the course.');
    // }


     public function enrollFree(LearningCourse $course)
    {
        if (!$course->is_free)
        {
            abort(403, 'This course is not free.');
        }
        $alreadyEnrolled = CourseBuy::where('user_id', Auth::id())
            ->where('learning_course_id', $course->id)
            ->exists();

        if ($alreadyEnrolled)
        {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'You are already enrolled in this course. You can access it from your dashboard.');
        }
        CourseBuy::create([
            'user_id' => Auth::id(),
            'learning_course_id' => $course->id,
            'type' => 'free',
            'amount' => 0,
            'payment_status' => 'success',
            'purchased_at' => now(),
        ]);

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'You have successfully enrolled in the course.');
    }

      


       public function enrollBundleFree(CourseBundle $bundle)
        {
            if (!$bundle->is_free) {
                abort(403, 'This bundle is not free.');
            }

            $userId = Auth::id();

            // CHECK BUNDLE ALREADY PURCHASED
            $alreadyPurchased = CourseBuy::where('user_id', $userId)
                ->where('bundle_id', $bundle->id)
                ->whereNull('learning_course_id')
                ->exists();

            if ($alreadyPurchased) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'You already enrolled in this bundle.');
            }

            DB::beginTransaction();

            try {

                // INSERT MAIN BUNDLE ENTRY (IMPORTANT FIX)
                CourseBuy::create([
                    'user_id' => $userId,
                    'bundle_id' => $bundle->id,
                    'learning_course_id' => null,
                    'type' => 'bundle_free', // 🔥 FIXED
                    'amount' => 0,
                    'payment_status' => 'success',
                    'purchased_at' => now(),
                ]);

                // GET COURSE IDS
                $courseIds = $bundle->courses->pluck('id')->toArray();

                // ALREADY ENROLLED COURSES
                $existingCourseIds = CourseBuy::where('user_id', $userId)
                    ->whereIn('learning_course_id', $courseIds)
                    ->pluck('learning_course_id')
                    ->toArray();

                $insertData = [];

                foreach ($courseIds as $courseId) {

                    if (!in_array($courseId, $existingCourseIds)) {

                        $insertData[] = [
                            'user_id' => $userId,
                            'learning_course_id' => $courseId,
                            'bundle_id' => $bundle->id,
                            'type' => 'bundle_course', // 🔥 FIXED
                            'amount' => 0,
                            'payment_status' => 'success',
                            'purchased_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                if (!empty($insertData)) {
                    CourseBuy::insert($insertData);
                }

                DB::commit();

                return redirect()->route('student.dashboard')
                    ->with('success', 'Bundle enrolled successfully!');

            } catch (\Exception $e) {

                DB::rollback();

                \Log::error('Bundle Enroll Error: ' . $e->getMessage());

                return redirect()->back()
                    ->with('error', 'Something went wrong. Please try again.');
            }
        }


    /**
     * Paid course checkout
     */

    public function checkout(LearningCourse $course)
    {
        return view('frontend.checkout', compact('course'));
    }


    public function bundleCheckout(CourseBundle $bundle)
    {
        $bundle->load('courses'); 
        return view('frontend.bundle-checkout', compact('bundle'));
    }
   
  
    public function initiatePayment(Request $request, LearningCourse $course)
    {   
        // dd($request->all());

        $user = auth()->user();

        if (!$user)
        {
            return redirect()->route('login');
        }

        // Already purchased
        $alreadyEnrolled = CourseBuy::where('user_id', $user->id)
            ->where('learning_course_id', $course->id)
            ->where('payment_status', 'success')
            ->exists();

        if ($alreadyEnrolled)
        {
            return redirect()->route('student.dashboard')
                ->with('error', 'You already purchased this course.');
        }

        /*
        |--------------------------------------------------------------------------
        | FREE COURSE HANDLING
        |--------------------------------------------------------------------------
         */
        if ($course->is_free)
        {

            $courseBuy = CourseBuy::create([
                'user_id' => $user->id,
                'learning_course_id' => $course->id,
                'type' => 'free',
                'amount' => 0,
                'discount_amount' => 0,
                'payment_status' => 'success',
                'is_active' => true,
                'purchased_at' => now(),
            ]);

            return redirect()
                ->route('course.thankyou', $courseBuy->id)
                ->with('success', 'Free course activated successfully.');
        }

        /*
        |--------------------------------------------------------------------------
        | PAID COURSE
        |--------------------------------------------------------------------------
         */

        $orderAmount = (float) $course->final_price;

        if ($orderAmount <= 0)
        {
            return back()->with('error', 'Invalid course amount.');
        }

        // Remove old pending
        CourseBuy::where('user_id', $user->id)
            ->where('learning_course_id', $course->id)
            ->where('payment_status', 'pending')
            ->delete();

        $orderId = 'ORDER_' . Str::random(12);

        $courseBuy = CourseBuy::create([
            'user_id' => $user->id,
            'learning_course_id' => $course->id,
            'transaction_id' => $orderId,
            'type' => 'paid',
            'amount' => 0, // IMPORTANT: only update after success
            'discount_amount' => max(0, $course->price - $orderAmount),
            'payment_status' => 'pending',
            'is_active' => false,
        ]);

        try {

            $response = Http::timeout(15)->withHeaders([
                'x-client-id' => env('CASHFREE_API_KEY'),
                'x-client-secret' => env('CASHFREE_API_SECRET'),
                'x-api-version' => '2022-09-01',
                'Content-Type' => 'application/json',
            ])->post(env('CASHFREE_URL'), [
                "order_id" => $orderId,
                "order_amount" => $orderAmount,
                "order_currency" => "INR",
                "customer_details" => [
                    "customer_id" => (string) $user->id,
                    "customer_name" => $user->name,
                    "customer_email" => $user->email,
                    "customer_phone" => $user->phone ?? "9999999999",
                ],
                "order_meta" => [
                    "return_url" => route('payment.success') . "?order_id={order_id}",
                ],
            ]);

            if (!$response->successful())
            {
                throw new \Exception('Order creation failed: ' . $response->body());
            }

            $paymentSessionId = $response->json('payment_session_id');

            if (!$paymentSessionId)
            {
                throw new \Exception('Payment session ID missing');
            }

            return view('frontend.payment.cashfree-checkout', [
                'paymentSessionId' => $paymentSessionId,
                'cashfreeMode' => env('CASHFREE_MODE'),
            ]);

        }
        catch (\Exception $e)
        {

            \Log::error('Cashfree Order Error: ' . $e->getMessage());

            $courseBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return back()->with('error', 'Unable to initiate payment. Please try again.');
        }
    }
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId)
        {
            return redirect('/')->with('error', 'Invalid payment response.');
        }

        $courseBuy = CourseBuy::with('course')
            ->where('transaction_id', $orderId)
            ->first();

        if (!$courseBuy)
        {
            return redirect('/')->with('error', 'Order not found.');
        }

        if ($courseBuy->payment_status === 'success')
        {
            return redirect()->route('course.thankyou', $courseBuy->id);
        }

        try {

            $response = Http::timeout(15)->withHeaders([
                'x-client-id' => env('CASHFREE_API_KEY'),
                'x-client-secret' => env('CASHFREE_API_SECRET'),
                'x-api-version' => '2022-09-01',
            ])->get(env('CASHFREE_URL') . '/' . $orderId);

            if (!$response->successful())
            {
                throw new \Exception('Verification failed');
            }

            $orderStatus = $response->json('order_status');
            $paidAmount = (float) $response->json('order_amount');

            if ($orderStatus === "PAID")
            {

                DB::transaction(function () use ($courseBuy, $paidAmount)
                {

                    $courseBuy->update([
                        'payment_status' => 'success',
                        'is_active' => true,
                        'amount' => $paidAmount,
                        'discount_amount' => max(0, $courseBuy->course->price - $paidAmount),
                        'type' => 'paid',
                        'payment_gateway' => 'cashfree',
                        'purchased_at' => now(),
                    ]);
                });

                return redirect()->route('course.thankyou', $courseBuy->id);
            }

            // Not paid
            $courseBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return redirect()
                ->route('course.checkout', $courseBuy->learning_course_id)
                ->with('error', 'Payment not completed.');

        }
        catch (\Exception $e)
        {

            \Log::error('Cashfree Verification Error: ' . $e->getMessage());

            $courseBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return redirect()
                ->route('course.checkout', $courseBuy->learning_course_id)
                ->with('error', 'Payment verification failed.');
        }
    }

    public function paymentFailure(Request $request)
    {
        $orderId = $request->order_id;

        $courseBuy = CourseBuy::where('transaction_id', $orderId)->first();

        if ($courseBuy)
        {
            $courseBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return redirect()
                ->route('course.checkout', $courseBuy->learning_course_id)
                ->with('error', 'Payment failed. Please try again.');
        }

        return redirect('/')->with('error', 'Order not found.');
    }

    public function thankYou(CourseBuy $courseBuy)
    {
        $courseBuy->load('course');

        return view('frontend.thank-you', compact('courseBuy'));
    }


     /**
     * Bundle Course checkout
     */

    public function initiateBundlePayment(Request $request, CourseBundle $bundle)
    {
        // dd($request->all());


        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Already purchased check
        $alreadyPurchased = CourseBuy::where('user_id', $user->id)
            ->where('bundle_id', $bundle->id)
            ->whereNull('learning_course_id')
            ->where('payment_status', 'success')
            ->exists();

        if ($alreadyPurchased) {
            return redirect()->route('student.dashboard')
                ->with('error', 'You already purchased this bundle.');
        }

        /*
        |-------------------------
        | FREE BUNDLE
        |-------------------------
        */
        if ($bundle->is_free) {

            CourseBuy::create([
                'user_id' => $user->id,
                'bundle_id' => $bundle->id,
                'type' => 'bundle_free',
                'amount' => 0,
                'payment_status' => 'success',
                'is_active' => true,
                'purchased_at' => now(),
            ]);

            return redirect()->route('student.dashboard')
                ->with('success', 'Free bundle activated.');
        }

        /*
        |-------------------------
        | PAID BUNDLE
        |-------------------------
        */

        $amount = (float) ($bundle->discount_price ?? $bundle->price);

        if ($amount <= 0) {
            return back()->with('error', 'Invalid bundle amount.');
        }

        // Remove old pending
        CourseBuy::where('user_id', $user->id)
            ->where('bundle_id', $bundle->id)
            ->where('payment_status', 'pending')
            ->delete();

        $orderId = 'BUNDLE_' . Str::random(12);

        $bundleBuy = CourseBuy::create([
            'user_id' => $user->id,
            'bundle_id' => $bundle->id,
            'transaction_id' => $orderId,
            'type' => 'bundle_paid',
            'amount' => 0,
            'payment_status' => 'pending',
            'is_active' => false,
        ]);

        try {

            $response = Http::timeout(15)->withHeaders([
                'x-client-id' => env('CASHFREE_API_KEY'),
                'x-client-secret' => env('CASHFREE_API_SECRET'),
                'x-api-version' => '2022-09-01',
                'Content-Type' => 'application/json',
            ])->post(env('CASHFREE_URL'), [
                "order_id" => $orderId,
                "order_amount" => $amount,
                "order_currency" => "INR",
                "customer_details" => [
                    "customer_id" => (string) $user->id,
                    "customer_name" => $user->name,
                    "customer_email" => $user->email,
                    "customer_phone" => $user->phone ?? "9999999999",
                ],
                "order_meta" => [
                    "return_url" => route('bundle.payment.success') . "?order_id={order_id}",
                ],
            ]);

            // dd($response->json());

            $paymentSessionId = $response->json('payment_session_id');



            return view('frontend.payment.cashfree-checkout', [
                'paymentSessionId' => $paymentSessionId,
                'cashfreeMode' => env('CASHFREE_MODE'),
            ]);

        } catch (\Exception $e) {

            \Log::error('Bundle Payment Error: ' . $e->getMessage());

            $bundleBuy->update([
                'payment_status' => 'failed',
            ]);

            return back()->with('error', 'Payment failed.');
        }
    }

    public function bundlePaymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect('/')->with('error', 'Invalid payment response.');
        }

        $bundleBuy = CourseBuy::where('transaction_id', $orderId)->first();

        if (!$bundleBuy) {
            return redirect('/')->with('error', 'Order not found.');
        }

        if ($bundleBuy->payment_status === 'success') {
            return redirect()->route('bundle.thankyou', $bundleBuy->id);
        }

        try {

            $response = Http::withHeaders([
                'x-client-id' => env('CASHFREE_API_KEY'),
                'x-client-secret' => env('CASHFREE_API_SECRET'),
                'x-api-version' => '2022-09-01',
            ])->get(env('CASHFREE_URL') . '/' . $orderId);

            $status = $response->json('order_status');
            $amount = (float) $response->json('order_amount');

            if ($status === "PAID") {

                DB::transaction(function () use ($bundleBuy, $amount) {

                    $bundleBuy->update([
                        'payment_status' => 'success',
                        'is_active' => true,
                        'amount' => $amount,
                        'type' => 'bundle_paid',
                        'payment_gateway' => 'cashfree',
                        'purchased_at' => now(),
                    ]);

                    // 🔥 AUTO INSERT BUNDLE COURSES
                    $bundle = CourseBundle::with('courses')->find($bundleBuy->bundle_id);

                    foreach ($bundle->courses as $course) {
                        CourseBuy::firstOrCreate([
                            'user_id' => $bundleBuy->user_id,
                            'learning_course_id' => $course->id,
                            'bundle_id' => $bundle->id,
                        ], [
                            'type' => 'bundle_course',
                            'amount' => 0,
                            'payment_status' => 'success',
                            'is_active' => true,
                            'purchased_at' => now(),
                        ]);
                    }

                });

                return redirect()->route('bundle.thankyou', $bundleBuy->id);
            }

            $bundleBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return redirect()->route('bundle.course.checkout', $bundleBuy->bundle_id)
                ->with('error', 'Payment not completed.');

        } catch (\Exception $e) {

            \Log::error('Bundle Verify Error: ' . $e->getMessage());

            return redirect()->route('bundle.course.checkout', $bundleBuy->bundle_id)
                ->with('error', 'Payment verification failed.');
        }
    }

   
    public function bundlePaymentFailure(Request $request)
    {
        $orderId = $request->order_id;

        $bundleBuy = CourseBuy::where('transaction_id', $orderId)->first();

        if ($bundleBuy) {
            $bundleBuy->update([
                'payment_status' => 'failed',
                'is_active' => false,
            ]);

            return redirect()->route('bundle.course.checkout', $bundleBuy->bundle_id)
                ->with('error', 'Payment failed.');
        }

        return redirect('/')->with('error', 'Order not found.');
    }


    public function bundleThankYou(CourseBuy $courseBuy)
    {
        // Load bundle + courses
        $courseBuy->load([
            'bundle.courses'
        ]);

        return view('frontend.bundle-thank-you', compact('courseBuy'));
    }
    
    }
