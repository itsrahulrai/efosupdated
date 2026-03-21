 @extends('backend.layout.layouts')
 @section('title', 'Job Sub Categories - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

 <main class="app-wrapper">

     <div class="container">

         <div class="app-page-head d-flex align-items-center justify-content-between">
             <div class="clearfix">
                 <h1 class="app-page-title">Job Sub Categories</h1>
                 <nav aria-label="breadcrumb">
                     <ol class="breadcrumb mb-0">
                         <li class="breadcrumb-item">
                             <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                         </li>
                         <li class="breadcrumb-item active" aria-current="page"> Job Sub Categories</li>
                     </ol>
                 </nav>
             </div>
         </div>

         <div class="row">
             <div class="col-lg-12">
                 <div class="card overflow-hidden">
                     <div class="card-header d-flex align-items-center justify-content-between">
                         <h6 class="card-title mb-0">Sub Categories</h6>
                         <a href="{{ route('admin.job-sub-categories.create') }}"
                             class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                             + Add New
                         </a>
                     </div>

                     <div class="card-body p-0 pb-2">
                         <table class="table display">
                             <thead class="table-light">
                                 <tr>
                                     <th width="70">S.No</th>
                                     <th class="minw-200px">Sub Category</th>
                                     <th class="minw-200px">Category</th>
                                     <th class="minw-150px">Slug</th>
                                     <th class="minw-150px">Status</th>
                                     <th class="text-end">Action</th>
                                 </tr>
                             </thead>


                             <tbody>
                                 @foreach ($subcategories as $index => $subcategory)
                                 <tr>
                                     <td>{{ $subcategories->firstItem() + $index }}</td>

                                     <td>{{ $subcategory->name }}</td>

                                     <td>
                                         <span class="badge bg-info">
                                             {{ $subcategory->category->name ?? '—' }}
                                         </span>
                                     </td>

                                     <td>{{ $subcategory->slug }}</td>

                                     <td>
                                         <div class="form-check form-switch fs-5">
                                             <input
                                                 class="form-check-input toggle-status"
                                                 type="checkbox"
                                                 data-id="{{ $subcategory->id }}"
                                                 {{ $subcategory->status ? 'checked' : '' }}>
                                         </div>
                                     </td>

                                     <td class="text-end">
                                         <a href="{{ route('admin.job-sub-categories.edit', $subcategory->id) }}"
                                             class="btn btn-sm btn-primary me-1">
                                             Edit
                                         </a>

                                        <form
                                            action="{{ route('admin.job-sub-categories.destroy', $subcategory->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirmDelete();"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>

                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>

                         </table>
                         <!-- Pagination -->
                         <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                             <div class="text-muted small">
                                 Showing {{ $subcategories->firstItem() }} to {{ $subcategories->lastItem() }}
                                 of {{ $subcategories->total() }} subcategories
                             </div>

                             <div>
                                 {{ $subcategories->links('pagination::bootstrap-5') }}
                             </div>
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
     $(document).on('change', '.toggle-status', function() {
         let subCategoryId = $(this).data('id');
         let status = $(this).is(':checked') ? 1 : 0;

         $.ajax({
             url: "{{ route('admin.job-sub-categories.toggle-status') }}",
             type: "POST",
             data: {
                 _token: "{{ csrf_token() }}",
                 id: subCategoryId,
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
         return confirm("Are you sure you want to permanently delete this subcategory?");
     }
 </script>
 @endpush
