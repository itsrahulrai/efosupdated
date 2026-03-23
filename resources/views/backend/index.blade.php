 @extends('backend.layout.layouts')
 @section('title', 'Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

     <main class="app-wrapper">

         <div class="container">

             <div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
                 <div class="clearfix">
                     <h1 class="app-page-title">Dashboard</h1>
                 </div>
             </div>

             <div class="row">

                 <div class="col-xxl-9">

                     <div class="row">
                         <div class="col-6 col-md-4 col-lg">
                             <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-secondary shadow-secondary rounded-circle text-white mb-3">
                                         <i class="fi fi-sr-users"></i>
                                     </div>
                                     <h3>{{ $totalStudents }}</h3>
                                     <h6 class="mb-0">Total Student</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6 col-md-4 col-lg">
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
                         <div class="col-6 col-md-4 col-lg">
                             <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-warning shadow-warning rounded-circle text-white mb-3">
                                         <i class="fi fi-sr-briefcase"></i>
                                     </div>
                                     <h3>{{ $jobapplication }}</h3>
                                     <h6 class="mb-0">Job Application</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6 col-md-6 col-lg">
                             <div class="card bg-success bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-success shadow-success rounded-circle text-white mb-3">
                                         <i class="fi fi-sr-document"></i>
                                     </div>
                                     <h3>{{ $totalBlogs }}</h3>
                                     <h6 class="mb-0">Blogs</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12 col-md-6 col-lg">
                             <div class="card bg-danger bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-danger shadow-danger rounded-circle text-white mb-3">
                                         <i class="fi fi-sr-graduation-cap"></i>
                                     </div>
                                     <h3>{{ $learningCourse }}</h3>
                                     <h6 class="mb-0">Courses</h6>
                                 </div>
                             </div>
                         </div>

                         {{-- new --}}
                         

                     </div>

                      <div class="row">
                         <div class="col-6 col-md-4 col-lg">
                             <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-secondary shadow-secondary rounded-circle text-white mb-3">
                                    <i class="fi fi-sr-bullseye"></i>
                                     </div>
                                     <h3>{{ $opportunity }}</h3>
                                     <h6 class="mb-0">Opportunity</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6 col-md-4 col-lg">
                             <div class="card bg-info bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-info shadow-info rounded-circle text-white mb-3">
                                        <i class="fi fi-sr-folder"></i>
                                     </div>
                                     <h3>{{ $bundleCourse }}</h3>
                                     <h6 class="mb-0">Bundle Cousre</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6 col-md-4 col-lg">
                             <div class="card bg-secondary bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-warning shadow-warning rounded-circle text-white mb-3">
                                         <i class="fi fi-sr-shopping-cart"></i>
                                     </div>
                                     <h3>{{ $courseOrders }}</h3>
                                     <h6 class="mb-0">Course Orders</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6 col-md-6 col-lg">
                             <div class="card bg-success bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-success shadow-success rounded-circle text-white mb-3">
                                       <i class="fi fi-sr-play"></i>
                                     </div>
                                     <h3>{{ $courseLesson }}</h3>
                                     <h6 class="mb-0">Course Lesson</h6>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12 col-md-6 col-lg">
                             <div class="card bg-danger bg-opacity-05 shadow-none border-0">
                                 <div class="card-body">
                                     <div class="avatar bg-danger shadow-danger rounded-circle text-white mb-3">
                                   <i class="fi fi-sr-clipboard-check"></i>
                                     </div>
                                     <h3>{{ $Quiz }}</h3>
                                     <h6 class="mb-0">Quizzes</h6>
                                 </div>
                             </div>
                         </div>

                         {{-- new --}}
                         

                     </div>


                     

                     
                 </div>

                 <div class="col-xxl-3">
                     <div class="card overflow-hidden z-1">
                         <div class="card-body">
                             <div class="w-75">
                                 <h6 class="card-title">Create Opportunity</h6>
                                 <p>Post jobs and attract candidates</p>
                             </div>
                             <img src="{{ static_asset('admin/assets/images/media/svg/media1.svg') }}" alt=""
                                 class="position-absolute bottom-0 end-0 z-n1">
                         </div>
                         <div class="card-footer border-0 pt-0">
                             <a href="{{ route('admin.jobs.create') }}"
                                 class="btn btn-outline-light waves-effect btn-shadow">Create Now</a>
                         </div>
                     </div>
                 </div>

                 <div class="col-lg-12 my-3">
                     <h5 class="fw-bold mb-0">
                         Current Opportunity
                         <span class="text-primary ms-1 text-2xs">
                             {{ $currentOpportunity->count() }} Jobs Added
                         </span>
                     </h5>
                 </div>

                 @php
                     $bgColors = ['bg-primary-subtle', 'bg-warning-subtle', 'bg-info-subtle', 'bg-success-subtle'];
                 @endphp


                 @foreach ($currentOpportunity as $index => $job)
                     <div class="col-xxl-3 col-md-6">

                         <div
                             class="card card-action action-elevate border-0 shadow-none 
                            {{ $bgColors[$index % count($bgColors)] }}">

                             <div class="card-body">

                                 <!-- Job Title + Logo -->
                                 <div class="d-flex gap-3 align-items-center mb-4">

                                     <div class="avatar bg-body rounded-2 p-2" style="width:55px;height:55px;">

                                         @if ($job->company_logo)
                                             <img src="{{ static_asset($job->company_logo) }}"
                                                 style="width:100%;height:100%;object-fit:contain;">
                                         @else
                                             <img src="{{ static_asset('admin/assets/images/media/default-company.png') }}"
                                                 style="width:100%;height:100%;object-fit:contain;">
                                         @endif

                                     </div>

                                     <div>

                                         <h6 class="mb-1 text-sm">
                                             {{ Str::limit($job->title, 60) }}
                                         </h6>

                                         <ul class="list-inline list-inline-disc d-flex mb-0">

                                             <li>{{ $job->job_type }}</li>

                                             <li>{{ $job->work_mode }}</li>

                                         </ul>

                                     </div>

                                 </div>

                                 <!-- Applied + Status -->
                                 <div class="bg-body p-3 rounded-3 mb-3 d-flex">

                                     <div class="text-center w-50">

                                         <h2 class="fs-1 fw-bold mb-1">

                                             {{ $job->applications_count ?? 0 }}

                                         </h2>

                                         <span class="text-primary">Applied</span>

                                     </div>

                                     <div class="vr"></div>

                                     <div class="text-center w-50">

                                         <span
                                             class="badge 
                                                {{ $job->status == 1 ? 'bg-success' : 'bg-danger' }}">

                                             {{ $job->status == 1 ? 'Active' : 'Inactive' }}

                                         </span>

                                         <div class="text-primary mt-1">Status</div>

                                     </div>

                                 </div>

                                 <!-- Salary + Location -->
                                 <div class="d-flex justify-content-between gap-2 pt-1 mb-3">

                                     <div>

                                         <span class="text-1xs">Salary</span>

                                         <span class="text-sm text-dark d-block fw-semibold">

                                             {{ $job->salary }}

                                         </span>

                                     </div>

                                     <div class="text-end">

                                         <span class="text-1xs">Location</span>

                                         <span class="text-sm text-dark d-block fw-semibold">

                                             {{ $job->area ?? $job->district . ' ' . $job->state }}

                                         </span>

                                     </div>

                                 </div>

                                 <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-primary w-100">

                                     See Job Post

                                 </a>

                             </div>

                         </div>

                     </div>
                 @endforeach


                 <div class="card">

                     <div class="card-header d-flex align-items-center justify-content-between border-0 pb-0">

                         <h6 class="card-title mb-0">Recent Job Applications</h6>

                         <a href="{{ route('admin.jobs.index') }}" class="btn-link">
                             View All
                         </a>

                     </div>

                     <div class="card-body pb-3">

                         <ul class="list-group list-group-hover list-group-smooth list-group-unlined list-group-outer">

                             @forelse($recentApplications as $app)
                                 <li class="list-group-item d-flex justify-content-between align-items-center">

                                     <!-- Avatar -->
                                     <div class="avatar rounded-circle me-1">

                                         <img src="{{ static_asset('admin/assets/images/avatar/profile.jpg') }}">

                                     </div>

                                     <!-- Student Name -->
                                     <div class="ms-2 me-auto">

                                         <h6 class="mb-0">
                                             {{ $app->student->name ?? 'Student' }}
                                         </h6>

                                         <small>
                                             {{ $app->job_title }}
                                         </small>

                                     </div>

                                     <!-- Status -->
                                     <span
                                         class="badge
                                            @if ($app->status == 'selected') bg-success
                                            @elseif($app->status == 'shortlisted') bg-info
                                            @elseif($app->status == 'rejected') bg-danger
                                            @else bg-warning @endif">

                                         {{ ucfirst($app->status) }}

                                     </span>

                                 </li>

                             @empty

                                 <li class="list-group-item text-muted text-center">
                                     No recent applications
                                 </li>
                             @endforelse

                         </ul>

                     </div>

                 </div>


                

             </div>
         </div>

     </main>

 @endsection
