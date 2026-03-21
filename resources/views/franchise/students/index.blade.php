 @extends('backend.layout.layouts')
 @section('title', 'Students - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

     <main class="app-wrapper">

         <div class="container">

             <div class="app-page-head d-flex align-items-center justify-content-between">
                 <div class="clearfix">
                     <h1 class="app-page-title"> Students</h1>
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0">
                             <li class="breadcrumb-item">
                                 <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">Students</li>
                         </ol>
                     </nav>
                 </div>
             </div>

             <div class="row">
                 <div class="col-lg-12">
                     <div class="card overflow-hidden">
                         <div class="card-header d-flex align-items-center justify-content-between">
                             <h6 class="card-title mb-0">Students</h6>
                         </div>

                         <div class="card-body p-0 pb-2">

                             <div class="table-responsive">
                                 <table class="table display">
                                     <thead class="table-light">
                                         <tr>
                                             <th width="60">#</th>
                                             <th>Name</th>
                                             <th>Reg. No</th>
                                             <th>Phone</th>
                                             <th>Email</th>
                                             <th>Location</th>
                                             <th>Looking For</th>
                                             <th>Status</th>
                                         </tr>
                                     </thead>


                                     <tbody>
                                         @forelse ($students as $index => $student)
                                             <tr>
                                                 <td>{{ $students->firstItem() + $index }}</td>

                                                 <td>
                                                     <div class="fw-semibold">{{ $student->name }}</div>
                                                     <small class="text-muted">{{ $student->gender }} |
                                                         {{ $student->age_group }}</small>
                                                 </td>

                                                 <td>{{ $student->registration_number }}</td>

                                                 <td>{{ $student->phone }}</td>

                                                 <td>{{ $student->email }}</td>

                                                 <td>
                                                     {{ $student->district }},
                                                     <span class="text-muted">{{ $student->state }}</span>
                                                 </td>

                                                 <td>
                                                     <span class="badge bg-info-subtle text-dark">
                                                         {{ $student->looking_for }}
                                                     </span>
                                                 </td>

                                                 <td>
                                                     <select class="form-select form-select-sm profile-status"
                                                         data-id="{{ $student->id }}">
                                                         <option value="pending"
                                                             {{ $student->profile_completed === 'pending' ? 'selected' : '' }}>
                                                             Pending</option>
                                                         <option value="processing"
                                                             {{ $student->profile_completed === 'processing' ? 'selected' : '' }}>
                                                             Processing</option>
                                                         <option value="completed"
                                                             {{ $student->profile_completed === 'completed' ? 'selected' : '' }}>
                                                             Completed</option>
                                                         <option value="rejected"
                                                             {{ $student->profile_completed === 'rejected' ? 'selected' : '' }}>
                                                             Rejected</option>
                                                         <option value="on_hold"
                                                             {{ $student->profile_completed === 'on_hold' ? 'selected' : '' }}>
                                                             On Hold</option>
                                                     </select>

                                                 </td>



                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="9">
                                                     <div class="text-center py-5">
                                                         <i class="bi bi-people fs-1 text-muted mb-3"></i>
                                                         <h6 class="fw-semibold">No Students Found</h6>
                                                         <p class="text-muted mb-0">
                                                             Students will appear here once they register.
                                                         </p>
                                                     </div>
                                                 </td>
                                             </tr>
                                         @endforelse
                                     </tbody>





                                 </table>
                                 <!-- Pagination -->
                                 <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                                     <div class="text-muted small">
                                         Showing {{ $students->firstItem() }} to {{ $students->lastItem() }}
                                         of {{ $students->total() }} Students
                                     </div>
                                     <div>
                                         {{ $students->links('pagination::bootstrap-5') }}
                                     </div>

                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
     </main>

 @endsection
