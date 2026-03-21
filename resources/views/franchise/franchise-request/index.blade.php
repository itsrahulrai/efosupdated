@extends('backend.layout.layouts')
@section('title', 'Franchise Requests')

@section('content')

    <main class="app-wrapper">
        <div class="container">

            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="app-page-title">Franchise Requests</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Franchise Requests</li>
                    </ol>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header">
                            <h6 class="card-title mb-0">All Requests</h6>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Owner Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>State</th>
                                            <th>District</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($franchiseRequests as $request)
                                            <tr>
                                                <td>{{ $franchiseRequests->firstItem() + $loop->index }}</td>

                                                <td>{{ $request->owner_name }}</td>
                                                <td>{{ $request->phone }}</td>
                                                <td>{{ $request->email }}</td>
                                                <td>{{ $request->state }}</td>
                                                <td>{{ $request->district }}</td>
                                                <td>
                                                    @if ($request->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($request->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">

                                                        <!-- View (Blue) -->
                                                        <a href="{{ route('franchise.edit', $request->id) }}"
                                                            class="btn btn-sm btn-primary" title="View">
                                                            <i class="fi fi-rr-eye"></i>
                                                        </a>

                                                        <!-- Delete (Red) -->
                                                        <form action="{{ route('franchise.destroy', $request->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Delete this request?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger" title="Delete">
                                                                <i class="fi fi-rr-trash"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- Pagination -->
                                <div class="p-3">
                                    {{ $franchiseRequests->links('pagination::bootstrap-5') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </main>

@endsection
