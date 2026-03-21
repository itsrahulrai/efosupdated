<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use ImageUploadTrait;

    // 🔹 LIST PAGE
    public function index()
    {
        $companies = Company::latest()->get();
        return view('backend.company.company-list', compact('companies'));
    }

    // 🔹 ADD FORM
    public function create()
    {
        return view('backend.company.add-company');
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string',
            'address'      => 'required|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload logo
        $logoName = $this->uploadImage($request, 'logo', 'uploads/logo');

        Company::create([
            'company_name' => $request->company_name,
            'company_type' => $request->company_type,
            'address'      => $request->address,
            'logo'         => $logoName,
            'slug'         => Str::slug($request->company_name),
            'status'       => 1,
        ]);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company saved successfully!');
    }

    // 🔹 EDIT FORM
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('backend.company.add-company', compact('company'));
    }

// 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string',
            'address'      => 'required|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload logo (delete old if new uploaded)
        $logoName = $this->uploadImage(
            $request,
            'logo',
            'uploads/company',
            $company->logo
        );

        $company->update([
            'company_name' => $request->company_name,
            'company_type' => $request->company_type,
            'address'      => $request->address,
            'logo'         => $logoName,
            'slug'         => Str::slug($request->company_name),
        ]);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company updated successfully!');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        if ($company->logo && file_exists(public_path('uploads/company/' . $company->logo))) {
            unlink(public_path('uploads/company/' . $company->logo));
        }

        $company->delete();

        return redirect()
            ->back()
            ->with('success', 'Company deleted successfully!');
    }
}
