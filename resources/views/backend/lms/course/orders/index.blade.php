@extends('backend.layout.layouts')
@section('title', 'Courses - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Courses Orders</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Courses Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Courses Orders</h6>
                        </div>

                        <div class="card-body p-0 pb-2">
                            <table class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th width="70">S.No</th>
                                        <th>Thumbnail</th>
                                        <th>Course</th>
                                        <th>Student</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Transaction ID</th>
                                        <th>Purchased At</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($courseOrders as $index => $order)
                                        <tr>
                                            <td>{{ $courseOrders->firstItem() + $index }}</td>

                                            <td>
                                                @if ($order->course->thumbnail)
                                                    <img src="{{ static_asset($order->course->thumbnail) }}" width="60"
                                                        class="rounded">
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            <td>{{ $order->course->title ?? '-' }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>

                                            <td>₹ {{ number_format($order->amount, 2) }}</td>

                                            <td>
                                                @if ($order->payment_status == 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($order->payment_status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>

                                            <td>{{ $order->transaction_id }}</td>
                                            <td>{{ $order->purchased_at?->format('d M Y') ?? 'N/A' }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.course-orders.destroy', $order->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                No Orders Found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            {{-- Pagination --}}
                            @if ($courseOrders->hasPages())
                                <div class="d-flex justify-content-end px-3">
                                    {{ $courseOrders->links() }}
                                </div>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('script')
    <script>
        $(document).on('change', '.toggle-status', function() {
            let categoryId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.learning-course.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: categoryId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });

        function confirmDelete() {
            return confirm("Are you sure you want to permanently delete this category?");
        }
    </script>
@endpush
