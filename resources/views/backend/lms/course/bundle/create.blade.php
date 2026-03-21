@extends('backend.layout.layouts')

@section('title',
    isset($bundle)
    ? 'Edit Bundle Course | EFOS Edumarketers Pvt Ltd'
    : 'Add Bundle Course | EFOS Edumarketers Pvt
    Ltd')

@section('content')

   @php
    $isEdit = $bundle->exists;
@endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit Bundle Course' : 'Add Bundle Course' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-course.index') }}">Bundle Course</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $isEdit ? 'Edit' : 'Add' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- CARD --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- FORM --}}

                                @if ($bundle->exists)
                                    <form method="POST" action="{{ route('admin.bundle-course.update', $bundle->id) }}" enctype="multipart/form-data">
                                        @method('PUT')
                                @else
                                    <form method="POST" action="{{ route('admin.bundle-course.store') }}" enctype="multipart/form-data">
                                @endif
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                {{-- BASIC INFO --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        Bundle Course Information
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course Title *</label>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    required value="{{ old('title', $bundle->title ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control"
                                                    value="{{ old('slug', $bundle->slug ?? '') }}">
                                            </div>



                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Select Courses</label>
                                                <select name="course_ids[]" id="courseSelect" class="form-control" multiple
                                                    required>

                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}"
                                                            {{ isset($bundle) && $bundle->courses->contains($course->id) ? 'selected' : '' }}>
                                                            {{ $course->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="card mb-4 shadow-sm">

                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        Course Content
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $bundle->short_description ?? '') }}</textarea>
                                        </div>

                                        <div>
                                            <label class="form-label"> Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $bundle->description ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- PRICING --}}
                                <div class="card mb-4 shadow-sm">

                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        Pricing
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Currency</label>
                                                <input type="text" name="currency" class="form-control"
                                                    value="{{ old('currency', $bundle->currency ?? 'INR') }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" name="price" id="priceInput" class="form-control"
                                                    value="{{ old('price', $bundle->price ?? 0) }}">

                                                <small class="text-mute">
                                                    If the course bundle is free, set the price to 0.
                                                </small>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Free Course</label>
                                                <select name="is_free" class="form-select">
                                                    <option value="0"
                                                        {{ old('is_free', $bundle->is_free ?? 0) == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="1"
                                                        {{ old('is_free', $bundle->is_free ?? 0) == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Has Discount</label>
                                                <select name="has_discount" class="form-select">
                                                    <option value="0"
                                                        {{ old('has_discount', $bundle->has_discount ?? 0) == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="1"
                                                        {{ old('has_discount', $bundle->has_discount ?? 0) == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount Price</label>
                                                <input type="number" name="discount_price" class="form-control"
                                                    value="{{ old('discount_price', $bundle->discount_price ?? '') }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount From</label>
                                                <input type="date" name="discount_from" class="form-control"
                                                    value="{{ old('discount_from', optional($bundle->discount_from)->format('Y-m-d')) }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount To</label>
                                                <input type="date" name="discount_to" class="form-control"
                                                    value="{{ old('discount_to', optional($bundle->discount_to)->format('Y-m-d')) }}">
                                            </div>
                                          

                                        </div>
                                    </div>
                                </div>

                                {{-- MEDIA & STATUS --}}
                                <div class="card mb-4 shadow-sm">

                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        Media & Status
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Thumbnail</label>
                                                <input type="file" name="thumbnail" class="form-control">
                                                <small class="text-muted">Allowed: JPG, PNG, WEBP (Max: 2MB)</small>
                                                {{-- Show existing image in edit --}}
                                                @if (!empty($bundle->thumbnail))
                                                    <div class="mb-2">
                                                        <img src="{{ static_asset($bundle->thumbnail) }}"
                                                            alt="Course Thumbnail" class="img-thumbnail"
                                                            style="max-height: 120px;">
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                        </div>

                        {{-- ACTIONS --}}

                        <div class="d-flex justify-content-end gap-2 mb-3 me-3">

                            <a href="{{ route('admin.bundle-course.index') }}" class="btn btn-secondary ms-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Update' : 'Submit' }}
                            </button>

                        </div>
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
        // Auto slug
        const nameInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        let slugTouched = false;

        slugInput.addEventListener('input', () => slugTouched = true);

        nameInput.addEventListener('input', function() {
            if (!slugTouched || slugInput.value.trim() === '') {
                slugInput.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/&/g, 'and')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }
        });

        // Jodit editor
        new Jodit('#description', {
            height: 350
        });
    </script>
 
@endpush
