 @extends('backend.layout.layouts')
 @section('title', 'Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

     <main class="app-wrapper">

         <div class="container">

             <div class="app-page-head d-flex align-items-center justify-content-between">
                 <div class="clearfix">
                     <h1 class="app-page-title">Calendar</h1>
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0">
                             <li class="breadcrumb-item">
                                 <a href="{{route('dashboard')}}">Dashboard</a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                         </ol>
                     </nav>
                 </div>
             </div>

             <div class="row">
                 <div class="col-12">

                     <div class="card">
                         <div class="card-body p-0">
                             <div class="row g-0">
                                 <div class="col-lg-3 p-4 border-end">
                                     <button id="openDrawerBtn" class="btn btn-primary waves-effect waves-light w-100"
                                         data-bs-toggle="modal" data-bs-target="#modalAddEvent">
                                         <i class="fi fi-rr-plus me-1"></i> Add Event
                                     </button>
                                     <hr class="border-dashed my-4">
                                     <h6 class="mb-3">Draggable Events</h6>
                                     <div id="external-events" class="d-grid gap-2">
                                         <div class="fc-event cursor-move rounded-2 px-3 py-2 bg-primary-subtle text-primary"
                                             data-color="var(--bs-primary)" data-location="Head Office"
                                             data-description="Discuss project status and next steps.">
                                             <i class="fi fi-rr-plane-departure me-1"></i> Tour & Picnic
                                         </div>
                                         <div class="fc-event cursor-move rounded-2 px-3 py-2 bg-success-subtle text-success"
                                             data-color="var(--bs-success)" data-location="Remote"
                                             data-description="Complete assigned tasks and update progress.">
                                             <i class="fi fi-rr-workflow-alt me-1"></i> Group Projects
                                         </div>
                                         <div class="fc-event cursor-move rounded-2 px-3 py-2 bg-info-subtle text-info"
                                             data-color="var(--bs-info)" data-location="Conference Room"
                                             data-description="Prepare and deliver client presentation.">
                                             <i class="fi fi-rr-podium me-1"></i> Presentation
                                         </div>
                                         <div class="fc-event cursor-move rounded-2 px-3 py-2 bg-warning-subtle text-warning"
                                             data-color="var(--bs-warning)" data-location="Personal"
                                             data-description="Follow up on pending emails and calls.">
                                             <i class="fi fi-rs-massage me-1"></i> Employee Wellness
                                         </div>
                                         <div class="fc-event cursor-move rounded-2 px-3 py-2 bg-danger-subtle text-danger"
                                             data-color="var(--bs-danger)" data-location="Office"
                                             data-description="Handle urgent support tickets immediately.">
                                             <i class="fi fi-rr-hr me-1"></i> Recruitment
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-9 p-4">
                                     <div id="calendar"></div>
                                 </div>
                             </div>
                         </div>
                     </div>



                 </div>
             </div>

         </div>

     </main>

 @endsection
