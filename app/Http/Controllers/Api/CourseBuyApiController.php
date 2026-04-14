<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseBundle;
use App\Models\CourseBuy;
use App\Models\LearningCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CourseBuyApiController extends Controller
{

    public function enrollFree(LearningCourse $course, Request $request)
    {

        if (!$course->is_free)
        {
            return response()->json([
                'status' => false,
                'message' => 'This course is not free',
            ], 403);
        }

        $userId = $request->user()->id;

        $alreadyEnrolled = CourseBuy::
            where('user_id', $userId)
            ->where('learning_course_id', $course->id)
            ->exists();

        if ($alreadyEnrolled)
        {
            return response()->json([
                'status' => false,
                'message' => 'Already enrolled in this course',
            ]);
        }

        $order = CourseBuy::create([

            'user_id' => $userId,

            'learning_course_id' => $course->id,

            'type' => 'free',

            'amount' => 0,

            'payment_status' => 'success',

            'purchased_at' => now(),

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Course enrolled successfully',

            'data' => $order,

        ]);

    }

    public function enrollBundleFree($bundle_id, Request $request)
    {
        // find bundle
        $bundle = CourseBundle::with('courses')->find($bundle_id);
        if (!$bundle)
        {
            return response()->json([
                'status' => false,
                'message' => 'Bundle not found',
            ], 404);
        }

        // check bundle free or not
        if ((int) $bundle->is_free !== 1)
        {
            return response()->json([
                'status' => false,
                'message' => 'This bundle is not free',
            ], 403);
        }

        $userId = $request->user()->id;
        // check already enrolled bundle
        $alreadyPurchased = CourseBuy::
            where('user_id', $userId)
            ->where('bundle_id', $bundle->id)
            ->whereNull('learning_course_id')
            ->exists();

        if ($alreadyPurchased)
        {
            return response()->json([
                'status' => false,
                'message' => 'Already enrolled in this bundle',
            ]);
        }

        DB::beginTransaction();

        try {

            // insert main bundle record
            CourseBuy::create([
                'user_id' => $userId,
                'bundle_id' => $bundle->id,
                'learning_course_id' => null,
                'type' => 'bundle_free',
                'amount' => 0,
                'payment_status' => 'success',
                'purchased_at' => now(),
            ]);

            // get bundle course ids
            $courseIds = $bundle->courses->pluck('id')->toArray();
            // already enrolled courses
            $existingCourseIds = CourseBuy::
                where('user_id', $userId)
                ->whereIn('learning_course_id', $courseIds)
                ->pluck('learning_course_id')
                ->toArray();

            $insertData = [];

            foreach ($courseIds as $courseId)
            {
                if (!in_array($courseId, $existingCourseIds))
                {
                    $insertData[] = [
                        'user_id' => $userId,
                        'learning_course_id' => $courseId,
                        'bundle_id' => $bundle->id,
                        'type' => 'bundle_course',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                }

            }

            if (!empty($insertData))
            {
                CourseBuy::insert($insertData);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Bundle enrolled successfully',
                'bundle_id' => $bundle->id,
                'courses_added' => count($insertData),
            ]);

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);

        }

    }

    public function initiatePayment(Request $request, $course_id)
    {

        $user = $request->user();

        $course = LearningCourse::find($course_id);

        if (!$course)
        {
            return response()->json([
                'status' => false,
                'message' => 'Course not found',
            ], 404);
        }

        // already purchased
        $already = CourseBuy::
            where('user_id', $user->id)
            ->where('learning_course_id', $course->id)
            ->where('payment_status', 'success')
            ->exists();

        if ($already)
        {
            return response()->json([
                'status' => false,
                'message' => 'You already purchased this course',
            ]);
        }

        // FREE COURSE
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

            return response()->json([

                'status' => true,

                'message' => 'Free course activated',

                'data' => $courseBuy,

            ]);

        }

        // PAID COURSE

        $orderAmount = (float) $course->final_price;

        if ($orderAmount <= 0)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid course price',
            ]);
        }

        // remove old pending
        CourseBuy::
            where('user_id', $user->id)
            ->where('learning_course_id', $course->id)
            ->where('payment_status', 'pending')
            ->delete();

        $orderId = 'ORDER_' . Str::random(12);

        $courseBuy = CourseBuy::create([

            'user_id' => $user->id,

            'learning_course_id' => $course->id,

            'transaction_id' => $orderId,

            'type' => 'paid',

            'amount' => 0,

            'discount_amount' => max(0, $course->price - $orderAmount),

            'payment_status' => 'pending',

            'is_active' => false,

        ]);

        try {

            $response = Http::

                withHeaders([

                'x-client-id' => env('CASHFREE_API_KEY'),

                'x-client-secret' => env('CASHFREE_API_SECRET'),

                'x-api-version' => '2022-09-01',

                'Content-Type' => 'application/json',

            ])

                ->post(env('CASHFREE_URL'), [

                    "order_id" => $orderId,

                    "order_amount" => $orderAmount,

                    "order_currency" => "INR",

                    "customer_details" => [

                        "customer_id" => (string) $user->id,

                        "customer_name" => $user->name,

                        "customer_email" => $user->email,

                        "customer_phone" => $user->phone,

                    ],

                ]);

            if (!$response->successful())
            {
                throw new \Exception($response->body());
            }

            $paymentSessionId = $response->json('payment_session_id');

            return response()->json([

                'status' => true,

                'message' => 'Payment session created',

                'data' => [

                    'order_id' => $orderId,

                    'payment_session_id' => $paymentSessionId,

                    'amount' => $orderAmount,

                    'currency' => 'INR',

                ],

            ]);

        }
        catch (\Exception $e)
        {

            $courseBuy->update([

                'payment_status' => 'failed',

            ]);

            return response()->json([

                'status' => false,

                'message' => $e->getMessage(),

            ], 500);

        }

    }

    public function initiateBundlePayment(Request $request, $bundle_id)
    {

        $user = $request->user();

        $bundle = CourseBundle::find($bundle_id);

        if (!$bundle)
        {
            return response()->json([
                'status' => false,
                'message' => 'Bundle not found',
            ]);
        }

        // already purchased

        $already = CourseBuy::

            where('user_id', $user->id)

            ->where('bundle_id', $bundle->id)

            ->whereNull('learning_course_id')

            ->where('payment_status', 'success')

            ->exists();

        if ($already)
        {
            return response()->json([
                'status' => false,
                'message' => 'Bundle already purchased',
            ]);
        }

        // FREE BUNDLE

        if ($bundle->is_free)
        {

            CourseBuy::create([

                'user_id' => $user->id,

                'bundle_id' => $bundle->id,

                'type' => 'bundle_free',

                'amount' => 0,

                'payment_status' => 'success',

                'is_active' => true,

                'purchased_at' => now(),

            ]);

            return response()->json([

                'status' => true,

                'message' => 'Free bundle activated',

            ]);

        }

        $amount = (float) ($bundle->discount_price ?? $bundle->price);

        if ($amount <= 0)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid bundle price',
            ]);
        }

        // remove old pending

        CourseBuy::

            where('user_id', $user->id)

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

            $response = Http::

                withHeaders([

                'x-client-id' => env('CASHFREE_API_KEY'),

                'x-client-secret' => env('CASHFREE_API_SECRET'),

                'x-api-version' => '2022-09-01',

            ])

                ->post(env('CASHFREE_URL'), [

                    "order_id" => $orderId,

                    "order_amount" => $amount,

                    "order_currency" => "INR",

                    "customer_details" => [

                        "customer_id" => (string) $user->id,

                        "customer_name" => $user->name,

                        "customer_email" => $user->email,

                        "customer_phone" => $user->phone,

                    ],

                ]);

            $paymentSessionId = $response->json('payment_session_id');

            return response()->json([

                'status' => true,

                'message' => 'Bundle payment session created',

                'data' => [

                    'order_id' => $orderId,

                    'payment_session_id' => $paymentSessionId,

                    'amount' => $amount,

                    'currency' => 'INR',

                ],

            ]);

        }
        catch (\Exception $e)
        {

            $bundleBuy->update([

                'payment_status' => 'failed',

            ]);

            return response()->json([

                'status' => false,

                'message' => $e->getMessage(),

            ]);

        }

    }
}
