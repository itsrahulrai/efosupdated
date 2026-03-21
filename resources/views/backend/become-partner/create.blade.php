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

                    <form
                        action="{{ $isEdit ? route('admin.become-partner.update', $franchise->id) : route('admin.become-partner.store') }}"
                        method="POST">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif
                        <div class="row">

                            <!-- Owner Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Owner Name</label>
                                <input type="text" class="form-control" name="owner_name"
                                    value="{{ old('owner_name', $franchise->owner_name ?? '') }}">
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
                                <input type="text" class="form-control" name="phone" value="{{ $franchise->phone }}">
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $franchise->email }}">
                            </div>

                            <!-- State -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state" value="{{ $franchise->state }}">
                            </div>

                            <!-- District -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">District</label>
                                <input type="text" class="form-control" name="district"
                                    value="{{ $franchise->district }}">
                            </div>

                            <!-- Address -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2" placeholder="Enter full address">{{ old('address', $franchise->address ?? '') }}</textarea>
                            </div>


                            <div class="row">

                                <!-- Business Experience -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Business Experience</label>
                                    <select class="form-select" name="business_experience">
                                        @foreach (['0-1', '1-3', '3-5', '5+'] as $exp)
                                            <option value="{{ $exp }}"
                                                {{ old('business_experience', $franchise->business_experience ?? '') == $exp ? 'selected' : '' }}>
                                                {{ $exp }} Years
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="pending" {{ $franchise->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="approved" {{ $franchise->status == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="rejected" {{ $franchise->status == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>
                                </div>

                                <!-- Active Status -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Active Status</label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" {{ $franchise->is_active == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $franchise->is_active == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <!-- Franchise Code -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Franchise Code</label>
                                <input type="text" class="form-control" name="franchise_code"
                                    value="{{ $franchise->franchise_code }}">
                            </div>

                            <!-- Map Location -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Map Location</label>

                                <input type="text" class="form-control mb-2" name="location" id="locationInput"
                                    value="{{ old('location', $franchise->location ?? '') }}"
                                    placeholder="Enter address or place name">


                            </div>


                            <!-- Investment Range -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Investment Range</label>
                                <input type="text" class="form-control" name="investment_range"
                                    value="{{ $franchise->investment_range }}">
                            </div>

                            <!-- Approved By (Admin ID) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Approved By</label>

                                <select class="form-select" name="approved_by">
                                    <option value="">-- Select Admin --</option>

                                    @foreach ($admins as $admin)
                                        <option value="{{ $admin->id }}"
                                            {{ old('approved_by', $franchise->approved_by ?? '') == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Message -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="3">{{ old('message', $franchise->message ?? '') }}</textarea>

                            </div>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? 'Update' : 'Submit' }}
                        </button>

                        <a href="{{ route('admin.become-partner.index') }}" class="btn btn-secondary ms-2">
                            Cancel
                        </a>

                    </form>
                </div>
    </main>

@endsection

@push('script')
@endpush
