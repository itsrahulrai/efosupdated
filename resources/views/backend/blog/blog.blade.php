@extends('backend.layout.layouts')
@section('title', 'Blogs List - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">

            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Blogs List</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Blogs</h6>
                            <a href="{{ route('admin.blogs.create') }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                + Add New
                            </a>
                        </div>

                        <div class="card-body p-0 pb-2">
                            <table id="dt_basic" class="table display">
                                <thead class="table-light">
                                    <tr>
                                        <th class="minw-20px">S.No</th>
                                        <th class="minw-200px">Image</th>
                                        <th class="minw-200px">Name</th>
                                        <th class="minw-150px">Slug</th>
                                        <th class="minw-150px">Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tableBody">>
                                    @forelse($blogs as $index => $blog)
                                        <tr>
                                            <td></td>

                                            <td>
                                                @if ($blog->image && file_exists(public_path($blog->image)))
                                                    <img src="{{ static_asset($blog->image) }}" alt="{{ $blog->alt }}"
                                                        width="80" height="50">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>

                                            <td>{{ $blog->name }}</td>
                                            <td>{{ $blog->slug }}</td>

                                            <td>
                                                @if ($blog->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="text-end">
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                                    class="d-inline-block"
                                                    onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No blogs found.</td>
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

@push('script')
    <script>
        let count = 1;
        document.querySelectorAll("#tableBody tr").forEach(function(row) {
            row.children[0].innerHTML = count++;
        });
    </script>
@endpush
