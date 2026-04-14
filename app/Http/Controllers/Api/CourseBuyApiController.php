<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseBundle;
use App\Models\CourseBuy;
use App\Models\LearningCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function enrollBundleFreeApi(CourseBundle $bundle, Request $request)
    {
        if (!$bundle->is_free)
        {return response()->json([
                'status' => false,
                'message' => 'This bundle is not free',
            ], 403);
        }

        $userId = $request->user()->id;
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
            CourseBuy::create([
                'user_id' => $userId,
                'bundle_id' => $bundle->id,
                'learning_course_id' => null,
                'type' => 'bundle_free',
                'amount' => 0,
                'payment_status' => 'success',
                'purchased_at' => now(),
            ]);

            // bundle courses
            $courseIds = $bundle->courses->pluck('id')->toArray();
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




}
