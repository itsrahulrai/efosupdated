    @extends('backend.layout.layouts')
    @section('title', 'Course Information - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
    @section('content')

        <main class="app-wrapper">
            <div class="container">
                <div class="app-page-head d-flex align-items-center justify-content-between">
                    <div class="clearfix">
                        <h1 class="app-page-title"> Course Information</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Course Information</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">Course Information</h6>
                            </div>
                            <div class="card-body">


                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <form class="row" method="POST"
                                    action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($course))
                                        @method('PUT')
                                    @endif


                                    <div class="mb-4 bg-white p-4">
                                        <h5 class="fw-bold border-bottom pb-2 mb-3">
                                            {{ isset($course) ? 'Edit Course' : 'Course Information' }}
                                        </h5>

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course Title *</label>
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ old('title', $course->title ?? '') }}"
                                                    placeholder="Enter course title" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course Image
                                                    {{ isset($course) ? '' : '*' }}</label>
                                                <input type="file" name="image" class="form-control" accept="image/*"
                                                    onchange="previewImage(event)" {{ isset($course) ? '' : 'required' }}>

                                                @if (isset($course) && $course->image)

                                                    <img id="imagePreview"
                                                        src="{{ static_asset('uploads/courses/' . $course->image) }}"
                                                        class="mt-2 border rounded" style="height:120px;">
                                                @else

                                                    <img id="imagePreview" class="mt-2 d-none border rounded"
                                                        style="height:120px;">
                                                @endif

                                                <small class="text-muted d-block mt-1">
                                                    JPG, PNG, WEBP, SVG, GIF (Max 5MB)
                                                </small>
                                            </div>


                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Short Description * 100–160 characters (approx.)</label>
                                                <textarea name="short_description" class="form-control" rows="3" placeholder="Short description" required>{{ old('short_description', $course->short_description ?? '') }}</textarea>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Full Description</label>
                                                <textarea name="description" id="cources_content" class="form-control" rows="5" placeholder="Detailed description">{{ old('description', $course->description ?? '') }}</textarea>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- ================= SEO DETAILS ================= --}}
                                    <div class="mb-4 bg-white p-4">
                                        <h5 class="fw-bold border-bottom pb-2 mb-3">SEO Information</h5>

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Meta Title</label>
                                                <input type="text" name="meta_title" class="form-control"
                                                    value="{{ old('meta_title', $course->meta_title ?? '') }}"
                                                    placeholder="SEO meta title">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" class="form-control"
                                                    value="{{ old('meta_keywords', $course->meta_keywords ?? '') }}"
                                                    placeholder="keyword1, keyword2">
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" rows="3" placeholder="SEO meta description">{{ old('meta_description', $course->meta_description ?? '') }}</textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="1"
                                                        {{ old('status', $course->status ?? 1) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('status', $course->status ?? 1) == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- ================= ACTION BUTTONS ================= --}}
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($course) ? 'Update Course' : 'Save Course' }}
                                        </button>
                                        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                                            Cancel
                                        </a>
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
            function previewImage(event) {
                var input = event.target;
                var reader = new FileReader();
                reader.onload = function() {
                    var img = document.getElementById('imagePreview');
                    img.src = reader.result;
                    img.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const shortDesc = document.getElementById('cources_content');

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
