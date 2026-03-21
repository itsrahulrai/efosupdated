@extends('backend.layout.layouts')

@section('title', 'Job Categories - Career Guidance Services | EFOS Edumarketers Pvt Ltd')

@section('content')

@php
    $isEdit = isset($jobCategory);
@endphp

<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title">
                    {{ $isEdit ? 'Edit Job Category' : 'Add Job Category' }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Job Categories
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- CARD --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h6 class="card-title">
                            {{ $isEdit ? 'Update Category' : 'Create Category' }}
                        </h6>
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
                        <form class="row"
                              method="POST"
                              action="{{ $isEdit
                                  ? route('admin.job-categories.update', $jobCategory->id)
                                  : route('admin.job-categories.store') }}">

                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            {{-- NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control"
                                       placeholder="Enter Category Name"
                                       value="{{ old('name', $jobCategory->name ?? '') }}"
                                       required>
                            </div>

                            {{-- SLUG --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control"
                                       placeholder="auto-generated"
                                       value="{{ old('slug', $jobCategory->slug ?? '') }}">
                                <small class="text-muted">
                                    Leave empty to auto-generate from name
                                </small>
                            </div>

                            {{-- SUBMIT --}}
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEdit ? 'Update' : 'Submit' }}
                                </button>

                                <a href="{{ route('admin.job-categories.index') }}"
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
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    let slugManuallyEdited = false;

    // Detect manual slug edit
    slugInput.addEventListener('input', function () {
        slugManuallyEdited = true;
    });

    nameInput.addEventListener('input', function () {
        const nameValue = this.value.trim();

        // If name cleared → clear slug and reset manual flag
        if (nameValue === '') {
            slugInput.value = '';
            slugManuallyEdited = false;
            return;
        }

        // Auto-generate slug ONLY if user has not edited slug manually
        if (!slugManuallyEdited) {
            slugInput.value = generateSlug(nameValue);
        }
    });

    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/&/g, 'and')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }
</script>


@endpush
