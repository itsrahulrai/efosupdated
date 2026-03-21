@extends('backend.layout.layouts')

@section('title', isset($company) ? 'Edit Company | EFOS Edumarketers Pvt Ltd' : 'Add Company | EFOS Edumarketers Pvt Ltd')

@section('content')

<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title">
                    {{ isset($company) ? 'Edit Company' : 'Add Company' }}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.companies.index') }}">Company</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ isset($company) ? 'Edit Company' : 'Add Company' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- FORM --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h6 class="card-title">
                            {{ isset($company) ? 'Update Company Details' : 'Add Company Details' }}
                        </h6>
                    </div>

                    <div class="card-body">
                        <form class="row"
                              method="POST"
                              action="{{ isset($company) ? route('admin.companies.update', $company->id) : route('admin.companies.store') }}"
                              enctype="multipart/form-data">

                            @csrf
                            @if(isset($company))
                                @method('PUT')
                            @endif

                            {{-- COMPANY NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text"
                                       name="company_name"
                                       class="form-control"
                                       value="{{ old('company_name', $company->company_name ?? '') }}"
                                       required>
                            </div>

                            {{-- COMPANY TYPE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Type</label>
                                <select name="company_type" class="form-control" required>
                                    <option value="">Select Company Type</option>
                                    @foreach(['Private Limited','Public Limited','Partnership','Proprietorship','LLP','Startup'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('company_type', $company->company_type ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ADDRESS --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="3"
                                          required>{{ old('address', $company->address ?? '') }}</textarea>
                            </div>

                            {{-- LOGO --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Company Logo</label>

                                <input type="file" name="logo" class="form-control">

                                @if(isset($company) && $company->logo)
                                    <div class="mt-2">
                                        <img src="{{ static_asset($company->logo) }}"
                                            alt="Company Logo"
                                            style="height:80px;border:1px solid #ddd;padding:4px;border-radius:4px">
                                    </div>
                                @endif
                            </div>


                            {{-- SUBMIT --}}
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($company) ? 'Update' : 'Submit' }}
                                </button>

                                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary ms-2">
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
