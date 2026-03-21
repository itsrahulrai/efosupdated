<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\AssignedCourse;
use App\Models\CourseBundle;
use App\Models\CourseBuy;
use App\Models\LearningCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssignedCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignedCourses = AssignedCourse::with(['student', 'course', 'bundle.courses'])->latest()->paginate(10);
        return view('backend.lms.assignedcourse.index', compact('assignedCourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $courses = LearningCourse::where('status', 1)->orderBy('title')->get();
        $bundles = CourseBundle::where('status', 1)->orderBy('title')->get();

        return view('backend.lms.assignedcourse.create', compact('students', 'courses', 'bundles'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id' => 'nullable|required_without:bundle_id',
            'bundle_id' => 'nullable|required_without:course_id',
        ]);

        DB::beginTransaction();

        try {

            $student = Student::select('id', 'user_id')->findOrFail($request->student_id);
            $studentId = $student->id;
            $userId = $student->user_id;
            $assignedAt = $request->assigned_at ?? now();

            // ======================================================
            //  CASE 1: SINGLE COURSE (UPDATED)
            // ======================================================
            if ($request->course_id)
            {

                // already assigned directly
                if (AssignedCourse::where('student_id', $studentId)
                    ->where('course_id', $request->course_id)
                    ->exists())
                {

                    return back()->with('error', 'This course already assigned.');
                }

                // already bought directly
                if (CourseBuy::where('user_id', $userId)
                    ->where('learning_course_id', $request->course_id)
                    ->exists())
                {

                    return back()->with('error', 'Student already enrolled in this course.');
                }

                // NEW: check inside assigned bundles
                $bundleCourseExists = CourseBuy::where('user_id', $userId)
                    ->whereNotNull('bundle_id')
                    ->whereNull('learning_course_id') // only bundle main rows
                    ->whereHas('bundle.courses', function ($q) use ($request)
                {
                        $q->where('learning_courses.id', $request->course_id);
                    })
                    ->exists();

                if ($bundleCourseExists)
                {
                    return back()->with('error', 'This course is already included in an assigned bundle.');
                }

                // assigned_courses
                AssignedCourse::create([
                    'student_id' => $studentId,
                    'course_id' => $request->course_id,
                    'bundle_id' => null,
                    'assigned_by' => auth()->id(),
                    'assigned_at' => $assignedAt,
                    'status' => 1,
                ]);

                //  course_buys
                CourseBuy::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'learning_course_id' => $request->course_id,
                    ],
                    [
                        'bundle_id' => null,
                        'type' => 'admin_assign_course',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                    ]
                );
            }

            // ======================================================
            // CASE 2: BUNDLE (NO CHANGE)
            // ======================================================
            if ($request->bundle_id)
            {

                $bundle = CourseBundle::with('courses:id')->findOrFail($request->bundle_id);

                if (AssignedCourse::where('student_id', $studentId)
                    ->where('bundle_id', $bundle->id)
                    ->whereNull('course_id')
                    ->exists())
                {

                    return back()->with('error', 'This bundle already assigned.');
                }

                AssignedCourse::create([
                    'student_id' => $studentId,
                    'course_id' => null,
                    'bundle_id' => $bundle->id,
                    'assigned_by' => auth()->id(),
                    'assigned_at' => $assignedAt,
                    'status' => 1,
                ]);

                CourseBuy::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'bundle_id' => $bundle->id,
                        'learning_course_id' => null,
                    ],
                    [
                        'type' => 'admin_assign_bundle',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                    ]
                );

                $courseIds = $bundle->courses->pluck('id')->toArray();

                $existing = CourseBuy::where('user_id', $userId)
                    ->whereIn('learning_course_id', $courseIds)
                    ->pluck('learning_course_id')
                    ->toArray();

                $insertData = [];

                foreach ($courseIds as $courseId)
                {
                    if (in_array($courseId, $existing))
                    {
                        continue;
                    }

                    $insertData[] = [
                        'user_id' => $userId,
                        'learning_course_id' => $courseId,
                        'bundle_id' => $bundle->id,
                        'type' => 'bundle_course',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if ($insertData)
                {
                    CourseBuy::insert($insertData);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.assigned-course.index')
                ->with('success', 'Assignment successful.');

        }
        catch (\Illuminate\Database\QueryException $e)
        {

            DB::rollBack();

            if ($e->errorInfo[1] == 1062)
            {
                return back()->with('error', 'Student already enrolled.');
            }

            \Log::error('Assign Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong.');
        }
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
    public function edit($id)
    {

        $assignedCourse = AssignedCourse::findOrFail($id);

        $students = Student::orderBy('name')->get();

        $courses = LearningCourse::where('status', 1)
            ->orderBy('title')
            ->get();

        $bundles = CourseBundle::where('status', 1)->orderBy('title')->get();

        return view('backend.lms.assignedcourse.create',
            compact('assignedCourse', 'students', 'courses', 'bundles'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id' => 'nullable|required_without:bundle_id',
            'bundle_id' => 'nullable|required_without:course_id',
        ]);

        DB::beginTransaction();

        try {

            $assignedCourse = AssignedCourse::findOrFail($id);

            $student = Student::select('id', 'user_id')->findOrFail($request->student_id);
            $studentId = $student->id;
            $userId = $student->user_id;
            $assignedAt = $request->assigned_at ?? now();

            // ======================================
            //  DELETE OLD DATA
            // ======================================
            CourseBuy::where('user_id', $userId)
                ->where(function ($q) use ($assignedCourse)
            {
                    $q->where('learning_course_id', $assignedCourse->course_id)
                        ->orWhere('bundle_id', $assignedCourse->bundle_id);
                })
                ->delete();

            $assignedCourse->delete();

            // ======================================================
            // CASE 1: SINGLE COURSE (UPDATED)
            // ======================================================
            if ($request->course_id)
            {

                // already assigned
                if (AssignedCourse::where('student_id', $studentId)
                    ->where('course_id', $request->course_id)
                    ->exists())
                {

                    return back()->with('error', 'This course already assigned.');
                }

                // already bought
                if (CourseBuy::where('user_id', $userId)
                    ->where('learning_course_id', $request->course_id)
                    ->exists())
                {

                    return back()->with('error', 'Student already enrolled in this course.');
                }

                // check bundle contains this course
                $bundleCourseExists = CourseBuy::where('user_id', $userId)
                    ->whereNotNull('bundle_id')
                    ->whereNull('learning_course_id')
                    ->whereHas('bundle.courses', function ($q) use ($request)
                {
                        $q->where('learning_courses.id', $request->course_id);
                    })
                    ->exists();

                if ($bundleCourseExists)
                {
                    return back()->with('error', 'This course is already included in an assigned bundle.');
                }

                // assigned_courses
                AssignedCourse::create([
                    'student_id' => $studentId,
                    'course_id' => $request->course_id,
                    'bundle_id' => null,
                    'assigned_by' => auth()->id(),
                    'assigned_at' => $assignedAt,
                    'status' => 1,
                ]);

                // course_buys
                CourseBuy::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'learning_course_id' => $request->course_id,
                    ],
                    [
                        'bundle_id' => null,
                        'type' => 'admin_assign_course',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                    ]
                );
            }

            // ======================================================
            // CASE 2: BUNDLE
            // ======================================================
            if ($request->bundle_id)
            {

                $bundle = CourseBundle::with('courses:id')->findOrFail($request->bundle_id);

                // duplicate bundle
                if (AssignedCourse::where('student_id', $studentId)
                    ->where('bundle_id', $bundle->id)
                    ->whereNull('course_id')
                    ->exists())
                {

                    return back()->with('error', 'This bundle already assigned.');
                }

                //  assigned_courses
                AssignedCourse::create([
                    'student_id' => $studentId,
                    'course_id' => null,
                    'bundle_id' => $bundle->id,
                    'assigned_by' => auth()->id(),
                    'assigned_at' => $assignedAt,
                    'status' => 1,
                ]);

                // bundle main entry
                CourseBuy::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'bundle_id' => $bundle->id,
                        'learning_course_id' => null,
                    ],
                    [
                        'type' => 'admin_assign_bundle',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                    ]
                );

                $courseIds = $bundle->courses->pluck('id')->toArray();

                $existing = CourseBuy::where('user_id', $userId)
                    ->whereIn('learning_course_id', $courseIds)
                    ->pluck('learning_course_id')
                    ->toArray();

                $insertData = [];

                foreach ($courseIds as $courseId)
                {

                    if (in_array($courseId, $existing))
                    {
                        continue;
                    }

                    $insertData[] = [
                        'user_id' => $userId,
                        'learning_course_id' => $courseId,
                        'bundle_id' => $bundle->id,
                        'type' => 'bundle_course',
                        'amount' => 0,
                        'payment_status' => 'success',
                        'purchased_at' => $assignedAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if ($insertData)
                {
                    CourseBuy::insert($insertData);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.assigned-course.index')
                ->with('success', 'Updated successfully.');

        }
        catch (\Illuminate\Database\QueryException $e)
        {

            DB::rollBack();

            if ($e->errorInfo[1] == 1062)
            {
                return back()->with('error', 'Student already enrolled.');
            }

            \Log::error('Update Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $assignedCourse = AssignedCourse::findOrFail($id);

            $userId = Student::where('id', $assignedCourse->student_id)
                ->value('user_id');

            CourseBuy::where('user_id', $userId)
                ->where(function ($query) use ($assignedCourse)
            {

                    // single course
                    if ($assignedCourse->course_id)
                {
                        $query->where('learning_course_id', $assignedCourse->course_id);
                    }

                    // bundle
                    if ($assignedCourse->bundle_id)
                {
                        $query->orWhere('bundle_id', $assignedCourse->bundle_id);
                    }
                })
            // only delete admin-related data (IMPORTANT)
              ->whereIn('type', [
                    'admin_assign', 
                    'admin_assign_bundle',
                    'bundle_course',
                ])
                                ->delete();
            $assignedCourse->delete();

            DB::commit();

            return redirect()
                ->route('admin.assigned-course.index')
                ->with('success', 'Assignment removed successfully.');

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            \Log::error('Delete Error:', [
                'message' => $e->getMessage(),
                'id' => $id,
            ]);

            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Download Bulk Assign Template
     */

    public function downloadBulkAssignTemplate()
    {
        // Fetch data
        $courses = LearningCourse::pluck('title')->toArray();
        $bundles = CourseBundle::pluck('title')->toArray();

        $spreadsheet = new Spreadsheet();

        // =========================
        // MAIN SHEET
        // =========================
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Assignments');

        $headers = ['Email', 'Phone', 'Course', 'Bundle'];
        $sheet->fromArray($headers, null, 'A1');

        // =========================
        // COURSE LIST SHEET
        // =========================
        $courseSheet = $spreadsheet->createSheet();
        $courseSheet->setTitle('CourseList');

        foreach ($courses as $i => $course)
        {
            $courseSheet->setCellValue('A' . ($i + 1), $course);
        }

        // =========================
        // BUNDLE LIST SHEET
        // =========================
        $bundleSheet = $spreadsheet->createSheet();
        $bundleSheet->setTitle('BundleList');

        foreach ($bundles as $i => $bundle)
        {
            $bundleSheet->setCellValue('A' . ($i + 1), $bundle);
        }

        // =========================
        // APPLY DROPDOWNS
        // =========================
        for ($row = 2; $row <= 200; $row++)
        {

            // COURSE DROPDOWN (Column C)
            $courseValidation = $sheet->getCell('C' . $row)->getDataValidation();
            $courseValidation->setType(DataValidation::TYPE_LIST);
            $courseValidation->setAllowBlank(true);
            $courseValidation->setShowDropDown(true);
            $courseValidation->setFormula1('CourseList!$A$1:$A$' . count($courses));

            // BUNDLE DROPDOWN (Column D)
            $bundleValidation = $sheet->getCell('D' . $row)->getDataValidation();
            $bundleValidation->setType(DataValidation::TYPE_LIST);
            $bundleValidation->setAllowBlank(true);
            $bundleValidation->setShowDropDown(true);
            $bundleValidation->setFormula1('BundleList!$A$1:$A$' . count($bundles));
        }

        // =========================
        // HIDE HELPER SHEETS
        // =========================
        $courseSheet->setSheetState(
            \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
        );

        $bundleSheet->setSheetState(
            \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
        );

        // =========================
        // DOWNLOAD
        // =========================
        $fileName = "bulk-assign-template.xlsx";

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        $writer->save("php://output");
    }

    /**
     * Bulk Assign Cousre or Bundle
     */

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        DB::beginTransaction();

        try {

            //Load Excel
            $spreadsheet = IOFactory::load($request->file('file')->getPathname());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            if (count($rows) <= 1)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Excel file empty or invalid',
                ]);
            }

            // Preload data (FAST)
            $courses = LearningCourse::pluck('id', DB::raw('LOWER(title)'))->toArray();
            $bundles = CourseBundle::pluck('id', DB::raw('LOWER(title)'))->toArray();

            $students = Student::select('id', 'user_id', 'email', 'phone')->get();

            //normalize student data
            $studentMap = [];
            foreach ($students as $s)
            {
                if ($s->email)
                {
                    $studentMap['email_' . strtolower($s->email)] = $s;
                }
                if ($s->phone)
                {
                    $cleanPhone = preg_replace('/\D/', '', $s->phone);
                    $studentMap['phone_' . $cleanPhone] = $s;
                }
            }

            $success = 0;
            $failed = [];
            $assignedAt = now()->format('Y-m-d H:i:s');

            foreach ($rows as $index => $row)
            {

                if ($index === 0)
                {
                    continue;
                }

                $email = trim($row[0] ?? '');
                $phone = trim($row[1] ?? '');
                $courseName = strtolower(trim($row[2] ?? ''));
                $bundleName = strtolower(trim($row[3] ?? ''));

                // skip empty row
                if (!$email && !$phone && !$courseName && !$bundleName)
                {
                    continue;
                }

                if (!$email && !$phone)
                {
                    $failed[] = "Row " . ($index + 1) . ": Email/Phone missing";
                    continue;
                }

                // ======================================================
                // FIND STUDENT (FROM MEMORY - FAST)
                // ======================================================
                $student = null;

                if ($email && isset($studentMap['email_' . strtolower($email)]))
                {
                    $student = $studentMap['email_' . strtolower($email)];
                }
                elseif ($phone)
                {
                    $cleanPhone = preg_replace('/\D/', '', $phone);
                    $student = $studentMap['phone_' . $cleanPhone] ?? null;
                }

                if (!$student)
                {
                    $failed[] = "Row " . ($index + 1) . ": Student not found";
                    continue;
                }

                $studentId = $student->id;
                $userId = $student->user_id;

                // ======================================================
                // NAME → ID
                // ======================================================
                $courseId = $courseName ? ($courses[$courseName] ?? null) : null;
                $bundleId = $bundleName ? ($bundles[$bundleName] ?? null) : null;

                if ($courseName && !$courseId)
                {
                    $failed[] = "Row " . ($index + 1) . ": Course not found - $courseName";
                    continue;
                }

                if ($bundleName && !$bundleId)
                {
                    $failed[] = "Row " . ($index + 1) . ": Bundle not found - $bundleName";
                    continue;
                }

                if ($courseId && $bundleId)
                {
                    $failed[] = "Row " . ($index + 1) . ": दोनों नहीं allowed";
                    continue;
                }

                // ======================================================
                // COURSE ASSIGN
                // ======================================================
                if ($courseId)
                {

                    AssignedCourse::firstOrCreate(
                        [
                            'student_id' => $studentId,
                            'course_id' => $courseId,
                            'bundle_id' => null,
                        ],
                        [
                            'assigned_by' => auth()->id(),
                            'assigned_at' => $assignedAt,
                            'status' => 1,
                        ]
                    );

                    CourseBuy::firstOrCreate(
                        [
                            'user_id' => $userId,
                            'learning_course_id' => $courseId,
                        ],
                        [
                            'bundle_id' => null,
                            'type' => 'admin_assign_course',
                            'amount' => 0,
                            'payment_status' => 'success',
                            'purchased_at' => $assignedAt,
                        ]
                    );

                    $success++;
                }

                // ======================================================
                // BUNDLE ASSIGN
                // ======================================================
                if ($bundleId)
                {

                    AssignedCourse::firstOrCreate(
                        [
                            'student_id' => $studentId,
                            'bundle_id' => $bundleId,
                            'course_id' => null,
                        ],
                        [
                            'assigned_by' => auth()->id(),
                            'assigned_at' => $assignedAt,
                            'status' => 1,
                        ]
                    );

                    CourseBuy::firstOrCreate(
                        [
                            'user_id' => $userId,
                            'bundle_id' => $bundleId,
                            'learning_course_id' => null,
                        ],
                        [
                            'type' => 'admin_assign_bundle',
                            'amount' => 0,
                            'payment_status' => 'success',
                            'purchased_at' => $assignedAt,
                        ]
                    );

                    $success++;
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "$success records imported successfully",
                'failed' => $failed,
            ]);

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            \Log::error('Import Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Import failed',
            ]);
        }
    }
}
