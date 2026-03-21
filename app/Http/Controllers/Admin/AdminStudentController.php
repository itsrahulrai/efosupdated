<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\FranchiseProfile;
use App\Models\Student;
use App\Models\User;
use App\Models\StudentExperience;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentRegisteredMail;



class AdminStudentController extends Controller
{

    use ImageUploadTrait;

    //  public function index()
    // {
    //     $students = Student::latest()->paginate(10);

    //     return view('backend.students.index',compact('students'));
    // }

    public function index(Request $request)
    {
        $students = Student::query();

        // SEARCH
        if ($request->filled('search'))
        {
            $search = $request->search;
            $students->where(function ($q) use ($search)
            {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        // LOOKING FOR FILTER
        if ($request->filled('looking_for'))
        {
            $students->where('looking_for', $request->looking_for);
        }

        // STATUS FILTER
        if ($request->filled('profile_completed'))
        {
            $students->where('profile_completed', $request->profile_completed);
        }

        $students = $students->latest()->paginate(50)->withQueryString();

        $franchises = FranchiseProfile::where('status', 'approved')
            ->where('is_active', 1)
            ->orderBy('company_name')
            ->get();

        return view('backend.students.index', compact('students', 'franchises'));
    }

    public function storeAssignedFranchise(Request $request, Student $student)
    {
        $request->validate([
            'franchise_id' => 'required|exists:franchise_profiles,id',
        ]);

        $student->update([
            'franchise_id' => $request->franchise_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student assigned to franchise successfully',
        ]);
    }

    public function create()
    {
        $student = new Student(); // empty model
        return view('backend.students.create', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('backend.students.create', compact('student'));
    }

    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
        ]);

        DB::beginTransaction();

        // ================= REGISTRATION NUMBER GENERATION =================
        $lastStudent = Student::where('registration_number', 'like', 'EFOS%')
            ->orderBy('id', 'desc')
            ->lockForUpdate() // prevents duplicate in concurrent requests
            ->first();

        if ($lastStudent && $lastStudent->registration_number)
        {
            $lastNumber = (int) str_replace('EFOS', '', $lastStudent->registration_number);
            $nextNumber = $lastNumber + 1;
        }
        else
        {
            $nextNumber = 1;
        }

        $registrationNumber = 'EFOS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Log::info('Generated registration number', [
            'registration_number' => $registrationNumber,
        ]);

