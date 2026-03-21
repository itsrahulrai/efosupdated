@extends('backend.layout.layouts')
@section('title', 'YouTube Videos | EFOS Edumarketers Pvt Ltd')

@section('content')
<main class="app-wrapper">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="app-page-head d-flex align-items-center justify-content-between">
            <div>
                <h1 class="app-page-title">YouTube Videos</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">YouTube</li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('admin.youtube.create') }}"
               class="btn btn-primary btn-sm">
                + Add Video
            </a>
        </div>

        {{-- TABLE --}}
        <div class="card mt-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Title</th>
                            <th>YouTube URL</th>
                            <th width="120">Status</th>
                            <th width="150" class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($videos as $index => $video)
                            <tr>
                                <td>{{ $videos->firstItem() + $index }}</td>

                                <td>{{ $video->title }}</td>

                                <td>
                                    <a href="{{ $video->youtube_url }}" target="_blank">
                                        {{ Str::limit($video->youtube_url, 40) }}
                                    </a>
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status"
                                            type="checkbox"
                                            data-id="{{ $video->id }}"
                                            {{ $video->status ? 'checked' : '' }}>
                                    </div>
                                </td>

                                {{-- ACTION --}}
                                <td class="text-end">
                                    <a href="{{ route('admin.youtube.edit', $video->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.youtube.destroy', $video->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this video?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No YouTube videos found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($videos->hasPages())
                <div class="card-footer">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
$(document).on('change', '.toggle-status', function () {

    let id = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: "{{ route('admin.youtube.toggle-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
            status: status
        },
        success: function (res) {
            if (res.success) {
                toastr.success(res.message);
            }
        },
        error: function () {
            toastr.error('Status update failed');
        }
    });
});
</script>
@endpush

