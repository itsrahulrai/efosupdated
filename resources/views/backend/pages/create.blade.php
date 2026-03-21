@extends('backend.layout.layouts')

@section('title', isset($page) ? 'Edit Page | EFOS Edumarketers Pvt Ltd' : 'Add Page | EFOS Edumarketers Pvt Ltd')

@section('content')

    @php
        $isEdit = isset($page);
    @endphp

    <main class="app-wrapper">
        <div class="container">

            {{-- HEADER --}}
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">
                        {{ $isEdit ? 'Edit Page' : 'Add Page' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pages.index') }}">Pages</a>
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
                                action="{{ $isEdit ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                <div class="row">

                                    {{-- NAME --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Page Name *</label>
                                        <input type="text" id="page_name" name="name" class="form-control" required
                                            value="{{ old('name', $page->name ?? '') }}" placeholder="Enter page name">
                                    </div>

                                    {{-- SLUG --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" id="page_slug" name="slug" class="form-control"
                                            value="{{ old('slug', $page->slug ?? '') }}"
                                            placeholder="Auto-generated if empty">
                                    </div>

                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="mb-3">
                                    <label class="form-label">Page Content</label>
                                    <textarea name="description" id="page_content" class="form-control" rows="6">{{ old('description', $page->description ?? '') }}</textarea>
                                </div>

                                <hr>

                                {{-- SEO --}}
                                <h5 class="mb-3">SEO Settings</h5>

                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="{{ old('meta_title', $page->meta_title ?? '') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control"
                                        value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Canonical URL</label>
                                    <input type="url" name="canonical_url" class="form-control"
                                        value="{{ old('canonical_url', $page->canonical_url ?? '') }}">
                                </div>

                                {{-- STATUS --}}
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1"
                                            {{ old('status', $page->status ?? 1) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $page->status ?? 1) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                {{-- SUBMIT --}}
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEdit ? 'Update' : 'Submit' }}
                                </button>

                                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary ms-2">
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
        // Auto slug
        const nameInput = document.getElementById('page_name');
        const slugInput = document.getElementById('page_slug');
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
        new Jodit('#page_content', {
            height: 350
        });
    </script>
@endpush
