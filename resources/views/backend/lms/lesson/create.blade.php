@extends('backend.layout.layouts')

@section('title',
    isset($lesson)
    ? 'Edit Course Lesson | EFOS Edumarketers Pvt Ltd'
    : 'Add Course Lesson | EFOS Edumarketers Pvt
    Ltd')

@section('content')

    @php
        $isEdit = isset($lesson);
    @endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit  Course Lesson ' : 'Add  Course Lesson ' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-course.index') }}"> Course Lesson </a>
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
                            {{-- LESSON FORM --}}
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ $isEdit ? route('admin.lesson.update', $lesson->id) : route('admin.lesson.store') }}">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                {{-- BASIC INFORMATION --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white fw-semibold">
                                        Lesson Information
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            {{-- Course --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course *</label>
                                                <select name="course_id" id="course_id" class="form-select" required>
                                                    <option value="">Select Course</option>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}"
                                                            {{ old('course_id', $lesson->course_id ?? '') == $course->id ? 'selected' : '' }}>
                                                            {{ $course->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Chapter --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Chapter *</label>
                                                <select name="chapter_id" id="chapter_id" class="form-select" required>
                                                    <option value="">Select Chapter</option>

                                                    @if ($isEdit)
                                                        @foreach ($chapters as $chapter)
                                                            <option value="{{ $chapter->id }}"
                                                                {{ old('chapter_id', $lesson->chapter_id ?? '') == $chapter->id ? 'selected' : '' }}>
                                                                {{ $chapter->title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>


                                            {{-- Lesson Title --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Lesson Title *</label>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    required value="{{ old('title', $lesson->title ?? '') }}">
                                            </div>

                                            {{-- Slug --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control"
                                                    value="{{ old('slug', $lesson->slug ?? '') }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- CONTENT SETTINGS --}}


                                {{-- CONTENT SETTINGS --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white fw-semibold">
                                        Lesson Content
                                    </div>

                                    <div class="card-body">

                                        {{-- Lesson Type + Video fields --}}
                                        <div class="row">

                                            {{-- Lesson Type --}}
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Lesson Type</label>
                                                <select name="type" id="lesson_type" class="form-select">
                                                    @foreach (['video', 'text'] as $type)
                                                        <option value="{{ $type }}"
                                                            {{ old('type', $lesson->type ?? 'video') == $type ? 'selected' : '' }}>
                                                            {{ ucfirst($type) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Video Fields (same row) --}}
                                            <div class="col-md-8" id="video_fields">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Video Source</label>
                                                        <select name="video_source" class="form-select">
                                                            <option value="">Select</option>
                                                            @foreach (['youtube', 'upload'] as $source)
                                                                <option value="{{ $source }}"
                                                                    {{ old('video_source', $lesson->video_source ?? '') == $source ? 'selected' : '' }}>
                                                                    {{ ucfirst($source) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Video URL</label>

                                                        <input type="url" name="video_url" id="video_url"
                                                            class="form-control" placeholder="Paste YouTube video URL"
                                                            value="{{ old('video_url', $lesson->video_url ?? '') }}">

                                                        <!-- Video Preview -->
                                                        <div class="ratio ratio-16x9 mt-3 d-none" id="videoPreviewBox">
                                                            <iframe id="videoPreview" src="" allowfullscreen
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                                            </iframe>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        {{-- Text Content (full width) --}}
                                        <div class="row" id="text_fields">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Content</label>
                                                <textarea name="content" id="content" class="form-control" rows="6">
                                                    {{ old('content', $lesson->content ?? '') }}
                                                                    </textarea>
                                                                     <!-- Note -->
                                                <small class="text-muted">
                                                    Recommended image size: <b>650 × 433 px (Width × Height)</b> for proper alignment and clear display in content editor.
                                                </small>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label class="form-label">Upload PDF</label>
                                                <input type="file" name="pdf_file" class="form-control"
                                                    accept="application/pdf">

                                                @if (isset($lesson) && $lesson->pdf_file)
                                                    <small class="text-muted d-block mt-1">
                                                        Current File:
                                                        <a href="{{ static_asset($lesson->pdf_file) }}" target="_blank">
                                                            View PDF
                                                        </a>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- SETTINGS --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-white fw-semibold">
                                        Lesson Settings
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Duration (seconds)</label>
                                                <input type="number" name="duration_seconds" class="form-control"
                                                    value="{{ old('duration_seconds', $lesson->duration_seconds ?? 0) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Sort Order</label>
                                                <input type="number" name="sort_order" class="form-control"
                                                    value="{{ old('sort_order', $lesson->sort_order ?? 0) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Free Preview</label>
                                                <select name="is_free_preview" class="form-select">
                                                    <option value="1"
                                                        {{ old('is_free_preview', $lesson->is_free_preview ?? 0) == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ old('is_free_preview', $lesson->is_free_preview ?? 0) == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Mandatory</label>
                                                <select name="is_mandatory" class="form-select">
                                                    <option value="1"
                                                        {{ old('is_mandatory', $lesson->is_mandatory ?? 1) == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ old('is_mandatory', $lesson->is_mandatory ?? 1) == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="1"
                                                        {{ old('status', $lesson->status ?? 1) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('status', $lesson->status ?? 1) == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- ACTIONS --}}
                                <div class="d-flex justify-content-end gap-2 mb-3">
                                    <a href="{{ route('admin.lesson.index') }}" class="btn btn-secondary">
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
        // document.addEventListener('DOMContentLoaded', function() {

        // ---------- Auto slug ----------
        const nameInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        let slugTouched = false;

        if (slugInput && nameInput) {
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
        }

        // ---------- Course → Chapter ----------
        const courseSelect = document.getElementById('course_id');
        const chapterSelect = document.getElementById('chapter_id');

        if (courseSelect && chapterSelect) {
            courseSelect.addEventListener('change', function() {
                const courseId = this.value;

                chapterSelect.innerHTML = '<option value="">Loading...</option>';

                if (!courseId) {
                    chapterSelect.innerHTML = '<option value="">Select Chapter</option>';
                    return;
                }

                const url = "{{ route('admin.course.chapters', ':id') }}".replace(':id', courseId);

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        chapterSelect.innerHTML = '<option value="">Select Chapter</option>';

                        data.forEach(chapter => {
                            chapterSelect.innerHTML +=
                                `<option value="${chapter.id}">${chapter.title}</option>`;
                        });
                    })
                    .catch(() => {
                        chapterSelect.innerHTML =
                            '<option value="">Failed to load chapters</option>';
                    });
            });
        }

        // });
    </script>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {

        const lessonType = document.getElementById('lesson_type');
        const videoFields = document.getElementById('video_fields');
        const textFields = document.getElementById('text_fields');

        function toggleLessonFields(type) {
            if (type === 'video') {
                videoFields.style.display = 'block';
                textFields.style.display = 'none';
            } else {
                videoFields.style.display = 'none';
                textFields.style.display = 'block';
            }
        }

        if (lessonType) {
            toggleLessonFields(lessonType.value);
            lessonType.addEventListener('change', function() {
                toggleLessonFields(this.value);
            });
        }

        // Jodit Editor
        if (document.getElementById('content')) {
            new Jodit('#content', {
                height: 350,
                toolbarAdaptive: false,
                toolbarSticky: false
            });
        }

        // });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const input = document.getElementById('video_url');
            const previewBox = document.getElementById('videoPreviewBox');
            const previewFrame = document.getElementById('videoPreview');

            function getYoutubeEmbed(url) {
                let videoId = null;

                // Normal YouTube URL
                if (url.includes('youtube.com/watch')) {
                    const params = new URL(url).searchParams;
                    videoId = params.get('v');
                }

                // Short URL
                if (url.includes('youtu.be/')) {
                    videoId = url.split('youtu.be/')[1];
                }

                return videoId ?
                    `https://www.youtube.com/embed/${videoId}` :
                    null;
            }

            function updatePreview() {
                const url = input.value.trim();
                const embedUrl = getYoutubeEmbed(url);

                if (embedUrl) {
                    previewFrame.src = embedUrl;
                    previewBox.classList.remove('d-none');
                } else {
                    previewFrame.src = '';
                    previewBox.classList.add('d-none');
                }
            }

            // Load preview if value already exists (edit page)
            updatePreview();

            // Update preview on typing/paste
            input.addEventListener('input', updatePreview);
        });
    </script>
@endpush
