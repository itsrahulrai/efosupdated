<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10);

        return view('backend.pages.index', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:pages,slug',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
            'canonical_url'    => 'nullable|url',
            'status'           => 'nullable|boolean',
        ]);

        Page::create([
            'name'             => $request->name,
            'slug'             => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'description'      => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'canonical_url'    => $request->canonical_url,
            'status'           => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     */
        public function show($slug)
            {
                $page = Page::where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

                return view('frontend.show', compact('page'));
            }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Page $page)
    {
        return view('backend.pages.create', compact('page'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
            'canonical_url'    => 'nullable|url',
            'status'           => 'nullable|boolean',
        ]);

        $page->update([
            'name'             => $request->name,
            'slug'             => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'description'      => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'canonical_url'    => $request->canonical_url,

            'status'           => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully');
    }

    public function toggleStatus(Request $request)
    {
        $subcategory = Page::findOrFail($request->id);
        $subcategory->status = $request->status;
        $subcategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Page  status updated successfully',
        ]);
    }
}
