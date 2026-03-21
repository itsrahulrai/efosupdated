<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseBuy;

class CourseOrderController extends Controller
{

    public function courseOrder()
    {
        $courseOrders = CourseBuy::with(['user', 'course'])
            ->latest()
            ->paginate(10);

        return view('backend.lms.course.orders.index', compact('courseOrders'));
    }

    public function destroyOrder(string $id)
    {
        $course = CourseBuy::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.course.orders')
            ->with('success', 'Course Order deleted successfully');
    }
}
