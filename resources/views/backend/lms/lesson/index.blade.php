@extends('backend.layout.layouts')
@section('title', 'Chapter Lesson - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Chapter Lesson</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chapter Lesson</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Chapter Lesson</h6>
                            <a href="{{ route('admin.lesson.create') }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                + Add New
                            </a>
                        </div>

                        <div class="card-body p-0 pb-2">
                            <table class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th width="70">S.No</th>
                                        <th>Course</th>
                                        <th>Chapter</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th>Preview</th>
                                        <th>Mandatory</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lessons as $index => $lesson)
                                        <tr>
                                            <td>{{ $lessons->firstItem() + $index }}</td>

                                            {{-- Course --}}
                                            <td>{{ $lesson->course->title ?? '-' }}</td>

                                            {{-- Chapter --}}
                                            <td>{{ $lesson->chapter->title ?? '-' }}</td>

                                            {{-- Lesson Name --}}
                                            <td>{{ $lesson->title }}</td>

                                            {{-- Type --}}
                                            <td>
                                                <span class="badge bg-info text-capitalize">
                                                    {{ $lesson->type }}
                                                </span>
                                            </td>

                                            {{-- Duration --}}
                                            <td>
                                                {{ gmdate('i:s', $lesson->duration_seconds) }}
                                            </td>

                                            {{-- Preview --}}
                                            <td>
                                                @if ($lesson->is_free_preview)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>

                                            {{-- Mandatory --}}
                                            <td>
                                                @if ($lesson->is_mandatory)
                                                    <span class="badge bg-danger">Yes</span>
                                                @else
                                                    <span class="badge bg-warning">Optional</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                <div class="form-check form-switch fs-5">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        data-id="{{ $lesson->id }}"
                                                        {{ $lesson->status ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- Action --}}
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('admin.lesson.edit', $lesson->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>

                                                    <form action="{{ route('admin.lesson.destroy', $lesson->id) }}"
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
                                                No lessons found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>


                            </table>

                            {{-- Pagination --}}
                            @if ($lessons->hasPages())
                                <div class="d-flex justify-content-end px-3">
                                    {{ $lessons->links() }}
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
                url: "{{ route('admin.lesson.status') }}",
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
