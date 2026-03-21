<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index()
    {
        $categoriesData = Category::latest()->simplePaginate(10);
        return view('backend.blog.categories', compact('categoriesData'));
    }




    public function create()
    {
        return view('backend.blog.add-cat');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            $original = $data['slug'];
            $i = 1;
            while (Category::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $original . '-' . $i++;
            }
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('categories/og_images', 'public');
        }

        if (!empty($data['schema'])) {
            $data['schema'] = trim($data['schema']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('backend.blog.add-cat', compact('category'));
    }



    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            $original = $data['slug'];
            $i = 1;
            while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
                $data['slug'] = $original . '-' . $i++;
            }
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('categories/og_images', 'public');
        }
        if (!empty($data['schema'])) {
            $data['schema'] = trim($data['schema']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully'
        ]);
    }
}
