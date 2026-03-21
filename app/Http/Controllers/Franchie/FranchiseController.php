<?php
namespace App\Http\Controllers\Franchie;

use App\Http\Controllers\Controller;
use App\Models\FranchiseProfile;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $franchiseRequests = FranchiseProfile::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('franchise.franchise-request.index', compact('franchiseRequests'));
    }


    public function franchiseStudents()
    {
        $user = auth()->user();

        $franchise = FranchiseProfile::where('user_id', $user->id)->firstOrFail();

        $students = $franchise->students()
            ->latest()
            ->paginate(10);

        return view('franchise.students.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $franchise = FranchiseProfile::findOrFail($id);
        return view('franchise.franchise-request.edit', compact('franchise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_name'          => 'required|string|max:255',
            'company_name'        => 'nullable|string|max:255',
            'phone'               => 'required|string|max:15',
            'email'               => 'required|email|max:255',
        ]);
       
        $franchise = FranchiseProfile::findOrFail($id);
      
        $franchise->update([
            'owner_name'          => $request->owner_name,
            'company_name'        => $request->company_name,
            'phone'               => $request->phone,
            'email'               => $request->email,
            'state'               => $request->state,   
            'district'            => $request->district,
            'business_experience' => $request->business_experience,
            'investment_range'    => $request->investment_range,
            'location'            => $request->location,
            'franchise_code'      => $request->franchise_code,
        ]);

     
        return redirect()
            ->route('franchise.index')
            ->with('success', 'Franchise request updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
