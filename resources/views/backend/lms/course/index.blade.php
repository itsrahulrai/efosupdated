@extends('backend.layout.layouts')
@section('title', 'Courses - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Courses</h6>
                            <a href="{{ route('admin.learning-course.create') }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                + Add New
                            </a>
                        </div>

                        <div class="card-body p-0 pb-2">
                            <table class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th width="70">S.No</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Language</th>
                                        <th>Duration</th>
                                        <th>Subject</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($learningCourse as $index => $course)
                                        <tr>
                                            <td>{{ $learningCourse->firstItem() + $index }}</td>
                                            <td>
                                                @if ($course->thumbnail)
                                                    <img src="{{ static_asset($course->thumbnail) }}" width="60"
                                                        class="rounded">
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->slug }}</td>
                                            <td>{{ $course->language ?? '-' }}</td>
                                            <td>{{ $course->duration ?? '-' }}</td>
                                            <td>{{ $course->subject->name ?? '-' }}</td>
                                            <td>
                                                @if ($course->is_free)
                                                    <span class="badge bg-success">Free</span>
                                                @else
                                                    ₹ {{ number_format($course->price) }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-check form-switch fs-5">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        data-id="{{ $course->id }}"
                                                        {{ $course->status ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- Action --}}
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('admin.learning-course.edit', $course->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>

                                                    <form
                                                        action="{{ route('admin.learning-course.destroy', $course->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">
                                                No courses found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            @if ($learningCourse->hasPages())
                                <div class="d-flex justify-content-end px-3">
                                    {{ $learningCourse->links() }}
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
     $(document).off('change', '.toggle-status').on('change', '.toggle-status', function() {
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
