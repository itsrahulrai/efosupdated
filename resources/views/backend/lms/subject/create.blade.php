@extends('backend.layout.layouts')

@section('title',
    isset($subject)
    ? 'Edit Category | EFOS Edumarketers Pvt Ltd'
    : 'Add Category | EFOS Edumarketers Pvt
    Ltd')

@section('content')

    @php
        $isEdit = isset($subject);
    @endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit Category' : 'Add Category' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pages.index') }}">Category</a>
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
                                action="{{ $isEdit ? route('admin.subject.update', $subject->id) : route('admin.subject.store') }}">

                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                <div class="row">

                                    {{-- SUBJECT NAME --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"> Name *</label>
                                        <input type="text" id="subject_name" name="name" class="form-control" required
                                            value="{{ old('name', $subject->name ?? '') }}"
                                            placeholder="Enter category name">
                                    </div>

                                    {{-- SLUG --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" id="subject_slug" name="slug" class="form-control"
                                            value="{{ old('slug', $subject->slug ?? '') }}"
                                            placeholder="Auto-generated if empty">
                                    </div>

                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="subject_content" class="form-control" rows="6"
                                        placeholder="Enter category description">{{ old('description', $subject->description ?? '') }}</textarea>
                                </div>
                                <hr>

                                {{-- STATUS --}}
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1"
                                            {{ old('status', $subject->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $subject->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                {{-- SUBMIT --}}
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEdit ? 'Update' : 'Submit' }}
                                </button>

                                <a href="{{ route('admin.subject.index') }}" class="btn btn-secondary ms-2">
                                    Cancel
                                </a>

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
        const nameInput = document.getElementById('subject_name');
        const slugInput = document.getElementById('subject_slug');
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
    </script>
@endpush
