<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentorAvailability;
use App\Models\MentorCategory;
use App\Models\MentorProfile;
use App\Models\MentorSessionPrice;
use Illuminate\Http\Request;

class MentorCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expertises = MentorCategory::latest()
            ->paginate(10, ['*'], 'expertise_page');

        $mentorProfiles = MentorProfile::with('category')
            ->latest()
            ->paginate(10, ['*'], 'mentor_page');

        $mentorSessionPrice = MentorSessionPrice::with('mentor')
            ->latest()
            ->paginate(10, ['*'], 'mentor_session_price');

        $mentorAvailability = MentorAvailability::with('mentor')
            ->latest()
            ->paginate(10, ['*'], 'mentor_availability');
            

        return view(
            'backend.mentor.index',
            compact('expertises', 'mentorProfiles', 'mentorSessionPrice','mentorAvailability')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.mentor.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        MentorCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.mentor-categories.index')
            ->with('success', 'Mentor Category Created Successfully');
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
        $expertise = MentorCategory::findorFail($id);
        return view('backend.mentor.categories.create', compact('expertise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all()  );

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $expertise = MentorCategory::findOrFail($id);

        $expertise->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.mentor-categories.index')
            ->with('success', 'Mentor Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $expertise = MentorCategory::findOrFail($id);
        $expertise->delete();

        return redirect()
            ->route('admin.mentor-categories.index')
            ->with('success', 'Mentor Category deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $expertise = MentorCategory::findOrFail($request->id);
        $expertise->status = $request->status;
        $expertise->save();

        return response()->json([
            'success' => true,
            'message' => 'Mentor Category status updated successfully',
        ]);
    }
}
