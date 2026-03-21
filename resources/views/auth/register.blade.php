<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register | Career Guidance Services | EFOS Edumarketers Pvt Ltd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ static_asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ static_asset('assets/images/apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/flaticon/css/all/all.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/lucide/lucide.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/simplebar/simplebar.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/node-waves/waves.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/css/styles.css') }}">
</head>

<body>
    <div class="page-layout">

        <div class="auth-cover-wrapper">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="auth-cover"
                        style="background-image: url('{{ static_asset('admin/assets/images/auth/auth-cover-bg.png') }}');">
                        <div class="clearfix">
                            <img src="{{ static_asset('admin/assets/images/auth/auth.png') }}" alt=""
                                class="img-fluid cover-img ms-5">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="p-3 p-sm-5 maxw-450px m-auto auth-inner" data-simplebar>
                        <div class="mb-4 text-center">
                            <a href="index.html" aria-label="GXON logo">
                                <img class="visible-light" src="{{ static_asset('assets/images/logo/logo.jpg') }}"
                                    width="150px" alt="logo">
                                <img class="visible-dark" src="{{ static_asset('assets/images/logo/logo.jpg') }}"
                                    alt="logo">
                            </a>
                        </div>
                        <div class="text-center mb-5">
                            <h5 class="mb-1">Welcome to EFOS</h5>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="p-4 bg-white rounded shadow">
                            @csrf

                            <!-- Name -->
                            <div class="mb-4">
                                <label class="form-label" for="regName">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="regName" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your full name" required autofocus>

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="regEmail">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="regEmail" name="email" value="{{ old('email') }}"
                                    placeholder="info@example.com" required>

                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label class="form-label" for="regPassword">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="regPassword" name="password" placeholder="********" required>

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label" for="regPasswordConfirm">Confirm Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="regPasswordConfirm" name="password_confirmation" placeholder="********"
                                    required>

                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Already Registered -->
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('login') }}">Already registered?</a>
                            </div>

                            <!-- Submit -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Register
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- begin::GXON Page Scripts -->
    <script src="{{ static_asset('admin/assets/libs/global/global.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/appSettings.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/main.js') }}"></script>
    <!-- end::GXON Page Scripts -->
</body>

</html>
