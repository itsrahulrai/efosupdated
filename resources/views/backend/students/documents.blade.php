@extends('backend.layout.layouts')
@section('title', 'Documents - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

<main class="app-wrapper">

    <div class="container">

        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title"> Documents</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Documents</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title mb-0">Students</h6>

                    </div>



                    <div class="card-body p-0 pb-2">

                        {{-- UPLOAD DOCUMENTS --}}
                        <div class="mb-4 p-3 border rounded bg-light">

                            <h5 class="fw-semibold mb-1">Upload Documents</h5>
                            <p class="text-muted mb-3">
                                Add document title and upload files (Aadhaar, Resume, Certificates, etc.)
                            </p>

                            <form action="{{ route('admin.students.documents.upload', $student->id) }}"
                                method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div id="document-wrapper">

                                    {{-- SINGLE ROW --}}
                                    <div class="row g-3 align-items-end document-row mb-2">

                                        <div class="col-md-4">
                                            <label class="form-label">Document Title</label>
                                            <input type="text"
                                                name="documents[0][title]"
                                                class="form-control"
                                                placeholder=""
                                                required>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">Select File</label>
                                            <input type="file"
                                                name="documents[0][file]"
                                                class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png"
                                                required>
                                        </div>

                                        <div class="col-md-3 text-end">
                                            <button type="button"
                                                class="btn btn-danger btn-sm remove-row d-none">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button"
                                        class="btn btn-outline-primary"
                                        id="add-more">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Add More Document
                                    </button>

                                    <button class="btn btn-primary">
                                        <i class="bi bi-upload me-1"></i>
                                        Upload Documents
                                    </button>
                                </div>

                            </form>
                        </div>


                        @forelse($student->documents as $doc)
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">

                            <div>
                                <div class="fw-medium">{{ $doc->title }}</div>
                                <small class="text-muted">
                                    {{ strtoupper($doc->file_type) }} • {{ $doc->file_size }} KB
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                {{-- VIEW --}}
                                <a href="{{ static_asset($doc->file_path) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                {{-- DOWNLOAD --}}
                                <a href="{{ static_asset($doc->file_path) }}"
                                    download
                                    class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-download"></i> Download
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.students.documents.delete', $doc->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this document?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                        @empty
                        <p class="text-muted mb-0 mx-3">No documents uploaded.</p>
                        @endforelse



                    </div>
                </div>
            </div>
        </div>
</main>

@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        let index = 1;

        document.getElementById('add-more').addEventListener('click', function() {

            const wrapper = document.getElementById('document-wrapper');

            const row = document.createElement('div');
            row.className = 'row g-3 align-items-end document-row mb-2';

            row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label">Document Title</label>
                <input type="text"
                       name="documents[${index}][title]"
                       class="form-control"
                       placeholder=""
                       required>
            </div>

            <div class="col-md-5">
                <label class="form-label">Select File</label>
                <input type="file"
                       name="documents[${index}][file]"
                       class="form-control"
                       accept=".pdf,.jpg,.jpeg,.png"
                       required>
            </div>

            <div class="col-md-3 text-end">
                <button type="button"
                        class="btn btn-danger btn-sm remove-row">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
        `;

            wrapper.appendChild(row);
            index++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                e.target.closest('.document-row').remove();
            }
        });

    });
</script>
@endpush