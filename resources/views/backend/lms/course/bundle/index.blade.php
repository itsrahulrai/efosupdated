@extends('backend.layout.layouts')
@section('title', 'Bundle Course Mangment - Career Guidance Services | EFOS Edumarketers Pvt Ltd')


@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title"> Bundle Course Mangment</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bundle Course Mangment</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Bundle Course Mangment</h6>
                            <a href="{{ route('admin.bundle-course.create') }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                <i class="bi bi-plus-lg"></i>
                                Add Bundle
                            </a>
                        </div>

                        <div class="card-body p-0 pb-2">


                            <div class="tab-content px-3 pb-3">

                                <div class="tab-pane fade show active">

                                    @include('backend.lms.course.bundle.partials.bundle-table')
                                </div>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

