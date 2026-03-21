@extends('backend.layout.layouts')
@section('title', isset($blog) ? 'Edit Blog | EFOS Edumarketers Pvt Ltd' : 'Add Blog | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title">{{ isset($blog) ? 'Edit Company' : 'Add Company' }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.companies.index') }}"> Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($blog) ? 'Edit Company' : 'Add Company' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Company</h6>
                            <a href="{{ isset($company) ? route('admin.companies.edit', $company->id) : route('admin.companies.create') }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">

                                {{ isset($company) ? 'Edit Company' : '+ Add Company' }}
                            </a>

                        </div>
                        <div class="card-body p-0 pb-2">
                            <table id="dt_basic" class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th class="minw-200px">Image</th>
                                        <th class="minw-200px">Name</th>
                                        <th class="minw-200px">Type</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($companies as $company)
                                        <tr>
                                            <!-- Image -->
                                            <td>
                                                @if ($company->logo)
                                                    <img src="{{ static_asset($company->logo) }}"
                                                        alt="{{ $company->company_name }}" width="60" class="rounded">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>

                                            <!-- Name -->
                                            <td>{{ $company->company_name }}</td>
                                            <td>{{ $company->company_type }}</td>

                                            <!-- Action -->
                                            <td class="text-end">
                                                <a href="{{ route('admin.companies.edit', $company->id) }}"
                                                    class="btn btn-sm btn-info">Edit</a>

                                                <form action="{{ route('admin.companies.destroy', $company->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this company?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Company Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
