@extends('backend.layout.layouts')
@section('title', isset($job) ? 'Edit Job' : 'Create Job')

@section('content')
<main class="app-wrapper">
    <div class="container">

        <!-- Header -->
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">
                    {{ isset($job) ? 'Edit Job' : 'Create Job' }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.jobs.index') }}">Opportunity</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ isset($job) ? 'Edit' : 'Create' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php $isEdit = isset($job); @endphp

                <form method="POST"
                      action="{{ $isEdit ? route('admin.jobs.update', $job->id) : route('admin.jobs.store') }}"
                      enctype="multipart/form-data"
                      class="row g-3">

                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                   <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="job_category_id" class="form-select" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('job_category_id', $job->job_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sub Category -->
                        <div class="col-md-6">
                            <label class="form-label">Sub Category *</label>

                            <select name="job_sub_category_id" id="sub_category" class="form-select" required>
                                <option value="">Select Sub Category</option>

                                @if($isEdit)
                                    @foreach($subCategories as $sub)
                                        @if($sub->job_category_id == $job->job_category_id)
                                            <option value="{{ $sub->id }}"
                                                {{ $job->job_sub_category_id == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>


                    <!-- Job Title -->
                    <div class="col-md-6">
                        <label class="form-label">Opportunity Title *</label>
                        <input type="text" name="title" id="job_title"
                               class="form-control"
                               value="{{ old('title', $job->title ?? '') }}"
                               required>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="job_slug"
                               class="form-control"
                               value="{{ old('slug', $job->slug ?? '') }}">
                        <small class="text-muted">Auto-generated if left empty</small>
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name"
                               class="form-control"
                               value="{{ old('company_name', $job->company_name ?? '') }}">
                    </div>

                    <!-- Company Logo -->
                    <div class="col-md-6">
                        <label class="form-label">Company Logo</label>
                        <input type="file" name="image" class="form-control">
                        @if($isEdit && $job->company_logo)
                            <img src="{{ static_asset($job->company_logo) }}"
                                 class="mt-2 rounded"
                                 height="50">
                        @endif
                    </div>

                    <!-- Location -->
                    <div class="col-md-4">
                        <label class="form-label">Area</label>
                        <input type="text" name="area" class="form-control"
                               value="{{ old('area', $job->area ?? '') }}">
                    </div>

                                                <!-- State -->
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <select name="state"
                                        class="form-select"
                                        data-state
                                        data-target="district_select"
                                        data-selected="{{ old('state', $job->state ?? '') }}">
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <!-- District -->
                            <div class="col-md-4">
                                <label class="form-label">District</label>
                                <select name="district"
                                        id="district_select"
                                        class="form-select"
                                        data-selected="{{ old('district', $job->district ?? '') }}">
                                    <option value="">Select District</option>
                                </select>
                            </div>



                    <!-- Salary -->
                    <div class="col-md-6">
                        <label class="form-label">Salary</label>
                        <input type="text" name="salary" class="form-control"
                               value="{{ old('salary', $job->salary ?? '') }}">
                    </div>

                    <!-- Job Meta -->
                    <div class="col-md-3">
                        <label class="form-label">Opportunity Type</label>
                        <input type="text" name="job_type" class="form-control"
                               value="{{ old('job_type', $job->job_type ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Work Mode</label>
                        <input type="text" name="work_mode" class="form-control"
                               value="{{ old('work_mode', $job->work_mode ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Shift</label>
                        <input type="text" name="shift" class="form-control"
                               value="{{ old('shift', $job->shift ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control"
                               value="{{ old('experience', $job->experience ?? '') }}">
                    </div>



                    <div class="col-md-3">
                        <label class="form-label">Education</label>
                        <input type="text" name="education" class="form-control"
                            value="{{ old('education', $job->education ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Eligibility</label>
                        <input type="text" name="eligibility" class="form-control"
                            value="{{ old('eligibility', $job->eligibility ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Age Limit</label>
                        <input type="text" name="age_limit" class="form-control"
                            value="{{ old('age_limit', $job->age_limit ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Any</option>
                            <option value="Male" {{ old('gender', $job->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $job->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Any" {{ old('gender', $job->gender ?? '') == 'Any' ? 'selected' : '' }}>Any</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">English Level</label>
                        <select name="english_level" class="form-select">
                            <option value="">Select</option>
                            <option value="Basic" {{ old('english_level', $job->english_level ?? '') == 'Basic' ? 'selected' : '' }}>Basic</option>
                            <option value="Intermediate" {{ old('english_level', $job->english_level ?? '') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ old('english_level', $job->english_level ?? '') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>

                     <!-- Status -->
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $job->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $job->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                      <!-- Skills -->
                    <div class="col-12">
                        <label class="form-label">Skills</label>
                        <textarea name="skills" class="form-control" rows="2">{{ old('skills', $job->skills ?? '') }}</textarea>
                    </div>



                    <div class="col-12">
                        <label class="form-label">Opportunity Highlights (Max 4)</label>

                        @for($i = 0; $i < 4; $i++)
                            <input type="text"
                                name="highlights[]"
                                class="form-control mb-2"
                                placeholder="Highlight {{ $i + 1 }}"
                                value="{{ old('highlights.' . $i, $job->highlights[$i] ?? '') }}">
                        @endfor
                    </div>

                    <!-- Descriptions -->
                    <div class="col-12">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $job->short_description ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                       <textarea
                                name="description"
                                id="description_editor"
                                class="form-control"
                                rows="6"
                            >{{ old('description', $job->description ?? '') }}</textarea>
                    </div>

                    <hr>
<h5 class="mt-4">SEO Meta Information</h5>

<!-- Meta Title -->
<div class="col-md-6">
    <label class="form-label">Meta Title</label>
    <input type="text" name="meta_title" class="form-control"
        value="{{ old('meta_title', $job->meta_title ?? '') }}"
        placeholder="SEO title (optional)">
</div>

<!-- Meta Keywords -->
<div class="col-md-6">
    <label class="form-label">Meta Keywords</label>
    <input type="text" name="meta_keywords" class="form-control"
        value="{{ old('meta_keywords', $job->meta_keywords ?? '') }}"
        placeholder="keyword1, keyword2">
</div>

<!-- Meta Description -->
<div class="col-12">
    <label class="form-label">Meta Description</label>
    <textarea name="meta_description" class="form-control" rows="2"
        placeholder="SEO description (150–160 chars)">{{ old('meta_description', $job->meta_description ?? '') }}</textarea>
</div>

<!-- Meta Robots -->
<div class="col-md-4">
    <label class="form-label">Meta Robots</label>
    <select name="meta_robots" class="form-select">
        <option value="index, follow" {{ old('meta_robots', $job->meta_robots ?? 'index, follow') == 'index, follow' ? 'selected' : '' }}>index, follow</option>
        <option value="noindex, follow" {{ old('meta_robots', $job->meta_robots ?? '') == 'noindex, follow' ? 'selected' : '' }}>noindex, follow</option>
        <option value="noindex, nofollow" {{ old('meta_robots', $job->meta_robots ?? '') == 'noindex, nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
    </select>
</div>

<!-- Canonical URL -->
<div class="col-md-8">
    <label class="form-label">Canonical URL</label>
    <input type="text" name="canonical_url" class="form-control"
        value="{{ old('canonical_url', $job->canonical_url ?? '') }}"
        placeholder="https://efos.in/opportunity/">
</div>


<hr>
<h5 class="mt-4">Social Share (Open Graph)</h5>

<!-- OG Title -->
<div class="col-md-6">
    <label class="form-label">OG Title</label>
    <input type="text" name="og_title" class="form-control"
        value="{{ old('og_title', $job->og_title ?? '') }}"
        placeholder="Social share title">
</div>

<!-- OG Image -->
<div class="col-md-6">
    <label class="form-label">OG Image</label>
    <input type="file" name="og_image" class="form-control">

    @if($isEdit && !empty($job->og_image))
        <img src="{{ static_asset($job->og_image) }}"
             class="mt-2 rounded"
             style="height:60px">
    @endif

    <small class="text-muted">
        Recommended: 1200 × 630 px (JPG)
    </small>
</div>

<!-- OG Description -->
<div class="col-12">
    <label class="form-label">OG Description</label>
    <textarea name="og_description" class="form-control" rows="2"
        placeholder="Social share description">{{ old('og_description', $job->og_description ?? '') }}</textarea>
</div>




                    <!-- Submit -->
                   <div class="col-12 mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ $isEdit ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary ms-2">
                        Cancel
                    </a>
                </div>


                </form>
            </div>
        </div>

    </div>
</main>
@endsection

@push('script')
<script>
const titleInput = document.getElementById('job_title');
const slugInput  = document.getElementById('job_slug');

titleInput.addEventListener('input', function () {
    if (slugInput.value.trim() === '') {
        slugInput.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }
});
</script>

<script>
document.querySelector('select[name="job_category_id"]').addEventListener('change', function () {
    const categoryId = this.value;
    const subCategorySelect = document.getElementById('sub_category');

    subCategorySelect.innerHTML = '<option value="">Loading...</option>';

    if (!categoryId) {
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
        return;
    }

    const url = "{{ route('admin.jobs.get-subcategories', ':id') }}".replace(':id', categoryId);

    fetch(url)
        .then(res => res.json())
        .then(data => {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            data.forEach(sub => {
                subCategorySelect.innerHTML +=
                    `<option value="${sub.id}">${sub.name}</option>`;
            });
        })
        .catch(() => {
            subCategorySelect.innerHTML = '<option value="">Error loading</option>';
        });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {

    const shortDesc = document.getElementById('short_description');
    const fullDesc  = document.getElementById('description_editor');

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


<script>
    /* ===== Handle Edit Mode Preselection ===== */
stateDropdowns.forEach(stateSelect => {

    const selectedStateName = stateSelect.dataset.selected;
    if (!selectedStateName) return;

    [...stateSelect.options].forEach(opt => {
        if (opt.value === selectedStateName) {  
            opt.selected = true;
            stateSelect.dispatchEvent(new Event('change'));
        }
    });

    const districtSelect = document.getElementById(stateSelect.dataset.target);
    const selectedDistrict = districtSelect?.dataset.selected;

    if (selectedDistrict) {
        setTimeout(() => {
            [...districtSelect.options].forEach(opt => {
                if (opt.value === selectedDistrict) {
                    opt.selected = true;
                }
            });
        }, 100);
    }
});

</script>
@endpush


