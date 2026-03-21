@extends('frontend.layout.layout')
@section('title', 'Student Login Page | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'EFOS Edumarketers Pvt Ltd offers expert career guidance, counselling, and skill
    development support to help students choose the right career path for a successful future.')
@section('meta_keywords',
    'career guidance, EFOS Edumarketers, career counselling, student counselling, skill
    development, education services, career planning, career support')
@section('meta_robots', 'index, follow')
@section('canonical', url('https://efos.in/'))
@section('content')

    <style>
        .login-card {
            max-width: 500px;
            width: 100%;
            border-radius: 14px;
            background: #ffffff;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: rgba(13, 110, 253, .1);
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: auto;
        }

        .input-group-text {
            border-right: 0;
        }

        .form-control {
            border-left: 0;
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>

    <main>


        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                       Forgot Password
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Forgot Password</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->


        <div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
            <div class="card border-0 shadow-lg p-4 login-card">

                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                   <h4 class="fw-bold">Forgot Password</h4>
                    <p class="text-muted small mb-0">
                    Enter your registered email to receive a password reset link
                    </p>
                </div>
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif


                <!-- Form -->
              <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Enter Your Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" name="email" class="form-control"
                            placeholder="Enter your registered email" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Send Password Reset Link
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('student.login') }}" class="text-decoration-none small fw-semibold">
                        Back to Login
                    </a>
                </div>


                </form>


                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        © {{ date('Y') }} Candididate Portal · Empowering Learners
                    </small>
                </div>


            </div>
        </div>



    </main>

@endsection
