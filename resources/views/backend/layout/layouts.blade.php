<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ config('app.name', 'Dashboard Login | Garuna Consultancy Services') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end::GXON Mobile Specific -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#316AFF">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Hover Business Services">

    <!-- begin::GXON Favicon Tags -->
    <link rel="icon" type="image/png" href="{{ static_asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ static_asset('assets/images/favicon.png') }}">
    <!-- end::GXON Favicon Tags -->

    <!-- begin::GXON Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <!-- end::GXON Google Fonts -->

    <!-- begin::GXON Required Stylesheet -->
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/flaticon/css/all/all.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/lucide/lucide.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/simplebar/simplebar.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/node-waves/waves.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}">
    <!-- end::GXON Required Stylesheet -->

    <!-- begin::GXON CSS Stylesheet -->
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/assets/css/styles.css') }}">
    <!-- end::GXON CSS Stylesheet -->

    <!-- jQuery (Required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.9/build/jodit.min.css">
    @stack('style')

</head>

<body>
    <div class="page-layout">

        @include('backend.include.header')

        @include('backend.include.side-bar')

        @yield('content')

        @include('backend.include.footer')

    </div>


    <!-- begin::GXON Page Scripts -->
    <script src="{{ static_asset('admin/assets/libs/global/global.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/sortable/Sortable.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/chartjs/chart.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/dashboard.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/todolist.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/appSettings.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ static_asset('admin/assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/fullcalendar.js') }}"></script>
    <script src="{{ static_asset('/assets/js/state.js') }}"></script>


    <!-- end::GXON Page Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jodit@3.24.9/build/jodit.min.js"></script>





    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    @stack('script')


    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-body text-center p-4">

                    <!-- Icon -->
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center 
            rounded-circle bg-danger-subtle text-danger"
                        style="width:64px;height:64px;">
                        <i class="fa-regular fa-trash-can fs-4"></i>
                    </div>

                    <!-- Title -->
                    <h5 class="fw-semibold mb-1">
                        Delete Item?
                    </h5>

                    <!-- Text -->
                    <p class="text-muted small mb-4">
                        This item will be permanently deleted and cannot be recovered.
                    </p>

                    <!-- Actions -->
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button" class="btn btn-danger w-50" id="confirmDeleteBtn">
                            Delete
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>




    <script>
        let deleteForm = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            deleteForm = this;
            deleteModal.show();
        });

        $('#confirmDeleteBtn').on('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobileSidebarToggle');
            const sidebar = document.getElementById('appMenubar');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    document.body.classList.toggle('menubar-open');
                });
            }
        });
    </script>

    <script>
        document.addEventListener('click', function(e) {
            if (
                document.body.classList.contains('menubar-open') &&
                !document.getElementById('appMenubar').contains(e.target) &&
                !document.getElementById('mobileSidebarToggle').contains(e.target)
            ) {
                document.body.classList.remove('menubar-open');
            }
        });
    </script>

    @stack('script')
</body>

</html>
