<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::latest()->paginate(5);

        return view('backend.lms.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.lms.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subjects,slug',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $slug = $request->slug
        ? Str::slug($request->slug)
        : Str::slug($request->name);

        Subject::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->status,
        ]);

        return redirect()->route('admin.subject.index')
            ->with('success', 'Subject added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('backend.lms.subject.create', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subjects,slug,' . $subject->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $slug = $request->slug
        ? Str::slug($request->slug)
        : Str::slug($request->name);

        $subject->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->status,
        ]);

        return redirect()->route('admin.subject.index')
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subject.index')->with('success', 'Subject deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subjects,id',
            'status' => 'required|boolean',
        ]);

        $subject = Subject::findOrFail($request->id);
        $subject->is_active = $request->status;
        $subject->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }
}
