<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')->latest()->paginate(10);
        return view('backend.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();

        return view('backend.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|unique:sub_categories,slug',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug ?? Str::slug($request->name),
            'status'      => 1,
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Subcategory created successfully.');
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
    public function edit(SubCategory $sub_category)
    {
        $categories = Category::where('status', 1)->get();

        return view('backend.subcategory.create', [
            'subcategory' => $sub_category,
            'categories'  => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|unique:sub_categories,slug,' . $sub_category->id,
        ]);

        $sub_category->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug ?? Str::slug($request->name),
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $sub_category)
    {
        $sub_category->delete();

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = $request->status;
        $subcategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Subcategory status updated successfully',
        ]);
    }
}
