@extends('backend.layout.layouts')
@section('title', isset($blog) ? 'Edit Blog | EFOS Edumarketers Pvt Ltd' : 'Add Blog | EFOS Edumarketers Pvt Ltd')
@section('content')

<main class="app-wrapper">
    <div class="container">
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title">{{ isset($blog) ? 'Edit Blog' : 'Add Blog' }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.blogs.index') }}">Blogs</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($blog) ? 'Edit Blog' : 'Add Blog' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @if(isset($blog))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Blog Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                        value="{{ old('name', $blog->name ?? '') }}" required>
                                </div>

                                <!-- Slug -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" placeholder="Enter Slug (optional)"
                                        value="{{ old('slug', $blog->slug ?? '') }}">
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($blogcategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ (old('category_id', $blog->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            

                            <!-- Short Content -->
                            <div class="mb-3">
                                <label class="form-label">Short Content</label>
                                <textarea name="short_content" id="short_content" class="form-control" rows="3" placeholder="Enter Short Content">{{ old('short_content', $blog->short_content ?? '') }}</textarea>
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control" id="content" rows="6" placeholder="Enter Blog Content">{{ old('content', $blog->content ?? '') }}</textarea>
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                @if(isset($blog) && $blog->image)
                                    <img src="{{ static_asset($blog->image) }}" alt="{{ $blog->alt }}" width="120" class="mt-2">
                                @endif
                            </div>

                            <!-- Alt Text -->
                            <div class="mb-3">
                                <label class="form-label">Alt Text</label>
                                <input type="text" name="alt" class="form-control" placeholder="Image Alt Text" value="{{ old('alt', $blog->alt ?? '') }}">
                            </div>

                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" placeholder="Enter Meta Title" value="{{ old('meta_title', $blog->meta_title ?? '') }}">
                            </div>

                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3" placeholder="Enter Meta Description">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                            </div>

                            <!-- Meta Keywords -->
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" placeholder="Enter Meta Keywords" value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}">
                            </div>

                            <!-- Meta Robots -->
                            <div class="mb-3">
                                <label class="form-label">Meta Robot</label>
                                <select name="meta_robot" class="form-control">
                                    <option value="">Select</option>
                                    <option value="index, follow" {{ (old('meta_robot', $blog->meta_robot ?? '') == 'index, follow') ? 'selected' : '' }}>index, follow</option>
                                    <option value="noindex, nofollow" {{ (old('meta_robot', $blog->meta_robot ?? '') == 'noindex, nofollow') ? 'selected' : '' }}>noindex, nofollow</option>
                                </select>
                            </div>

                            <!-- Canonical -->
                            <div class="mb-3">
                                <label class="form-label">Canonical URL</label>
                                <input type="text" name="canonical" class="form-control" placeholder="Enter Canonical URL" value="{{ old('canonical', $blog->canonical ?? '') }}">
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ (old('status', $blog->status ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ (old('status', $blog->status ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ isset($blog) ? 'Update' : 'Submit' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection


@push('script')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const shortDesc = document.getElementById('short_content');
    const fullDesc  = document.getElementById('content');

    if (shortDesc) {
        new Jodit(shortDesc, {
            height: 150,
            toolbarAdaptive: false,
            buttons: [
                'bold', 'italic', 'underline',
                '|', 'ul', 'ol',
                '|', 'link', 'eraser'
            ]
        });
    }

    if (fullDesc) {
        new Jodit(fullDesc, {
            height: 300,
            toolbarAdaptive: false,
            buttons: [
                'bold', 'italic', 'underline',
                '|', 'ul', 'ol',
                '|', 'link', 'image',
                '|', 'align', 'undo', 'redo'
            ]
        });
    }

});
</script>
@endpush