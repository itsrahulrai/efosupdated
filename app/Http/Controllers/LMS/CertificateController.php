<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:learning_courses,id',
            'certificate_number' => 'required|unique:certificates,certificate_number',
            'issue_date' => 'nullable|date',
        ]);

        Certificate::create($request->all());

        return redirect()->back()->with('success', 'Certificate Created Successfully');
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:learning_courses,id',
            'certificate_number' => 'required|unique:certificates,certificate_number,' . $id,
            'issue_date' => 'nullable|date',
        ]);

        $certificate->update($request->all());

        return redirect()->back()->with('success', 'Certificate Updated Successfully');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return back()->with('success', 'Certificate Deleted Successfully');
    }

    public function print($id)
    {
        $certificate = Certificate::with([
            'student:id,name,registration_number',
            'course:id,title',
        ])->findOrFail($id);

        // dd($certificate);

        return view('backend.lms.certificates.certificate', compact('certificate'));
    }

}
