    @extends('backend.layout.layouts')
    @section('title', 'Become Partner')

    @section('content')

        <main class="app-wrapper">
            <div class="container">

                <div class="app-page-head d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="app-page-title">Become Partner</h1>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Become Partner</li>
                        </ol>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Become Partner</h6>
                            </div>

                            <div class="card-body p-0">
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
                                                    <select class="form-select form-select-sm status-select"
                                                        data-id="{{ $request->id }}">

                                                        <option value="pending"
                                                            {{ $request->status == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>

                                                        <option value="approved"
                                                            {{ $request->status == 'approved' ? 'selected' : '' }}>
                                                            Approved
                                                        </option>

                                                        <option value="rejected"
                                                            {{ $request->status == 'rejected' ? 'selected' : '' }}>
                                                            Rejected
                                                        </option>

                                                    </select>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">

                                                        <!-- View (Blue) -->
                                                        <a href="{{ route('admin.become-partner.edit', $request->id) }}"
                                                            class="btn btn-sm btn-primary" title="View">
                                                            <i class="fi fi-rr-edit"></i>
                                                        </a>

                                                        <!-- Delete (Red) -->
                                                        <form
                                                            action="{{ route('admin.become-partner.destroy', $request->id) }}"
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


    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                document.querySelectorAll('.status-select').forEach(select => {

                    select.addEventListener('change', function() {

                        const status = this.value;
                        const id = this.dataset.id;

                        fetch(`{{ url('admin/become-partner') }}/${id}/update-status`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    status
                                })
                            })
                            .then(res => res.json())
                            .then(data => {

                                if (data.success) {
                                    // ✅ SUCCESS ALERT
                                    alert(data.message || 'Status updated successfully');
                                } else {
                                    // ❌ ERROR ALERT
                                    alert(data.message || 'Status update failed');
                                }

                            })
                            .catch(() => {
                                alert('Something went wrong!');
                            });

                    });

                });

            });
        </script>
    @endpush
