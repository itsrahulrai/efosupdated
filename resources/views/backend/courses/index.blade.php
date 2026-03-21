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

                             <a href="{{ route('admin.courses.create') }}"
                                 class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                 + Add New
                             </a>
                         </div>

                         <div class="card-body p-0 pb-2">
                             <table class="table display mb-0">
                                 <thead class="table-light">
                                     <tr>
                                         <th width="60">#</th>
                                         <th>Course</th>
                                         <th>Image</th>
                                         <th>Short Description</th>
                                         <th>Status</th>
                                         <th class="text-end">Action</th>
                                     </tr>
                                 </thead>

                                 <tbody>
                                     @forelse ($courses as $index => $course)
                                         <tr>
                                             <td>{{ $courses->firstItem() + $index }}</td>
                                             <td>
                                                 <div class="fw-semibold">{{ $course->title }}</div>
                                             </td>
                                             <td>
                                                 @if ($course->image)
                                                     <img src="{{ static_asset('uploads/courses/' . $course->image) }}"
                                                         class="mt-1 border rounded" width="80px">
                                                 @endif
                                             </td>
                                             <td>
                                                 {{ \Illuminate\Support\Str::limit($course->short_description, 60) }}
                                             </td>
                                             <td>
                                                 @if ($course->status)
                                                     <span class="badge bg-success">Active</span>
                                                 @else
                                                     <span class="badge bg-danger">Inactive</span>
                                                 @endif
                                             </td>
                                             <td class="text-end">
                                                 <a href="{{ route('admin.courses.edit', $course->id) }}"
                                                     class="btn btn-sm btn-primary me-1">
                                                     Edit
                                                 </a>
                                                 <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                                     method="POST" class="d-inline"
                                                     onsubmit="return confirm('Are you sure you want to delete this course?');">
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
                                             <td colspan="6">
                                                 <div class="text-center py-5">
                                                     <i class="bi bi-journal-bookmark fs-1 text-muted mb-3"></i>
                                                     <h6 class="fw-semibold">No Courses Found</h6>
                                                     <p class="text-muted mb-0">
                                                         Courses will appear here once you add them.
                                                     </p>
                                                 </div>
                                             </td>
                                         </tr>
                                     @endforelse
                                 </tbody>
                             </table>

                             {{-- Pagination --}}
                             @if ($courses->count())
                                 <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                                     <div class="text-muted small">
                                         Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }}
                                         of {{ $courses->total() }} Courses
                                     </div>
                                     <div>
                                         {{ $courses->links('pagination::bootstrap-5') }}
                                     </div>
                                 </div>
                             @endif
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </main>

 @endsection
