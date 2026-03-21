@extends('backend.layout.layouts')
@section('title', isset($newsEvent) ? 'Edit News / Event | EFOS' : 'Add News / Event | EFOS')
@section('content')
<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">
                    {{ isset($newsEvent) ? 'Edit' : 'Add' }} News / Event
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.news-events.index') }}">News / Events</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ isset($newsEvent) ? 'Edit' : 'Add' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- FORM --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
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

                        <form method="POST"
                            action="{{ isset($newsEvent)
                                ? route('admin.news-events.update', $newsEvent->id)
                                : route('admin.news-events.store') }}"
                                                enctype="multipart/form-data">

                            @csrf
                            @if(isset($newsEvent))
                            @method('PUT')
                            @endif

                            <div class="row">

                                {{-- HEADING --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Heading *</label>
                                    <input type="text" name="heading" class="form-control"
                                        value="{{ old('heading', $newsEvent->heading ?? '') }}" required>
                                </div>

                                {{-- CATEGORY --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="News" {{ old('category', $newsEvent->category ?? '') == 'News' ? 'selected' : '' }}>News</option>
                                        <option value="Events" {{ old('category', $newsEvent->category ?? '') == 'Events' ? 'selected' : '' }}>Events</option>
                                    </select>
                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description *</label>
                                    <textarea name="description" class="form-control" rows="6" required>{{ old('description', $newsEvent->description ?? '') }}</textarea>
                                </div>

                                {{-- IMAGES --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">Add Images</label>

                                    <div id="image-fields">
                                        <div class="input-group mb-2">
                                            <input type="file" name="images[]" class="form-control">
                                            <button type="button" class="btn btn-primary" id="add-image-btn">+</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- SUBMIT --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($newsEvent) ? 'Update' : 'Save' }}
                                </button>

                                <a href="{{ route('admin.news-events.index') }}" class="btn btn-secondary ms-2">
                                    Cancel
                                </a>
                            </div>

                        </form>

                        @if(isset($newsEvent) && $newsEvent->images->count())
                        <div class="col-12 mt-4">
                            <label class="form-label fw-semibold mb-2">Existing Images</label>

                            <div class="d-flex flex-wrap gap-4">
                                @foreach($newsEvent->images as $img)
                                <div class="border rounded shadow-sm" style="width:120px; overflow:hidden;">

                                    <img src="{{ static_asset($img->image) }}"
                                        width="120" height="90"
                                        style="object-fit:cover"
                                        class="w-100">

                                    <div class="p-1 bg-light border-top">
                                        <form method="POST"
                                            action="{{ route('admin.news-events.image.delete', $img->id) }}"
                                            onsubmit="return confirm('Delete this image?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm w-100">
                                                Delete
                                            </button>
                                        </form>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const addBtn = document.getElementById('add-image-btn');
        const imageFields = document.getElementById('image-fields');

        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
            <input type="file" name="images[]" class="form-control" accept="image/*">
            <button type="button" class="btn btn-danger remove-field">X</button>
        `;
            imageFields.appendChild(div);
        });

        imageFields.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-field')) {
                e.target.closest('.input-group').remove();
            }
        });

    });
</script>
@endpush