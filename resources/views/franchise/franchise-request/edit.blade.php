@extends('backend.layout.layouts')
@section('title', 'Edit Franchise Request')

@section('content')

<main class="app-wrapper">
    <div class="container">

        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">Edit Franchise Request</h1>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Franchise Details</h6>
            </div>

            <div class="card-body">

                <form action="{{ route('franchise.update', $franchise->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Owner Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Owner Name</label>
                            <input type="text" class="form-control" name="owner_name"
                                   value="{{ $franchise->owner_name }}">
                        </div>

                        <!-- Company Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="company_name"
                                   value="{{ $franchise->company_name }}">
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                   value="{{ $franchise->phone }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ $franchise->email }}">
                        </div>

                        <!-- State -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state"
                                   value="{{ $franchise->state }}">
                        </div>

                        <!-- District -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">District</label>
                            <input type="text" class="form-control" name="district"
                                   value="{{ $franchise->district }}">
                        </div>

                        <!-- Business Experience -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Business Experience</label>
                            <input type="text" class="form-control" name="business_experience"
                                   value="{{ $franchise->business_experience }}">
                        </div>

                        <!-- Investment Range -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Investment Range</label>
                            <input type="text" class="form-control" name="investment_range"
                                   value="{{ $franchise->investment_range }}">
                        </div>

                        <!-- Location -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location"
                                   value="{{ $franchise->location }}">
                        </div>

                        <!-- Franchise Code -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Franchise Code</label>
                            <input type="text" class="form-control" name="franchise_code"
                                   value="{{ $franchise->franchise_code }}">
                        </div>

                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</main>

@endsection
