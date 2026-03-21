<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FranchiseProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BecomePartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $franchiseRequests = FranchiseProfile::latest()->paginate(10);
        return view('backend.become-partner.index', compact('franchiseRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = User::where('role', 'admin')->get();

        return view('backend.become-partner.create', [
            'isEdit' => false,
            'franchise' => null,
            'admins' => $admins,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'address' => 'nullable|string',
            'business_experience' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'is_active' => 'required|boolean',
            'franchise_code' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'investment_range' => 'nullable|string|max:100',
            'approved_by' => 'nullable|exists:users,id',
            'message' => 'nullable|string',
        ]);

        FranchiseProfile::create($data);

        return redirect()
            ->route('admin.become-partner.index')
            ->with('success', 'Franchise created successfully!');
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
    public function edit(string $id)
    {
        $franchise = FranchiseProfile::findOrFail($id);
        $admins = User::where('role', 'admin')->get();

        return view('backend.become-partner.create', [
            'isEdit' => true,
            'franchise' => $franchise,
            'admins' => $admins,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $franchise = FranchiseProfile::findOrFail($id);

        $data = $request->validate([
            'owner_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'address' => 'nullable|string',
            'business_experience' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'is_active' => 'required|boolean',
            'franchise_code' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'investment_range' => 'nullable|string|max:100',
            'approved_by' => 'nullable|exists:users,id',
            'message' => 'nullable|string',
        ]);

        $franchise->update($data);

        return redirect()
            ->route('admin.become-partner.index')
            ->with('success', 'Franchise updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $becomePartner = FranchiseProfile::findOrFail($id);
        $becomePartner->delete();

        return redirect()->route('admin.become-partner.index')
            ->with('success', 'Franchise deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        try {

            $request->validate([
                'status' => 'required|in:approved,pending,rejected',
            ]);

            $franchise = FranchiseProfile::findOrFail($id);

            $franchise->status = $request->status;

            if ($request->status === 'approved')
            {
                $franchise->approved_at = now();
                $franchise->approved_by = auth()->id();
                $franchise->is_active = 1;
            }

            if ($request->status === 'rejected')
            {
                $franchise->is_active = 0;
            }

            $franchise->save();

            return response()->json([
                'success' => true,
                'message' => 'Franchise status updated successfully.',
                'status' => $franchise->status,
            ]);

        }
        catch (\Exception $e)
        {

            Log::error('Franchise Status Update Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating status.',
            ], 500);
        }
    }

}
