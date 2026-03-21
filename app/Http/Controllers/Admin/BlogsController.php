<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
     use ImageUploadTrait;

    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('backend.blog.blog', compact('blogs'));
    }


    public function create()
    {
         $blogcategories = Category::latest()->get();
        //  dd($blogcategories);
        //  exit;

         return view('backend.blog.add-blog', compact('blogcategories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id'     => 'required|exists:categories,id',
                'name'            => 'required|string|max:255',
                'slug'            => 'nullable|string|max:255|unique:blogs,slug',
                'short_content'   => 'nullable|string|max:255',
                'content'         => 'nullable|string',
                'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Upload image using trait
            $imagePath = $this->uploadImage($request, 'image', 'uploads/blogs');

            // Create blog
            Blog::create([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'slug'             => $request->slug ?: Str::slug($request->name),
                'short_content'    => $request->short_content,
                'content'          => $request->content,
                'image'            => $imagePath,
                'alt'              => $request->alt,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'meta_robot'       => $request->meta_robot,
                'canonical'        => $request->canonical,
                'status'           => $request->status ?? 1,
            ]);

            return redirect()->route('admin.blogs.index')
                            ->with('success','Blog created successfully.');

        } catch (\Exception $e) {
            Log::error('Blog Store Error: '.$e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Something went wrong while creating the blog. Please try again.');
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $blogcategories = Category::latest()->get();
        return view('backend.blog.add-blog', compact('blog', 'blogcategories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'category_id'     => 'required|exists:categories,id',
                'name'            => 'required|string|max:255',
                'slug'            => 'nullable|string|max:255|unique:blogs,slug,' . $id,
                'short_content'   => 'nullable|string|max:255',
                'content'         => 'nullable|string',
                'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $blog = Blog::findOrFail($id);
            $imagePath = $this->updateImage($request, 'image', 'uploads/blogs', $blog->image);

            // Update blog
            $blog->update([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'slug'             => $request->slug ?: Str::slug($request->name),
                'short_content'    => $request->short_content,
                'content'          => $request->content,
                'image'            => $imagePath,
                'alt'              => $request->alt,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'meta_robot'       => $request->meta_robot,
                'canonical'        => $request->canonical,
                'status'           => $request->status ?? 1,
            ]);

            return redirect()->route('admin.blogs.index')
                            ->with('success','Blog updated successfully.');

        } catch (\Exception $e) {
            Log::error('Blog Update Error: '.$e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Something went wrong while updating the blog. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            if ($blog->image) {
                $this->deleteImage($blog->image);
            }
            $blog->delete();
            return redirect()->route('admin.blogs.index')
                            ->with('success', 'Blog deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Blog Delete Error: ' . $e->getMessage());

            return redirect()->back()
                            ->with('error', 'Something went wrong while deleting the blog.');
        }
    }

    }