        try {

            Log::info('Student store started', [
                'user_id' => auth()->id(),
                'email' => $request->email,
            ]);

            /* ================= CREATE STUDENT ================= */
            $student = Student::create([
                'user_id' => auth()->id(),
                'registration_number' => $registrationNumber,

                // BASIC
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'age_group' => $request->age_group,
                'gender' => $request->gender,
                'state' => $request->state,
                'district' => $request->district,
                'present_status' => $request->present_status,
                'looking_for' => $request->looking_for,

                // PROFILE
                'profile_summary' => $request->profile_summary,

                // PERSONAL
                'pincode' => $request->pincode,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'category' => $request->category,
                'address' => $request->address,

                // EDUCATION
                'highest_qualification' => $request->highest_qualification,

                // 10th
                'tenth_board' => $request->tenth_board,
                'tenth_year' => $request->tenth_year,
                'tenth_marks' => $request->tenth_marks,
                'tenth_stream' => $request->tenth_stream,

                // 12th
                'twelfth_board' => $request->twelfth_board,
                'twelfth_year' => $request->twelfth_year,
                'twelfth_marks' => $request->twelfth_marks,
                'twelfth_stream' => $request->twelfth_stream,

                // Graduation
                'graduation_university' => $request->graduation_university,
                'graduation_year' => $request->graduation_year,
                'graduation_marks' => $request->graduation_marks,
                'graduation_stream' => $request->graduation_stream,
                'graduation_field' => $request->graduation_field,

                // PG
                'pg_university' => $request->pg_university,
                'pg_year' => $request->pg_year,
                'pg_marks' => $request->pg_marks,
                'pg_stream' => $request->pg_stream,
                'pg_field' => $request->pg_field,

                // SKILL
                'skill_type' => $request->skill_type,
                'skill_trade' => $request->skill_trade,
                'skill_year' => $request->skill_year,

                // JOB
                'experience_type' => $request->experience_type,

                // OTHER
                'passport' => $request->passport,
                'relocation' => $request->relocation,
                'blood_group' => $request->blood_group,

                'profile_completed' => true,
            ]);

            Log::info('Student created successfully', [
                'student_id' => $student->id,
            ]);

            /* ================= PHOTO UPLOAD ================= */
            if ($request->hasFile('photo'))
            {

                Log::info('Uploading student photo', [
                    'student_id' => $student->id,
                ]);

                $student->photo = $this->updateImage(
                    $request,
                    'photo',
                    'uploads/students',
                    null
                );

                $student->save();
            }

            /* ================= JOB EXPERIENCES ================= */
            if (
                $request->experience_type === 'Experienced' &&
                is_array($request->company_name)
            )
            {

                Log::info('Processing job experiences', [
                    'student_id' => $student->id,
                    'companies' => $request->company_name,
                ]);

                foreach ($request->company_name as $index => $company)
                {

                    if (!empty($company))
                    {

                        StudentExperience::create([
                            'student_id' => $student->id,
                            'company_name' => $company,
                            'job_profile' => $request->job_profile[$index] ?? null,
                            'job_duration' => $request->job_duration[$index] ?? null,
                            'job_state' => $request->job_state[$index] ?? null,
                            'job_district' => $request->job_district[$index] ?? null,
                            'salary_range' => $request->salary_range[$index] ?? null,
                            'job_summary' => $request->job_summary[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            Log::info('Student store completed', [
                'student_id' => $student->id,
            ]);

            return redirect()
                ->route('admin.all.students')
                ->with('success', 'Student created successfully');

        }
        catch (\Exception $e)
        {

            DB::rollBack();

            Log::error('Student store failed', [
                'user_id' => auth()->id(),
                'request_data' => $request->except(['photo']),
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->with('error', 'Something went wrong!')
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // exit;

        $student = Student::findOrFail($id);

        DB::beginTransaction();

        try {

            /* ================= PHOTO UPDATE ================= */
            if ($request->hasFile('photo'))
            {
                Log::info('Updating student photo', ['student_id' => $student->id]);

                $student->photo = $this->updateImage(
                    $request,
                    'photo',
                    'uploads/students',
                    $student->photo
                );
            }

            /* ================= UPDATE STUDENT ================= */
            Log::info('Updating student main data', ['student_id' => $student->id]);

            $student->update([

                'name' => $request->name,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'age_group' => $request->age_group,
                'gender' => $request->gender,
                'state' => $request->state,
                'district' => $request->district,
                'present_status' => $request->present_status,
                'looking_for' => $request->looking_for,
                'profile_summary' => $request->profile_summary,
                'pincode' => $request->pincode,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'category' => $request->category,
                'address' => $request->address,
                'highest_qualification' => $request->highest_qualification,
                'tenth_board' => $request->tenth_board,
                'tenth_year' => $request->tenth_year,
                'tenth_marks' => $request->tenth_marks,
                'tenth_stream' => $request->tenth_stream,
                'twelfth_board' => $request->twelfth_board,
                'twelfth_year' => $request->twelfth_year,
                'twelfth_marks' => $request->twelfth_marks,
                'twelfth_stream' => $request->twelfth_stream,
                'graduation_university' => $request->graduation_university,
                'graduation_year' => $request->graduation_year,
                'graduation_marks' => $request->graduation_marks,
                'graduation_stream' => $request->graduation_stream,
                'graduation_field' => $request->graduation_field,
                'pg_university' => $request->pg_university,
                'pg_year' => $request->pg_year,
                'pg_marks' => $request->pg_marks,
                'pg_stream' => $request->pg_stream,
                'pg_field' => $request->pg_field,
                'skill_type' => $request->skill_type,
                'skill_trade' => $request->skill_trade,
                'skill_year' => $request->skill_year,
                'experience_type' => $request->experience_type,
                'passport' => $request->passport,
                'relocation' => $request->relocation,
                'blood_group' => $request->blood_group,
                'profile_completed' => true,
            ]);

            Log::info('Student main data updated', ['student_id' => $student->id]);

            /* ================= JOB EXPERIENCES ================= */
            Log::info('Deleting old job experiences', ['student_id' => $student->id]);

            StudentExperience::where('student_id', $student->id)->delete();

            if ($request->experience_type === 'Experienced' && is_array($request->company_name))
            {

                foreach ($request->company_name as $index => $company)
                {
                    if (!empty($company))
                    {
                        Log::info('Creating job experience', [
                            'student_id' => $student->id,
                            'company' => $company,
                        ]);

                        StudentExperience::create([
                            'student_id' => $student->id,
                            'company_name' => $company,
                            'job_profile' => $request->job_profile[$index] ?? null,
                            'job_duration' => $request->job_duration[$index] ?? null,
                            'job_state' => $request->job_state[$index] ?? null,
                            'job_district' => $request->job_district[$index] ?? null,
                            'salary_range' => $request->salary_range[$index] ?? null,
                            'job_summary' => $request->job_summary[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            Log::info('Student update committed successfully', ['student_id' => $student->id]);

            return redirect()
                ->route('admin.all.students')
                ->with('success', 'Student updated successfully');

        }
        catch (\Throwable $e)
        {

            DB::rollBack();

            Log::error('Student update FAILED', [
                'student_id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong! Check logs.')
                ->withInput();
        }
    }
    
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.all.students')
            ->with('success', 'Student deleted successfully');
    }

    public function documents(Student $student)
    {
        $student->load('documents');

        return view('backend.students.documents', compact('student'));
    }

    public function uploadDocuments(Request $request, Student $student)
    {
        $request->validate([
            'documents.*.title' => 'required|string|max:255',
            'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $uploadPath = public_path('uploads/documents');
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }

        foreach ($request->documents as $doc)
        {

            $file = $doc['file'];
            $extension = $file->extension();
            $sizeKB = round($file->getSize() / 1024);

            $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $extension;
            $file->move($uploadPath, $fileName);

            Document::create([
                'user_id' => $student->user_id,
                'student_id' => $student->id,
                'title' => $doc['title'],
                'file_path' => 'uploads/documents/' . $fileName,
                'file_type' => $extension,
                'file_size' => $sizeKB,
            ]);
        }

        return back()->with('success', 'Documents uploaded successfully.');
    }

    public function deleteDocument(Document $document)
    {
        $filePath = public_path($document->file_path);

        if (file_exists($filePath))
        {
            unlink($filePath);
        }
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function updateProfileStatus(Request $request, Student $student)
    {
        $request->validate([
            'profile_completed' => 'required|in:pending,processing,completed,rejected,on_hold',
        ]);

        $student->update([
            'profile_completed' => $request->profile_completed,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }




public function downloadStudentBulkAssignTemplate()
{
    $spreadsheet = new Spreadsheet();

    // ================= MAIN SHEET =================
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Students');

    // ================= HEADERS =================
    $headers = [
        'Name','Phone','Email','Whatsapp','Age Group','Gender',
        'State','District','Present Status','Looking For',
        'Father Name','Mother Name','Category','Address','Pincode',

        'Highest Qualification',

        '10th Board','10th Year','10th Marks','10th Stream',

        '12th Board','12th Year','12th Marks','12th Stream',

        'Graduation University','Graduation Year','Graduation Marks','Graduation Stream','Graduation Field',

        'PG University','PG Year','PG Marks','PG Stream','PG Field',

        'Skill Type','Skill Trade','Skill Year',

        'Experience Type',

        'Passport','Relocation','Blood Group',

        'UTM Source','UTM Medium','UTM Campaign','UTM Term','UTM Content',
    ];

    $sheet->fromArray($headers, null, 'A1');

    // ================= SAMPLE DATA =================
    $sampleData = [
        [
            'Rahul Sharma','9876543210','rahul@gmail.com','9876543210',
            '16 - 18','Male','Uttar Pradesh','Lucknow','Student','education',
            'Ramesh','Sita','GEN','Lucknow Address','226001',

            '12th Pass',

            'CBSE','2018','85%','Science',

            'CBSE','2020','88%','Science',

            'Lucknow University','2023','75%','BSc','Physics',

            '','','','','',

            'Computer','IT','2022',

            'Fresher',

            'No','Yes','O+',

            'google','cpc','campaign1','term1','content1',
        ]
    ];

    // ================= INSTRUCTION ROW =================
    $lastColumn = $sheet->getHighestColumn();

    // ================= INSERT SAMPLE =================
    $sheet->fromArray($sampleData, null, 'A2');

    // ================= STYLING =================
    $sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
    $sheet->freezePane('A2');

    // Sample row color
    $sheet->getStyle('A2:' . $lastColumn . '2')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEFEFEF');

    // Auto width
    for ($col = 'A'; $col != $lastColumn; $col++)
    {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    $sheet->getColumnDimension($lastColumn)->setAutoSize(true);


    // ================= HELPER SHEET =================
    $helper = $spreadsheet->createSheet();
    $helper->setTitle('Dropdowns');

    // Age
    $ageGroups = [
        '16 - 18','19 - 21','22 - 25','26 - 30'
    ];

    $genders = ['Male','Female','Others'];

    $status = [
        'Student','Looking for Job','Working','Retired',
        'Ex-armyperson','Woman after break'
    ];

    $lookingFor = [
        'education','skill_course','Opportunity','learn_earn',
        'career_counselling','international_options'
    ];

    $qualification = [
        'Below 10th','10th','ITI/Diploma','12th Pass',
        'Undergraduate','Graduate','Post Graduate','PhD','Others'
    ];

    $experience = ['Fresher','Experienced'];
    $categories = ['GEN','OBC','SC','ST','Other'];

    // Fill helper
    $this->fillColumn($helper, 'A', $ageGroups);
    $this->fillColumn($helper, 'B', $genders);
    $this->fillColumn($helper, 'C', $status);
    $this->fillColumn($helper, 'D', $lookingFor);
    $this->fillColumn($helper, 'E', $qualification);
    $this->fillColumn($helper, 'F', $experience);
    $this->fillColumn($helper, 'G', $categories);

    // ================= DROPDOWNS =================
    for ($i = 2; $i <= 200; $i++) {

        $this->setDropdown($sheet, 'E'.$i, 'Dropdowns!$A$1:$A$'.count($ageGroups));
        $this->setDropdown($sheet, 'F'.$i, 'Dropdowns!$B$1:$B$'.count($genders));
        $this->setDropdown($sheet, 'I'.$i, 'Dropdowns!$C$1:$C$'.count($status));
        $this->setDropdown($sheet, 'J'.$i, 'Dropdowns!$D$1:$D$'.count($lookingFor));
        $this->setDropdown($sheet, 'M'.$i, 'Dropdowns!$G$1:$G$'.count($categories));

        $this->setDropdown($sheet, 'P'.$i, 'Dropdowns!$E$1:$E$'.count($qualification));

        $this->setDropdown($sheet, 'AL'.$i, 'Dropdowns!$F$1:$F$'.count($experience));
    }

    // ================= HIDE HELPER =================
    $helper->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

    // ================= DOWNLOAD =================
    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="student_bulk_template.xlsx"');

    $writer->save("php://output");
    exit;
}

// ================= HELPERS =================

private function fillColumn($sheet, $column, $data)
{
    $row = 1;
    foreach ($data as $val) {
        $sheet->setCellValue($column.$row, $val);
        $row++;
    }
}

private function setDropdown($sheet, $cell, $range)
{
    $validation = $sheet->getCell($cell)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setAllowBlank(true);
    $validation->setShowDropDown(true);
    $validation->setFormula1($range);
}

// Old Worked Code without Mail send
    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls'
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $file = $request->file('file');

    //         $spreadsheet = IOFactory::load($file->getPathname());
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $rows = $sheet->toArray();

    //         if (count($rows) <= 1) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Empty file'
    //             ]);
    //         }

    //         $success = 0;
    //         $failed = [];

    //         // AGE MAP
    //         $ageMap = [
    //             '16 - 18' => '16_18',
    //             '19 - 21' => '19_21',
    //             '22 - 25' => '22_25',
    //             '26 - 30' => '26_30',
    //         ];

    //         foreach ($rows as $index => $row) {

    //             if ($index == 0) continue;

    //             $name  = trim($row[0] ?? '');
    //             $phone = trim($row[1] ?? '');
    //             $email = trim($row[2] ?? '');

    //             if (!$name || !$email) {
    //                 $failed[] = "Row ".($index+1)." missing name/email";
    //                 continue;
    //             }

    //             // DUPLICATE CHECK
    //             if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
    //                 $failed[] = "Row ".($index+1)." duplicate user";
    //                 continue;
    //             }

    //             // REGISTRATION NUMBER
    //             $last = Student::orderBy('id','desc')->lockForUpdate()->first();

    //             if ($last && preg_match('/EFOS(\d+)/', $last->registration_number, $m)) {
    //                 $nextNumber = (int)$m[1] + 1;
    //             } else {
    //                 $nextNumber = 1;
    //             }

    //             $regNo = 'EFOS'.str_pad($nextNumber,3,'0',STR_PAD_LEFT);

    //             //CREATE USER
    //             $user = User::create([
    //                 'name' => $name,
    //                 'email' => $email,
    //                 'phone' => $phone,
    //                 'role' => 'student',
    //                 'password' => Hash::make($phone ?: '123456'),
    //             ]);

    //             // AGE CONVERT
    //             $ageGroup = $ageMap[$row[4]] ?? null;

    //             // CREATE STUDENT (FULL DATA)
    //             Student::create([
    //                 'user_id' => $user->id,
    //                 'registration_number' => $regNo,

    //                 // BASIC
    //                 'name' => $name,
    //                 'phone' => $phone,
    //                 'email' => $email,
    //                 'whatsapp' => $row[3] ?? null,

    //                 'age_group' => $ageGroup,
    //                 'gender' => $row[5] ?? null,
    //                 'state' => $row[6] ?? null,
    //                 'district' => $row[7] ?? null,
    //                 'present_status' => $row[8] ?? null,
    //                 'looking_for' => $row[9] ?? null,

    //                 // PERSONAL
    //                 'father_name' => $row[10] ?? null,
    //                 'mother_name' => $row[11] ?? null,
    //                 'category' => $row[12] ?? null,
    //                 'address' => $row[13] ?? null,
    //                 'pincode' => $row[14] ?? null,

    //                 // EDUCATION MAIN
    //                 'highest_qualification' => $row[15] ?? null,

    //                 // 10th
    //                 'tenth_board' => $row[16] ?? null,
    //                 'tenth_year' => $row[17] ?? null,
    //                 'tenth_marks' => $row[18] ?? null,
    //                 'tenth_stream' => $row[19] ?? null,

    //                 // 12th
    //                 'twelfth_board' => $row[20] ?? null,
    //                 'twelfth_year' => $row[21] ?? null,
    //                 'twelfth_marks' => $row[22] ?? null,
    //                 'twelfth_stream' => $row[23] ?? null,

    //                 // Graduation
    //                 'graduation_university' => $row[24] ?? null,
    //                 'graduation_year' => $row[25] ?? null,
    //                 'graduation_marks' => $row[26] ?? null,
    //                 'graduation_stream' => $row[27] ?? null,
    //                 'graduation_field' => $row[28] ?? null,

    //                 // PG
    //                 'pg_university' => $row[29] ?? null,
    //                 'pg_year' => $row[30] ?? null,
    //                 'pg_marks' => $row[31] ?? null,
    //                 'pg_stream' => $row[32] ?? null,
    //                 'pg_field' => $row[33] ?? null,

    //                 // SKILL
    //                 'skill_type' => $row[34] ?? null,
    //                 'skill_trade' => $row[35] ?? null,
    //                 'skill_year' => $row[36] ?? null,

    //                 // JOB
    //                 'experience_type' => $row[37] ?? null,

    //                 // OTHER
    //                 'passport' => $row[38] ?? null,
    //                 'relocation' => $row[39] ?? null,
    //                 'blood_group' => $row[40] ?? null,

    //                 // UTM
    //                 'utm_source' => $row[41] ?? 'bulk_import',
    //                 'utm_medium' => $row[42] ?? 'excel',
    //                 'utm_campaign' => $row[43] ?? 'bulk_upload',
    //                 'utm_term' => $row[44] ?? null,
    //                 'utm_content' => $row[45] ?? null,

    //                 'profile_completed' => 1
    //             ]);

    //             $success++;
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => "$success students imported successfully",
    //             'failed' => $failed
    //         ]);

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Import failed',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }



// In this code when import mail send also

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        DB::beginTransaction();

        try {

            $file = $request->file('file');

            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // HEADER REMOVE
            unset($rows[0]);

            // EMPTY ROW REMOVE
            $rows = array_values(array_filter($rows, function ($row) {

                // check if any column has value
                return count(array_filter($row)) > 0;
            }));

            if(count($rows) == 0){
                return response()->json([
                    'status'=>false,
                    'message'=>'Excel file me data nahi hai'
                ]);
            }

            $success = 0;
            $failed = [];

            $ageMap = [
                '16 - 18' => '16_18',
                '19 - 21' => '19_21',
                '22 - 25' => '22_25',
                '26 - 30' => '26_30',
            ];

            $existingEmails = User::pluck('email')->toArray();
            $existingPhones = User::pluck('phone')->toArray();

            $last = Student::latest()->first();

            if ($last && preg_match('/EFOS(\d+)/', $last->registration_number, $m)) {
                $nextNumber = (int)$m[1];
            } else {
                $nextNumber = 0;
            }

            foreach ($rows as $index => $row) {

                try{

                    $name  = trim($row[0] ?? '');
                    $phone = trim($row[1] ?? '');
                    $email = trim($row[2] ?? '');

                    if(!$name || !$email){
                        $failed[] = "Row ".($index+2)." name/email missing";
                        continue;
                    }

                    if(in_array($email,$existingEmails)){
                        $failed[] = "Row ".($index+2)." duplicate email";
                        continue;
                    }

                    $nextNumber++;

                    $regNo = 'EFOS'.str_pad($nextNumber,3,'0',STR_PAD_LEFT);

                    $user = User::create([
                        'name'=>$name,
                        'email'=>$email,
                        'phone'=>$phone,
                        'role'=>'student',
                        'password'=>Hash::make($phone ?: '123456')
                    ]);

                    $student = Student::create([

                        'user_id'=>$user->id,
                        'registration_number'=>$regNo,

                        'name'=>$name,
                        'phone'=>$phone,
                        'email'=>$email,

                        'whatsapp'=>$row[3] ?? null,

                        'age_group'=>$ageMap[$row[4]] ?? null,
                        'gender'=>$row[5] ?? null,

                        'state'=>$row[6] ?? null,
                        'district'=>$row[7] ?? null,

                        'present_status'=>$row[8] ?? null,
                        'looking_for'=>$row[9] ?? null,

                        'father_name'=>$row[10] ?? null,
                        'mother_name'=>$row[11] ?? null,

                        'category'=>$row[12] ?? null,
                        'address'=>$row[13] ?? null,
                        'pincode'=>$row[14] ?? null,

                        'highest_qualification'=>$row[15] ?? null,

                        'tenth_board'=>$row[16] ?? null,
                        'tenth_year'=>$row[17] ?? null,
                        'tenth_marks'=>$row[18] ?? null,
                        'tenth_stream'=>$row[19] ?? null,

                        'twelfth_board'=>$row[20] ?? null,
                        'twelfth_year'=>$row[21] ?? null,
                        'twelfth_marks'=>$row[22] ?? null,
                        'twelfth_stream'=>$row[23] ?? null,

                        'graduation_university'=>$row[24] ?? null,
                        'graduation_year'=>$row[25] ?? null,
                        'graduation_marks'=>$row[26] ?? null,
                        'graduation_stream'=>$row[27] ?? null,
                        'graduation_field'=>$row[28] ?? null,

                        'pg_university'=>$row[29] ?? null,
                        'pg_year'=>$row[30] ?? null,
                        'pg_marks'=>$row[31] ?? null,
                        'pg_stream'=>$row[32] ?? null,
                        'pg_field'=>$row[33] ?? null,

                        'skill_type'=>$row[34] ?? null,
                        'skill_trade'=>$row[35] ?? null,
                        'skill_year'=>$row[36] ?? null,

                        'experience_type'=>$row[37] ?? null,

                        'passport'=>$row[38] ?? null,
                        'relocation'=>$row[39] ?? null,
                        'blood_group'=>$row[40] ?? null,

                        'utm_source'=>$row[41] ?? 'bulk_import',
                        'utm_medium'=>$row[42] ?? 'excel',
                        'utm_campaign'=>$row[43] ?? 'bulk_upload',
                        'utm_term'=>$row[44] ?? null,
                        'utm_content'=>$row[45] ?? null,

                        'profile_completed'=>1
                    ]);

                    Mail::to($student->email)
                        ->queue(new StudentRegisteredMail($student));

                    $existingEmails[] = $email;

                    $success++;

                }
                catch(\Exception $rowError){

                    Log::error('IMPORT ROW ERROR',[
                        'row'=>$index+2,
                        'data'=>$row,
                        'error'=>$rowError->getMessage()
                    ]);

                    $failed[]="Row ".($index+2)." error";
                }
            }

            DB::commit();

            return response()->json([
                'status'=>true,
                'message'=>"$success students imported successfully",
                'failed'=>$failed
            ]);

        }
        catch(\Exception $e){

            DB::rollBack();

            Log::error('IMPORT ERROR',[
                'error'=>$e->getMessage(),
                'line'=>$e->getLine()
            ]);

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }

}
