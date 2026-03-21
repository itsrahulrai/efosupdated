<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class YoutubeVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = YoutubeVideo::latest()->paginate(10);
        return view('backend.youtube.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.youtube.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'sort_order'  => 'nullable|integer',
            'status'      => 'nullable|boolean',
        ]);

        YoutubeVideo::create([
            'title'       => $request->title,
            'youtube_url' => $request->youtube_url,
            'sort_order'  => $request->sort_order ?? 0,
            'status'      => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.youtube.index')
            ->with('success', 'YouTube video added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(YoutubeVideo $youtube)
    {
        return view('backend.youtube.show', compact('youtube'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YoutubeVideo $youtube)
    {
        return view('backend.youtube.create', compact('youtube'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YoutubeVideo $youtube)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'sort_order'  => 'nullable|integer',
            'status'      => 'nullable|boolean',
        ]);

        $youtube->update([
            'title'       => $request->title,
            'youtube_url' => $request->youtube_url,
            'sort_order'  => $request->sort_order ?? 0,
            'status'      => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.youtube.index')
            ->with('success', 'YouTube video updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YoutubeVideo $youtube)
    {
        $youtube->delete();

        return redirect()
            ->route('admin.youtube.index')
            ->with('success', 'YouTube video deleted successfully');
    }

    /**
     * Toggle status (AJAX)
     */
    public function toggleStatus(Request $request)
    {
        $video = YoutubeVideo::findOrFail($request->id);
        $video->status = $request->status;
        $video->save();

        return response()->json([
            'success' => true,
            'message' => 'Video status updated successfully'
        ]);
    }
}
