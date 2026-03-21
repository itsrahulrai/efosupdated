@extends('backend.layout.layouts')
@section('title', 'Job Sub Categories - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

@php
    $isEdit = isset($jobSubCategory);
@endphp

<main class="app-wrapper">
    <div class="container">

        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title">
                    {{ $isEdit ? 'Edit Job Sub Category' : 'Add Job Sub Category' }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Job Sub Categories</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h6 class="card-title">Job Sub Category</h6>
                    </div>

                    <div class="card-body">

                        {{-- ERRORS --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- FORM --}}
                        <form class="row" method="POST"
                              action="{{ $isEdit
                                  ? route('admin.job-sub-categories.update', $jobSubCategory->id)
                                  : route('admin.job-sub-categories.store') }}">

                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            {{-- PARENT CATEGORY --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="job_category_id" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($jobcategories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('job_category_id', $jobSubCategory->job_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- SUB CATEGORY NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sub Category Name</label>
                                <input type="text"
                                       id="subcategory_name"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $jobSubCategory->name ?? '') }}"
                                       required>
                            </div>

                            {{-- SLUG --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text"
                                       id="subcategory_slug"
                                       name="slug"
                                       class="form-control"
                                       value="{{ old('slug', $jobSubCategory->slug ?? '') }}">
                                <small class="text-muted">Leave empty to auto-generate</small>
                            </div>

                            {{-- SUBMIT --}}
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEdit ? 'Update' : 'Submit' }}
                                </button>

                                <a href="{{ route('admin.job-sub-categories.index') }}"
                                   class="btn btn-secondary ms-2">
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
    const nameInput = document.getElementById('subcategory_name');
    const slugInput = document.getElementById('subcategory_slug');
    let slugEdited = false;

    slugInput.addEventListener('input', () => slugEdited = true);

    nameInput.addEventListener('input', function () {
        const value = this.value.trim();

        if (value === '') {
            slugInput.value = '';
            slugEdited = false;
            return;
        }

        if (!slugEdited) {
            slugInput.value = value
                .toLowerCase()
                .replace(/&/g, 'and')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }
    });
</script>
@endpush
