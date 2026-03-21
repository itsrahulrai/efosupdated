@extends('backend.layout.layouts')

@section('title',
    isset($course)
    ? 'Edit Course Chapter | EFOS Edumarketers Pvt Ltd'
    : 'Add Course Chapter | EFOS Edumarketers Pvt
    Ltd')

@section('content')

    @php
        $isEdit = isset($chapter);
    @endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit  Course Chapter' : 'Add  Course Chapter' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.course-chapter.index') }}"> Course Chapter</a>
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
                                action="{{ $isEdit ? route('admin.course-chapter.update', $chapter->id) : route('admin.course-chapter.store') }}">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white border-bottom fw-semibold text-dark">
                                        {{ $isEdit ? 'Edit Course Chapter' : 'Add Course Chapter' }}
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            {{-- CHAPTER TITLE --}}
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Chapter Title *</label>
                                                <input type="text" name="title" class="form-control" required
                                                    value="{{ old('title', $chapter->title ?? '') }}">
                                            </div>

                                            {{-- COURSE --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course *</label>
                                                <select name="course_id" class="form-select" required>
                                                    <option value="">Select Course</option>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}"
                                                            {{ old('course_id', $chapter->course_id ?? '') == $course->id ? 'selected' : '' }}>
                                                            {{ $course->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- SORT ORDER --}}
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">Sort Order</label>
                                                <input type="number" name="sort_order" class="form-control"
                                                    value="{{ old('sort_order', $chapter->sort_order ?? 0) }}">
                                            </div>

                                            {{-- STATUS --}}
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="1"
                                                        {{ old('status', $chapter->status ?? 1) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('status', $chapter->status ?? 1) == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                            {{-- DESCRIPTION --}}
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" rows="3">{{ old('description', $chapter->description ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ACTIONS --}}
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.course-chapter.index') }}" class="btn btn-secondary">
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
