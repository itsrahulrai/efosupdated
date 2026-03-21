    @extends('backend.layout.layouts')
    @section('title', 'News & Event - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
    @section('content')

        <main class="app-wrapper">
            <div class="container">

                <div class="app-page-head d-flex align-items-center justify-content-between">
                    <div class="clearfix">
                        <h1 class="app-page-title"> News & Event </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">News & Event </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h6 class="card-title mb-0">Blogs</h6>
                                <a href="{{ route('admin.news-events.create') }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                    + Add New
                                </a>
                            </div>

                            <div class="card-body p-0 pb-2">
                                <table id="dt_basic" class="table display">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="minw-200px">Image</th>
                                            <th class="minw-200px">Name</th>
                                            <th class="minw-150px">Slug</th>
                                            <th class="minw-150px">Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($items as $item)
                                            <tr>
                                                {{-- IMAGE --}}
                                               <td>
                                                    @if($item->images->count())
                                                        <img src="{{ static_asset($item->images->first()->image) }}"
                                                            width="60" height="60"
                                                            style="object-fit:cover;border-radius:6px;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>


                                                {{-- TITLE --}}
                                                <td>{{ $item->heading }}</td>

                                                {{-- SLUG --}}
                                                <td>{{ \Illuminate\Support\Str::slug($item->heading) }}</td>

                                                {{-- STATUS --}}
                                                <td>
                                                    <span class="badge bg-success">Active</span>
                                                </td>

                                                {{-- ACTION BUTTONS --}}
                                                <td class="text-end">
                                                    <a href="{{ route('admin.news-events.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                    <form action="{{ route('admin.news-events.destroy', $item->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No records found</td>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#dt_basic').DataTable();
            });
        </script>
    @endpush
