@extends('backend.layout.layouts')
@section('title', isset($youtube) ? 'Edit YouTube Video | EFOS' : 'Add YouTube Video | EFOS')

@section('content')
<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">
                    {{ isset($youtube) ? 'Edit YouTube Video' : 'Add YouTube Video' }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.youtube.index') }}">YouTube</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ isset($youtube) ? 'Edit' : 'Add' }}
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
                            action="{{ isset($youtube)
                                    ? route('admin.youtube.update', $youtube->id)
                                    : route('admin.youtube.store') }}">

                            @csrf
                            @if(isset($youtube))
                            @method('PUT')
                            @endif

                            <div class="row">

                                {{-- TITLE --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Video Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        name="title"
                                        class="form-control"
                                        placeholder="Enter video title"
                                        value="{{ old('title', $youtube->title ?? '') }}"
                                        required>
                                </div>

                                {{-- SORT ORDER --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number"
                                        name="sort_order"
                                        class="form-control"
                                        placeholder="0"
                                        value="{{ old('sort_order', $youtube->sort_order ?? 0) }}">
                                </div>

                                {{-- STATUS --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1"
                                            {{ old('status', $youtube->status ?? 1) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $youtube->status ?? 1) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                {{-- YOUTUBE URL INPUT --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        YouTube URL <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        name="youtube_url"
                                        id="youtube_url"
                                        class="form-control"
                                        placeholder="https://www.youtube.com/watch?v=XXXX"
                                        value="{{ old('youtube_url', $youtube->youtube_url ?? '') }}"
                                        required>
                                </div>

                                {{-- PREVIEW --}}
                                @if(isset($youtube))
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Preview</label>

                                    <div class="ratio ratio-16x9 rounded border" style="max-width: 320px;">
                                        <iframe
                                            src="{{ youtube_embed($youtube->youtube_url) }}"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                                @endif



                            </div>

                            {{-- SUBMIT --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($youtube) ? 'Update' : 'Submit ' }}
                                </button>

                                <a href="{{ route('admin.youtube.index') }}"
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
    document.getElementById('youtube_url').addEventListener('input', function() {
        const iframe = document.getElementById('ytPreview');
        const match = this.value.match(/(?:v=|\/)([0-9A-Za-z_-]{11})/);
        iframe.src = match ? `https://www.youtube.com/embed/${match[1]}` : '';
    });
    rame.src = match ? `https://www.youtube.com/embed/${match[1]}` : '';
    });
</script>

@endpush