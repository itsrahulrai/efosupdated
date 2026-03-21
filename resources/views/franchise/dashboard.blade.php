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


<div class="row mt-4">

    {{-- Total Franchise --}}
    <div class="col-3">
        <div class="card bg-primary bg-opacity-05 shadow-none border-0">
            <div class="card-body">
                <div class="avatar bg-primary shadow-primary rounded-circle text-white mb-3">
                    <i class="fi fi-rr-building"></i>
                </div>
                <h3>{{ $totalFranchise ?? 0 }}</h3>
                <h6 class="mb-0">Total Franchise</h6>
            </div>
        </div>
    </div>

    {{-- Pending Franchise --}}
    <div class="col-3">
        <div class="card bg-warning bg-opacity-05 shadow-none border-0">
            <div class="card-body">
                <div class="avatar bg-warning shadow-warning rounded-circle text-white mb-3">
                    <i class="fi fi-rr-time-forward"></i>
                </div>
                <h3>{{ $pendingFranchise ?? 0 }}</h3>
                <h6 class="mb-0">Pending Applications</h6>
            </div>
        </div>
    </div>

    {{-- Approved Franchise --}}
    <div class="col-3">
        <div class="card bg-success bg-opacity-05 shadow-none border-0">
            <div class="card-body">
                <div class="avatar bg-success shadow-success rounded-circle text-white mb-3">
                    <i class="fi fi-rr-badge-check"></i>
                </div>
                <h3>{{ $approvedFranchise ?? 0 }}</h3>
                <h6 class="mb-0">Approved Franchise</h6>
            </div>
        </div>
    </div>

    {{-- Rejected Franchise --}}
    <div class="col-3">
        <div class="card bg-danger bg-opacity-05 shadow-none border-0">
            <div class="card-body">
                <div class="avatar bg-danger shadow-danger rounded-circle text-white mb-3">
                    <i class="fi fi-rr-ban"></i>
                </div>
                <h3>{{ $rejectedFranchise ?? 0 }}</h3>
                <h6 class="mb-0">Rejected Franchise</h6>
            </div>
        </div>
    </div>

</div>

         </div>
     </main>

 @endsection
