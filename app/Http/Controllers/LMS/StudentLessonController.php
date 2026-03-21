<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\LessonProgress;

class StudentLessonController extends Controller
{
    public function markComplete($lessonId)
    {
        $user = auth()->user();

        $lesson = CourseLesson::findOrFail($lessonId);

        LessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'course_id' => $lesson->course_id,
            ],
            [
                'is_completed' => 1,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson completed successfully.',
        ]);
    }
}
