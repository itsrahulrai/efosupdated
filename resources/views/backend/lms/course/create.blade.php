@extends('backend.layout.layouts')

@section('title',
    isset($course)
    ? 'Edit Learning Course | EFOS Edumarketers Pvt Ltd'
    : 'Add Learning Course | EFOS Edumarketers Pvt
    Ltd')

@section('content')

    @php
        $isEdit = isset($course);
    @endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit Learning Course' : 'Add Learning Course' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-course.index') }}">Learning Course</a>
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
                            <form method="POST"
                                action="{{ $isEdit ? route('admin.learning-course.update', $course->id) : route('admin.learning-course.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                {{-- BASIC INFO --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        Course Information
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course Title *</label>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    required value="{{ old('title', $course->title ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control"
                                                    value="{{ old('slug', $course->slug ?? '') }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Language</label>
                                                <input type="text" name="language" class="form-control"
                                                    value="{{ old('language', $course->language ?? '') }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Level</label>
                                                <select name="level" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach (['Beginner', 'Intermediate', 'Advanced'] as $level)
                                                        <option value="{{ $level }}"
                                                            {{ old('level', $course->level ?? '') == $level ? 'selected' : '' }}>
                                                            {{ $level }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Duration</label>
                                                <input type="text" name="duration" class="form-control"
                                                    placeholder="e.g. 10 Hours"
                                                    value="{{ old('duration', $course->duration ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Category *</label>
                                                <select name="subject_id" class="form-select" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ old('subject_id', $course->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                                                            {{ $subject->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Demo Video URL</label>
                                                <input type="url" name="demo_video" class="form-control"
                                                    value="{{ old('demo_video', $course->demo_video ?? '') }}">
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
                                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $course->short_description ?? '') }}</textarea>
                                        </div>

                                        <div>
                                            <label class="form-label"> Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $course->description ?? '') }}</textarea>
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
                                                    value="{{ old('currency', $course->currency ?? 'INR') }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" name="price" class="form-control"
                                                    value="{{ old('price', $course->price ?? 0) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Free Course</label>
                                                <select name="is_free" class="form-select">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Has Discount</label>
                                                <select name="has_discount" class="form-select">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount Price</label>
                                                <input type="number" name="discount_price" class="form-control"
                                                    value="{{ old('discount_price', $course->discount_price ?? '') }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount From</label>
                                                <input type="date" name="discount_from" class="form-control"
                                                    value="{{ old('discount_from', $course->discount_from ?? '') }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Discount To</label>
                                                <input type="date" name="discount_to" class="form-control"
                                                    value="{{ old('discount_to', $course->discount_to ?? '') }}">
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
                                                @if (!empty($course->thumbnail))
                                                    <div class="mb-2">
                                                        <img src="{{ static_asset($course->thumbnail) }}"
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

                            <a href="{{ route('admin.learning-course.index') }}" class="btn btn-secondary ms-2">
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
