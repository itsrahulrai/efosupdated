    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Login | Career Guidance Services | EFOS Edumarketers Pvt Ltd</title>
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
                                <a href="" aria-label="GXON logo">
                                    <img class="visible-light" src="{{ static_asset('assets/images/logo/logo.jpg') }}"
                                        width="150px" alt="logo">
                                    <img class="visible-dark" src="{{ static_asset('assets/images/logo/logo.jpg') }}"
                                        alt="logo">
                                </a>
                            </div>
                            <div class="text-center mb-5">
                                <h5 class="mb-1">Welcome to EFOS</h5>
                            </div>
                            <div class="auth-bg"
                                style="background-image: url('{{ static_asset('admin/assets/images/auth/auth-cover-bg.png') }}');
                                    background-size: cover; background-position: center;">

                                    {{-- SHOW ERROR HERE --}}
                                    @if ($errors->has('error'))
                                        <div class="alert alert-danger text-center mb-4">
                                            {{ $errors->first('error') }}
                                        </div>
                                    @endif
                                <form method="POST" action="{{ route('login') }}" class="p-4 bg-white rounded shadow">
                                    @csrf       

                                    <!-- Email -->
                                    <div class="mb-4">
                                        <label class="form-label" for="loginEmail">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="loginEmail" name="email" value="{{ old('email') }}"
                                            placeholder="info@example.com" required autofocus>

                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-4">
                                        <label class="form-label" for="loginPassword">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="loginPassword" name="password" placeholder="********" required>

                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Remember + Forgot -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="checkbox" id="rememberMe"
                                                    name="remember">
                                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                                            </div>
                                           
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>

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
