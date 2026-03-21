 @extends('backend.layout.layouts')
 @section('title', 'Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

     <main class="app-wrapper">
         <div class="container">
             <div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
                 <div class="clearfix">
                     <h1 class="app-page-title">Dashboard</h1>
                     <span id="liveDateTime"></span>
                 </div>
             </div>



             <div class="row">
                 <div class="col-3">
                     <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                         <div class="card-body">
                             <div class="avatar bg-secondary shadow-secondary rounded-circle text-white mb-3">
                                 <i class="fi fi-sr-users"></i>
                             </div>
                             <h3>{{ $totalStudents }}</h3>
                             <h6 class="mb-0">Total Students</h6>
                         </div>
                     </div>
                 </div>

                 <div class="col-3">
                     <div class="card bg-info bg-opacity-05 shadow-none border-0">
                         <div class="card-body">
                             <div class="avatar bg-info shadow-info rounded-circle text-white mb-3">
                                 <i class="fi fi-sr-user-add"></i>
                             </div>
                             <h3>{{ $totalFranchise }}</h3>
                             <h6 class="mb-0">Franchise Center</h6>
                         </div>
                     </div>
                 </div>

                 <div class="col-3">
                     <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                         <div class="card-body">
                             <div class="avatar bg-warning shadow-warning rounded-circle text-white mb-3">
                                 <i class="fi fi-rr-calendar"></i>
                             </div>
                             <h3>{{ $jobapplication }}</h3>
                             <h6 class="mb-0">Job Application</h6>
                         </div>
                     </div>
                 </div>

                 <div class="col-3">
                     <div class="card bg-danger bg-opacity-05 shadow-none border-0">
                         <div class="card-body">
                             <div class="avatar bg-danger shadow-danger rounded-circle text-white mb-3">
                                 <i class="fi fi-rr-document"></i>
                             </div>
                             <h3>{{ $totalBlogs }}</h3>
                             <h6 class="mb-0">Blogs</h6>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </main>

 @endsection
