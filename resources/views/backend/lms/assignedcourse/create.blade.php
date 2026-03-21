@extends('backend.layout.layouts')
@section('title', 'Courses - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
@section('content')

    <main class="app-wrapper">
        <div class="container">
            <div class="app-page-head d-flex align-items-center justify-content-between">
                <div class="clearfix">
                    <h1 class="app-page-title">Assigned Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Assigned Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Assigned Courses</h6>
                        </div>

                        <div class="card-body p-0 pb-2">
                           <form action="{{ isset($assignedCourse) 
                                        ? route('admin.assigned-course.update',$assignedCourse->id) 
                                        : route('admin.assigned-course.store') }}"
                                    method="POST">

                                @csrf

                                @if(isset($assignedCourse))
                                @method('PUT')
                                @endif

                               <div class="row g-3 mx-2 mt-2">

                                    {{-- Student --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Select Student
                                        </label>

                                       <select name="student_id" class="form-select" required>
                                        <option value="">Choose Student</option>

                                        @foreach ($students as $student)

                                        <option value="{{ $student->id }}"
                                        {{ isset($assignedCourse) && $assignedCourse->student_id == $student->id ? 'selected' : '' }}>

                                        {{ $student->name }} ({{ $student->registration_number }})

                                        </option>

                                        @endforeach

                                        </select>
                                    </div>


                                    {{-- Course --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Select Course
                                        </label>

                                        <select name="course_id" class="form-select" >
                                            <option value="">Choose Course</option>

                                            @foreach ($courses as $course)

                                            <option value="{{ $course->id }}"
                                            {{ isset($assignedCourse) && $assignedCourse->course_id == $course->id ? 'selected' : '' }}>

                                            {{ $course->title }}

                                            </option>

                                            @endforeach

                                            </select>

                                    </div>

                                    {{-- Bundle --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Select Bundle
                                        </label>

                                        <select name="bundle_id" class="form-select">
                                            <option value="">Choose Bundle</option>

                                            @foreach ($bundles as $bundle)

                                            <option value="{{ $bundle->id }}"
                                            {{ isset($assignedCourse) && $assignedCourse->bundle_id == $bundle->id ? 'selected' : '' }}>

                                            {{ $bundle->title }}

                                            </option>

                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Assigned Date --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Assigned Date
                                        </label>

                                       <input type="date"
                                            name="assigned_at"
                                            class="form-control"
                                            value="{{ isset($assignedCourse) 
                                                    ? \Carbon\Carbon::parse($assignedCourse->assigned_at)->format('Y-m-d') 
                                                    : date('Y-m-d') }}">

                                    </div>

                                </div>


                              <div class="mt-4 mx-2 d-flex justify-content-end gap-2">
                               <button type="submit" class="btn btn-primary">
                                    {{ isset($assignedCourse) ? 'Update' : 'Submit' }}
                                    </button>

                                <a href="{{ route('admin.assigned-course.index') }}" class="btn btn-light border">
                                    Cancel
                                </a>

                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('script')
@endpush
