@extends('backend.layout.layouts')

@section('title', 'Pages - Career Guidance Services | EFOS Edumarketers Pvt Ltd')

@section('content')

<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <h1 class="app-page-title">Pages</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Pages</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- CARD --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title mb-0">Pages</h6>
                        <a href="{{ route('admin.pages.create') }}"
                           class="btn btn-primary btn-sm">
                            + Add New Page
                        </a>
                    </div>

                    <div class="card-body p-0 pb-2">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="70">#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pages as $index => $page)
                                    <tr>
                                        <td>{{ $pages->firstItem() + $index }}</td>

                                        <td>{{ $page->name }}</td>

                                        <td>
                                            <code>{{ $page->slug }}</code>
                                        </td>

                                        {{-- STATUS --}}
                                        <td>
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input toggle-status"
                                                    type="checkbox"
                                                    data-id="{{ $page->id }}"
                                                    {{ $page->status ? 'checked' : '' }}>
                                            </div>
                                        </td>

                                        {{-- ACTION --}}
                                        <td class="text-end">
                                            <a href="{{ route('admin.pages.edit', $page->id) }}"
                                               class="btn btn-sm btn-primary">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.pages.destroy', $page->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this page?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No pages found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- PAGINATION --}}
                        @if ($pages->hasPages())
                            <div class="p-3">
                                {{ $pages->links('pagination::bootstrap-5') }}
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
    $(document).on('change', '.toggle-status', function () {
        let pageId = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('admin.page.toggle-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: pageId,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function () {
                toastr.error('Status update failed');
            }
        });
    });
</script>
@endpush
